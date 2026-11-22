@extends('themes.animattor-dark.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@push('styles')
<style>
    /* Continuous Marquee Ticker (Animattor style) */
    .marquee-container {
        overflow: hidden;
        white-space: nowrap;
        position: relative;
        padding: 16px 0;
        background: rgba(139, 92, 246, 0.05);
        border-top: 1px solid rgba(139, 92, 246, 0.2);
        border-bottom: 1px solid rgba(139, 92, 246, 0.2);
    }
    .marquee-track {
        display: inline-block;
        animation: marqueeScroll 25s linear infinite;
    }
    @keyframes marqueeScroll {
        from { transform: translateX(0%); }
        to { transform: translateX(-50%); }
    }
    .bento-card-hero {
        background: radial-gradient(circle at 100% 0%, rgba(139, 92, 246, 0.25), rgba(23, 21, 48, 0.95));
        border: 1px solid rgba(139, 92, 246, 0.35);
        border-radius: 1.5rem;
    }
    .bento-telemetry-box {
        background: rgba(13, 12, 29, 0.9);
        border: 1px solid rgba(139, 92, 246, 0.25);
        border-radius: 1.25rem;
    }
    .radar-pulse {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #8b5cf6;
        box-shadow: 0 0 0 0 rgba(139, 92, 246, 0.7);
        animation: radarPulse 2s infinite;
    }
    @keyframes radarPulse {
        to { box-shadow: 0 0 0 12px rgba(139, 92, 246, 0); }
    }
</style>
@endpush

@section('content')
<!-- Hero Section (Centered 3D Product Launch Style - Animattor.co) -->
<section id="hero" class="py-5 text-center position-relative overflow-hidden">
    <div class="container py-4 position-relative z-2">
        <div class="d-inline-flex align-items-center gap-2 badge-violet mb-4 px-3 py-2">
            <span class="radar-pulse"></span>
            <span>{{ $contact->availability_status ?? 'Available for Select Projects & Leadership Roles' }}</span>
        </div>

        <h1 class="display-3 fw-bolder mb-3 text-white">
            {{ $profile->name ?? 'Md. Alif Ahmed' }}
        </h1>

        <h2 class="h4 text-violet-glow fw-semibold mb-4 mx-auto" style="max-width: 780px;">
            {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
        </h2>

        <p class="lead text-secondary mb-5 mx-auto" style="max-width: 720px; font-size: 1.2rem;">
            {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
            Specialized in custom Laravel backends, multi-carrier courier API automations, and resilient Meta Conversion API server-side tracking pipelines.
        </p>

        <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
            <a href="#projects" class="btn btn-violet px-4 py-3 d-inline-flex align-items-center gap-2">
                <i data-lucide="sparkles" style="width: 18px; height: 18px;"></i>
                <span>Explore Interactive Showcase</span>
            </a>
            <a href="#contact" class="btn btn-violet-outline px-4 py-3 d-inline-flex align-items-center gap-2">
                <i data-lucide="mail" style="width: 18px; height: 18px;"></i>
                <span>Initiate Collaboration</span>
            </a>
        </div>

        @if ($profile?->avatar || $profile?->profileImage)
            <div class="mb-2">
                <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name }}" class="rounded-circle shadow-lg border border-3 border-violet p-1" style="width: 140px; height: 140px; object-fit: cover;">
            </div>
        @endif
    </div>
</section>

<!-- Continuous Infinite Marquee Ticker (Animattor / Sitewise style) -->
<div class="marquee-container mb-5">
    <div class="marquee-track font-mono small text-uppercase">
        <span class="mx-4 text-violet-glow">✦ LARAVEL 11 ARCHITECTURE</span>
        <span class="mx-4 text-secondary">✦ META CONVERSION API (99.8% VERIFIED)</span>
        <span class="mx-4 text-violet-glow">✦ MULTI-CARRIER COURIER LOGISTICS (PATHAO / REDX / STEADFAST)</span>
        <span class="mx-4 text-secondary">✦ HIGH-CONCURRENCY MYSQL PROFILING</span>
        <span class="mx-4 text-violet-glow">✦ DOCKER DEPLOYMENTS</span>
        <span class="mx-4 text-secondary">✦ ZERO-LOSS TELEMETRY</span>
        <span class="mx-4 text-violet-glow">✦ LARAVEL 11 ARCHITECTURE</span>
        <span class="mx-4 text-secondary">✦ META CONVERSION API (99.8% VERIFIED)</span>
        <span class="mx-4 text-violet-glow">✦ MULTI-CARRIER COURIER LOGISTICS (PATHAO / REDX / STEADFAST)</span>
        <span class="mx-4 text-secondary">✦ HIGH-CONCURRENCY MYSQL PROFILING</span>
    </div>
</div>

<div class="container mb-5">

    <!-- Section: Asymmetrical Bento Grid Showcase -->
    <section id="projects" class="mb-5 py-4">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge-violet mb-2 d-inline-block">Bento Grid Matrix</span>
                <h2 class="display-5 fw-bold text-white mb-0">Featured Projects &amp; Case Studies</h2>
            </div>
            <a href="{{ url('/projects') }}" class="btn btn-sm btn-violet-outline">Full Case Archive →</a>
        </div>

        <div class="row g-4">
            @forelse ($featuredProjects as $idx => $project)
                <div class="{{ $idx === 0 ? 'col-lg-8' : ($idx === 1 ? 'col-lg-4' : 'col-lg-4') }}">
                    <div class="bento-card-hero p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge-violet">{{ $project->category?->name ?? 'Enterprise Solution' }}</span>
                                <i data-lucide="arrow-up-right" class="text-violet-glow" style="width: 22px; height: 22px;"></i>
                            </div>

                            <div class="mb-3 overflow-hidden rounded-3" style="height: {{ $idx === 0 ? '220px' : '150px' }}; background: #0d0c1d;">
                                @if ($project->coverImage)
                                    <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column justify-content-between p-3" style="background: radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.3), #0d0c1d);">
                                        <span class="small font-mono text-violet-glow">{{ $project->category?->name ?? 'Engineering' }}</span>
                                        <div class="h5 fw-bold text-white">{{ $project->title }}</div>
                                    </div>
                                @endif
                            </div>

                            <h3 class="h4 fw-bold text-white mb-2">{{ $project->title }}</h3>
                            <p class="text-secondary small mb-3 leading-relaxed">{{ $project->summary }}</p>
                        </div>

                        <div>
                            <div class="d-flex flex-wrap gap-1 mb-3">
                                @foreach ($project->skills->take(3) as $ps)
                                    <span class="badge bg-secondary-subtle text-light small">{{ $ps->name }}</span>
                                @endforeach
                            </div>
                            <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-violet w-100 text-center">
                                Inspect Engineering Breakdown →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-secondary text-center py-4">Projects loading...</p>
            @endforelse

            <!-- Bento Live Telemetry Widget -->
            <div class="col-lg-8">
                <div class="bento-telemetry-box p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge-violet">Live Telemetry &amp; CAPI Status</span>
                            <span class="text-success small font-mono">● OPERATIONAL</span>
                        </div>
                        <h3 class="h4 fw-bold text-white mb-2">Server-Side Conversion Engine &amp; Dispatch Hub</h3>
                        <p class="small text-secondary mb-4 leading-relaxed">
                            Dual-stream event reconciliation preventing ad-blocker signal loss. Asynchronous courier dispatch directly interfaced with Pathao, RedX, and Steadfast REST endpoints.
                        </p>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <div class="p-3 rounded border border-secondary-subtle text-center">
                                <div class="h4 fw-bold text-violet-glow mb-0">99.8%</div>
                                <div class="small text-secondary" style="font-size: 0.72rem;">CAPI Event Match</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="p-3 rounded border border-secondary-subtle text-center">
                                <div class="h4 fw-bold text-violet-glow mb-0">&lt;100ms</div>
                                <div class="small text-secondary" style="font-size: 0.72rem;">Dispatch Latency</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="p-3 rounded border border-secondary-subtle text-center">
                                <div class="h4 fw-bold text-violet-glow mb-0">100%</div>
                                <div class="small text-secondary" style="font-size: 0.72rem;">DB Lock Isolation</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Services &amp; Architecture</h2>
        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4">
                    <div class="bento-telemetry-box p-4 h-100">
                        <h3 class="h5 fw-bold text-violet-glow mb-2">{{ $srv->title }}</h3>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $srv->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Experience Timeline -->
    <section id="experience" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Professional Experience</h2>
        <div class="d-flex flex-column gap-3">
            @foreach ($experiences as $exp)
                <div class="bento-telemetry-box p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h3 class="h5 fw-bold text-white mb-1">{{ $exp->designation }}</h3>
                            <div class="text-violet-glow small">{{ $exp->company }}</div>
                        </div>
                        <span class="badge-violet">
                            {{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} — {{ $exp->is_current ? 'Present' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('Y') : '') }}
                        </span>
                    </div>
                    <p class="small text-secondary mb-0 leading-relaxed">{{ $exp->description }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Competency Matrix -->
    <section id="expertise" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Technical Expertise &amp; Core Stack</h2>
        <div class="row g-4">
            @foreach ($skillCategories as $cat)
                <div class="col-md-6 col-lg-3">
                    <div class="bento-telemetry-box p-4 h-100">
                        <h3 class="h6 fw-bold text-violet-glow mb-3">{{ $cat->name }}</h3>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                            @foreach ($cat->skills as $sk)
                                <li class="small text-light">{{ $sk->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="mb-5 py-4">
        <div class="bento-card-hero p-4 p-md-5">
            <h2 class="display-6 fw-bold text-white mb-3">About Alif Ahmed</h2>
            <p class="lead text-secondary mb-4 leading-relaxed">
                {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
            </p>
            <div class="small text-violet-glow font-mono">
                Structured Execution Process · High Concurrency Database Profiling
            </div>
        </div>
    </section>

    <!-- Education -->
    <section id="education" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Education &amp; Credentials</h2>
        @foreach ($educations as $edu)
            <div class="bento-telemetry-box p-4 mb-3">
                <h3 class="h5 fw-bold text-white mb-1">{{ $edu->degree }}</h3>
                <div class="text-violet-glow small mb-1">{{ $edu->institution }}</div>
                <div class="small text-secondary">{{ $edu->subject }}</div>
            </div>
        @endforeach
    </section>

    <!-- Contact CTA -->
    <section id="contact" class="py-5 text-center">
        <div class="bento-card-hero p-5">
            <h2 class="display-4 fw-bold text-white mb-3">Initiate Collaboration</h2>
            <p class="lead text-secondary mb-4 mx-auto" style="max-width: 600px;">
                Direct inquiries for high-throughput Laravel systems, logistics automation, and technical project leadership.
            </p>
            <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="btn btn-violet px-5 py-3" style="font-size: 1.1rem;">
                Transmit Message ({{ $contact->email ?? 'admin@alifahmed.com' }})
            </a>
        </div>
    </section>

</div>
@endsection
