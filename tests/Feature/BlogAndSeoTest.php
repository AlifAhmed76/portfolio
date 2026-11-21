<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\User;
use App\Models\Workspace;
use App\Services\WorkspaceResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogAndSeoTest extends TestCase
{
    use RefreshDatabase;

    protected Workspace $workspace;
    protected User $admin;
    protected PostCategory $category;

    protected function setUp(): void
    {
        parent::setUp();
        WorkspaceResolver::clear();

        $this->workspace = Workspace::create([
            'name' => 'Portfolio Main',
            'slug' => 'portfolio-main',
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

        $this->category = PostCategory::create([
            'workspace_id' => $this->workspace->id,
            'name' => 'Architecture',
            'slug' => 'architecture',
        ]);
    }

    public function test_admin_can_create_post_with_auto_calculated_reading_time(): void
    {
        // 450 words should be ~3 minutes
        $content = str_repeat('Laravel architecture engineering database optimization ', 90);

        $response = $this->actingAs($this->admin)->post(route('admin.posts.store'), [
            'title' => 'Scaling Meta Conversion API Pipelines',
            'slug' => 'scaling-meta-conversion-api-pipelines',
            'category_id' => $this->category->id,
            'summary' => 'Resilient server-side attribution pipeline architecture.',
            'content' => $content,
            'status' => 'published',
            'meta_title' => 'Meta CAPI Architecture',
            'meta_description' => 'Scaling server-side tracking.',
        ]);

        $response->assertRedirect(route('admin.posts.index'));

        $post = Post::where('slug', 'scaling-meta-conversion-api-pipelines')->first();
        $this->assertNotNull($post);
        $this->assertSame(3, $post->reading_time);
        $this->assertSame('published', $post->status);
        $this->assertNotNull($post->published_at);
    }

    public function test_public_blog_index_and_guest_draft_protection(): void
    {
        $publishedPost = Post::create([
            'workspace_id' => $this->workspace->id,
            'category_id' => $this->category->id,
            'title' => 'Published Technical Article',
            'slug' => 'published-technical-article',
            'content' => 'Public article content describing high performance architectures.',
            'reading_time' => 2,
            'status' => 'published',
            'published_at' => now(),
            'author_id' => $this->admin->id,
        ]);

        $draftPost = Post::create([
            'workspace_id' => $this->workspace->id,
            'category_id' => $this->category->id,
            'title' => 'Secret Draft Article',
            'slug' => 'secret-draft-article',
            'content' => 'Unpublished draft content.',
            'reading_time' => 1,
            'status' => 'draft',
            'author_id' => $this->admin->id,
        ]);

        // Blog index shows published, hides draft
        $indexResponse = $this->get('/blog');
        $indexResponse->assertOk();
        $indexResponse->assertSee('Published Technical Article');
        $indexResponse->assertDontSee('Secret Draft Article');

        // Single published post accessible
        $singleResponse = $this->get('/blog/published-technical-article');
        $singleResponse->assertOk();
        $singleResponse->assertSee('Published Technical Article');
        $singleResponse->assertSee('BlogPosting'); // JSON-LD check

        // Single draft post returns 404 for guests
        $draftResponse = $this->get('/blog/secret-draft-article');
        $draftResponse->assertNotFound();
    }

    public function test_contact_form_honeypot_and_rate_limiting(): void
    {
        // 1. Legitimate submission succeeds
        $response = $this->post('/contact', [
            'name' => 'Client Alex',
            'email' => 'alex@enterprise.com',
            'subject' => 'Project Inquiry',
            'message' => 'We need custom Laravel architecture and courier API integration.',
        ]);

        $response->assertSessionHas('contact_success');
        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Client Alex',
            'email' => 'alex@enterprise.com',
            'status' => 'unread',
        ]);

        // 2. Honeypot submission silently rejected (no database entry)
        $this->post('/contact', [
            'name' => 'Spam Bot',
            'email' => 'bot@spammer.org',
            'hp_website' => 'http://spam-link.ru',
            'message' => 'Buy cheap medications now.',
        ]);

        $this->assertDatabaseMissing('contact_messages', [
            'email' => 'bot@spammer.org',
        ]);

        // 3. Rate limiting check (max 3 submissions per 10 mins)
        // First submission already occurred. Let's do submission 2 and 3:
        $this->post('/contact', [
            'name' => 'Alex 2',
            'email' => 'alex2@enterprise.com',
            'message' => 'Message 2',
        ]);
        $this->post('/contact', [
            'name' => 'Alex 3',
            'email' => 'alex3@enterprise.com',
            'message' => 'Message 3',
        ]);

        // 4th submission should trigger 429 Too Many Requests
        $rateLimitedResponse = $this->post('/contact', [
            'name' => 'Alex 4',
            'email' => 'alex4@enterprise.com',
            'message' => 'Message 4',
        ]);
        $rateLimitedResponse->assertStatus(429);
    }

    public function test_sitemap_xml_and_robots_txt_generation(): void
    {
        $projCat = ProjectCategory::create([
            'workspace_id' => $this->workspace->id,
            'name' => 'Solutions',
            'slug' => 'solutions',
        ]);

        Project::create([
            'workspace_id' => $this->workspace->id,
            'category_id' => $projCat->id,
            'title' => 'Sitemap Project Test',
            'slug' => 'sitemap-project-test',
            'summary' => 'Test project summary',
            'status' => 'published',
            'published_at' => now(),
        ]);

        Post::create([
            'workspace_id' => $this->workspace->id,
            'category_id' => $this->category->id,
            'title' => 'Sitemap Post Test',
            'slug' => 'sitemap-post-test',
            'content' => 'Test post content',
            'status' => 'published',
            'published_at' => now(),
            'author_id' => $this->admin->id,
        ]);

        // Sitemap XML
        $sitemapResponse = $this->get('/sitemap.xml');
        $sitemapResponse->assertOk();
        $sitemapResponse->assertHeader('Content-Type', 'application/xml');
        $sitemapResponse->assertSee('/projects/sitemap-project-test');
        $sitemapResponse->assertSee('/blog/sitemap-post-test');

        // Robots.txt
        $robotsResponse = $this->get('/robots.txt');
        $robotsResponse->assertOk();
        $robotsResponse->assertHeader('Content-Type', 'text/plain; charset=utf-8');
        $robotsResponse->assertSee('Disallow: /admin/');
        $robotsResponse->assertSee('sitemap.xml');
    }
}
