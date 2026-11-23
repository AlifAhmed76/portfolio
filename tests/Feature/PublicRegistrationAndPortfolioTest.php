<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\Project;
use App\Models\User;
use App\Models\Workspace;
use App\Services\WorkspaceResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PublicRegistrationAndPortfolioTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        WorkspaceResolver::clear();
    }

    public function test_registration_page_is_accessible(): void
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
        $response->assertSee('PORTFOLIO BUILDER');
        $response->assertSee('Full Name / Public Display Name');
        $response->assertSee('Username / URL Slug');
    }

    public function test_public_user_can_register_and_creates_portfolio(): void
    {
        $response = $this->post(route('register.submit'), [
            'name' => 'Sarah Connor',
            'username' => 'sarah-connor',
            'email' => 'sarah@example.com',
            'password' => 'CyberDyne2026!',
            'password_confirmation' => 'CyberDyne2026!',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();

        // Verify Workspace creation
        $workspace = Workspace::where('slug', 'sarah-connor')->first();
        $this->assertNotNull($workspace);
        $this->assertEquals("Sarah Connor's Portfolio", $workspace->name);

        // Verify Owner User
        $user = User::where('email', 'sarah@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals($workspace->id, $user->workspace_id);
        $this->assertEquals('owner', $user->role);
        $this->assertTrue(Hash::check('CyberDyne2026!', $user->password));

        // Verify Profile created with exact chosen name
        $profile = Profile::where('workspace_id', $workspace->id)->first();
        $this->assertNotNull($profile);
        $this->assertEquals('Sarah Connor', $profile->name);

        // Verify Starter Project created
        $project = Project::where('workspace_id', $workspace->id)->first();
        $this->assertNotNull($project);
        $this->assertEquals('Flagship Web Application', $project->title);
    }

    public function test_registration_validates_unique_username_and_email(): void
    {
        Workspace::create([
            'name' => 'Existing Portfolio',
            'slug' => 'taken-slug',
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Existing User',
            'email' => 'taken@example.com',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'status' => 'active',
        ]);

        $response = $this->post(route('register.submit'), [
            'name' => 'New User',
            'username' => 'taken-slug',
            'email' => 'taken@example.com',
            'password' => 'Secret1234!',
            'password_confirmation' => 'Secret1234!',
        ]);

        $response->assertSessionHasErrors(['username', 'email']);
    }

    public function test_public_user_portfolio_renders_at_user_slug(): void
    {
        // 1. Setup Tenant Workspace for Sarah Connor
        $sarahWorkspace = Workspace::create([
            'name' => "Sarah Connor's Portfolio",
            'slug' => 'sarah-connor',
            'status' => 'active',
        ]);

        Profile::create([
            'workspace_id' => $sarahWorkspace->id,
            'name' => 'Sarah Connor',
            'designation' => 'Security Systems Engineer & Cloud Architect',
            'headline' => 'Defending the Future with Resilient Web Infrastructures',
            'bio' => 'Full-stack builder with a passion for high-reliability systems.',
        ]);

        // 2. Request /u/sarah-connor
        $response = $this->get('/u/sarah-connor');
        $response->assertStatus(200);

        // Navbar and page must prominently show Sarah Connor
        $response->assertSee('Sarah Connor');
        $response->assertSee('Security Systems Engineer');
    }

    public function test_default_workspace_still_renders_on_root(): void
    {
        $defaultWorkspace = Workspace::create([
            'name' => 'Alif Ahmed Portfolio',
            'slug' => 'default',
            'status' => 'active',
        ]);

        Profile::create([
            'workspace_id' => $defaultWorkspace->id,
            'name' => 'Md. Alif Ahmed',
            'designation' => 'Web Developer | Technical Project Lead',
            'headline' => 'Building Digital Experiences. Engineering Business Solutions.',
            'bio' => 'Dedicated Web Developer and Technical Project Lead.',
        ]);

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Md. Alif Ahmed');
    }
}
