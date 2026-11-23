<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\PageRevision;
use App\Models\User;
use App\Models\Workspace;
use App\Services\PageBuilderService;
use App\Services\WorkspaceResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class PageBuilderTest extends TestCase
{
    use RefreshDatabase;

    protected Workspace $workspace;
    protected User $admin;
    protected PageBuilderService $builderService;

    protected function setUp(): void
    {
        parent::setUp();
        WorkspaceResolver::clear();

        $this->workspace = Workspace::create([
            'name' => 'Test Workspace',
            'slug' => 'test-workspace',
            'status' => 'active',
        ]);

        $this->admin = User::create([
            'workspace_id' => $this->workspace->id,
            'name' => 'Md. Alif Ahmed',
            'email' => 'admin@alifahmed.com',
            'password' => bcrypt('password123'),
            'role' => 'owner',
            'status' => 'active',
        ]);

        $this->builderService = app(PageBuilderService::class);
    }

    public function test_block_schema_validation_accepts_valid_blocks(): void
    {
        $validBlocks = [
            [
                'id' => 'hero-1',
                'type' => 'hero',
                'enabled' => true,
                'settings' => [
                    'headline' => 'Test Headline',
                    'subheadline' => 'Test Subheadline',
                ],
            ],
            [
                'id' => 'contact-1',
                'type' => 'contact',
                'enabled' => true,
                'settings' => [
                    'title' => 'Get in touch',
                ],
            ],
        ];

        $validated = $this->builderService->validateBlocks($validBlocks);
        $this->assertCount(2, $validated);
        $this->assertSame('hero', $validated[0]['type']);
        $this->assertSame('contact', $validated[1]['type']);
    }

    public function test_block_schema_validation_rejects_unknown_block_types(): void
    {
        $this->expectException(ValidationException::class);

        $invalidBlocks = [
            [
                'id' => 'malicious-1',
                'type' => 'unsupported_arbitrary_type',
                'enabled' => true,
                'settings' => [],
            ],
        ];

        $this->builderService->validateBlocks($invalidBlocks);
    }

    public function test_custom_html_sanitization_removes_scripts_and_event_handlers(): void
    {
        $dirtyHtml = '<div class="banner" onclick="stealData()"><script>alert("XSS")</script><p>Clean content</p><a href="javascript:alert(1)">Click</a></div>';
        $sanitized = $this->builderService->sanitizeHtml($dirtyHtml);

        $this->assertStringNotContainsString('<script>', $sanitized);
        $this->assertStringNotContainsString('alert("XSS")', $sanitized);
        $this->assertStringNotContainsString('onclick', $sanitized);
        $this->assertStringNotContainsString('javascript:', $sanitized);
        $this->assertStringContainsString('Clean content', $sanitized);
    }

    public function test_admin_can_create_page(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.pages.store'), [
            'title' => 'E-Commerce Architecture',
            'slug' => 'ecommerce-architecture',
            'meta_title' => 'SEO Title',
            'meta_description' => 'SEO Description',
        ]);

        $page = Page::where('slug', 'ecommerce-architecture')->first();
        $this->assertNotNull($page);
        $response->assertRedirect(route('admin.pages.builder', $page));
        $this->assertSame('draft', $page->status);
    }

    public function test_save_draft_persists_blocks_without_publishing(): void
    {
        $page = Page::create([
            'workspace_id' => $this->workspace->id,
            'title' => 'Case Study Draft',
            'slug' => 'case-study-draft',
            'status' => 'draft',
            'created_by' => $this->admin->id,
        ]);

        $blocks = [
            [
                'id' => 'hero-1',
                'type' => 'hero',
                'enabled' => true,
                'settings' => ['headline' => 'Draft Headline'],
            ],
        ];

        $response = $this->actingAs($this->admin)->postJson(
            route('admin.pages.builder.save-draft', $page),
            ['blocks' => $blocks]
        );

        $response->assertOk();
        $page->refresh();
        $this->assertSame('draft', $page->status);
        $this->assertCount(1, $page->getBlocks());
        $this->assertSame('Draft Headline', $page->getBlocks()[0]['settings']['headline']);
        $this->assertDatabaseMissing('page_revisions', ['page_id' => $page->id]);
    }

    public function test_publish_creates_revision_snapshot_and_sets_status(): void
    {
        $page = Page::create([
            'workspace_id' => $this->workspace->id,
            'title' => 'Services Page',
            'slug' => 'services-page',
            'status' => 'draft',
            'created_by' => $this->admin->id,
        ]);

        $blocks = [
            [
                'id' => 'services-1',
                'type' => 'services',
                'enabled' => true,
                'settings' => ['title' => 'Our Core Services'],
            ],
        ];

        $response = $this->actingAs($this->admin)->postJson(
            route('admin.pages.builder.publish', $page),
            ['blocks' => $blocks]
        );

        $response->assertOk();
        $page->refresh();
        $this->assertSame('published', $page->status);
        $this->assertNotNull($page->published_at);
        $this->assertDatabaseHas('page_revisions', [
            'page_id' => $page->id,
            'revision_number' => 1,
        ]);

        // Publish second revision
        $blocks[0]['settings']['title'] = 'Updated Core Services';
        $this->actingAs($this->admin)->postJson(
            route('admin.pages.builder.publish', $page),
            ['blocks' => $blocks]
        );

        $this->assertDatabaseHas('page_revisions', [
            'page_id' => $page->id,
            'revision_number' => 2,
        ]);
    }

    public function test_restore_revision_reverts_blocks_to_snapshot(): void
    {
        $page = Page::create([
            'workspace_id' => $this->workspace->id,
            'title' => 'Revision Test',
            'slug' => 'revision-test',
            'status' => 'draft',
            'created_by' => $this->admin->id,
        ]);

        // Publish Rev 1
        $this->builderService->publish($page, [
            ['id' => 'b1', 'type' => 'hero', 'enabled' => true, 'settings' => ['headline' => 'Version 1']],
        ], $this->admin->id);

        // Publish Rev 2
        $this->builderService->publish($page, [
            ['id' => 'b1', 'type' => 'hero', 'enabled' => true, 'settings' => ['headline' => 'Version 2']],
        ], $this->admin->id);

        $page->refresh();
        $this->assertSame('Version 2', $page->getBlocks()[0]['settings']['headline']);

        // Restore Rev 1
        $response = $this->actingAs($this->admin)->post(
            route('admin.pages.builder.restore', [$page, 1])
        );

        $response->assertRedirect(route('admin.pages.builder', $page));
        $page->refresh();
        $this->assertSame('Version 1', $page->getBlocks()[0]['settings']['headline']);
    }

    public function test_public_page_routing_and_guest_draft_protection(): void
    {
        $publishedPage = Page::create([
            'workspace_id' => $this->workspace->id,
            'title' => 'Public Showcase',
            'slug' => 'public-showcase',
            'content_json' => [
                ['id' => 'hero-pub', 'type' => 'hero', 'enabled' => true, 'settings' => ['headline' => 'Public Live Heading']],
            ],
            'status' => 'published',
            'published_at' => now(),
            'created_by' => $this->admin->id,
        ]);

        $draftPage = Page::create([
            'workspace_id' => $this->workspace->id,
            'title' => 'Secret Draft',
            'slug' => 'secret-draft',
            'content_json' => [
                ['id' => 'hero-sec', 'type' => 'hero', 'enabled' => true, 'settings' => ['headline' => 'Secret Content']],
            ],
            'status' => 'draft',
            'created_by' => $this->admin->id,
        ]);

        // Published page is visible to guest
        $response = $this->get('/public-showcase');
        $response->assertOk();
        $response->assertSee('Public Live Heading');

        // Draft page returns 404 for guest
        $guestDraftResponse = $this->get('/secret-draft');
        $guestDraftResponse->assertNotFound();

        // Draft page is accessible by authenticated admin
        $adminDraftResponse = $this->actingAs($this->admin)->get('/secret-draft');
        $adminDraftResponse->assertOk();
        $adminDraftResponse->assertSee('Secret Content');
    }

    public function test_grapesjs_visual_builder_payload_is_validated_and_persisted(): void
    {
        $page = Page::create([
            'workspace_id' => $this->workspace->id,
            'title' => 'Visual Landing',
            'slug' => 'visual-landing',
            'status' => 'draft',
            'created_by' => $this->admin->id,
        ]);

        $grapesPayload = [
            'mode' => 'grapesjs',
            'html' => '<div class="hero-custom"><h1>Visual Drag Drop Heading</h1><p>Designed with Elementor style builder</p></div>',
            'css' => '.hero-custom { background: #070a14; color: #ffffff; }',
            'components' => ['type' => 'wrapper'],
        ];

        // 1. Save Draft
        $draftRes = $this->actingAs($this->admin)->postJson(
            route('admin.pages.builder.save-draft', $page),
            ['blocks' => $grapesPayload]
        );
        $draftRes->assertOk();
        $draftRes->assertJson(['success' => true]);

        $page->refresh();
        $this->assertEquals('grapesjs', $page->getBlocks()['mode']);
        $this->assertStringContainsString('Visual Drag Drop Heading', $page->getBlocks()['html']);

        // 2. Publish
        $pubRes = $this->actingAs($this->admin)->postJson(
            route('admin.pages.builder.publish', $page),
            ['blocks' => $grapesPayload]
        );
        $pubRes->assertOk();
        $this->assertDatabaseHas('page_revisions', [
            'page_id' => $page->id,
            'revision_number' => 1,
        ]);

        // 3. Public access
        $publicRes = $this->get('/visual-landing');
        $publicRes->assertOk();
        $publicRes->assertSee('Visual Drag Drop Heading');
    }
}
