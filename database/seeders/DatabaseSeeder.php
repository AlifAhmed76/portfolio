<?php

namespace Database\Seeders;

use App\Models\ContactDetail;
use App\Models\Profile;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Initial Workspace
        $workspace = Workspace::firstOrCreate(
            ['slug' => 'default'],
            [
                'name' => 'Alif Ahmed Portfolio',
                'status' => 'active',
            ]
        );

        // 2. Owner User (Credentials from env)
        $adminName = env('ADMIN_NAME', 'Md. Alif Ahmed');
        $adminEmail = env('ADMIN_EMAIL', 'admin@alifahmed.com');
        $adminPassword = env('ADMIN_PASSWORD', 'ChangeMeInProd123!');

        User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'workspace_id' => $workspace->id,
                'name' => $adminName,
                'password' => Hash::make($adminPassword),
                'role' => 'owner',
                'status' => 'active',
            ]
        );

        // 3. Initial Profile
        Profile::updateOrCreate(
            ['workspace_id' => $workspace->id],
            [
                'name' => $adminName,
                'designation' => 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist',
                'headline' => 'Building Digital Experiences. Engineering Business Solutions.',
                'bio' => 'Experienced Web Developer and Technical Project Lead specializing in custom Laravel web application engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, and performance optimization.',
            ]
        );

        // 4. Initial Contact Details (clearly labeled placeholders for unconfirmed fields)
        ContactDetail::updateOrCreate(
            ['workspace_id' => $workspace->id],
            [
                'email' => $adminEmail,
                'phone' => 'Pending: owner to confirm',
                'whatsapp' => 'Pending: owner to confirm',
                'location' => 'Pending: owner to confirm',
                'availability_status' => 'Available for Technical Leadership & Development',
            ]
        );

        // 5. Initial Site Settings
        $defaultSettings = [
            'site_title' => ['ALIF AHMED — Portfolio', 'string'],
            'tagline' => ['Building Digital Experiences. Engineering Business Solutions.', 'string'],
            'active_theme' => ['crystal-3d', 'string'],
            'accent_color' => ['#10b981', 'string'],
            'default_language' => ['en', 'string'],
        ];

        foreach ($defaultSettings as $key => [$value, $type]) {
            SiteSetting::updateOrCreate(
                ['workspace_id' => $workspace->id, 'setting_key' => $key],
                ['setting_value' => $value, 'value_type' => $type]
            );
        }

        // 6. Initial Social Links (user-defined platforms, clearly labeled placeholders)
        $socialLinks = [
            ['platform' => 'github', 'label' => 'GitHub', 'url' => 'https://github.com/Pending-owner-to-confirm', 'icon' => 'github', 'sort_order' => 1],
            ['platform' => 'linkedin', 'label' => 'LinkedIn', 'url' => 'https://linkedin.com/in/Pending-owner-to-confirm', 'icon' => 'linkedin', 'sort_order' => 2],
            ['platform' => 'facebook', 'label' => 'Facebook', 'url' => 'https://facebook.com/Pending-owner-to-confirm', 'icon' => 'facebook', 'sort_order' => 3],
        ];

        foreach ($socialLinks as $link) {
            SocialLink::updateOrCreate(
                ['workspace_id' => $workspace->id, 'platform' => $link['platform']],
                $link
            );
        }
    }
}
