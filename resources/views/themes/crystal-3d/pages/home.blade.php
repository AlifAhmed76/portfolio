@extends('themes.crystal-3d.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@section('content')
<div class="container py-4">

    <!-- Section 1: Hero Banner (Rich 3D Visual Showcase) -->
    <section id="hero" class="py-5 mb-4">
        <div class="crystal-card-3d p-4 p-lg-5 position-relative overflow-hidden">
            <div class="row align-items-center g-5">
                <div class="col-lg-7 text-center text-lg-start">
                    <div class="d-inline-flex align-items-center gap-2 badge-crystal mb-3">
                        <span class="beacon-dot"></span>
                        <span>{{ $contact->availability_status ?? 'Available for Select Projects & Leadership Roles' }}</span>
                    </div>

                    <h1 class="display-3 fw-bold mb-2">
                        {{ $profile->name ?? 'Md. Alif Ahmed' }}
                    </h1>

                    <h2 class="h4 text-emerald fw-semibold mb-3">
                        {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
                    </h2>

                    <p class="lead text-secondary mb-4" style="font-size: 1.15rem; max-width: 680px;">
                        {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                        Specialized in custom Laravel backends, high-conversion e-commerce storefronts, multi-carrier courier API integrations, and resilient Meta Conversion API server-side tracking pipelines.
                    </p>

                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 mb-4">
                        <a href="#projects" class="btn btn-emerald px-4 py-3 d-inline-flex align-items-center gap-2">
                            <i data-lucide="folder-git-2" style="width: 18px; height: 18px;"></i>
                            <span>Explore Case Studies</span>
                        </a>
                        <a href="#contact" class="btn btn-crystal-outline px-4 py-3 d-inline-flex align-items-center gap-2">
                            <i data-lucide="mail" style="width: 18px; height: 18px;"></i>
                            <span>Discuss Sprints</span>
                        </a>
                    </div>

                    <!-- Core Technologies Quick Pills -->
                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start align-items-center gap-2 pt-3 border-top border-secondary-subtle opacity-75">
                        <span class="small text-secondary me-2">Core Stack:</span>
                        <span class="badge bg-body-secondary text-body px-3 py-2">PHP 8.2+</span>
                        <span class="badge bg-body-secondary text-body px-3 py-2">Laravel 11</span>
                        <span class="badge bg-body-secondary text-body px-3 py-2">MySQL / MariaDB</span>
                        <span class="badge bg-body-secondary text-body px-3 py-2">Meta CAPI &amp; GTM</span>
                        <span class="badge bg-body-secondary text-body px-3 py-2">Courier APIs</span>
                        <span class="badge bg-body-secondary text-body px-3 py-2">Alpine.js / Vue</span>
                        <span class="badge bg-body-secondary text-body px-3 py-2">Docker</span>
                    </div>
                </div>

                <!-- Right Column: 3D Holographic Crystal Card -->
                <div class="col-lg-5 text-center">
                    <div class="p-4 rounded-4 crystal-surface position-relative shadow-lg border border-emerald-subtle" style="background: radial-gradient(circle at 50% 30%, rgba(16, 185, 129, 0.15), rgba(15, 23, 42, 0.85));">
                        
                        <!-- 3D Holographic Prism Frame -->
                        <div class="prism-orb mb-4 position-relative overflow-hidden">
                            <div class="avatar-glow-ring"></div>
                            @if ($profile?->avatar || $profile?->profileImage)
                                <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" 
                                     alt="{{ $profile->name ?? 'Md. Alif Ahmed' }}" 
                                     class="rounded-circle w-100 h-100 object-fit-cover position-relative p-1" 
                                     style="z-index: 2;">
                            @else
                                <div class="hologram-monogram position-relative d-flex flex-column align-items-center justify-content-center" style="z-index: 2;">
                                    <span class="display-6 fw-bold text-emerald mb-0" style="letter-spacing: 2px;">AA</span>
                                    <span class="badge bg-emerald-subtle text-emerald" style="font-size: 0.65rem; letter-spacing: 1.5px;">SYSTEM LEAD</span>
                                </div>
                            @endif
                        </div>

                        <!-- Floating Tech Hologram Tags -->
                        <div class="d-flex flex-column gap-2 text-start">
                            <div class="d-flex justify-content-between align-items-center p-2 px-3 rounded-3 crystal-surface border border-secondary-subtle">
                                <span class="small fw-semibold"><i data-lucide="shield-check" class="text-emerald me-1" style="width: 15px; height: 15px;"></i> Enterprise Architecture</span>
                                <span class="badge bg-emerald-subtle text-emerald small">Verified</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-2 px-3 rounded-3 crystal-surface border border-secondary-subtle">
                                <span class="small fw-semibold"><i data-lucide="activity" class="text-emerald me-1" style="width: 15px; height: 15px;"></i> Server-Side CAPI Tracking</span>
                                <span class="badge bg-emerald-subtle text-emerald small">99.8% Match</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-2 px-3 rounded-3 crystal-surface border border-secondary-subtle">
                                <span class="small fw-semibold"><i data-lucide="truck" class="text-emerald me-1" style="width: 15px; height: 15px;"></i> Multi-Courier Logistics Hub</span>
                                <span class="badge bg-emerald-subtle text-emerald small">Automated</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Key Metrics & Highlights -->
    <section id="highlights" class="mb-5 pb-3">
        <div class="row g-4">
            @foreach ($stats as $stat)
                <div class="col-6 col-lg-3">
                    <div class="crystal-card-3d p-4 h-100 text-center d-flex flex-column justify-content-center align-items-center">
                        <div class="icon-box mb-3">
                            <i data-lucide="{{ $stat['icon'] }}" style="width: 24px; height: 24px;"></i>
                        </div>
                        <h3 class="display-6 fw-bold text-emerald mb-1">{{ $stat['value'] }}</h3>
                        <p class="small text-secondary mb-0 fw-medium">{{ $stat['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 3: About Me -->
    <section id="about" class="mb-5 py-4">
        <div class="row g-4 align-items-stretch">
            <div class="col-lg-7">
                <div class="crystal-card-3d p-4 p-md-5 h-100 d-flex flex-column">
                    <span class="badge-crystal align-self-start mb-3">Professional Biography</span>
                    <h2 class="h2 fw-bold mb-4">Engineering Reliable Web Architectures That Drive Real Business Growth</h2>
                    <p class="text-secondary mb-4 leading-relaxed">
                        {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
                    </p>
                    <p class="text-secondary mb-4 leading-relaxed">
                        My development methodology is anchored in architectural clarity, defensive database design, and sub-second execution speeds. Whether rescuing cart abandonment with streamlined checkouts or circumventing ad-blockers with resilient server-side telemetry, I build systems engineered to withstand scale and protect company revenue.
                    </p>
                    <div class="row g-3 mt-auto pt-3 border-top border-secondary-subtle">
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i data-lucide="check" class="text-emerald" style="width: 18px; height: 18px;"></i>
                                <span class="small fw-semibold">Custom Laravel Engineering</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i data-lucide="check" class="text-emerald" style="width: 18px; height: 18px;"></i>
                                <span class="small fw-semibold">Zero-Loss Server Attribution</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i data-lucide="check" class="text-emerald" style="width: 18px; height: 18px;"></i>
                                <span class="small fw-semibold">Multi-Carrier API Automations</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <i data-lucide="check" class="text-emerald" style="width: 18px; height: 18px;"></i>
                                <span class="small fw-semibold">High Concurrency DB Profiling</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="crystal-card-3d p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <span class="badge-crystal mb-3 d-inline-block">Snapshot &amp; Logistics</span>
                        <h3 class="h4 fw-bold mb-4">Availability &amp; Location</h3>
                        
                        <div class="d-flex flex-column gap-3 mb-4">
                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-box flex-shrink-0" style="width: 42px; height: 42px;">
                                    <i data-lucide="map-pin" style="width: 18px; height: 18px;"></i>
                                </div>
                                <div>
                                    <span class="d-block small text-secondary">Location</span>
                                    <span class="fw-semibold">{{ $contact->location ?? 'Dhaka, Bangladesh (Available Worldwide)' }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-box flex-shrink-0" style="width: 42px; height: 42px;">
                                    <i data-lucide="briefcase" style="width: 18px; height: 18px;"></i>
                                </div>
                                <div>
                                    <span class="d-block small text-secondary">Role Focus</span>
                                    <span class="fw-semibold text-emerald">Technical Project Lead &amp; Web Architect</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-start gap-3">
                                <div class="icon-box flex-shrink-0" style="width: 42px; height: 42px;">
                                    <i data-lucide="languages" style="width: 18px; height: 18px;"></i>
                                </div>
                                <div>
                                    <span class="d-block small text-secondary">Languages</span>
                                    <span class="fw-semibold">English (Fluent Professional), Bengali (Native)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 crystal-surface border border-emerald-subtle rounded-3 text-center">
                        <p class="small text-secondary mb-2">Need direct technical advice or project planning?</p>
                        <a href="#contact" class="btn btn-sm btn-emerald w-100">Initiate Collaboration</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Technical Expertise & Skills Matrix -->
    <section id="expertise" class="mb-5 py-4">
        <div class="text-center mb-5">
            <span class="badge-crystal mb-2 d-inline-block">Competency Matrix</span>
            <h2 class="h2 fw-bold">Technical Expertise &amp; Core Stack</h2>
            <p class="text-secondary mx-auto" style="max-width: 650px;">
                Battle-tested skills across the modern software engineering lifecycle, from database transactions to server-side attribution pipelines.
            </p>
        </div>

        <div class="row g-4">
            @forelse ($skillCategories as $category)
                <div class="col-md-6 col-xl-3">
                    <div class="crystal-card-3d p-4 h-100 d-flex flex-column">
                        <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom border-secondary-subtle">
                            <i data-lucide="layers" class="text-emerald" style="width: 20px; height: 20px;"></i>
                            <h3 class="h5 fw-bold mb-0">{{ $category->name }}</h3>
                        </div>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-3 flex-grow-1">
                            @foreach ($category->skills as $skill)
                                <li class="d-flex align-items-start gap-2">
                                    <i data-lucide="chevron-right" class="text-emerald mt-1 flex-shrink-0" style="width: 15px; height: 15px;"></i>
                                    <div>
                                        <span class="d-block fw-semibold text-body small">{{ $skill->name }}</span>
                                        @if ($skill->description)
                                            <span class="d-block text-secondary" style="font-size: 0.78rem;">{{ $skill->description }}</span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4 text-secondary">
                    <p>Skills matrix loading...</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Section 5: Featured Projects & Case Studies (With Rich Visual Preview Mockups) -->
    <section id="projects" class="mb-5 py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
            <div>
                <span class="badge-crystal mb-2 d-inline-block">Production Engineering</span>
                <h2 class="h2 fw-bold mb-1">Featured Projects &amp; Case Studies</h2>
                <p class="text-secondary mb-0">Production systems solving real commercial, logistics, and attribution problems.</p>
            </div>
            <a href="{{ url('/projects') }}" class="btn btn-crystal-outline btn-sm d-inline-flex align-items-center gap-1">
                <span>View All Projects</span>
                <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
            </a>
        </div>

        <div class="row g-4">
            @forelse ($featuredProjects as $index => $project)
                <div class="col-md-6 col-lg-4">
                    <div class="crystal-card-3d p-4 h-100 d-flex flex-column">
                        
                        <!-- Visual Project Cover (Dynamic Uploaded Media or Editorial Case Cover) -->
                        <div class="project-card-visual mb-3 position-relative overflow-hidden" style="height: 195px; background: #0f172a;">
                            @if ($project->coverImage)
                                <img src="{{ $project->coverImage->url }}" 
                                     alt="{{ $project->title }}" 
                                     class="w-100 h-100 object-fit-cover project-img-zoom">
                            @else
                                <div class="editorial-project-cover w-100 h-100 d-flex flex-column justify-content-between p-3" 
                                     style="background: radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.22), transparent 60%), linear-gradient(135deg, #0b1120 0%, #020617 100%); border: 1px solid rgba(255, 255, 255, 0.08);">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-emerald-subtle text-emerald font-monospace px-2 py-1" style="font-size: 0.72rem;">
                                            {{ $project->category?->name ?? 'Enterprise Solution' }}
                                        </span>
                                        <div class="icon-circle" style="width: 28px; height: 28px; border-radius: 50%; background: rgba(255, 255, 255, 0.08); display: flex; align-items: center; justify-content: center;">
                                            <i data-lucide="arrow-up-right" class="text-emerald" style="width: 15px; height: 15px;"></i>
                                        </div>
                                    </div>
                                    <div class="my-auto">
                                        <div class="text-white fw-bold mb-1" style="font-size: 1.05rem;">{{ $project->title }}</div>
                                        <div class="text-secondary small line-clamp-2" style="font-size: 0.78rem;">{{ Str::limit($project->summary ?? $project->description, 80) }}</div>
                                    </div>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ($project->skills->take(3) as $ps)
                                            <span class="badge bg-secondary-subtle text-secondary" style="font-size: 0.65rem;">{{ $ps->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-secondary-subtle text-secondary small px-2 py-1">
                                {{ $project->category?->name ?? 'Enterprise Solution' }}
                            </span>
                            @if ($project->is_featured)
                                <span class="badge bg-emerald-subtle text-emerald small px-2 py-1">Featured</span>
                            @endif
                        </div>

                        <h3 class="h5 fw-bold mb-2">{{ $project->title }}</h3>
                        <p class="small text-secondary mb-3 flex-grow-1 leading-relaxed">
                            {{ $project->summary }}
                        </p>

                        <!-- Tech tags -->
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            @foreach ($project->skills->take(4) as $s)
                                <span class="badge bg-body-secondary text-body" style="font-size: 0.72rem;">{{ $s->name }}</span>
                            @endforeach
                        </div>

                        <div class="d-flex gap-2 mt-auto pt-3 border-top border-secondary-subtle">
                            <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-emerald flex-grow-1 text-center">
                                Case Study
                            </a>
                            @if ($project->links->where('link_type', 'live')->first())
                                <a href="{{ $project->links->where('link_type', 'live')->first()->url }}" target="_blank" rel="noopener" class="btn btn-sm btn-crystal-outline" title="Live Preview">
                                    <i data-lucide="external-link" style="width: 16px; height: 16px;"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4 text-secondary">
                    <p>Projects being loaded.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Section 6: Services & Solutions -->
    <section id="services" class="mb-5 py-4">
        <div class="text-center mb-5">
            <span class="badge-crystal mb-2 d-inline-block">Specialized Offerings</span>
            <h2 class="h2 fw-bold">Services &amp; Technical Capabilities</h2>
            <p class="text-secondary mx-auto" style="max-width: 650px;">
                High-impact engineering solutions tailored for scaling businesses, e-commerce brands, and technical teams.
            </p>
        </div>

        <div class="row g-4">
            @forelse ($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="crystal-card-3d p-4 h-100 d-flex flex-column">
                        <div class="icon-box mb-3">
                            <i data-lucide="{{ $service->icon ?: 'code' }}" style="width: 24px; height: 24px;"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-2">{{ $service->title }}</h3>
                        <p class="small text-secondary mb-4 flex-grow-1 leading-relaxed">
                            {{ $service->description }}
                        </p>
                        <div class="mt-auto pt-3 border-top border-secondary-subtle">
                            <a href="#contact" class="btn btn-sm btn-crystal-outline w-100 d-inline-flex justify-content-center align-items-center gap-1">
                                <span>Inquire About This Service</span>
                                <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4 text-secondary">
                    <p>Services loading...</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- Section 7: Professional Experience & Leadership -->
    <section id="experience" class="mb-5 py-4">
        <div class="text-center mb-5">
            <span class="badge-crystal mb-2 d-inline-block">Career Journey</span>
            <h2 class="h2 fw-bold">Professional Experience &amp; Leadership</h2>
            <p class="text-secondary mx-auto" style="max-width: 650px;">
                Demonstrated track record of delivering resilient software systems and guiding engineering initiatives.
            </p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex flex-column gap-4">
                    @forelse ($experiences as $exp)
                        <div class="crystal-card-3d p-4 p-md-4 timeline-node">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                                <h3 class="h5 fw-bold mb-0 text-body">{{ $exp->designation }}</h3>
                                <span class="badge bg-emerald-subtle text-emerald small">
                                    {{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} — 
                                    {{ $exp->is_current ? 'Present' : (\Carbon\Carbon::parse($exp->end_date)->format('M Y')) }}
                                </span>
                            </div>
                            <h4 class="h6 text-emerald fw-semibold mb-3">{{ $exp->company }}</h4>
                            <p class="small text-secondary mb-0 leading-relaxed">
                                {{ $exp->description }}
                            </p>
                        </div>
                    @empty
                        <div class="text-center py-4 text-secondary">
                            <p>Experience details loading...</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Section 8: Education & Credentials -->
    <section id="education" class="mb-5 py-4">
        <div class="text-center mb-5">
            <span class="badge-crystal mb-2 d-inline-block">Credentials</span>
            <h2 class="h2 fw-bold">Education &amp; Academic Background</h2>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                @forelse ($educations as $edu)
                    <div class="crystal-card-3d p-4 text-center">
                        <div class="icon-box mx-auto mb-3">
                            <i data-lucide="graduation-cap" style="width: 24px; height: 24px;"></i>
                        </div>
                        <h3 class="h5 fw-bold mb-1">{{ $edu->degree }}</h3>
                        <p class="text-emerald fw-medium mb-2">{{ $edu->institution }}</p>
                        <p class="small text-secondary mb-2">{{ $edu->subject }}</p>
                        @if ($edu->result)
                            <span class="badge bg-secondary-subtle text-secondary small">{{ $edu->result }}</span>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-4 text-secondary">
                        <p>Education records loading...</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Section 9: Engineering Process / Methodology -->
    <section id="process" class="mb-5 py-4">
        <div class="text-center mb-5">
            <span class="badge-crystal mb-2 d-inline-block">Execution Playbook</span>
            <h2 class="h2 fw-bold">Structured Execution Process &amp; Methodology</h2>
            <p class="text-secondary mx-auto" style="max-width: 650px;">
                A disciplined, predictable pipeline from architectural planning to zero-downtime production deployments.
            </p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-4">
                <div class="crystal-card-3d p-4 h-100">
                    <span class="h1 fw-bold text-emerald opacity-50 d-block mb-2">01</span>
                    <h3 class="h5 fw-bold mb-2">Discovery &amp; Architecture</h3>
                    <p class="small text-secondary mb-0">Deconstructing business goals, schema requirements, API contracts, and high-concurrency throughput expectations.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="crystal-card-3d p-4 h-100">
                    <span class="h1 fw-bold text-emerald opacity-50 d-block mb-2">02</span>
                    <h3 class="h5 fw-bold mb-2">Service-Layer Backend</h3>
                    <p class="small text-secondary mb-0">Building robust Laravel models, clean repositories, transactional integrity, and optimized MariaDB/MySQL indexes.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="crystal-card-3d p-4 h-100">
                    <span class="h1 fw-bold text-emerald opacity-50 d-block mb-2">03</span>
                    <h3 class="h5 fw-bold mb-2">API &amp; Queue Automation</h3>
                    <p class="small text-secondary mb-0">Integrating couriers, payment gateways, and Meta CAPI pipelines with asynchronous background jobs and retry fallbacks.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="crystal-card-3d p-4 h-100">
                    <span class="h1 fw-bold text-emerald opacity-50 d-block mb-2">04</span>
                    <h3 class="h5 fw-bold mb-2">Security, QA &amp; Hardening</h3>
                    <p class="small text-secondary mb-0">CSRF/XSS sanitization, rate-limiting, comprehensive automated tests (SQLite &amp; MariaDB), and Core Web Vitals optimization.</p>
                </div>
            </div>
            <div class="col-md-12 col-lg-6">
                <div class="crystal-card-3d p-4 h-100">
                    <span class="h1 fw-bold text-emerald opacity-50 d-block mb-2">05</span>
                    <h3 class="h5 fw-bold mb-2">CI/CD &amp; Telemetry</h3>
                    <p class="small text-secondary mb-0">Containerized Docker builds, automated zero-downtime deployment, error logging, and server health tracking.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 10: Technical Insights & Blog -->
    @if ($recentPosts->isNotEmpty())
        <section id="blog" class="mb-5 py-4">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                <div>
                    <span class="badge-crystal mb-2 d-inline-block">Technical Insights</span>
                    <h2 class="h2 fw-bold mb-1">Latest Articles &amp; Engineering Notes</h2>
                    <p class="text-secondary mb-0">Practical writeups on backend engineering, server-side tracking, and web architecture.</p>
                </div>
                <a href="{{ url('/blog') }}" class="btn btn-crystal-outline btn-sm d-inline-flex align-items-center gap-1">
                    <span>View All Articles</span>
                    <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
                </a>
            </div>

            <div class="row g-4">
                @foreach ($recentPosts as $post)
                    <div class="col-md-6">
                        <div class="crystal-card-3d p-4 h-100 d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-secondary-subtle text-secondary small">
                                    {{ $post->category?->name ?? 'Engineering' }}
                                </span>
                                <span class="small text-secondary">{{ $post->reading_time }} min read</span>
                            </div>

                            <h3 class="h5 fw-bold mb-2">
                                <a href="{{ url('/blog/' . $post->slug) }}" class="text-body text-decoration-none">
                                    {{ $post->title }}
                                </a>
                            </h3>

                            <p class="small text-secondary mb-4 flex-grow-1 leading-relaxed">
                                {{ $post->summary }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top border-secondary-subtle">
                                <span class="small text-secondary">{{ $post->published_at?->format('M d, Y') }}</span>
                                <a href="{{ url('/blog/' . $post->slug) }}" class="text-emerald text-decoration-none small fw-semibold">
                                    Read Article →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Section 11: Contact & Collaboration -->
    <section id="contact" class="mb-5 py-5">
        <div class="row g-4">
            <div class="col-lg-5">
                <div class="crystal-card-3d p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <span class="badge-crystal mb-3 d-inline-block">Get in Touch</span>
                        <h2 class="h2 fw-bold mb-3">Initiate Collaboration &amp; Strategic Builds</h2>
                        <p class="text-secondary mb-4 leading-relaxed">
                            Have an upcoming Laravel project, enterprise e-commerce platform, or tracking integration that demands clean architecture and reliable execution? Let's connect.
                        </p>

                        <div class="d-flex flex-column gap-3 mb-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box flex-shrink-0">
                                    <i data-lucide="mail" style="width: 20px; height: 20px;"></i>
                                </div>
                                <div>
                                    <span class="d-block small text-secondary">Direct Email</span>
                                    <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="fw-semibold text-body text-decoration-none">
                                        {{ $contact->email ?? 'admin@alifahmed.com' }}
                                    </a>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box flex-shrink-0">
                                    <i data-lucide="map-pin" style="width: 20px; height: 20px;"></i>
                                </div>
                                <div>
                                    <span class="d-block small text-secondary">Location</span>
                                    <span class="fw-semibold">{{ $contact->location ?? 'Dhaka, Bangladesh (Available Worldwide)' }}</span>
                                </div>
                            </div>

                            <div class="d-flex align-items-center gap-3">
                                <div class="icon-box flex-shrink-0">
                                    <i data-lucide="clock" style="width: 20px; height: 20px;"></i>
                                </div>
                                <div>
                                    <span class="d-block small text-secondary">Availability</span>
                                    <span class="fw-semibold text-emerald">{{ $contact->availability_status ?? 'Available for Select Projects' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3 border-top border-secondary-subtle">
                        <span class="d-block small text-secondary mb-2">Connect via Professional Networks:</span>
                        <div class="d-flex gap-2">
                            @foreach ($socialLinks as $link)
                                <a href="{{ $link->url }}" target="_blank" rel="noopener" class="btn btn-sm btn-crystal-outline p-2" title="{{ $link->label }}">
                                    <i data-lucide="{{ $link->icon ?: 'link' }}" style="width: 18px; height: 18px;"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="crystal-card-3d p-4 p-md-5 h-100">
                    <h3 class="h4 fw-bold mb-2">Send an Inquiry</h3>
                    <p class="small text-secondary mb-4">Fill out the form below and I will review and reply within 24 hours.</p>

                    @if (session('contact_success'))
                        <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
                            <i data-lucide="check-circle" style="width: 20px; height: 20px;"></i>
                            <span>{{ session('contact_success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger mb-4">
                            <ul class="mb-0 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="/contact" method="POST">
                        @csrf
                        <!-- Honeypot anti-spam trap (invisible to human users) -->
                        <div style="display:none !important;" aria-hidden="true">
                            <input type="text" name="hp_website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Your Name *</label>
                                <input type="text" name="name" class="form-control crystal-surface" value="{{ old('name') }}" placeholder="e.g. John Doe" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Your Email *</label>
                                <input type="email" name="email" class="form-control crystal-surface" value="{{ old('email') }}" placeholder="name@company.com" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Subject / Project Scope</label>
                            <input type="text" name="subject" class="form-control crystal-surface" value="{{ old('subject') }}" placeholder="e.g. E-Commerce Platform Architecture &amp; CAPI Integration">
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-secondary">Message / Technical Requirements *</label>
                            <textarea name="message" rows="5" class="form-control crystal-surface" placeholder="Describe your project, timeline, deliverables, or questions..." required>{{ old('message') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-emerald w-100 py-3 d-inline-flex align-items-center justify-content-center gap-2">
                            <i data-lucide="send" style="width: 18px; height: 18px;"></i>
                            <span>Send Message</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</div>
@endsection
