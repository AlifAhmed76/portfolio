@extends('themes.industrial-engineering.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@section('content')
<div class="container py-5">

    <!-- Section 1: Architectural Drawing Header (Base Structures style) -->
    <section id="hero" class="mb-5 pb-4">
        <div class="eng-card p-4 p-md-5">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4 pb-3 border-bottom border-secondary" style="border-color: rgba(255,255,255,0.1) !important;">
                <span class="font-mono small text-warning">
                    [DWG REF: BENG-2026-01 // COORD: 23.8103° N, 90.4125° E]
                </span>
                <span class="font-mono small text-white-50">
                    STATUS: {{ strtoupper($contact->availability_status ?? 'Available for Select Projects & Leadership Roles') }}
                </span>
            </div>

            <div class="row align-items-center g-4">
                <div class="{{ ($profile?->avatar || $profile?->profileImage) ? 'col-lg-8' : 'col-12' }}">
                    <h1 class="display-3 fw-bold mb-2 text-white">
                        {{ $profile->name ?? 'Md. Alif Ahmed' }}
                    </h1>

                    <h2 class="h5 font-mono mb-4" style="color: var(--eng-orange);">
                        {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
                    </h2>

                    <p class="lead text-secondary mb-4 leading-relaxed" style="font-size: 1.2rem; max-width: 740px;">
                        {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                        Specialized in custom Laravel backends, multi-carrier courier API automations, and resilient Meta Conversion API server-side tracking pipelines engineered with defensive rigor.
                    </p>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="#projects" class="btn-eng">View Structural Projects ↓</a>
                        <a href="#contact" class="btn-eng-outline">Initiate Collaboration</a>
                    </div>
                </div>

                @if ($profile?->avatar || $profile?->profileImage)
                    <div class="col-lg-4 text-center">
                        <div class="p-2 d-inline-block border border-2 border-warning" style="background: rgba(15, 23, 42, 0.9);">
                            <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name }}" class="img-fluid" style="width: 200px; height: 200px; object-fit: cover;">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Section 2: Metric Spec Strip -->
    <section id="highlights" class="mb-5 pb-3">
        <div class="row g-3">
            @foreach ($stats as $stat)
                <div class="col-6 col-md-3">
                    <div class="eng-card p-3 text-center">
                        <div class="h3 font-mono fw-bold mb-1" style="color: var(--eng-orange);">{{ $stat['value'] }}</div>
                        <div class="small font-mono text-secondary text-uppercase" style="font-size: 0.72rem;">{{ $stat['label'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 3: Structural Engineering Projects & Case Studies -->
    <section id="projects" class="mb-5 py-4">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="font-mono small text-warning mb-1 d-block">// PRODUCTION DRAWINGS</span>
                <h2 class="display-6 fw-bold text-white mb-0">Featured Projects &amp; Case Studies</h2>
            </div>
            <a href="{{ url('/projects') }}" class="btn-eng-outline btn-sm">All Drawings →</a>
        </div>

        <div class="d-flex flex-column gap-4">
            @forelse ($featuredProjects as $idx => $project)
                <div class="eng-card p-4 p-md-5">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-7">
                            <div class="font-mono small text-warning mb-2">
                                [DWG NO: EXP-00{{ $idx + 1 }} · {{ strtoupper($project->category?->name ?? 'SYSTEM') }}]
                            </div>
                            <h3 class="h4 fw-bold text-white mb-3">{{ $project->title }}</h3>
                            <p class="text-secondary small mb-3 leading-relaxed">{{ $project->summary }}</p>

                            <div class="d-flex flex-wrap gap-2 mb-4">
                                @foreach ($project->skills as $sk)
                                    <span class="badge bg-dark border border-secondary text-light font-mono" style="font-size: 0.75rem;">
                                        {{ $sk->name }}
                                    </span>
                                @endforeach
                            </div>

                            <a href="{{ url('/projects/' . $project->slug) }}" class="btn-eng btn-sm">
                                Inspect Engineering Specs →
                            </a>
                        </div>
                        <div class="col-lg-5">
                            <div class="overflow-hidden border border-secondary" style="height: 200px; background: #0f172a;">
                                @if ($project->coverImage)
                                    <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column justify-content-between p-3" style="background: radial-gradient(circle at 80% 20%, rgba(249, 115, 22, 0.25), #0f172a);">
                                        <span class="font-mono small text-warning">STRUCTURAL SPEC</span>
                                        <div class="h5 font-mono fw-bold text-white">{{ $project->title }}</div>
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

    <!-- Section 4: Services -->
    <section id="services" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">// Engineering Architecture &amp; Services</h2>
        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4">
                    <div class="eng-card p-4 h-100">
                        <h3 class="h6 font-mono fw-bold mb-2" style="color: var(--eng-orange);">{{ $srv->title }}</h3>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $srv->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 5: Experience -->
    <section id="experience" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">// Structural Work Governance</h2>
        <div class="d-flex flex-column gap-3">
            @foreach ($experiences as $exp)
                <div class="eng-card p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-baseline mb-2">
                        <h3 class="h6 fw-bold text-white mb-0">{{ $exp->designation }} <span class="text-warning font-mono">@ {{ $exp->company }}</span></h3>
                        <span class="small font-mono text-secondary">
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
        <h2 class="display-6 fw-bold text-white mb-4">// Technical Stack Blueprint</h2>
        <div class="row g-4">
            @foreach ($skillCategories as $cat)
                <div class="col-md-6 col-lg-3">
                    <div class="eng-card p-4 h-100">
                        <h3 class="h6 font-mono fw-bold mb-3" style="color: var(--eng-orange);">{{ $cat->name }}</h3>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                            @foreach ($cat->skills as $sk)
                                <li class="small text-light font-mono">• {{ $sk->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 7: Process Statement -->
    <section id="about" class="mb-5 py-4">
        <div class="eng-card p-4 p-md-5">
            <h2 class="display-6 fw-bold text-white mb-3">Structured Execution Process</h2>
            <p class="lead text-secondary mb-4 leading-relaxed">
                {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
            </p>
            <div class="font-mono small text-warning">
                Tolerance: ±0.01s · Scaled Database Partitions · Strict Architectural Auditing
            </div>
        </div>
    </section>

    <!-- Section 8: Education -->
    <section id="education" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">// Academic Credentials</h2>
        @foreach ($educations as $edu)
            <div class="eng-card p-4 mb-3">
                <h3 class="h6 fw-bold text-white mb-1">{{ $edu->degree }}</h3>
                <div class="small font-mono mb-1" style="color: var(--eng-orange);">{{ $edu->institution }}</div>
                <div class="small text-secondary">{{ $edu->subject }}</div>
            </div>
        @endforeach
    </section>

    <!-- Section 9: Contact CTA -->
    <section id="contact" class="py-5 text-center">
        <div class="eng-card p-5">
            <h2 class="display-4 fw-bold text-white mb-3">Initiate Collaboration</h2>
            <p class="lead text-secondary mb-4 mx-auto" style="max-width: 600px;">
                Direct inquiries for structural Laravel systems, courier logistics automations, and technical project leadership.
            </p>
            <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="btn-eng px-5 py-3 fs-5">
                TRANSMIT SPEC ({{ $contact->email ?? 'admin@alifahmed.com' }})
            </a>
        </div>
    </section>

</div>
@endsection
