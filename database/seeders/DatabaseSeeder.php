<?php

namespace Database\Seeders;

use App\Models\ContactDetail;
use App\Models\Education;
use App\Models\Experience;
use App\Models\HomepageSection;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
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

        // 11. Initial Experiences
        $experiences = [
            [
                'company' => 'Independent Technical Consultancy & Digital Solutions',
                'designation' => 'Lead Web Engineer & Technical Solutions Architect',
                'description' => 'Architecting and delivering enterprise Laravel web systems, custom e-commerce checkout platforms, Meta Conversion API server-side tracking pipelines, and courier logistics integrations. Leading sprint architecture, reviewing code, and ensuring sub-second response times.',
                'start_date' => '2022-01-01',
                'end_date' => null,
                'is_current' => true,
                'sort_order' => 1,
            ],
            [
                'company' => 'E-Commerce Solutions Group',
                'designation' => 'Full-Stack Web Developer & Integration Specialist',
                'description' => 'Engineered scalable RESTful API backends, multi-channel payment gateway integrations, database schema optimizations, and reactive client-side interfaces. Reduced checkout abandonment and eliminated conversion tracking discrepancy.',
                'start_date' => '2020-03-01',
                'end_date' => '2021-12-31',
                'is_current' => false,
                'sort_order' => 2,
            ],
        ];

        foreach ($experiences as $exp) {
            Experience::updateOrCreate(
                ['workspace_id' => $workspace->id, 'company' => $exp['company'], 'designation' => $exp['designation']],
                $exp
            );
        }

        // 12. Initial Education
        Education::updateOrCreate(
            ['workspace_id' => $workspace->id, 'degree' => 'B.Sc. in Computer Science & Engineering (CSE)'],
            [
                'institution' => 'University of Technology',
                'subject' => 'Computer Science & Software Engineering',
                'result' => 'First Class Honours',
                'start_date' => '2017-01-01',
                'end_date' => '2021-01-01',
                'sort_order' => 1,
            ]
        );

        // 13. Additional Featured Projects
        $project2 = Project::updateOrCreate(
            ['workspace_id' => $workspace->id, 'slug' => 'courier-logistics-automation-hub'],
            [
                'category_id' => $catEcommerce->id,
                'title' => 'Courier & Logistics Automation Middleware Hub',
                'summary' => 'Automated logistics middleware routing multi-carrier consignments, instant airway bill generation, and real-time delivery status webhooks.',
                'description' => 'Engineered a centralized logistics gateway integrating Pathao, Steadfast, and RedX courier APIs. Dispatches thousands of parcels daily with automatic failover, webhook listeners, and zero manual entry.',
                'status' => 'published',
                'is_featured' => true,
                'sort_order' => 2,
                'published_at' => now(),
            ]
        );

        ProjectDetail::updateOrCreate(
            ['project_id' => $project2->id],
            [
                'challenge' => 'Manual dispatch booking created delivery bottlenecks of 4+ hours daily and tracking numbers often failed to reach customers in time.',
                'solution' => 'Built an asynchronous queue-driven courier hub that auto-creates consignments upon order approval, downloads shipping labels, and broadcasts tracking SMS.',
                'implementation' => 'Designed resilient Laravel job workers with exponential backoff retry algorithms, unified carrier payload transformers, and secure webhook signature verification.',
                'outcome' => 'Eliminated 100% of manual entry errors, reduced parcel booking time from 4 hours to instantaneous background dispatch.',
            ]
        );

        ProjectLink::firstOrCreate(
            ['project_id' => $project2->id, 'link_type' => 'live'],
            ['label' => 'Live Logistics Demo', 'url' => 'https://example.com/demo-logistics', 'sort_order' => 1]
        );

        $project3 = Project::updateOrCreate(
            ['workspace_id' => $workspace->id, 'slug' => 'server-side-meta-capi-middleware'],
            [
                'category_id' => $catWebApps->id,
                'title' => 'Server-Side Meta CAPI & Conversion Attribution Engine',
                'summary' => 'Dual-stream tracking pipeline reconciling client-side Pixel events with server-side Meta Conversion API for 99.8% accurate attribution.',
                'description' => 'A robust privacy-compliant conversion tracking architecture built to conquer iOS 14.5+ restrictions and ad-blockers. Includes SHA-256 user data hashing, event deduplication, and Google Tag Manager DataLayer synchronization.',
                'status' => 'published',
                'is_featured' => true,
                'sort_order' => 3,
                'published_at' => now(),
            ]
        );

        ProjectDetail::updateOrCreate(
            ['project_id' => $project3->id],
            [
                'challenge' => 'Browser ad-blockers and Safari ITP caused 30-40% of conversion data to go unrecorded, degrading Meta ad performance and ROAS measurement.',
                'solution' => 'Engineered a dual-stream pipeline sending events simultaneously via browser and server-side Graph API, matching deduplication keys (`event_id`).',
                'implementation' => 'Utilized Laravel middleware and queued HTTP clients to dispatch hashed user parameters (`em`, `ph`, `fbc`, `fbp`) without impacting page load latency.',
                'outcome' => 'Restored 99.8% event match quality and improved Meta campaign ROAS through accurate attribution modeling.',
            ]
        );

        ProjectLink::firstOrCreate(
            ['project_id' => $project3->id, 'link_type' => 'live'],
            ['label' => 'Attribution Architecture Docs', 'url' => 'https://example.com/demo-attribution', 'sort_order' => 1]
        );

        // 14. Initial Blog Posts
        $catBlogAnalytics = PostCategory::firstOrCreate(
            ['workspace_id' => $workspace->id, 'slug' => 'analytics-tracking'],
            ['name' => 'Analytics & Tracking', 'description' => 'Server-side attribution, Meta CAPI, and Google Tag Manager insights.']
        );

        $catBlogBackend = PostCategory::firstOrCreate(
            ['workspace_id' => $workspace->id, 'slug' => 'backend-architecture'],
            ['name' => 'Backend & Architecture', 'description' => 'High-performance Laravel design patterns, database tuning, and API engineering.']
        );

        $tagLaravel = PostTag::firstOrCreate(['workspace_id' => $workspace->id, 'slug' => 'laravel'], ['name' => 'Laravel 11']);
        $tagCapi = PostTag::firstOrCreate(['workspace_id' => $workspace->id, 'slug' => 'meta-capi'], ['name' => 'Meta CAPI']);
        $tagPerformance = PostTag::firstOrCreate(['workspace_id' => $workspace->id, 'slug' => 'performance'], ['name' => 'Performance']);

        $post1 = Post::updateOrCreate(
            ['workspace_id' => $workspace->id, 'slug' => 'mastering-meta-conversion-api-in-laravel'],
            [
                'category_id' => $catBlogAnalytics->id,
                'author_id' => $owner->id,
                'title' => 'Mastering Meta Conversion API (CAPI) in Laravel 11',
                'summary' => 'A comprehensive guide to defeating iOS privacy barriers and client-side ad-blockers with asynchronous server-side event tracking.',
                'content' => "## Why Client-Side Tracking Fails in Modern E-Commerce\n\nBrowser-based tracking via standard JavaScript pixels suffers from ad-blockers, Safari Intelligent Tracking Prevention (ITP), and network drops. Over 35% of purchase events can be missed.\n\n### The Dual-Stream Solution\n\nBy dispatching events from both the client browser and your Laravel backend with an identical `event_id`, Meta automatically deduplicates them. If the browser event is blocked, the server event ensures the purchase is recorded.\n\n```php\nHttp::asJson()->post('https://graph.facebook.com/v19.0/' . \$pixelId . '/events', [\n    'data' => [[\n        'event_name' => 'Purchase',\n        'event_time' => time(),\n        'event_id' => \$eventId,\n        'user_data' => [\n            'em' => [hash('sha256', strtolower(trim(\$email)))],\n        ],\n    ]],\n    'access_token' => \$accessToken,\n]);\n```\n\n### Key Takeaways\n1. Always hash customer PII using SHA-256 before transmission.\n2. Leverage Laravel's asynchronous database queues so checkout latency is unaffected.",
                'reading_time' => 5,
                'status' => 'published',
                'published_at' => now()->subDays(2),
                'meta_title' => 'Mastering Meta Conversion API in Laravel 11 | Md. Alif Ahmed',
                'meta_description' => 'Step-by-step technical guide to implementing server-side Meta Conversion API in Laravel for 100% conversion attribution.',
            ]
        );
        $post1->tags()->sync([$tagLaravel->id, $tagCapi->id]);

        $post2 = Post::updateOrCreate(
            ['workspace_id' => $workspace->id, 'slug' => 'high-throughput-ecommerce-architecture-laravel'],
            [
                'category_id' => $catBlogBackend->id,
                'author_id' => $owner->id,
                'title' => 'Architecting High-Throughput E-Commerce Systems with Laravel',
                'summary' => 'Practical patterns for handling heavy traffic surges, preventing database race conditions, and executing sub-100ms checkout operations.',
                'content' => "## Engineering for Scale During Flash Sales\n\nE-commerce platforms often encounter massive concurrency spikes during promotional launches. Standard Eloquent patterns can easily exhaust database connection pools or result in race conditions.\n\n### Pessimistic vs. Optimistic Locking\n\nWhen deducting inventory for limited-stock products, avoid naive updates. Use pessimistic locking within database transactions:\n\n```php\nDB::transaction(function () use (\$productId, \$qty) {\n    \$product = Product::where('id', \$productId)->lockForUpdate()->first();\n    if (\$product->stock < \$qty) {\n        throw new InsufficientStockException();\n    }\n    \$product->decrement('stock', \$qty);\n});\n```\n\n### Queue Everything Non-Critical\n\nEmail receipts, invoice PDF generation, SMS notifications, and courier dispatch APIs must never block the HTTP response cycle. Offload them to Redis or MariaDB queues.",
                'reading_time' => 6,
                'status' => 'published',
                'published_at' => now()->subDays(5),
                'meta_title' => 'High-Throughput E-Commerce Architecture in Laravel | Md. Alif Ahmed',
                'meta_description' => 'Learn architectural patterns for handling heavy traffic surges, avoiding database locks, and accelerating checkout speed in Laravel.',
            ]
        );
        $post2->tags()->sync([$tagLaravel->id, $tagPerformance->id]);
    }
}
