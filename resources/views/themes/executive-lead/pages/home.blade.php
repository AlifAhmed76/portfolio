@extends('themes.executive-lead.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@push('styles')
<style>
    /* Executive Command Center / Leadership Architecture */
    .exec-kpi-badge {
        font-family: var(--font-mono);
        font-size: 0.75rem;
        background: rgba(245, 158, 11, 0.15);
        border: 1px solid rgba(245, 158, 11, 0.3);
        color: #fbbf24;
        padding: 4px 12px;
        border-radius: 4px;
        display: inline-block;
    }
    .exec-governance-row {
        border-left: 3px solid #f59e0b;
        background: rgba(17, 34, 64, 0.6);
        padding: 24px;
        border-radius: 0 12px 12px 0;
        margin-bottom: 16px;
    }
</style>
@endpush

@section('content')
<div class="container py-5" style="max-width: 1140px;">

    <!-- Executive Leadership Summary Banner -->
    <section id="hero" class="mb-5 pb-4">
        <div class="exec-card p-4 p-md-5" style="background: linear-gradient(135deg, rgba(17, 34, 64, 0.95) 0%, rgba(10, 25, 47, 0.98) 100%);">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-secondary-subtle">
                <span class="exec-kpi-badge">
                    [ EXECUTIVE STATUS: {{ strtoupper($contact->availability_status ?? 'Available for Select Projects & Leadership Roles') }} ]
                </span>
                <span class="small font-mono text-warning">DIRECTORATE // SPRINT ARCHITECTURE</span>
            </div>

            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bolder text-white mb-2">
                        {{ $profile->name ?? 'Md. Alif Ahmed' }}
                    </h1>

                    <h2 class="h5 text-warning fw-semibold mb-4">
                        {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
                    </h2>

                    <p class="lead mb-4 leading-relaxed" style="color: var(--exec-text); font-size: 1.15rem; max-width: 720px;">
                        {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                        Specialized in custom Laravel backends, high-conversion e-commerce storefronts, multi-carrier courier API integrations, and resilient Meta Conversion API server-side tracking pipelines.
                    </p>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="#projects" class="btn btn-gold px-4 py-3 fw-bold">Review Commercial Case Deliveries</a>
                        <a href="#contact" class="btn btn-gold-outline px-4 py-3 fw-bold">Initiate Collaboration</a>
                    </div>
                </div>

                @if ($profile?->avatar || $profile?->profileImage)
                    <div class="col-lg-4 text-center">
                        <div class="p-2 d-inline-block rounded-4 border border-warning" style="background: rgba(10, 25, 47, 0.8);">
                            <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name }}" class="rounded-3 shadow-lg" style="width: 190px; height: 190px; object-fit: cover;">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Executive KPI Metrics Dashboard -->
    <section id="highlights" class="mb-5 pb-2">
        <div class="row g-3">
            @foreach ($stats as $stat)
                <div class="col-6 col-md-3">
                    <div class="exec-card p-4 text-center h-100">
                        <div class="display-5 fw-bold text-warning mb-1">{{ $stat['value'] }}</div>
                        <div class="small font-mono text-secondary text-uppercase" style="font-size: 0.78rem;">{{ $stat['label'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Commercial Case Deliveries (Executive 2-Column Grid with SLA / ROI Notes) -->
    <section id="projects" class="mb-5 py-4">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="exec-kpi-badge mb-2 d-inline-block">Commercial Deliveries</span>
                <h2 class="display-6 fw-bold text-white mb-0">Featured Projects &amp; Case Studies</h2>
            </div>
            <a href="{{ url('/projects') }}" class="btn btn-sm btn-gold-outline">Inspect All Deliveries →</a>
        </div>

        <div class="row g-4">
            @forelse ($featuredProjects as $project)
                <div class="col-lg-6">
                    <div class="exec-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="exec-kpi-badge">{{ $project->category?->name ?? 'Production' }}</span>
                                <span class="small font-mono text-success">● DELIVERED</span>
                            </div>

                            <div class="mb-3 overflow-hidden rounded-3 border border-secondary-subtle" style="height: 200px; background: #0a192f;">
                                @if ($project->coverImage)
                                    <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column justify-content-between p-3" style="background: radial-gradient(circle at 80% 20%, rgba(245, 158, 11, 0.25), #0a192f);">
                                        <span class="exec-kpi-badge align-self-start">{{ $project->category?->name ?? 'Production' }}</span>
                                        <div class="h5 fw-bold text-white">{{ $project->title }}</div>
                                    </div>
                                @endif
                            </div>

                            <h3 class="h4 fw-bold text-white mb-2">{{ $project->title }}</h3>
                            <p class="small text-secondary mb-4 leading-relaxed">{{ $project->summary }}</p>
                        </div>

                        <div>
                            <div class="d-flex flex-wrap gap-1 mb-4">
                                @foreach ($project->skills as $s)
                                    <span class="badge bg-secondary-subtle text-light small">{{ $s->name }}</span>
                                @endforeach
                            </div>

                            <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-gold w-100 text-center fw-semibold">
                                Read Architecture Case Study →
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-secondary text-center py-4">Projects loading...</p>
            @endforelse
        </div>
    </section>

    <!-- Services Governance Section -->
    <section id="services" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Services &amp; Architecture</h2>
        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4">
                    <div class="exec-card p-4 h-100">
                        <div class="small font-mono text-warning mb-1">SERVICE OFFERING</div>
                        <h3 class="h5 fw-bold text-white mb-2">{{ $srv->title }}</h3>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $srv->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Leadership Experience Timeline (Executive Governance Rows) -->
    <section id="experience" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Professional Experience</h2>
        <div>
            @foreach ($experiences as $exp)
                <div class="exec-governance-row">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start mb-2">
                        <div>
                            <h3 class="h4 fw-bold text-white mb-1">{{ $exp->designation }}</h3>
                            <div class="text-warning small font-mono">{{ $exp->company }}</div>
                        </div>
                        <span class="exec-kpi-badge mt-2 mt-md-0">
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
                    <div class="exec-card p-4 h-100">
                        <h3 class="h6 fw-bold text-warning mb-3 font-mono">{{ $cat->name }}</h3>
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
        <div class="exec-card p-4 p-md-5">
            <h2 class="display-6 fw-bold text-white mb-3">About Alif Ahmed</h2>
            <p class="lead text-secondary mb-4 leading-relaxed">
                {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
            </p>
            <div class="small text-warning font-mono">
                Structured Execution Process · High Concurrency Database Profiling
            </div>
        </div>
    </section>

    <!-- Education Section -->
    <section id="education" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Education &amp; Credentials</h2>
        @foreach ($educations as $edu)
            <div class="exec-card p-4 mb-3">
                <h3 class="h5 fw-bold text-white mb-1">{{ $edu->degree }}</h3>
                <div class="text-warning small mb-1">{{ $edu->institution }}</div>
                <div class="small text-secondary">{{ $edu->subject }}</div>
            </div>
        @endforeach
    </section>

    <!-- Contact CTA -->
    <section id="contact" class="py-5 text-center">
        <div class="exec-card p-5">
            <h2 class="display-4 fw-bold text-white mb-3">Initiate Collaboration</h2>
            <p class="lead text-secondary mb-4 mx-auto" style="max-width: 600px;">
                Direct inquiries for technical project leadership, high-concurrency systems, and attribution architecture.
            </p>
            <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="btn btn-gold px-5 py-3 fw-bold" style="font-size: 1.1rem;">
                Initiate Executive Discussion ({{ $contact->email ?? 'admin@alifahmed.com' }})
            </a>
        </div>
    </section>

</div>
@endsection
