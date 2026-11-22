<?php

namespace Tests\Feature;

use App\Models\Theme;
use App\Models\ThemeRevision;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceTheme;
use App\Services\ThemePublishingService;
use App\Services\ThemeResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ThemeEngineTest extends TestCase
{
    use RefreshDatabase;

    protected Workspace $workspace;
    protected User $admin;
    protected ThemePublishingService $publishingService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->workspace = Workspace::create([
            'name' => 'Alif Ahmed Portfolio',
            'slug' => 'default',
            'status' => 'active',
        ]);

        $this->admin = User::create([
            'workspace_id' => $this->workspace->id,
            'name' => 'Md. Alif Ahmed',
            'email' => 'admin@alifahmed.com',
            'password' => Hash::make('Secret123!'),
            'role' => 'owner',
            'status' => 'active',
        ]);

        $this->publishingService = app(ThemePublishingService::class);
    }

    public function test_all_four_themes_have_valid_manifests_and_templates(): void
    {
        $expectedThemes = ['crystal-3d', 'minimal-professional', 'creative-studio', 'futuristic-tech', 'split-engineer', 'editorial-brutalist'];

        foreach ($expectedThemes as $slug) {
            $manifestPath = resource_path("views/themes/{$slug}/theme.json");
            $this->assertFileExists($manifestPath);

            $manifest = json_decode(File::get($manifestPath), true);
            $this->assertIsArray($manifest);
            $this->assertEquals($slug, $manifest['slug']);
            $this->assertNotEmpty($manifest['name']);
            $this->assertNotEmpty($manifest['version']);
            $this->assertNotEmpty($manifest['supported_blocks']);

            // Required views exist
            $this->assertFileExists(resource_path("views/themes/{$slug}/layouts/app.blade.php"));
            $this->assertFileExists(resource_path("views/themes/{$slug}/pages/home.blade.php"));
            $this->assertFileExists(resource_path("views/themes/{$slug}/pages/projects/index.blade.php"));
            $this->assertFileExists(resource_path("views/themes/{$slug}/pages/projects/show.blade.php"));
        }
    }

    public function test_theme_studio_indexes_and_syncs_catalog(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.themes.index'));
        $response->assertStatus(200);
        $response->assertSee('Theme Studio');
        $response->assertSee('Crystal 3D');
        $response->assertSee('Minimal Professional');
        $response->assertSee('Creative Studio');
        $response->assertSee('Futuristic Tech');
        $response->assertSee('Split Engineer');
        $response->assertSee('Editorial Brutalist');

        $this->assertDatabaseHas('themes', ['slug' => 'crystal-3d']);
        $this->assertDatabaseHas('themes', ['slug' => 'minimal-professional']);
        $this->assertDatabaseHas('themes', ['slug' => 'creative-studio']);
        $this->assertDatabaseHas('themes', ['slug' => 'futuristic-tech']);
        $this->assertDatabaseHas('themes', ['slug' => 'split-engineer']);
        $this->assertDatabaseHas('themes', ['slug' => 'editorial-brutalist']);
    }

    public function test_theme_preview_does_not_mutate_live_active_theme(): void
    {
        $this->actingAs($this->admin)->get(route('admin.themes.index'));

        $crystalTheme = Theme::where('slug', 'crystal-3d')->first();
        $minimalTheme = Theme::where('slug', 'minimal-professional')->first();

        // 1. Publish crystal-3d as live theme
        $this->publishingService->publish($crystalTheme);
        $this->assertEquals('crystal-3d', ThemeResolver::resolve()->slug);

        // 2. Generate preview token for minimal-professional
        $previewToken = $this->publishingService->generatePreviewToken($minimalTheme);

        // 3. Request home page with preview token
        $response = $this->get('/?theme_preview=' . $previewToken);
        $response->assertStatus(200);
        $response->assertSee('Preview:');
        $response->assertSee('Minimal Professional Theme');

        // 4. Request home page without preview token: MUST still be Crystal 3D!
        ThemeResolver::clear();
        $normalResponse = $this->get('/');
        $normalResponse->assertStatus(200);
        $this->assertStringNotContainsString('Minimal Professional Theme', $normalResponse->getContent());

        // Live database setting remains crystal-3d
        $this->assertDatabaseHas('workspace_themes', [
            'theme_id' => $crystalTheme->id,
            'is_active' => true,
        ]);
        $this->assertDatabaseMissing('workspace_themes', [
            'theme_id' => $minimalTheme->id,
            'is_active' => true,
        ]);
    }

    public function test_theme_publish_is_transactional_and_records_revisions(): void
    {
        $this->actingAs($this->admin)->get(route('admin.themes.index'));

        $studioTheme = Theme::where('slug', 'creative-studio')->first();

        // Publish creative studio
        $response = $this->actingAs($this->admin)->post(route('admin.themes.publish', $studioTheme));
        $response->assertRedirect(route('admin.themes.index'));

        $this->assertDatabaseHas('workspace_themes', [
            'theme_id' => $studioTheme->id,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('theme_revisions', [
            'theme_id' => $studioTheme->id,
            'revision_number' => 1,
        ]);

        $this->assertDatabaseHas('activity_logs', [
            'action' => 'theme.publish',
        ]);
    }

    public function test_theme_rollback_restores_previous_state(): void
    {
        $this->actingAs($this->admin)->get(route('admin.themes.index'));

        $crystal = Theme::where('slug', 'crystal-3d')->first();
        $futuristic = Theme::where('slug', 'futuristic-tech')->first();

        // Step 1: Publish crystal (rev 1)
        $this->publishingService->publish($crystal);
        $rev1 = ThemeRevision::where('theme_id', $crystal->id)->first();

        // Step 2: Publish futuristic (rev 1)
        $this->publishingService->publish($futuristic);
        $this->assertEquals('futuristic-tech', ThemeResolver::resolve()->slug);

        // Step 3: Rollback to rev 1
        $response = $this->actingAs($this->admin)->post(route('admin.themes.rollback', $rev1));
        $response->assertRedirect(route('admin.themes.index'));

        $this->assertEquals('crystal-3d', ThemeResolver::resolve()->slug);
        $this->assertDatabaseHas('workspace_themes', [
            'theme_id' => $crystal->id,
            'is_active' => true,
        ]);
    }
}
