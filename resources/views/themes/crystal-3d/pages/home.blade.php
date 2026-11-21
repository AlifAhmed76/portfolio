@extends('themes.crystal-3d.layouts.app')

@section('title', 'Md. Alif Ahmed — Web Developer & Technical Project Lead')
@section('meta_description', 'Md. Alif Ahmed — Web Developer | Technical Project Lead | E-commerce Solutions Specialist. Enterprise Laravel systems, courier logistics, Meta Conversion API, and security hardening.')

@section('content')
<div class="container py-4">
    <!-- 2. Hero Section (CSS 3D Depth Facet) -->
    <section class="crystal-hero-wrapper mb-5 pt-3">
        <div class="crystal-surface crystal-hero-card p-4 p-md-5 text-center position-relative" id="heroCard">
            <!-- Availability Pill -->
            <div class="mb-4">
                <span class="badge px-3 py-2 rounded-pill border" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border-color: rgba(16, 185, 129, 0.3) !important;">
                    <span class="d-inline-block rounded-circle bg-success me-2" style="width: 8px; height: 8px; box-shadow: 0 0 8px #10b981;"></span>
                    {{ $contact->availability_status ?? 'Available for Select Projects & Leadership Roles' }}
                </span>
            </div>

            <!-- Identity & Title -->
            <h1 class="display-3 fw-bold mb-3 tracking-tight">
                {{ $profile->name ?? 'Md. Alif Ahmed' }}
            </h1>
            <h2 class="h4 text-emerald fw-semibold mb-3">
                {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
            </h2>

            <p class="lead text-secondary mx-auto mb-4" style="max-width: 780px; font-size: 1.15rem; line-height: 1.7;">
                {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
            </p>

            <div class="d-flex flex-wrap justify-content-center gap-3 pt-2">
                <a href="#projects" class="btn btn-emerald px-4 py-2">
                    Explore Case Studies &darr;
                </a>
                <a href="#contact" class="btn btn-outline-emerald px-4 py-2">
                    Initiate Collaboration &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- 3. Highlights Bar -->
    <section class="mb-5">
        <div class="row g-3">
            <div class="col-sm-6 col-lg-3">
                <div class="crystal-surface p-4 h-100 crystal-card-hover">
                    <div class="text-emerald mb-2">
                        <i data-lucide="layers" style="width: 28px; height: 28px;"></i>
                    </div>
                    <h5 class="fw-bold mb-1">Custom Laravel</h5>
                    <p class="small text-secondary mb-0">Full-stack web applications, clean service layers, jobs & queues.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="crystal-surface p-4 h-100 crystal-card-hover">
                    <div class="text-emerald mb-2">
                        <i data-lucide="shopping-cart" style="width: 28px; height: 28px;"></i>
                    </div>
                    <h5 class="fw-bold mb-1">E-Commerce & Logistics</h5>
                    <p class="small text-secondary mb-0">High-conversion checkout & courier API automated parcel dispatch.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="crystal-surface p-4 h-100 crystal-card-hover">
                    <div class="text-emerald mb-2">
                        <i data-lucide="activity" style="width: 28px; height: 28px;"></i>
                    </div>
                    <h5 class="fw-bold mb-1">Meta Conversion API</h5>
                    <p class="small text-secondary mb-0">Server-side event tracking, deduplication, and attribution resilience.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="crystal-surface p-4 h-100 crystal-card-hover">
                    <div class="text-emerald mb-2">
                        <i data-lucide="shield-check" style="width: 28px; height: 28px;"></i>
                    </div>
                    <h5 class="fw-bold mb-1">Speed & Security</h5>
                    <p class="small text-secondary mb-0">Core Web Vitals tuning, multi-layer caching, and query profiling.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. About Section -->
    <section class="mb-5 py-3" id="about">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="section-tag">// 01 Background</span>
                <h2 class="display-6 fw-bold mb-3">Engineering Resilient Digital Infrastructure</h2>
                <div class="text-secondary leading-relaxed mb-4">
                    <p class="mb-3">
                        {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
                    </p>
                    <p class="mb-0">
                        My approach bridges technical precision and commercial strategy: designing software systems that not only scale reliably under load, but directly accelerate revenue, reduce operational friction, and ensure complete data integrity.
                    </p>
                </div>

                <div class="row g-3">
                    <div class="col-sm-4">
                        <div class="p-3 crystal-surface">
                            <h6 class="text-emerald fw-bold mb-1">Full-Stack</h6>
                            <small class="text-secondary">Laravel, PHP, Vue, MySQL</small>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 crystal-surface">
                            <h6 class="text-emerald fw-bold mb-1">Architecture</h6>
                            <small class="text-secondary">Clean Services & Queue Workers</small>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="p-3 crystal-surface">
                            <h6 class="text-emerald fw-bold mb-1">Tracking</h6>
                            <small class="text-secondary">Server-side CAPI & GTM</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="crystal-surface p-4 p-md-5">
                    <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i data-lucide="compass" class="text-emerald"></i>
                        Core Engineering Principles
                    </h5>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-3 small text-secondary">
                        <li class="d-flex align-items-start gap-2">
                            <i data-lucide="check" class="text-emerald flex-shrink-0 mt-1" style="width: 16px; height: 16px;"></i>
                            <div><strong class="text-light">Transactional Reliability:</strong> ACID compliance, idempotent webhook processing, and atomic state transitions.</div>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i data-lucide="check" class="text-emerald flex-shrink-0 mt-1" style="width: 16px; height: 16px;"></i>
                            <div><strong class="text-light">First-Party Data Governance:</strong> Mitigating browser tracking loss with resilient server-side pipelines.</div>
                        </li>
                        <li class="d-flex align-items-start gap-2">
                            <i data-lucide="check" class="text-emerald flex-shrink-0 mt-1" style="width: 16px; height: 16px;"></i>
                            <div><strong class="text-light">Performance First:</strong> Zero unnecessary bundle bloat, optimized database indexing, and sub-second TTFB.</div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. Expertise & Skills Matrix -->
    <section class="mb-5 py-3" id="expertise">
        <div class="text-center mb-4">
            <span class="section-tag">// 02 Capabilities</span>
            <h2 class="display-6 fw-bold mb-2">Technical Competency & Evidence</h2>
            <p class="text-secondary mx-auto" style="max-width: 650px;">
                Demonstrated practical experience across core architectural layers, web engineering frameworks, and tracking infrastructure.
            </p>
        </div>

        <div class="row g-4">
            @forelse ($skillCategories as $category)
                <div class="col-md-6 col-lg-3">
                    <div class="crystal-surface p-4 h-100 crystal-card-hover d-flex flex-column">
                        <h4 class="h6 fw-bold text-emerald mb-3 d-flex align-items-center gap-2">
                            <i data-lucide="cpu" style="width: 16px; height: 16px;"></i>
                            {{ $category->name }}
                        </h4>
                        <div class="d-flex flex-column gap-3 flex-grow-1">
                            @foreach ($category->skills as $skill)
                                <div class="border-bottom pb-2" style="border-color: var(--theme-border) !important;">
                                    <div class="fw-semibold small text-light">{{ $skill->name }}</div>
                                    @if ($skill->description)
                                        <div class="text-secondary small mt-1" style="font-size: 12px; line-height: 1.4;">
                                            {{ $skill->description }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-secondary py-4">Skills registered in CMS will display here.</div>
            @endforelse
        </div>
    </section>

    <!-- 6. Featured Projects & Case Studies -->
    <section class="mb-5 py-3" id="projects">
        <div class="d-flex flex-wrap justify-content-between align-items-end mb-4 gap-3">
            <div>
                <span class="section-tag">// 03 Portfolio</span>
                <h2 class="display-6 fw-bold mb-1">Featured Engineering Cases</h2>
                <p class="text-secondary mb-0">Production deployments solving high-impact operational and architectural bottlenecks.</p>
            </div>
            <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-emerald">
                View All Case Studies &rarr;
            </a>
        </div>

        <div class="row g-4">
            @forelse ($featuredProjects as $project)
                <div class="col-lg-6">
                    <div class="crystal-surface h-100 p-4 crystal-card-hover d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-secondary-subtle text-secondary small">
                                {{ $project->category?->name ?? 'Case Study' }}
                            </span>
                            @if ($project->is_featured)
                                <span class="badge bg-emerald-subtle text-emerald small border border-emerald-subtle">
                                    ★ Featured Implementation
                                </span>
                            @endif
                        </div>

                        <h3 class="h4 fw-bold mb-2">
                            <a href="{{ route('projects.show', $project->slug) }}" class="text-decoration-none text-light">
                                {{ $project->title }}
                            </a>
                        </h3>

                        <p class="text-secondary small mb-3">
                            {{ $project->summary }}
                        </p>

                        @if ($project->detail)
                            <div class="p-3 rounded-3 mb-3" style="background: rgba(255,255,255,0.02); border: 1px solid var(--theme-border);">
                                <div class="small text-secondary mb-1">
                                    <strong class="text-light">Challenge:</strong> {{ Str::limit($project->detail->challenge, 120) }}
                                </div>
                                <div class="small text-secondary">
                                    <strong class="text-emerald">Solution:</strong> {{ Str::limit($project->detail->solution, 120) }}
                                </div>
                            </div>
                        @endif

                        @if ($project->skills->isNotEmpty())
                            <div class="d-flex flex-wrap gap-1 mb-4">
                                @foreach ($project->skills as $skill)
                                    <span class="badge bg-dark border border-secondary text-secondary small" style="font-size: 11px;">
                                        {{ $skill->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="pt-3 border-top mt-auto d-flex justify-content-between align-items-center" style="border-color: var(--theme-border) !important;">
                            <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-sm btn-emerald">
                                In-Depth Case Study &rarr;
                            </a>
                            @if ($project->links->where('link_type', 'live')->first())
                                <a href="{{ $project->links->where('link_type', 'live')->first()->url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1">
                                    <i data-lucide="external-link" style="width: 14px; height: 14px;"></i>
                                    <span>Demo</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-secondary">
                    <p>No featured projects found. Use CMS admin to add and feature projects.</p>
                </div>
            @endforelse
        </div>
    </section>

    <!-- 7. Specialized Services & Solutions -->
    <section class="mb-5 py-3" id="services">
        <div class="text-center mb-4">
            <span class="section-tag">// 04 Offerings</span>
            <h2 class="display-6 fw-bold mb-2">Specialized Engineering Services</h2>
            <p class="text-secondary mx-auto" style="max-width: 650px;">
                End-to-end technical leadership, full-stack implementation, and systems optimization.
            </p>
        </div>

        <div class="row g-4">
            @forelse ($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="crystal-surface p-4 h-100 crystal-card-hover d-flex flex-column">
                        <div class="p-3 rounded-3 mb-3 d-inline-block text-emerald" style="background: rgba(16, 185, 129, 0.1); width: fit-content;">
                            <i data-lucide="{{ $service->icon ?? 'sparkles' }}" style="width: 24px; height: 24px;"></i>
                        </div>
                        <h4 class="h5 fw-bold mb-2">{{ $service->title }}</h4>
                        <p class="text-secondary small mb-3 flex-grow-1 leading-relaxed">{{ $service->description }}</p>
                        @if ($service->deliverables)
                            <div class="border-top pt-3 small text-secondary" style="border-color: var(--theme-border) !important;">
                                <strong class="text-light d-block mb-1">Key Deliverables:</strong>
                                {{ $service->deliverables }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-secondary py-4">Services will be listed here.</div>
            @endforelse
        </div>
    </section>

    <!-- 8 & 9. Experience & Education Timelines -->
    <section class="mb-5 py-3" id="experience">
        <div class="row g-5">
            <div class="col-lg-6">
                <span class="section-tag">// 05 Career</span>
                <h3 class="h4 fw-bold mb-4 d-flex align-items-center gap-2">
                    <i data-lucide="briefcase" class="text-emerald"></i>
                    Professional Experience
                </h3>
                <div class="timeline ps-3 position-relative" style="border-left: 2px solid var(--theme-border);">
                    @forelse ($experiences as $exp)
                        <div class="mb-4 position-relative ps-3">
                            <div class="position-absolute rounded-circle bg-emerald" style="width: 10px; height: 10px; left: -21px; top: 6px;"></div>
                            <h5 class="fw-bold mb-1">{{ $exp->designation }}</h5>
                            <div class="text-emerald small fw-semibold mb-1">{{ $exp->company }} &bull; {{ $exp->location ?? 'Remote' }}</div>
                            <div class="text-secondary small mb-2">
                                {{ $exp->start_date ? $exp->start_date->format('M Y') : '' }} - 
                                {{ $exp->is_current ? 'Present' : ($exp->end_date ? $exp->end_date->format('M Y') : '') }}
                            </div>
                            <p class="text-secondary small mb-0">{{ $exp->description }}</p>
                        </div>
                    @empty
                        <div class="ps-3 text-secondary small">
                            <div class="fw-semibold text-light mb-1">Technical Project Lead & Web Developer</div>
                            <div>Pending: owner to confirm exact employment history milestones.</div>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="col-lg-6">
                <span class="section-tag">// 06 Academic</span>
                <h3 class="h4 fw-bold mb-4 d-flex align-items-center gap-2">
                    <i data-lucide="graduation-cap" class="text-emerald"></i>
                    Education & Credentials
                </h3>
                <div class="timeline ps-3 position-relative" style="border-left: 2px solid var(--theme-border);">
                    @forelse ($educations as $edu)
                        <div class="mb-4 position-relative ps-3">
                            <div class="position-absolute rounded-circle bg-primary" style="width: 10px; height: 10px; left: -21px; top: 6px;"></div>
                            <h5 class="fw-bold mb-1">{{ $edu->degree }}</h5>
                            <div class="text-primary small fw-semibold mb-1">{{ $edu->institution }}</div>
                            <div class="text-secondary small mb-2">
                                {{ $edu->start_date ? $edu->start_date->format('Y') : '' }} - 
                                {{ $edu->end_date ? $edu->end_date->format('Y') : 'Present' }}
                            </div>
                            @if ($edu->description)
                                <p class="text-secondary small mb-0">{{ $edu->description }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="ps-3 text-secondary small">
                            <div class="fw-semibold text-light mb-1">Academic Degree / Relevant Certifications</div>
                            <div>Pending: owner to confirm exact degree and institution details.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- 10. Working Process -->
    <section class="mb-5 py-3" id="process">
        <div class="text-center mb-4">
            <span class="section-tag">// 07 Methodology</span>
            <h2 class="display-6 fw-bold mb-2">Structured Execution Process</h2>
            <p class="text-secondary mx-auto" style="max-width: 650px;">
                Disciplined four-phase project lifecycle delivering measurable stability and business clarity.
            </p>
        </div>

        <div class="row g-3">
            <div class="col-sm-6 col-lg-3">
                <div class="crystal-surface p-4 h-100">
                    <span class="font-monospace text-emerald fw-bold d-block mb-2" style="font-size: 1.25rem;">01</span>
                    <h5 class="fw-bold mb-2">Discovery & Scope</h5>
                    <p class="small text-secondary mb-0">Deconstructing business goals, architectural boundaries, third-party API requirements, and timeline risk.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="crystal-surface p-4 h-100">
                    <span class="font-monospace text-emerald fw-bold d-block mb-2" style="font-size: 1.25rem;">02</span>
                    <h5 class="fw-bold mb-2">Architecture & Design</h5>
                    <p class="small text-secondary mb-0">Defining database schemas, indexing strategy, queue pipelines, API contracts, and UX flowcharts.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="crystal-surface p-4 h-100">
                    <span class="font-monospace text-emerald fw-bold d-block mb-2" style="font-size: 1.25rem;">03</span>
                    <h5 class="fw-bold mb-2">Full-Stack Execution</h5>
                    <p class="small text-secondary mb-0">Clean code implementation with automated tests, webhook handlers, security checks, and tracking triggers.</p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="crystal-surface p-4 h-100">
                    <span class="font-monospace text-emerald fw-bold d-block mb-2" style="font-size: 1.25rem;">04</span>
                    <h5 class="fw-bold mb-2">Optimization & Handoff</h5>
                    <p class="small text-secondary mb-0">Core Web Vitals tuning, caching warmup, deployment CI/CD verification, and clear operations documentation.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 11. Contact & Inquiry Section -->
    <section class="mb-5 py-4" id="contact">
        <div class="row g-4 justify-content-center">
            <div class="col-lg-5">
                <div class="crystal-surface p-4 p-md-5 h-100 d-flex flex-column">
                    <span class="section-tag">// 08 Connect</span>
                    <h2 class="display-6 fw-bold mb-3">Initiate Collaboration</h2>
                    <p class="text-secondary leading-relaxed mb-4">
                        Available for technical project leadership, high-throughput Laravel engineering, custom e-commerce systems, and conversion tracking audits.
                    </p>

                    <div class="d-flex flex-column gap-3 mb-4">
                        @if ($contact && $contact->email)
                            <div class="d-flex align-items-center gap-3">
                                <div class="p-2 rounded-3 text-emerald" style="background: rgba(16, 185, 129, 0.1);">
                                    <i data-lucide="mail"></i>
                                </div>
                                <div>
                                    <small class="text-secondary d-block">Primary Email</small>
                                    <a href="mailto:{{ $contact->email }}" class="text-light fw-semibold text-decoration-none">{{ $contact->email }}</a>
                                </div>
                            </div>
                        @endif

                        @if ($contact && $contact->location)
                            <div class="d-flex align-items-center gap-3">
                                <div class="p-2 rounded-3 text-emerald" style="background: rgba(16, 185, 129, 0.1);">
                                    <i data-lucide="map-pin"></i>
                                </div>
                                <div>
                                    <small class="text-secondary d-block">Location</small>
                                    <span class="text-light fw-semibold">{{ $contact->location }}</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($socialLinks->isNotEmpty())
                        <div class="border-top pt-4 mt-auto" style="border-color: var(--theme-border) !important;">
                            <h6 class="text-uppercase text-secondary small fw-bold mb-3">Verified Profiles</h6>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach ($socialLinks as $link)
                                    <a href="{{ $link->url }}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary px-3 d-flex align-items-center gap-2">
                                        <i data-lucide="{{ $link->icon ?? 'link' }}" style="width: 14px; height: 14px;"></i>
                                        <span>{{ $link->label }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-7">
                <div class="crystal-surface p-4 p-md-5">
                    <h3 class="h4 fw-bold mb-3">Send a Direct Message</h3>
                    
                    @if (session('contact_success'))
                        <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
                            <i data-lucide="check-circle" class="text-success"></i>
                            <span>{{ session('contact_success') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('home') }}#contact" method="POST">
                        @csrf
                        <!-- Honeypot spam defense field -->
                        <input type="text" name="hp_website" style="display:none !important;" tabindex="-1" autocomplete="off">

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Your Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control bg-transparent border-secondary text-light" required placeholder="e.g. Alex Morgan">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-semibold text-secondary">Your Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control bg-transparent border-secondary text-light" required placeholder="alex@company.com">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-secondary">Subject</label>
                            <input type="text" name="subject" class="form-control bg-transparent border-secondary text-light" placeholder="e.g. Technical Project Inquiry / Laravel Architecture">
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-semibold text-secondary">Project Details / Message <span class="text-danger">*</span></label>
                            <textarea name="message" rows="5" class="form-control bg-transparent border-secondary text-light" required placeholder="Outline your project scope, technical requirements, and timeline expectations..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-emerald w-100 py-3 fw-semibold d-flex align-items-center justify-content-center gap-2">
                            <i data-lucide="send" style="width: 16px; height: 16px;"></i>
                            <span>Transmit Inquiry</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    // Interactive 3D Depth Card Tilt (respects prefers-reduced-motion)
    const heroCard = document.getElementById('heroCard');
    if (heroCard && !window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        heroCard.addEventListener('mousemove', (e) => {
            const rect = heroCard.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            const rotateX = -(y / rect.height) * 8;
            const rotateY = (x / rect.width) * 8;
            heroCard.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
        });

        heroCard.addEventListener('mouseleave', () => {
            heroCard.style.transform = 'rotateX(0deg) rotateY(0deg)';
        });
    }
</script>
@endpush
