@extends('themes.nordic-minimal.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@section('content')
<div class="container py-5" style="max-width: 1040px;">

    <!-- Hero Section -->
    <section id="hero" class="py-5 mb-5 border-bottom" style="border-color: var(--nordic-border) !important;">
        <span class="badge-nordic mb-3 d-inline-block">
            {{ $contact->availability_status ?? 'Available for Select Projects & Leadership Roles' }}
        </span>

        <div class="row align-items-center g-5 mb-4">
            <div class="{{ ($profile?->avatar || $profile?->profileImage) ? 'col-lg-8' : 'col-12' }}">
                <h1 class="display-3 font-serif fw-bold mb-3" style="line-height: 1.15;">
                    {{ $profile->name ?? 'Md. Alif Ahmed' }}
                </h1>

                <h2 class="h4 text-muted font-serif mb-4">
                    {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
                </h2>

                <p class="lead mb-4" style="max-width: 680px; font-size: 1.2rem; color: var(--nordic-muted);">
                    {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                    Specialized in custom Laravel backends, multi-carrier courier API integrations, and resilient Meta Conversion API server-side tracking pipelines.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="#projects" class="btn btn-nordic">Selected Works ↓</a>
                    <a href="#contact" class="btn btn-nordic-outline">Initiate Collaboration</a>
                </div>
            </div>

            @if ($profile?->avatar || $profile?->profileImage)
                <div class="col-lg-4 text-center">
                    <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name }}" class="rounded-circle shadow-sm border p-2" style="width: 200px; height: 200px; object-fit: cover;">
                </div>
            @endif
        </div>
    </section>

    <!-- Metrics -->
    <section id="highlights" class="py-4 mb-5 border-bottom" style="border-color: var(--nordic-border) !important;">
        <div class="row g-4">
            @foreach ($stats as $stat)
                <div class="col-6 col-md-3">
                    <div class="display-6 font-serif fw-bold mb-1">{{ $stat['value'] }}</div>
                    <p class="small text-muted mb-0">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Projects -->
    <section id="projects" class="py-4 mb-5 border-bottom" style="border-color: var(--nordic-border) !important;">
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <span class="badge-nordic mb-2 d-inline-block">Curated Cases</span>
                <h2 class="display-5 font-serif fw-bold mb-0">Featured Projects &amp; Case Studies</h2>
            </div>
            <a href="{{ url('/projects') }}" class="small text-decoration-underline text-reset">All Works →</a>
        </div>

        <div class="row g-5">
            @forelse ($featuredProjects as $project)
                <div class="col-md-6">
                    <article class="h-100 d-flex flex-column">
                        <div class="mb-3 overflow-hidden rounded-3 border" style="height: 260px; background: #e7e5e4;">
                            @if ($project->coverImage)
                                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 d-flex flex-column justify-content-between p-4" style="background: #e7e5e4;">
                                    <span class="badge-nordic align-self-start">{{ $project->category?->name ?? 'Production' }}</span>
                                    <div class="font-serif h4 mb-0 text-dark">{{ $project->title }}</div>
                                </div>
                            @endif
                        </div>

                        <span class="small text-muted text-uppercase font-mono mb-1">{{ $project->category?->name ?? 'Production' }}</span>
                        <h3 class="h4 font-serif fw-bold mb-2">
                            <a href="{{ url('/projects/' . $project->slug) }}" class="text-decoration-none text-reset">
                                {{ $project->title }}
                            </a>
                        </h3>
                        <p class="small text-muted mb-3 flex-grow-1 leading-relaxed">{{ $project->summary }}</p>

                        <div class="d-flex flex-wrap gap-1 mb-3">
                            @foreach ($project->skills->take(3) as $s)
                                <span class="badge-nordic">{{ $s->name }}</span>
                            @endforeach
                        </div>

                        <a href="{{ url('/projects/' . $project->slug) }}" class="small fw-semibold text-decoration-underline text-reset mt-auto">
                            Read Architecture Case Study →
                        </a>
                    </article>
                </div>
            @empty
                <p class="text-muted text-center py-5">No projects available.</p>
            @endforelse
        </div>
    </section>

    <!-- Services -->
    <section id="services" class="py-4 mb-5 border-bottom" style="border-color: var(--nordic-border) !important;">
        <span class="badge-nordic mb-2 d-inline-block">Specializations</span>
        <h2 class="display-5 font-serif fw-bold mb-4">Services &amp; Architecture</h2>

        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4">
                    <div class="nordic-card p-4 h-100">
                        <h3 class="h5 font-serif fw-bold mb-2">{{ $srv->title }}</h3>
                        <p class="small text-muted mb-0 leading-relaxed">{{ $srv->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Experience -->
    <section id="experience" class="py-4 mb-5 border-bottom" style="border-color: var(--nordic-border) !important;">
        <span class="badge-nordic mb-2 d-inline-block">Career Journey</span>
        <h2 class="display-5 font-serif fw-bold mb-4">Professional Experience</h2>

        <div class="d-flex flex-column gap-4">
            @foreach ($experiences as $exp)
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start pb-4 border-bottom" style="border-color: var(--nordic-border) !important;">
                    <div>
                        <h3 class="h5 font-serif fw-bold mb-1">{{ $exp->designation }}</h3>
                        <div class="small font-mono text-muted mb-2">{{ $exp->company }}</div>
                        <p class="small text-muted mb-0" style="max-width: 650px;">{{ $exp->description }}</p>
                    </div>
                    <span class="small font-mono text-muted mt-2 mt-md-0">
                        {{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} — {{ $exp->is_current ? 'Present' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('Y') : '') }}
                    </span>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Expertise -->
    <section id="expertise" class="py-4 mb-5 border-bottom" style="border-color: var(--nordic-border) !important;">
        <span class="badge-nordic mb-2 d-inline-block">Stack</span>
        <h2 class="display-5 font-serif fw-bold mb-4">Technical Expertise &amp; Core Stack</h2>

        <div class="row g-4">
            @foreach ($skillCategories as $cat)
                <div class="col-md-6 col-lg-3">
                    <div class="nordic-card p-4 h-100">
                        <h3 class="h6 font-serif fw-bold mb-3">{{ $cat->name }}</h3>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                            @foreach ($cat->skills as $sk)
                                <li class="small text-muted">{{ $sk->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- About -->
    <section id="about" class="py-4 mb-5 border-bottom" style="border-color: var(--nordic-border) !important;">
        <span class="badge-nordic mb-2 d-inline-block">Monograph</span>
        <h2 class="display-5 font-serif fw-bold mb-3">About Alif Ahmed</h2>
        <p class="lead text-muted mb-4" style="max-width: 720px;">
            {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
        </p>
        <p class="small text-muted mb-0">
            Structured Execution Process · High Concurrency Database Profiling
        </p>
    </section>

    <!-- Education -->
    <section id="education" class="py-4 mb-5 border-bottom" style="border-color: var(--nordic-border) !important;">
        <span class="badge-nordic mb-2 d-inline-block">Academia</span>
        <h2 class="display-5 font-serif fw-bold mb-4">Education &amp; Credentials</h2>

        @foreach ($educations as $edu)
            <div class="mb-3">
                <h3 class="h5 font-serif fw-bold mb-1">{{ $edu->degree }}</h3>
                <div class="small text-muted">{{ $edu->institution }} · {{ $edu->subject }}</div>
            </div>
        @endforeach
    </section>

    <!-- Contact -->
    <section id="contact" class="py-5 text-center">
        <h2 class="display-4 font-serif fw-bold mb-3">Initiate Collaboration</h2>
        <p class="text-muted lead mb-4 mx-auto" style="max-width: 580px;">
            Inquiries for technical project leadership, high-throughput Laravel systems, and e-commerce tracking architecture.
        </p>
        <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="btn btn-nordic px-5 py-3">
            Write to {{ $contact->email ?? 'admin@alifahmed.com' }}
        </a>
    </section>

</div>
@endsection
