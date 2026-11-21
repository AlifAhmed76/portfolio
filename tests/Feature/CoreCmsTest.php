<?php

namespace Tests\Feature;

use App\Models\ContactDetail;
use App\Models\Education;
use App\Models\Experience;
use App\Models\HomepageSection;
use App\Models\Media;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\Service;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\SocialLink;
use App\Models\User;
use App\Models\Workspace;
use App\Services\MediaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CoreCmsTest extends TestCase
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

        Storage::fake('public');
    }

    public function test_admin_can_update_profile_and_forbids_sr_in_designation(): void
    {
        Profile::create([
            'workspace_id' => $this->workspace->id,
            'name' => 'Md. Alif Ahmed',
            'designation' => 'Web Developer',
            'headline' => 'Headline',
        ]);

        // Attempting to include "Sr." in designation must fail validation
        $failResponse = $this->actingAs($this->admin)->put(route('admin.identity.profile.update'), [
            'name' => 'Md. Alif Ahmed',
            'designation' => 'Sr. Web Developer',
            'headline' => 'Headline',
        ]);
        $failResponse->assertSessionHasErrors('designation');

        // Valid designation without "Sr." succeeds
        $successResponse = $this->actingAs($this->admin)->put(route('admin.identity.profile.update'), [
            'name' => 'Md. Alif Ahmed',
            'designation' => 'Web Developer | Technical Project Lead',
            'headline' => 'Building Digital Experiences. Engineering Business Solutions.',
            'bio' => 'Updated biography text.',
        ]);

        $successResponse->assertRedirect(route('admin.identity.index'));
        $this->assertDatabaseHas('profiles', [
            'designation' => 'Web Developer | Technical Project Lead',
            'bio' => 'Updated biography text.',
        ]);
    }

    public function test_admin_can_update_contact_details(): void
    {
        $response = $this->actingAs($this->admin)->put(route('admin.identity.contact.update'), [
            'email' => 'contact@alifahmed.com',
            'phone' => '+8801700000000',
            'whatsapp' => '+8801700000000',
            'location' => 'Dhaka, Bangladesh',
            'availability_status' => 'Available for Q1 Projects',
        ]);

        $response->assertRedirect(route('admin.identity.index'));
        $this->assertDatabaseHas('contact_details', [
            'email' => 'contact@alifahmed.com',
            'availability_status' => 'Available for Q1 Projects',
        ]);
    }

    public function test_social_links_crud_and_toggle(): void
    {
        // 1. Create
        $response = $this->actingAs($this->admin)->post(route('admin.identity.social.store'), [
            'platform' => 'github',
            'label' => 'GitHub',
            'url' => 'https://github.com/alifahmed',
            'sort_order' => 1,
            'is_enabled' => true,
        ]);

        $response->assertRedirect(route('admin.identity.index'));
        $this->assertDatabaseHas('social_links', [
            'platform' => 'github',
            'url' => 'https://github.com/alifahmed',
        ]);

        $link = SocialLink::first();

        // 2. Update
        $this->actingAs($this->admin)->put(route('admin.identity.social.update', $link), [
            'platform' => 'github',
            'label' => 'GitHub Profile',
            'url' => 'https://github.com/alifahmed-updated',
            'sort_order' => 2,
            'is_enabled' => false,
        ]);

        $this->assertDatabaseHas('social_links', [
            'label' => 'GitHub Profile',
            'is_enabled' => false,
        ]);

        // 3. Delete
        $this->actingAs($this->admin)->delete(route('admin.identity.social.destroy', $link));
        $this->assertDatabaseMissing('social_links', ['id' => $link->id]);
    }

    public function test_media_upload_validation_and_safe_delete(): void
    {
        $mediaService = app(MediaService::class);

        // Upload valid file
        $file = UploadedFile::fake()->image('portfolio-cover.jpg', 800, 600);
        $media = $mediaService->upload($file, 'Portfolio Cover');

        $this->assertDatabaseHas('media', [
            'id' => $media->id,
            'original_name' => 'portfolio-cover.jpg',
            'alt_text' => 'Portfolio Cover',
        ]);

        // Reference the media in a project
        $project = Project::create([
            'workspace_id' => $this->workspace->id,
            'title' => 'Project with Cover',
            'slug' => 'project-with-cover',
            'cover_image_id' => $media->id,
            'status' => 'published',
        ]);

        // Deleting referenced media must throw an exception
        $this->expectException(\InvalidArgumentException::class);
        $mediaService->delete($media);
    }

    public function test_project_crud_with_case_study_and_skills(): void
    {
        $category = ProjectCategory::create([
            'workspace_id' => $this->workspace->id,
            'name' => 'Web Apps',
            'slug' => 'web-apps',
        ]);

        $skillCategory = SkillCategory::create([
            'workspace_id' => $this->workspace->id,
            'name' => 'Backend',
            'slug' => 'backend',
        ]);

        $skill = Skill::create([
            'workspace_id' => $this->workspace->id,
            'category_id' => $skillCategory->id,
            'name' => 'Laravel',
            'description' => 'Eloquent, Queues, Service Architecture',
        ]);

        // Create Project
        $response = $this->actingAs($this->admin)->post(route('admin.projects.store'), [
            'title' => 'E-Commerce Solution',
            'slug' => 'e-commerce-solution',
            'category_id' => $category->id,
            'summary' => 'High volume e-commerce project',
            'description' => 'Comprehensive architecture breakdown',
            'status' => 'published',
            'is_featured' => 1,
            'sort_order' => 1,
            'skills' => [$skill->id],
            'challenge' => 'Handling 500 orders/minute',
            'solution' => 'Built Redis queue worker pipeline',
            'implementation' => 'Used Laravel jobs and database optimization',
            'outcome' => 'Zero dropped checkouts',
            'links' => [
                ['link_type' => 'live', 'label' => 'Live Store', 'url' => 'https://store.example.com'],
            ],
        ]);

        $response->assertRedirect(route('admin.projects.index'));

        $this->assertDatabaseHas('projects', [
            'title' => 'E-Commerce Solution',
            'slug' => 'e-commerce-solution',
            'is_featured' => true,
        ]);

        $project = Project::where('slug', 'e-commerce-solution')->first();
        $this->assertNotNull($project->detail);
        $this->assertEquals('Handling 500 orders/minute', $project->detail->challenge);
        $this->assertTrue($project->skills->contains($skill));
        $this->assertCount(1, $project->links);
    }

    public function test_skills_categories_and_services_crud(): void
    {
        // 1. Skill Category
        $catResponse = $this->actingAs($this->admin)->post(route('admin.skills.category.store'), [
            'name' => 'Cloud & DevOps',
            'sort_order' => 5,
        ]);
        $catResponse->assertStatus(302);
        $this->assertDatabaseHas('skill_categories', ['name' => 'Cloud & DevOps']);

        $category = SkillCategory::where('name', 'Cloud & DevOps')->first();

        // 2. Skill under Category
        $skillResponse = $this->actingAs($this->admin)->post(route('admin.skills.store'), [
            'category_id' => $category->id,
            'name' => 'Docker',
            'description' => 'Containerized local and staging deployments',
        ]);
        $skillResponse->assertStatus(302);
        $this->assertDatabaseHas('skills', ['name' => 'Docker', 'category_id' => $category->id]);

        // 3. Service
        $serviceResponse = $this->actingAs($this->admin)->post(route('admin.services.store'), [
            'title' => 'Technical Consulting',
            'description' => 'Advising on system architecture and code reviews.',
            'icon' => 'briefcase',
            'is_enabled' => 1,
            'sort_order' => 1,
        ]);
        $serviceResponse->assertStatus(302);
        $this->assertDatabaseHas('services', ['title' => 'Technical Consulting']);
    }

    public function test_homepage_sections_can_be_reordered_and_toggled(): void
    {
        $section = HomepageSection::create([
            'workspace_id' => $this->workspace->id,
            'section_key' => 'hero',
            'title' => 'Hero Banner',
            'is_enabled' => true,
            'sort_order' => 1,
        ]);

        // Toggle visibility
        $toggleResponse = $this->actingAs($this->admin)->post(route('admin.sections.toggle', $section));
        $toggleResponse->assertStatus(302);
        $this->assertDatabaseHas('homepage_sections', [
            'id' => $section->id,
            'is_enabled' => false,
        ]);

        // Update sort order and title
        $updateResponse = $this->actingAs($this->admin)->put(route('admin.sections.update', $section), [
            'title' => 'Main Hero Showcase',
            'sort_order' => 5,
            'is_enabled' => 1,
        ]);
        $updateResponse->assertStatus(302);
        $this->assertDatabaseHas('homepage_sections', [
            'id' => $section->id,
            'title' => 'Main Hero Showcase',
            'sort_order' => 5,
            'is_enabled' => true,
        ]);
    }
}
