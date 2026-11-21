<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    protected Workspace $workspace;
    protected User $admin;

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
    }

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
        $response->assertSee('ALIF AHMED');
    }

    public function test_admin_can_login_with_valid_credentials(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@alifahmed.com',
            'password' => 'Secret123!',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_admin_cannot_login_with_invalid_credentials(): void
    {
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@alifahmed.com',
            'password' => 'WrongPassword',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_is_throttled_after_too_many_attempts(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $this->post(route('admin.login.submit'), [
                'email' => 'admin@alifahmed.com',
                'password' => 'WrongPassword',
            ]);
        }

        // 6th attempt should be blocked by RateLimiter
        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@alifahmed.com',
            'password' => 'WrongPassword',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
    }

    public function test_authenticated_admin_can_access_dashboard(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('System Overview');
        $response->assertSee('Md. Alif Ahmed');
    }

    public function test_admin_can_logout(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.logout'));
        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_inactive_user_cannot_login(): void
    {
        $this->admin->update(['status' => 'inactive']);

        $response = $this->post(route('admin.login.submit'), [
            'email' => 'admin@alifahmed.com',
            'password' => 'Secret123!',
        ]);

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
