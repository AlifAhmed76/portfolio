<?php

namespace Tests\Feature;

use App\Models\ContactDetail;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectDetail;
use App\Models\Service;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\SocialLink;
use App\Models\Theme;
use App\Models\User;
use App\Models\Workspace;
use App\Services\WorkspaceResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FrontendVisualThemeTest extends TestCase
{
    use RefreshDatabase;

    protected Workspace $workspace;
    protected User $owner;

    protected function setUp(): void
    {
        parent::setUp();
        WorkspaceResolver::clear();

        $this->workspace = Workspace::create([
            'name' => 'Alif Ahmed Workspace',
            'slug' => 'default',
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

        Profile::create([
            'workspace_id' => $this->workspace->id,
            'name' => 'Md. Alif Ahmed',
            'designation' => 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist',
            'headline' => 'Building Digital Experiences. Engineering Business Solutions.',
            'bio' => 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering.',
        ]);

        ContactDetail::create([
            'workspace_id' => $this->workspace->id,
            'email' => 'alif@example.com',
            'location' => 'Dhaka, Bangladesh',
            'availability_status' => 'Available for Select Projects & Leadership Roles',
        ]);

        SocialLink::create([
            'workspace_id' => $this->workspace->id,
            'platform' => 'github',
            'label' => 'GitHub Profile',
            'url' => 'https://github.com/Pending-owner-to-confirm',
            'is_enabled' => true,
            'sort_order' => 1,
        ]);

        $cat = SkillCategory::create([
            'workspace_id' => $this->workspace->id,
            'name' => 'Backend Engineering',
            'slug' => 'backend-engineering',
            'sort_order' => 1,
        ]);

        Skill::create([
            'workspace_id' => $this->workspace->id,
            'category_id' => $cat->id,
            'name' => 'PHP & Laravel',
            'description' => 'Custom services and Eloquent optimization',
            'sort_order' => 1,
        ]);

        $projCat = ProjectCategory::create([
            'workspace_id' => $this->workspace->id,
            'name' => 'E-Commerce Solutions',
            'slug' => 'ecommerce-solutions',
        ]);

        $proj = Project::create([
            'workspace_id' => $this->workspace->id,
            'category_id' => $projCat->id,
            'title' => 'Courier Logistics API Integration',
            'slug' => 'courier-logistics-api',
            'summary' => 'Automated shipment parcel creation and tracking synchronization.',
            'status' => 'published',
            'is_featured' => true,
            'published_at' => now(),
            'sort_order' => 1,
        ]);

        ProjectDetail::create([
            'project_id' => $proj->id,
            'challenge' => 'Manual dispatch bottlenecks.',
            'solution' => 'Direct courier REST API wrapper with webhook events.',
            'implementation' => 'Laravel jobs and queues.',
            'outcome' => 'Zero dispatch errors.',
        ]);

        Service::create([
            'workspace_id' => $this->workspace->id,
            'title' => 'Custom Laravel Engineering',
            'description' => 'Scalable backend services.',
            'deliverables' => 'API docs, tested codebase.',
            'is_enabled' => true,
            'sort_order' => 1,
        ]);

        Experience::create([
            'workspace_id' => $this->workspace->id,
            'designation' => 'Technical Project Lead',
            'company' => 'Enterprise Solutions Ltd',
            'location' => 'Remote',
            'start_date' => '2022-01-01',
            'is_current' => true,
            'description' => 'Directing technical web engineering teams.',
        ]);

        Education::create([
            'workspace_id' => $this->workspace->id,
            'institution' => 'University of Engineering',
            'degree' => 'B.Sc. in Computer Science',
            'subject' => 'Computer Science & Engineering',
            'start_date' => '2018-01-01',
            'end_date' => '2022-01-01',
            'description' => 'Software engineering focus.',
        ]);
    }

    public function test_homepage_renders_all_sections_and_enforces_identity_rule(): void
    {
        $response = $this->get('/');
        $response->assertOk();

        // Identity verification: strictly NO "Sr."
        $response->assertSee('Md. Alif Ahmed');
        $response->assertSee('Web Developer | Technical Project Lead | E-commerce Solutions Specialist');
        $response->assertDontSee('Sr. Web Developer');
        $response->assertDontSee('Senior Web Developer');

        // Verify sections present
        $response->assertSee('Available for Select Projects & Leadership Roles');
        $response->assertSee('Custom Laravel Engineering');
        $response->assertSee('Backend Engineering');
        $response->assertSee('PHP & Laravel');
        $response->assertSee('Courier Logistics API Integration');
        $response->assertSee('Structured Execution Process');
        $response->assertSee('Initiate Collaboration');
        $response->assertSee('Technical Project Lead');
        $response->assertSee('Enterprise Solutions Ltd');
        $response->assertSee('B.Sc. in Computer Science');
    }

    public function test_project_case_study_detail_page_renders_correctly(): void
    {
        $response = $this->get('/projects/courier-logistics-api');
        $response->assertOk();
        $response->assertSee('Courier Logistics API Integration');
        $response->assertSee('Manual dispatch bottlenecks');
        $response->assertSee('Direct courier REST API wrapper');
    }

    public function test_theme_preview_mode_renders_alternate_theme(): void
    {
        Theme::create([
            'name' => 'Futuristic Tech',
            'slug' => 'futuristic-tech',
            'version' => '1.0.0',
            'manifest_json' => ['slug' => 'futuristic-tech', 'name' => 'Futuristic Tech'],
            'status' => 'active',
        ]);

        \App\Services\ThemeResolver::setPreviewSlug('futuristic-tech');
        $response = $this->get('/');
        $response->assertOk();
        $response->assertSee('SYS_STATUS');
        $response->assertSee('NODE::ALIF-PORTFOLIO-V1');
    }
}
