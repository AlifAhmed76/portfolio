@extends('themes.boutique-studio.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@section('content')
<div class="container py-5">

    <!-- Section 1: Boutique Hero (Devon Stank style) -->
    <section id="hero" class="py-5 mb-5">
        <div class="row align-items-center g-5">
            <div class="{{ ($profile?->avatar || $profile?->profileImage) ? 'col-lg-8' : 'col-12' }}">
                <div class="d-inline-flex align-items-center gap-2 mb-4 px-3 py-1 rounded-pill" style="background: rgba(163, 230, 53, 0.1); border: 1px solid rgba(163, 230, 53, 0.3);">
                    <span class="p-1 rounded-circle" style="background: var(--studio-accent); width: 8px; height: 8px;"></span>
                    <span class="small fw-semibold" style="color: var(--studio-accent); font-size: 0.8rem;">
                        {{ $contact->availability_status ?? 'Available for Select Projects & Leadership Roles' }}
                    </span>
                </div>

                <h1 class="display-3 font-display fw-bolder mb-3 text-white" style="letter-spacing: -0.03em; line-height: 1.05;">
                    {{ $profile->name ?? 'Md. Alif Ahmed' }}
                </h1>

                <h2 class="h4 mb-4 fw-semibold" style="color: var(--studio-accent);">
                    {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
                </h2>

                <p class="lead text-secondary mb-5 leading-relaxed" style="font-size: 1.25rem; max-width: 720px;">
                    {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                    Bespoke Laravel architectures, automated courier logistics pipelines, and resilient Meta Conversion API server-side tracking engineered for commercial scale.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="#projects" class="btn-lime">Explore Production Deliveries →</a>
                    <a href="#contact" class="btn-lime-outline">Initiate Collaboration</a>
                </div>
            </div>

            @if ($profile?->avatar || $profile?->profileImage)
                <div class="col-lg-4 text-center">
                    <div class="p-3 d-inline-block rounded-4" style="background: var(--studio-surface); border: 1px solid rgba(163, 230, 53, 0.3); box-shadow: 0 20px 40px -15px rgba(0,0,0,0.7);">
                        <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name }}" class="rounded-3 img-fluid" style="width: 240px; height: 240px; object-fit: cover;">
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Section 2: Commercial KPI Metrics -->
    <section id="highlights" class="mb-5 pb-4">
        <div class="row g-4">
            @foreach ($stats as $stat)
                <div class="col-6 col-md-3">
                    <div class="studio-card p-4 text-center h-100">
                        <div class="display-5 font-display fw-bold mb-1" style="color: var(--studio-accent);">{{ $stat['value'] }}</div>
                        <div class="small text-secondary text-uppercase fw-semibold" style="letter-spacing: 0.05em; font-size: 0.75rem;">{{ $stat['label'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 3: Selected Commercial Deliveries (Giant Boutique Cards) -->
    <section id="projects" class="mb-5 py-4">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <span class="badge mb-2 px-3 py-1" style="background: rgba(163, 230, 53, 0.15); color: var(--studio-accent); border: 1px solid rgba(163, 230, 53, 0.3);">
                    Curated Commercial Cases
                </span>
                <h2 class="display-5 font-display fw-bold text-white mb-0">Featured Projects &amp; Case Studies</h2>
            </div>
            <a href="{{ url('/projects') }}" class="btn-lime-outline btn-sm">Full Portfolio Archive →</a>
        </div>

        <div class="d-flex flex-column gap-5">
            @forelse ($featuredProjects as $project)
                <div class="studio-card p-4 p-md-5 overflow-hidden position-relative">
                    <div class="row align-items-center g-4">
                        <div class="col-lg-6">
                            <span class="badge mb-3" style="background: rgba(255,255,255,0.06); color: var(--studio-accent); border: 1px solid var(--studio-border);">
                                {{ $project->category?->name ?? 'E-Commerce Solution' }}
                            </span>
                            <h3 class="display-6 font-display fw-bold text-white mb-3">{{ $project->title }}</h3>
                            <p class="lead text-secondary mb-4 leading-relaxed" style="font-size: 1.1rem;">{{ $project->summary }}</p>
                            
                            <div class="d-flex flex-wrap gap-2 mb-4">
                                @foreach ($project->skills as $sk)
                                    <span class="badge bg-dark border border-secondary text-light px-3 py-2 small">{{ $sk->name }}</span>
                                @endforeach
                            </div>

                            <a href="{{ url('/projects/' . $project->slug) }}" class="btn-lime">
                                Inspect Engineering Breakdown →
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <div class="overflow-hidden rounded-3 border" style="height: 300px; background: #16171b; border-color: rgba(255,255,255,0.1) !important;">
                                @if ($project->coverImage)
                                    <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column justify-content-between p-4" style="background: radial-gradient(circle at 80% 20%, rgba(163, 230, 53, 0.2), #121316);">
                                        <span class="small font-display text-white-50">COMMERCIAL BUILD</span>
                                        <div class="h4 font-display fw-bold text-white">{{ $project->title }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-secondary text-center py-4">Projects loading...</p>
            @endforelse
        </div>
    </section>

    <!-- Section 4: Studio Services -->
    <section id="services" class="mb-5 py-4">
        <h2 class="display-6 font-display fw-bold text-white mb-4">Architecture &amp; Solutions</h2>
        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4">
                    <div class="studio-card p-4 h-100">
                        <h3 class="h5 fw-bold text-white mb-2" style="color: var(--studio-accent);">{{ $srv->title }}</h3>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $srv->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 5: Experience Timeline -->
    <section id="experience" class="mb-5 py-4">
        <h2 class="display-6 font-display fw-bold text-white mb-4">Professional Track Record</h2>
        <div class="d-flex flex-column gap-3">
            @foreach ($experiences as $exp)
                <div class="studio-card p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                        <h3 class="h5 fw-bold text-white mb-0">{{ $exp->designation }} <span style="color: var(--studio-accent);">· {{ $exp->company }}</span></h3>
                        <span class="small text-secondary">
                            {{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} — {{ $exp->is_current ? 'Present' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('Y') : '') }}
                        </span>
                    </div>
                    <p class="small text-secondary mb-0 leading-relaxed">{{ $exp->description }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 6: Competencies Matrix -->
    <section id="expertise" class="mb-5 py-4">
        <h2 class="display-6 font-display fw-bold text-white mb-4">Technical Stack &amp; Core Systems</h2>
        <div class="row g-4">
            @foreach ($skillCategories as $cat)
                <div class="col-md-6 col-lg-3">
                    <div class="studio-card p-4 h-100">
                        <h3 class="h6 font-display fw-bold mb-3" style="color: var(--studio-accent);">{{ $cat->name }}</h3>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                            @foreach ($cat->skills as $sk)
                                <li class="small text-secondary">• <span class="text-white">{{ $sk->name }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 7: About Statement -->
    <section id="about" class="mb-5 py-4">
        <div class="studio-card p-5">
            <h2 class="display-6 font-display fw-bold text-white mb-3">Structured Execution Process</h2>
            <p class="lead text-secondary mb-4 leading-relaxed">
                {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
            </p>
            <div class="small fw-bold" style="color: var(--studio-accent);">
                Defensive Code Architecture · High-Concurrency MySQL Profiling · Zero-Loss Attribution
            </div>
        </div>
    </section>

    <!-- Section 8: Education -->
    <section id="education" class="mb-5 py-4">
        <h2 class="display-6 font-display fw-bold text-white mb-4">Academic Credentials</h2>
        @foreach ($educations as $edu)
            <div class="studio-card p-4 mb-3">
                <h3 class="h5 fw-bold text-white mb-1">{{ $edu->degree }}</h3>
                <div class="small mb-1" style="color: var(--studio-accent);">{{ $edu->institution }}</div>
                <div class="small text-secondary">{{ $edu->subject }}</div>
            </div>
        @endforeach
    </section>

    <!-- Section 9: Studio Contact CTA -->
    <section id="contact" class="py-5 text-center">
        <div class="studio-card p-5">
            <h2 class="display-4 font-display fw-bold text-white mb-3">Initiate Collaboration</h2>
            <p class="lead text-secondary mb-4 mx-auto" style="max-width: 600px;">
                Direct inquiries for boutique e-commerce development, custom Laravel engineering, and technical project leadership.
            </p>
            <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="btn-lime px-5 py-3 fs-5">
                Schedule Discovery ({{ $contact->email ?? 'admin@alifahmed.com' }})
            </a>
        </div>
    </section>

</div>
@endsection
