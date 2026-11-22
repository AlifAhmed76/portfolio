@extends('themes.interactive-spotlight.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@section('content')
<div class="container py-5">

    <!-- Section 1: Interactive Hero (Arsalan Kaleem style) -->
    <section id="hero" class="py-5 mb-5 text-center text-lg-start">
        <div class="row align-items-center g-5">
            <div class="{{ ($profile?->avatar || $profile?->profileImage) ? 'col-lg-8' : 'col-12' }}">
                <div class="d-inline-flex align-items-center gap-2 mb-4 px-3 py-1 rounded-pill" style="background: rgba(6, 182, 212, 0.1); border: 1px solid rgba(6, 182, 212, 0.3);">
                    <span class="p-1 rounded-circle" style="background: var(--spot-cyan-glow); width: 8px; height: 8px; box-shadow: 0 0 8px var(--spot-cyan-glow);"></span>
                    <span class="small font-mono fw-semibold" style="color: var(--spot-cyan-glow); font-size: 0.8rem;">
                        {{ $contact->availability_status ?? 'Available for Select Projects & Leadership Roles' }}
                    </span>
                </div>

                <h1 class="display-3 fw-bolder mb-3 text-white" style="letter-spacing: -0.03em;">
                    {{ $profile->name ?? 'Md. Alif Ahmed' }}
                </h1>

                <h2 class="h4 fw-bold mb-4" style="color: var(--spot-cyan-glow);">
                    {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
                </h2>

                <p class="lead text-secondary mb-5 leading-relaxed" style="max-width: 720px; font-size: 1.25rem;">
                    {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                    Specializing in custom Laravel backends, multi-carrier courier API integrations, and resilient Meta Conversion API server-side tracking pipelines with fluid interactive craftsmanship.
                </p>

                <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                    <a href="#projects" class="btn-spot">
                        <i data-lucide="sparkles" style="width: 18px; height: 18px;"></i>
                        <span>Explore Selected Works</span>
                    </a>
                    <a href="#contact" class="btn-spot-outline">
                        <i data-lucide="mail" style="width: 18px; height: 18px;"></i>
                        <span>Initiate Collaboration</span>
                    </a>
                </div>
            </div>

            @if ($profile?->avatar || $profile?->profileImage)
                <div class="col-lg-4 text-center">
                    <div class="p-3 d-inline-block rounded-circle" style="background: rgba(6, 182, 212, 0.08); border: 2px solid var(--spot-cyan-glow); box-shadow: 0 0 30px rgba(6, 182, 212, 0.3);">
                        <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name }}" class="rounded-circle shadow" style="width: 220px; height: 220px; object-fit: cover;">
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Section 2: Metrics Strip -->
    <section id="highlights" class="mb-5 pb-3">
        <div class="row g-4">
            @foreach ($stats as $stat)
                <div class="col-6 col-md-3">
                    <div class="spot-card p-4 text-center h-100">
                        <div class="display-5 font-mono fw-bold mb-1" style="color: var(--spot-cyan-glow);">{{ $stat['value'] }}</div>
                        <div class="small text-secondary font-mono text-uppercase" style="font-size: 0.75rem;">{{ $stat['label'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 3: Selected Interactive Projects -->
    <section id="projects" class="mb-5 py-4">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge mb-2 px-3 py-1" style="background: rgba(6, 182, 212, 0.15); color: var(--spot-cyan-glow); border: 1px solid var(--spot-border);">
                    Interactive Showcases
                </span>
                <h2 class="display-5 fw-bold text-white mb-0">Featured Projects &amp; Case Studies</h2>
            </div>
            <a href="{{ url('/projects') }}" class="btn-spot-outline btn-sm">All Showcases →</a>
        </div>

        <div class="row g-4">
            @forelse ($featuredProjects as $project)
                <div class="col-lg-6">
                    <div class="spot-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge" style="background: rgba(6, 182, 212, 0.2); color: var(--spot-cyan-glow);">
                                    {{ $project->category?->name ?? 'Production' }}
                                </span>
                                <i data-lucide="arrow-up-right" style="color: var(--spot-cyan-glow); width: 20px; height: 20px;"></i>
                            </div>

                            <div class="mb-4 overflow-hidden rounded-3 border" style="height: 220px; background: rgba(0,0,0,0.4); border-color: var(--spot-border) !important;">
                                @if ($project->coverImage)
                                    <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column justify-content-between p-4" style="background: radial-gradient(circle at 80% 20%, rgba(6, 182, 212, 0.25), #030712);">
                                        <span class="small font-mono text-cyan">SYSTEM BUILD</span>
                                        <div class="h4 fw-bold text-white">{{ $project->title }}</div>
                                    </div>
                                @endif
                            </div>

                            <h3 class="h4 fw-bold text-white mb-2">{{ $project->title }}</h3>
                            <p class="text-secondary small mb-4 leading-relaxed">{{ $project->summary }}</p>
                        </div>

                        <div>
                            <div class="d-flex flex-wrap gap-1 mb-4">
                                @foreach ($project->skills as $sk)
                                    <span class="badge bg-secondary-subtle text-light small">{{ $sk->name }}</span>
                                @endforeach
                            </div>
                            <a href="{{ url('/projects/' . $project->slug) }}" class="btn-spot btn-sm w-100 justify-content-center">
                                Inspect Interactive Breakdown →
                            </a>
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
        <h2 class="display-6 fw-bold text-white mb-4">Services &amp; Architecture</h2>
        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4">
                    <div class="spot-card p-4 h-100">
                        <h3 class="h5 fw-bold text-white mb-2" style="color: var(--spot-cyan-glow);">{{ $srv->title }}</h3>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $srv->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 5: Experience Timeline -->
    <section id="experience" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Work Experience &amp; Leadership</h2>
        <div class="d-flex flex-column gap-3">
            @foreach ($experiences as $exp)
                <div class="spot-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="h5 fw-bold text-white mb-0">{{ $exp->designation }} <span style="color: var(--spot-cyan-glow);">@ {{ $exp->company }}</span></h3>
                        <span class="small font-mono text-secondary">
                            {{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} — {{ $exp->is_current ? 'Present' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('Y') : '') }}
                        </span>
                    </div>
                    <p class="small text-secondary mb-0 leading-relaxed">{{ $exp->description }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 6: Competency Stack -->
    <section id="expertise" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Core Technology Stack</h2>
        <div class="row g-4">
            @foreach ($skillCategories as $cat)
                <div class="col-md-6 col-lg-3">
                    <div class="spot-card p-4 h-100">
                        <h3 class="h6 fw-bold text-white mb-3" style="color: var(--spot-cyan-glow);">{{ $cat->name }}</h3>
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

    <!-- Section 7: Process -->
    <section id="about" class="mb-5 py-4">
        <div class="spot-card p-5">
            <h2 class="display-6 fw-bold text-white mb-3">Structured Execution Process</h2>
            <p class="lead text-secondary mb-4 leading-relaxed">
                {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
            </p>
            <div class="font-mono small" style="color: var(--spot-cyan-glow);">
                Sub-Second Execution · Defensive Database Lock Management · Fluid UI/UX Craftsmanship
            </div>
        </div>
    </section>

    <!-- Section 8: Credentials -->
    <section id="education" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Credentials &amp; Education</h2>
        @foreach ($educations as $edu)
            <div class="spot-card p-4 mb-3">
                <h3 class="h5 fw-bold text-white mb-1">{{ $edu->degree }}</h3>
                <div class="small mb-1" style="color: var(--spot-cyan-glow);">{{ $edu->institution }}</div>
                <div class="small text-secondary">{{ $edu->subject }}</div>
            </div>
        @endforeach
    </section>

    <!-- Section 9: Contact CTA -->
    <section id="contact" class="py-5 text-center">
        <div class="spot-card p-5">
            <h2 class="display-4 fw-bold text-white mb-3">Initiate Collaboration</h2>
            <p class="lead text-secondary mb-4 mx-auto" style="max-width: 600px;">
                Direct inquiries for high-throughput Laravel APIs, logistics automation, and technical project leadership.
            </p>
            <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="btn-spot px-5 py-3 fs-5">
                Transmit Message ({{ $contact->email ?? 'admin@alifahmed.com' }})
            </a>
        </div>
    </section>

</div>
@endsection
