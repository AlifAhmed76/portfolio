<?php

namespace Tests\Feature;

use App\Models\ContactDetail;
use App\Models\Profile;
use App\Models\SocialLink;
use App\Models\User;
use App\Models\Workspace;
use App\Services\WorkspaceResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class WorkspaceScopingTest extends TestCase
{
    use RefreshDatabase;

    public function test_workspace_models_are_scoped_to_current_workspace(): void
    {
        $workspaceA = Workspace::create(['name' => 'Workspace A', 'slug' => 'workspace-a', 'status' => 'active']);
        $workspaceB = Workspace::create(['name' => 'Workspace B', 'slug' => 'workspace-b', 'status' => 'active']);

        $userA = User::create([
            'workspace_id' => $workspaceA->id,
            'name' => 'Admin A',
            'email' => 'adminA@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Manually set workspace to A
        WorkspaceResolver::setCurrent($workspaceA);

        Profile::create([
            'workspace_id' => $workspaceA->id,
            'name' => 'Alif Ahmed Workspace A',
            'designation' => 'Lead Developer',
            'headline' => 'Building apps',
        ]);

        // Switch to workspace B
        WorkspaceResolver::setCurrent($workspaceB);

        Profile::create([
            'workspace_id' => $workspaceB->id,
            'name' => 'Other Person Workspace B',
            'designation' => 'Other Dev',
            'headline' => 'Other headline',
        ]);

        // When scoped to Workspace B, profile for Workspace A must not be visible
        $profilesInB = Profile::all();
        $this->assertCount(1, $profilesInB);
        $this->assertEquals('Other Person Workspace B', $profilesInB->first()->name);

        // When scoped to Workspace A, profile for Workspace B must not be visible
        WorkspaceResolver::setCurrent($workspaceA);
        $profilesInA = Profile::all();
        $this->assertCount(1, $profilesInA);
        $this->assertEquals('Alif Ahmed Workspace A', $profilesInA->first()->name);

        WorkspaceResolver::clear();
    }

    public function test_models_auto_assign_current_workspace_id_on_create(): void
    {
        $workspace = Workspace::create(['name' => 'Test Workspace', 'slug' => 'test-ws', 'status' => 'active']);
        WorkspaceResolver::setCurrent($workspace);

        $social = SocialLink::create([
            'platform' => 'github',
            'label' => 'GitHub',
            'url' => 'https://github.com/test',
        ]);

        $this->assertEquals($workspace->id, $social->workspace_id);

        WorkspaceResolver::clear();
    }

    public function test_workspace_resolver_resolves_from_authenticated_user(): void
    {
        WorkspaceResolver::clear();

        $workspace = Workspace::create(['name' => 'User Workspace', 'slug' => 'user-ws', 'status' => 'active']);
        $user = User::create([
            'workspace_id' => $workspace->id,
            'name' => 'User One',
            'email' => 'user1@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        $this->actingAs($user);

        $resolved = WorkspaceResolver::resolve();
        $this->assertNotNull($resolved);
        $this->assertEquals($workspace->id, $resolved->id);

        WorkspaceResolver::clear();
    }
}
