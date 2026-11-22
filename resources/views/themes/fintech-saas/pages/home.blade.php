@extends('themes.fintech-saas.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@push('styles')
<style>
    .saas-ticker {
        overflow: hidden;
        white-space: nowrap;
        background: rgba(99, 102, 241, 0.06);
        border-top: 1px solid var(--saas-border);
        border-bottom: 1px solid var(--saas-border);
        padding: 12px 0;
    }
    .saas-ticker-track {
        display: inline-block;
        animation: saasTicker 24s linear infinite;
    }
    @keyframes saasTicker {
        from { transform: translateX(0%); }
        to { transform: translateX(-50%); }
    }
</style>
@endpush

@section('content')
<!-- Continuous Live Telemetry Ticker -->
<div class="saas-ticker">
    <div class="saas-ticker-track font-mono small text-uppercase">
        <span class="mx-4 text-white">✦ DUAL-STREAM CAPI: 99.8% SYNCHRONIZED</span>
        <span class="mx-4" style="color: var(--saas-accent-glow);">✦ COURIER API LATENCY: &lt;85ms</span>
        <span class="mx-4 text-white">✦ LARAVEL QUEUE DISPATCH: 100% HEALTH</span>
        <span class="mx-4" style="color: var(--saas-teal);">✦ ZERO-LOSS EVENT DEDUPLICATION</span>
        <span class="mx-4 text-white">✦ DUAL-STREAM CAPI: 99.8% SYNCHRONIZED</span>
        <span class="mx-4" style="color: var(--saas-accent-glow);">✦ COURIER API LATENCY: &lt;85ms</span>
    </div>
</div>

<div class="container py-5">

    <!-- Section 1: Hero (Trendswap Fintech Product Launch Style) -->
    <section id="hero" class="py-5 text-center position-relative">
        <div class="d-inline-flex align-items-center gap-2 mb-4 px-3 py-1 rounded-pill" style="background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.35);">
            <span class="p-1 rounded-circle" style="background: var(--saas-teal); width: 8px; height: 8px;"></span>
            <span class="small font-mono fw-semibold" style="color: var(--saas-accent-glow); font-size: 0.8rem;">
                {{ $contact->availability_status ?? 'Available for Select Projects & Leadership Roles' }}
            </span>
        </div>

        <h1 class="display-3 fw-bolder mb-3 text-white" style="letter-spacing: -0.03em;">
            {{ $profile->name ?? 'Md. Alif Ahmed' }}
        </h1>

        <h2 class="h4 fw-bold mb-4 mx-auto" style="color: var(--saas-accent-glow); max-width: 780px;">
            {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
        </h2>

        <p class="lead text-secondary mb-5 mx-auto leading-relaxed" style="max-width: 700px; font-size: 1.2rem;">
            {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
            Architecting mission-critical Laravel backends, multi-carrier courier automations, and resilient Meta Conversion API server-side pipelines.
        </p>

        <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
            <a href="#projects" class="btn-saas">
                <i data-lucide="zap" style="width: 18px; height: 18px;"></i>
                <span>Explore Live Deployments</span>
            </a>
            <a href="#contact" class="btn-saas-outline">
                <i data-lucide="mail" style="width: 18px; height: 18px;"></i>
                <span>Initiate Collaboration</span>
            </a>
        </div>

        @if ($profile?->avatar || $profile?->profileImage)
            <div class="mb-4">
                <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name }}" class="rounded-circle shadow-lg border border-2 p-1" style="width: 150px; height: 150px; object-fit: cover; border-color: var(--saas-accent-glow) !important;">
            </div>
        @endif
    </section>

    <!-- Section 2: Metrics Dashboard Grid -->
    <section id="highlights" class="mb-5 pb-4">
        <div class="row g-4">
            @foreach ($stats as $stat)
                <div class="col-6 col-md-3">
                    <div class="saas-card p-4 text-center">
                        <div class="display-5 font-mono fw-bold mb-1 text-white">{{ $stat['value'] }}</div>
                        <div class="small text-secondary font-mono text-uppercase" style="font-size: 0.75rem;">{{ $stat['label'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 3: Live Deployments & Case Studies (Glass Cards) -->
    <section id="projects" class="mb-5 py-4">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge mb-2 px-3 py-1" style="background: rgba(99, 102, 241, 0.15); color: var(--saas-accent-glow); border: 1px solid var(--saas-border);">
                    Engineered Deployments
                </span>
                <h2 class="display-5 fw-bold text-white mb-0">Featured Projects &amp; Case Studies</h2>
            </div>
            <a href="{{ url('/projects') }}" class="btn-saas-outline btn-sm">Full Telemetry Archive →</a>
        </div>

        <div class="row g-4">
            @forelse ($featuredProjects as $project)
                <div class="col-lg-6">
                    <div class="saas-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge" style="background: rgba(99, 102, 241, 0.2); color: var(--saas-accent-glow);">
                                    {{ $project->category?->name ?? 'Enterprise API' }}
                                </span>
                                <span class="text-success small font-mono">● DEPLOYED</span>
                            </div>

                            <div class="mb-4 overflow-hidden rounded-3 border" style="height: 220px; background: rgba(0,0,0,0.3); border-color: var(--saas-border) !important;">
                                @if ($project->coverImage)
                                    <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column justify-content-between p-4" style="background: radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.25), rgba(7, 9, 19, 0.9));">
                                        <span class="small font-mono text-white-50">PRODUCTION BUILD</span>
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
                            <a href="{{ url('/projects/' . $project->slug) }}" class="btn-saas btn-sm w-100 justify-content-center">
                                Inspect Architecture Breakdown →
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
        <h2 class="display-6 fw-bold text-white mb-4">Platform &amp; Core Services</h2>
        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4">
                    <div class="saas-card p-4 h-100">
                        <h3 class="h5 fw-bold text-white mb-2" style="color: var(--saas-accent-glow);">{{ $srv->title }}</h3>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $srv->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 5: Experience -->
    <section id="experience" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Production Experience</h2>
        <div class="d-flex flex-column gap-3">
            @foreach ($experiences as $exp)
                <div class="saas-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h3 class="h5 fw-bold text-white mb-0">{{ $exp->designation }} <span style="color: var(--saas-accent-glow);">@ {{ $exp->company }}</span></h3>
                        <span class="small font-mono text-secondary">
                            {{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} — {{ $exp->is_current ? 'Present' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('Y') : '') }}
                        </span>
                    </div>
                    <p class="small text-secondary mb-0 leading-relaxed">{{ $exp->description }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 6: Stack Matrix -->
    <section id="expertise" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Technical Stack &amp; Infrastructure</h2>
        <div class="row g-4">
            @foreach ($skillCategories as $cat)
                <div class="col-md-6 col-lg-3">
                    <div class="saas-card p-4 h-100">
                        <h3 class="h6 fw-bold text-white mb-3" style="color: var(--saas-accent-glow);">{{ $cat->name }}</h3>
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

    <!-- Section 7: Process & Philosophy -->
    <section id="about" class="mb-5 py-4">
        <div class="saas-card p-5">
            <h2 class="display-6 fw-bold text-white mb-3">Structured Execution Process</h2>
            <p class="lead text-secondary mb-4 leading-relaxed">
                {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
            </p>
            <div class="font-mono small" style="color: var(--saas-teal);">
                Zero-Loss Telemetry · Database Locking Safety · Resilient Queue Dispatches
            </div>
        </div>
    </section>

    <!-- Section 8: Credentials -->
    <section id="education" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Credentials &amp; Education</h2>
        @foreach ($educations as $edu)
            <div class="saas-card p-4 mb-3">
                <h3 class="h5 fw-bold text-white mb-1">{{ $edu->degree }}</h3>
                <div class="small mb-1" style="color: var(--saas-accent-glow);">{{ $edu->institution }}</div>
                <div class="small text-secondary">{{ $edu->subject }}</div>
            </div>
        @endforeach
    </section>

    <!-- Section 9: Launch CTA -->
    <section id="contact" class="py-5 text-center">
        <div class="saas-card p-5">
            <h2 class="display-4 fw-bold text-white mb-3">Initiate Collaboration</h2>
            <p class="lead text-secondary mb-4 mx-auto" style="max-width: 600px;">
                Direct inquiries for high-throughput Laravel APIs, logistics automation, and technical project leadership.
            </p>
            <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="btn-saas px-5 py-3 fs-5">
                Transmit Message ({{ $contact->email ?? 'admin@alifahmed.com' }})
            </a>
        </div>
    </section>

</div>
@endsection
