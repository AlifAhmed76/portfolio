<?php

namespace Tests\Feature;

use App\Models\CodeFile;
use App\Models\User;
use App\Models\Workspace;
use App\Services\CodeEditorService;
use App\Services\WorkspaceResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CodeEditorSecurityTest extends TestCase
{
    use RefreshDatabase;

    protected Workspace $workspace;
    protected User $owner;
    protected User $editor;
    protected CodeEditorService $codeService;

    protected function setUp(): void
    {
        parent::setUp();
        WorkspaceResolver::clear();

        $this->workspace = Workspace::create([
            'name' => 'Portfolio Main',
            'slug' => 'portfolio-main',
            'status' => 'active',
        ]);

        $this->owner = User::create([
            'workspace_id' => $this->workspace->id,
            'name' => 'Md. Alif Ahmed',
            'email' => 'admin@alifahmed.com',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'status' => 'active',
        ]);

        $this->editor = User::create([
            'workspace_id' => $this->workspace->id,
            'name' => 'Content Assistant',
            'email' => 'editor@alifahmed.com',
            'password' => bcrypt('password123'),
            'role' => 'editor',
            'status' => 'active',
        ]);

        $this->codeService = app(CodeEditorService::class);
    }

    public function test_non_owner_role_is_strictly_forbidden(): void
    {
        $response = $this->actingAs($this->editor)->get(route('admin.code-editor.index'));
        $response->assertForbidden();

        $apiResponse = $this->actingAs($this->editor)->postJson(route('admin.code-editor.save'), [
            'path' => 'resources/views/themes/crystal-3d/pages/home.blade.php',
            'content' => 'Test content',
        ]);
        $apiResponse->assertForbidden();
    }

    public function test_owner_can_access_code_editor_and_file_tree(): void
    {
        $response = $this->actingAs($this->owner)->get(route('admin.code-editor.index'));
        $response->assertOk();
        $response->assertSee('Trusted Code Editor');
        $response->assertSee('Allowlisted Files');

        $tree = $this->codeService->getTree();
        $this->assertNotEmpty($tree);
        $this->assertTrue(collect($tree)->contains(fn($f) => str_contains($f['relative_path'], 'crystal-3d')));
    }

    public function test_path_traversal_attempts_are_blocked(): void
    {
        $maliciousPaths = [
            '../../.env',
            '..\\..\\.env',
            'resources/views/themes/../../.env',
            '/etc/passwd',
            'C:\\Windows\\System32\\cmd.exe',
            "resources/views/themes/test\0.php",
            '.env',
            'config/app.php',
            'routes/web.php',
            'app/Models/User.php',
        ];

        foreach ($maliciousPaths as $path) {
            try {
                $this->codeService->validateAndResolvePath($path);
                $this->fail("Expected path '{$path}' to be rejected, but it passed validation.");
            } catch (ValidationException $e) {
                $this->assertTrue(true);
            }

            // Test via API endpoint
            $response = $this->actingAs($this->owner)->getJson(
                route('admin.code-editor.open', ['path' => $path])
            );
            $response->assertStatus(422);
        }
    }

    public function test_syntax_validation_rejects_malformed_json_and_php(): void
    {
        $targetFile = 'resources/views/themes/crystal-3d/theme.json';

        // 1. Invalid JSON
        $response = $this->actingAs($this->owner)->postJson(route('admin.code-editor.save'), [
            'path' => $targetFile,
            'content' => '{ "name": "Broken JSON", invalid: syntax }',
        ]);

        $response->assertStatus(422);
        $this->assertStringContainsString('Syntax error in JSON', $response->json('message'));

        // 2. Invalid PHP
        $targetPhp = 'resources/views/themes/crystal-3d/pages/page.blade.php';
        $responsePhp = $this->actingAs($this->owner)->postJson(route('admin.code-editor.save'), [
            'path' => $targetPhp,
            'content' => '<?php function broken( { return 1; } ?>',
        ]);

        $responsePhp->assertStatus(422);
        $this->assertStringContainsString('syntax error', strtolower($responsePhp->json('message')));
    }

    public function test_save_creates_pre_save_backup_revision_and_rollback(): void
    {
        $targetRelPath = 'resources/views/themes/crystal-3d/pages/page.blade.php';
        $fullPath = base_path($targetRelPath);
        $originalContent = File::get($fullPath);

        try {
            // Save modified version 1
            $v1Content = $originalContent . "\n<!-- V1 Modification -->";
            $res1 = $this->actingAs($this->owner)->postJson(route('admin.code-editor.save'), [
                'path' => $targetRelPath,
                'content' => $v1Content,
            ]);
            $res1->assertOk();

            $codeFile = CodeFile::where('relative_path', $targetRelPath)->first();
            $this->assertNotNull($codeFile);
            $this->assertSame(1, $codeFile->revisions()->count());
            $this->assertSame($originalContent, $codeFile->revisions()->first()->content);

            // Save modified version 2
            $v2Content = $originalContent . "\n<!-- V2 Modification -->";
            $res2 = $this->actingAs($this->owner)->postJson(route('admin.code-editor.save'), [
                'path' => $targetRelPath,
                'content' => $v2Content,
            ]);
            $res2->assertOk();

            $this->assertSame(2, $codeFile->revisions()->count());

            // Rollback to Revision 1 (which had original content)
            $resRollback = $this->actingAs($this->owner)->postJson(route('admin.code-editor.restore'), [
                'path' => $targetRelPath,
                'revision_number' => 1,
            ]);
            $resRollback->assertOk();

            // File on disk matches original content
            $this->assertSame($originalContent, File::get($fullPath));
        } finally {
            // Guarantee original file is restored on disk
            File::put($fullPath, $originalContent);
        }
    }
}
