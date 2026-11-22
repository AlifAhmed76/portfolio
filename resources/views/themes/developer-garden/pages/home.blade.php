@extends('themes.developer-garden.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@section('content')
<div class="container py-5" style="max-width: 980px;">

    <!-- Section 1: Garden Hero Intro (Tania Rascia style) -->
    <header id="hero" class="mb-5 pb-4 border-bottom" style="border-color: var(--garden-border) !important;">
        <div class="d-inline-flex align-items-center gap-2 mb-3 font-mono small text-success px-2 py-1 rounded" style="background: var(--garden-accent-dim);">
            <span>●</span>
            <span>{{ $contact->availability_status ?? 'Available for Select Projects & Leadership Roles' }}</span>
        </div>

        <div class="row align-items-center g-4">
            <div class="{{ ($profile?->avatar || $profile?->profileImage) ? 'col-md-9' : 'col-12' }}">
                <h1 class="display-4 fw-bold mb-2 text-white">
                    {{ $profile->name ?? 'Md. Alif Ahmed' }}
                </h1>
                <h2 class="h5 text-success font-mono mb-3">
                    {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
                </h2>
                <p class="lead text-secondary mb-4 leading-relaxed" style="font-size: 1.15rem;">
                    {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                    Welcome to my digital garden. I specialize in custom Laravel backends, multi-carrier courier API automations, and resilient Meta Conversion API server-side tracking pipelines.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="#projects" class="btn btn-sm btn-success px-3 py-2 font-mono">Explore Projects ↓</a>
                    <a href="#contact" class="btn btn-sm btn-outline-secondary px-3 py-2 font-mono">Initiate Collaboration</a>
                    <a href="{{ url('/blog') }}" class="btn btn-sm btn-outline-secondary px-3 py-2 font-mono">Read Journal →</a>
                </div>
            </div>
            @if ($profile?->avatar || $profile?->profileImage)
                <div class="col-md-3 text-center">
                    <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name }}" class="rounded-circle border border-2 border-secondary shadow" style="width: 140px; height: 140px; object-fit: cover;">
                </div>
            @endif
        </div>
    </header>

    <!-- Section 2: Metrics Strip -->
    <section id="highlights" class="mb-5 pb-3">
        <div class="row g-3">
            @foreach ($stats as $stat)
                <div class="col-6 col-md-3">
                    <div class="garden-card p-3 text-center">
                        <div class="h4 font-mono fw-bold text-success mb-1">{{ $stat['value'] }}</div>
                        <div class="small text-secondary font-mono" style="font-size: 0.75rem;">{{ $stat['label'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 3: Projects (Tania Rascia Dense Directory Style) -->
    <section id="projects" class="mb-5 pb-4">
        <div class="d-flex justify-content-between align-items-baseline mb-4">
            <h2 class="h4 fw-bold font-mono text-white mb-0">// Featured Projects &amp; Case Studies</h2>
            <a href="{{ url('/projects') }}" class="small font-mono text-success text-decoration-none">view all →</a>
        </div>

        <div class="d-flex flex-column gap-3">
            @forelse ($featuredProjects as $project)
                <div class="garden-card p-3 p-md-4">
                    <div class="row align-items-center g-3">
                        <div class="col-md-3">
                            <span class="garden-tag">{{ $project->category?->name ?? 'Production' }}</span>
                        </div>
                        <div class="col-md-7">
                            <h3 class="h5 fw-bold mb-1">
                                <a href="{{ url('/projects/' . $project->slug) }}" class="garden-link">
                                    {{ $project->title }}
                                </a>
                            </h3>
                            <p class="small text-secondary mb-2 leading-relaxed">{{ $project->summary }}</p>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach ($project->skills->take(4) as $sk)
                                    <span class="text-secondary small font-mono me-2" style="font-size: 0.72rem;">#{{ $sk->name }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-2 text-md-end">
                            <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-outline-success font-mono" style="font-size: 0.78rem;">
                                Specs →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-secondary small">Projects loading...</p>
            @endforelse
        </div>
    </section>

    <!-- Section 4: Skills Matrix (Garden Cheat Sheet) -->
    <section id="expertise" class="mb-5 pb-4">
        <h2 class="h4 fw-bold font-mono text-white mb-4">// Technical Stack &amp; Skills Directory</h2>
        <div class="row g-3">
            @foreach ($skillCategories as $cat)
                <div class="col-md-6">
                    <div class="garden-card p-4 h-100">
                        <h3 class="h6 font-mono text-success fw-bold mb-3">{{ $cat->name }}</h3>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($cat->skills as $sk)
                                <span class="badge bg-dark border border-secondary text-light font-mono px-2 py-1" style="font-size: 0.78rem;">
                                    {{ $sk->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 5: Services -->
    <section id="services" class="mb-5 pb-4">
        <h2 class="h4 fw-bold font-mono text-white mb-4">// Engineering Consulting &amp; Services</h2>
        <div class="row g-3">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4">
                    <div class="garden-card p-4 h-100">
                        <h3 class="h6 fw-bold text-white mb-2">{{ $srv->title }}</h3>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $srv->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 6: Work History -->
    <section id="experience" class="mb-5 pb-4">
        <h2 class="h4 fw-bold font-mono text-white mb-4">// Work History &amp; Leadership</h2>
        <div class="d-flex flex-column gap-3">
            @foreach ($experiences as $exp)
                <div class="garden-card p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-baseline mb-2">
                        <h3 class="h6 fw-bold text-white mb-0">{{ $exp->designation }} <span class="text-success font-mono">@ {{ $exp->company }}</span></h3>
                        <span class="small font-mono text-secondary">
                            {{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} — {{ $exp->is_current ? 'Present' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('Y') : '') }}
                        </span>
                    </div>
                    <p class="small text-secondary mb-0 leading-relaxed">{{ $exp->description }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 7: About & Methodology -->
    <section id="about" class="mb-5 pb-4">
        <div class="garden-card p-4 p-md-5">
            <h2 class="h4 fw-bold font-mono text-white mb-3">// Structured Execution Process</h2>
            <p class="text-secondary leading-relaxed mb-4">
                {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
            </p>
            <div class="font-mono small text-success">
                Architecture First · Defensive Database Design · Sub-Second Execution
            </div>
        </div>
    </section>

    <!-- Section 8: Education -->
    <section id="education" class="mb-5 pb-4">
        <h2 class="h4 fw-bold font-mono text-white mb-4">// Credentials &amp; Education</h2>
        @foreach ($educations as $edu)
            <div class="garden-card p-3 mb-2 d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="h6 fw-bold text-white mb-0">{{ $edu->degree }}</h3>
                    <div class="small text-secondary">{{ $edu->institution }} · {{ $edu->subject }}</div>
                </div>
            </div>
        @endforeach
    </section>

    <!-- Section 9: Contact -->
    <section id="contact" class="py-4 text-center">
        <div class="garden-card p-4 p-md-5">
            <h2 class="h3 fw-bold text-white mb-2">Initiate Collaboration</h2>
            <p class="text-secondary small mx-auto mb-4" style="max-width: 500px;">
                Looking for technical leadership, high-throughput Laravel APIs, or server-side tracking architecture? Drop an email.
            </p>
            <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="btn btn-success px-4 py-2 font-mono">
                Email: {{ $contact->email ?? 'admin@alifahmed.com' }}
            </a>
        </div>
    </section>

</div>
@endsection
