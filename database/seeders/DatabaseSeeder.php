<?php

namespace Database\Seeders;

use App\Models\ContactDetail;
use App\Models\HomepageSection;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectCategory;
use App\Models\ProjectDetail;
use App\Models\ProjectLink;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\SocialLink;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

        $owner = User::firstOrCreate(
            ['email' => $adminEmail],
            [
                'workspace_id' => $workspace->id,
                'name' => $adminName,
                'password' => Hash::make($adminPassword),
                'role' => 'owner',
                'status' => 'active',
            ]
        );

        // 3. Initial Profile (Strictly NO "Sr.")
        Profile::updateOrCreate(
            ['workspace_id' => $workspace->id],
            [
                'name' => $adminName,
                'designation' => 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist',
                'headline' => 'Building Digital Experiences. Engineering Business Solutions.',
                'bio' => 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.',
            ]
        );

        // 4. Initial Contact Details (clearly labeled placeholders for unverified fields)
        ContactDetail::updateOrCreate(
            ['workspace_id' => $workspace->id],
            [
                'email' => $adminEmail,
                'phone' => 'Pending: owner to confirm',
                'whatsapp' => 'Pending: owner to confirm',
                'location' => 'Dhaka, Bangladesh (Available Worldwide)',
                'availability_status' => 'Available for Select Projects & Leadership Roles',
            ]
        );

        // 5. Initial Site Settings
        $defaultSettings = [
            'site_title' => ['ALIF AHMED — Web Developer & Technical Project Lead', 'string'],
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

        // 7. Skill Categories & Core Technologies
        $skillCatalog = [
            'Backend & Architecture' => [
                ['name' => 'PHP/Laravel', 'desc' => 'Custom full-stack web applications, clean service layers, jobs & queue workers, Eloquent optimization', 'icon' => 'code'],
                ['name' => 'REST API Integration', 'desc' => 'Robust third-party RESTful API development, webhook handlers, and token authentication', 'icon' => 'network'],
                ['name' => 'WordPress/CMS Development', 'desc' => 'Custom theme & plugin development, headless architectures, dynamic content solutions', 'icon' => 'layout-template'],
            ],
            'Frontend & Interfaces' => [
                ['name' => 'JavaScript (ES6+)', 'desc' => 'Modern client-side scripting, asynchronous workflows, DOM optimization', 'icon' => 'file-code'],
                ['name' => 'Vue.js', 'desc' => 'Interactive reactive components, single-page application modules, state synchronization', 'icon' => 'box'],
                ['name' => 'HTML5 / CSS3 / Bootstrap 5', 'desc' => 'Mobile-first responsive layouts, accessible semantic markup, custom CSS token systems', 'icon' => 'palette'],
            ],
            'Data & E-Commerce' => [
                ['name' => 'MySQL / MariaDB', 'desc' => 'Relational database schema design, indexing strategies, transaction integrity, query profiling', 'icon' => 'database'],
                ['name' => 'E-Commerce Solutions', 'desc' => 'End-to-end commerce platforms, shopping carts, checkout workflows, inventory management', 'icon' => 'shopping-cart'],
                ['name' => 'Courier API Integration', 'desc' => 'Automated shipment parcel creation, real-time tracking webhooks, delivery status sync', 'icon' => 'truck'],
            ],
            'Tracking, Performance & Security' => [
                ['name' => 'Meta Pixel & Conversion API', 'desc' => 'Server-side event tracking, deduplication, accurate e-commerce conversion attribution', 'icon' => 'activity'],
                ['name' => 'Google Tag Manager', 'desc' => 'Data layer event instrumentation, custom analytics triggers, consent-mode compliance', 'icon' => 'tag'],
                ['name' => 'Performance & Security Hardening', 'desc' => 'Core Web Vitals tuning, caching layers, CSRF/XSS defense, secure headers', 'icon' => 'shield-check'],
            ],
        ];

        $sort = 1;
        $seededSkills = [];
        foreach ($skillCatalog as $categoryName => $skills) {
            $cat = SkillCategory::firstOrCreate(
                ['workspace_id' => $workspace->id, 'name' => $categoryName],
                ['slug' => Str::slug($categoryName), 'sort_order' => $sort++]
            );

            $skillSort = 1;
            foreach ($skills as $s) {
                $createdSkill = Skill::firstOrCreate(
                    ['workspace_id' => $workspace->id, 'category_id' => $cat->id, 'name' => $s['name']],
                    ['description' => $s['desc'], 'icon' => $s['icon'], 'sort_order' => $skillSort++]
                );
                $seededSkills[] = $createdSkill;
            }
        }

        // 8. Project Categories & Initial Showcase Projects
        $catEcommerce = ProjectCategory::firstOrCreate(
            ['workspace_id' => $workspace->id, 'slug' => 'e-commerce-solutions'],
            ['name' => 'E-Commerce Solutions']
        );

        $catWebApps = ProjectCategory::firstOrCreate(
            ['workspace_id' => $workspace->id, 'slug' => 'custom-web-applications'],
            ['name' => 'Custom Web Applications']
        );

        $project1 = Project::updateOrCreate(
            ['workspace_id' => $workspace->id, 'slug' => 'enterprise-ecommerce-platform'],
            [
                'category_id' => $catEcommerce->id,
                'title' => 'Enterprise E-Commerce Platform & Tracking Pipeline',
                'summary' => 'High-conversion e-commerce solution with automated courier logistics integration and dual-stream Meta Conversion API tracking.',
                'description' => 'A comprehensive digital commerce infrastructure engineered with Laravel, MySQL, and Vue.js. Features high-throughput checkout processing, automated order dispatch via courier APIs, and precise server-side event tracking.',
                'status' => 'published',
                'is_featured' => true,
                'sort_order' => 1,
                'published_at' => now(),
            ]
        );

        ProjectDetail::updateOrCreate(
            ['project_id' => $project1->id],
            [
                'challenge' => 'Client faced high cart abandonment, manual parcel booking delays, and inaccurate browser-based conversion tracking due to ad blockers and iOS privacy restrictions.',
                'solution' => 'Engineered a streamlined one-page checkout, built direct asynchronous courier API integrations for instant tracking code generation, and implemented Meta Conversion API server-side tracking with event deduplication.',
                'implementation' => 'Developed custom Laravel service wrappers for logistics endpoints, utilized database queue workers for resilient webhook processing, and constructed a robust data layer for Google Tag Manager.',
                'outcome' => 'Pending: owner to confirm exact metric percentage; achieved instant label dispatch and near-zero conversion tracking loss across Safari and mobile devices.',
            ]
        );

        ProjectLink::firstOrCreate(
            ['project_id' => $project1->id, 'link_type' => 'live'],
            ['label' => 'Live Case Preview', 'url' => 'https://example.com/demo-ecommerce', 'sort_order' => 1]
        );

        // Attach first 4 skills to Project 1
        if (! empty($seededSkills)) {
            $project1->skills()->sync(array_slice(array_column($seededSkills, 'id'), 0, 4));
        }

        // 9. Initial Services
        $services = [
            [
                'title' => 'Custom Laravel Web Engineering',
                'desc' => 'End-to-end full-stack web applications crafted with clean architectural layers, database design, REST APIs, and strict security standards.',
                'icon' => 'code-2',
                'sort' => 1,
            ],
            [
                'title' => 'E-Commerce Architecture & Optimization',
                'desc' => 'High-performance digital storefronts featuring custom cart systems, payment gateways, and automated order fulfillment pipelines.',
                'icon' => 'shopping-cart',
                'sort' => 2,
            ],
            [
                'title' => 'Logistics & Courier API Integration',
                'desc' => 'Direct automated connection with parcel courier services, consignment booking, automated tracking updates, and delivery webhooks.',
                'icon' => 'truck',
                'sort' => 3,
            ],
            [
                'title' => 'Server-Side Analytics & Conversion APIs',
                'desc' => 'First-party server-side tracking via Meta Conversion API and Google Tag Manager to capture resilient, privacy-compliant attribution.',
                'icon' => 'activity',
                'sort' => 4,
            ],
            [
                'title' => 'Speed & Security Hardening',
                'desc' => 'Comprehensive code audits, Core Web Vitals optimization, query profiling, caching strategies, and defensive web application security.',
                'icon' => 'shield-check',
                'sort' => 5,
            ],
        ];

        foreach ($services as $srv) {
            Service::updateOrCreate(
                ['workspace_id' => $workspace->id, 'title' => $srv['title']],
                [
                    'description' => $srv['desc'],
                    'icon' => $srv['icon'],
                    'is_enabled' => true,
                    'sort_order' => $srv['sort'],
                ]
            );
        }

        // 10. Initial Homepage Sections
        $defaultSections = [
            ['key' => 'hero', 'title' => 'Hero Banner', 'order' => 1],
            ['key' => 'highlights', 'title' => 'Professional Highlights', 'order' => 2],
            ['key' => 'about', 'title' => 'About Alif Ahmed', 'order' => 3],
            ['key' => 'expertise', 'title' => 'Technical Expertise & Skills', 'order' => 4],
            ['key' => 'projects', 'title' => 'Featured Projects & Case Studies', 'order' => 5],
            ['key' => 'services', 'title' => 'Services & Solutions', 'order' => 6],
            ['key' => 'experience', 'title' => 'Professional Experience', 'order' => 7],
            ['key' => 'education', 'title' => 'Education & Credentials', 'order' => 8],
            ['key' => 'process', 'title' => 'Working Process', 'order' => 9],
            ['key' => 'blog', 'title' => 'Latest Insights & Articles', 'order' => 10],
            ['key' => 'contact', 'title' => 'Get in Touch', 'order' => 11],
        ];

        foreach ($defaultSections as $sec) {
            HomepageSection::updateOrCreate(
                ['workspace_id' => $workspace->id, 'section_key' => $sec['key']],
                ['title' => $sec['title'], 'sort_order' => $sec['order'], 'is_enabled' => true]
            );
        }

        // 11. Initial Page Templates
        \App\Models\PageTemplate::firstOrCreate(
            ['slug' => 'blank-canvas'],
            [
                'name' => 'Blank Canvas',
                'is_system' => true,
                'version' => '1.0',
                'schema_json' => [],
            ]
        );

        \App\Models\PageTemplate::firstOrCreate(
            ['slug' => 'landing-page'],
            [
                'name' => 'Standard Landing Page',
                'is_system' => true,
                'version' => '1.0',
                'schema_json' => [
                    [
                        'id' => 'block-hero-1',
                        'type' => 'hero',
                        'enabled' => true,
                        'settings' => [
                            'badge' => 'Available for Strategic Web Projects',
                            'headline' => 'Web Developer | Technical Project Lead',
                            'subheadline' => 'Building enterprise-grade web applications, e-commerce architectures, and high-performance APIs.',
                            'cta_primary_label' => 'Explore Work',
                            'cta_primary_url' => '#projects',
                            'cta_secondary_label' => 'Initiate Contact',
                            'cta_secondary_url' => '#contact',
                        ],
                    ],
                    [
                        'id' => 'block-about-1',
                        'type' => 'about',
                        'enabled' => true,
                        'settings' => [
                            'title' => 'Engineering Excellence',
                            'subtitle' => 'About Alif Ahmed',
                            'bio' => 'Dedicated technical project lead with deep expertise in custom Laravel engineering, high-scale database optimization, and conversion-focused architecture.',
                            'highlights' => 'Technical Project Management, High-Throughput E-Commerce, Meta Conversion API',
                        ],
                    ],
                    [
                        'id' => 'block-projects-1',
                        'type' => 'projects',
                        'enabled' => true,
                        'settings' => [
                            'title' => 'Featured Engineering Cases',
                            'subtitle' => 'Production Implementations',
                            'limit' => 6,
                            'featured_only' => true,
                            'layout' => 'grid',
                        ],
                    ],
                    [
                        'id' => 'block-contact-1',
                        'type' => 'contact',
                        'enabled' => true,
                        'settings' => [
                            'title' => 'Start a Project Conversation',
                            'subtitle' => 'Direct Consultation & Engagement',
                            'form_enabled' => true,
                            'show_socials' => true,
                        ],
                    ],
                ],
            ]
        );
    }
}
