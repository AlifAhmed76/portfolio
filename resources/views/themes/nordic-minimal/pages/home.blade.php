@extends('themes.nordic-minimal.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@push('styles')
<style>
    /* Tobias van Schneider Scandinavian Monograph */
    .essay-container {
        max-width: 760px;
        margin: 0 auto;
    }
    .essay-project-card {
        padding: 56px 0;
        border-bottom: 1px solid var(--nordic-border);
    }
    .serif-display {
        font-family: var(--font-serif);
        font-style: italic;
        font-weight: 400;
    }
</style>
@endpush

@section('content')
<div class="container py-5">
    <div class="essay-container">

        <!-- Hero Monograph -->
        <section id="hero" class="py-5 mb-5 border-bottom" style="border-color: var(--nordic-border) !important;">
            <div class="small font-mono text-muted mb-3 text-uppercase" style="letter-spacing: 0.12em; font-size: 0.72rem;">
                {{ $contact->availability_status ?? 'Available for Select Projects & Leadership Roles' }}
            </div>

            <h1 class="display-3 font-serif fw-normal mb-3" style="line-height: 1.1;">
                {{ $profile->name ?? 'Md. Alif Ahmed' }}
            </h1>

            <p class="h4 text-muted serif-display mb-4">
                {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
            </p>

            <p class="lead mb-5" style="font-size: 1.25rem; line-height: 1.8; color: var(--nordic-muted);">
                {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                Specialized in custom Laravel backends, multi-carrier courier API automations, and resilient Meta Conversion API server-side tracking pipelines.
            </p>

            @if ($profile?->avatar || $profile?->profileImage)
                <div class="mb-5">
                    <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name }}" class="rounded-circle shadow-sm border p-2" style="width: 140px; height: 140px; object-fit: cover;">
                </div>
            @endif

            <div class="d-flex gap-3">
                <a href="#projects" class="btn btn-nordic">Selected Works ↓</a>
                <a href="#contact" class="btn btn-nordic-outline">Initiate Collaboration</a>
            </div>
        </section>

        <!-- Stats Metric Note -->
        <section id="highlights" class="py-4 mb-5 border-bottom" style="border-color: var(--nordic-border) !important;">
            <div class="row g-4">
                @foreach ($stats as $stat)
                    <div class="col-6 col-md-3">
                        <div class="font-serif display-6 fw-normal mb-0">{{ $stat['value'] }}</div>
                        <div class="small text-muted" style="font-size: 0.78rem;">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Projects Essay List (Van Schneider Single-Column Essay format) -->
        <section id="projects" class="mb-5 pb-4">
            <div class="d-flex justify-content-between align-items-baseline mb-4">
                <h2 class="h3 font-serif mb-0">Featured Projects &amp; Case Studies</h2>
                <a href="{{ url('/projects') }}" class="small text-muted text-decoration-underline">All Projects →</a>
            </div>

            <div>
                @forelse ($featuredProjects as $project)
                    <article class="essay-project-card">
                        <span class="small font-mono text-muted text-uppercase mb-2 d-inline-block">{{ $project->category?->name ?? 'Production' }}</span>
                        
                        <h3 class="display-6 font-serif fw-normal mb-3">
                            <a href="{{ url('/projects/' . $project->slug) }}" class="text-decoration-none text-reset">
                                {{ $project->title }}
                            </a>
                        </h3>

                        <div class="mb-4 overflow-hidden rounded-2 border" style="height: 320px; background: #e7e5e4;">
                            @if ($project->coverImage)
                                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 d-flex flex-column justify-content-between p-4" style="background: #e7e5e4;">
                                    <span class="small font-mono text-muted">{{ $project->category?->name ?? 'Engineering' }}</span>
                                    <div class="font-serif h3 text-dark">{{ $project->title }}</div>
                                </div>
                            @endif
                        </div>

                        <p class="lead mb-4" style="font-size: 1.15rem; line-height: 1.8; color: var(--nordic-muted);">
                            {{ $project->summary }}
                        </p>

                        <div class="d-flex flex-wrap gap-2 mb-4">
                            @foreach ($project->skills as $skill)
                                <span class="badge-nordic">{{ $skill->name }}</span>
                            @endforeach
                        </div>

                        <a href="{{ url('/projects/' . $project->slug) }}" class="small fw-semibold text-decoration-underline text-reset">
                            Read Architecture Case Study →
                        </a>
                    </article>
                @empty
                    <p class="text-muted py-4">Projects loading...</p>
                @endforelse
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-5 border-bottom" style="border-color: var(--nordic-border) !important;">
            <h2 class="h3 font-serif mb-4">Services &amp; Architecture</h2>
            <div class="d-flex flex-column gap-4">
                @foreach ($services as $srv)
                    <div class="pb-3 border-bottom" style="border-color: var(--nordic-border) !important;">
                        <h3 class="h5 font-serif fw-normal mb-1">{{ $srv->title }}</h3>
                        <p class="small text-muted mb-0 leading-relaxed">{{ $srv->description }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Experience Section -->
        <section id="experience" class="py-5 border-bottom" style="border-color: var(--nordic-border) !important;">
            <h2 class="h3 font-serif mb-4">Professional Experience</h2>
            <div class="d-flex flex-column gap-4">
                @foreach ($experiences as $exp)
                    <div>
                        <div class="d-flex justify-content-between align-items-baseline mb-1">
                            <h3 class="h5 font-serif fw-normal mb-0">{{ $exp->designation }}</h3>
                            <span class="small font-mono text-muted">
                                {{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} — {{ $exp->is_current ? 'Present' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('Y') : '') }}
                            </span>
                        </div>
                        <div class="small text-muted mb-2 font-mono">{{ $exp->company }}</div>
                        <p class="small text-muted mb-0 leading-relaxed">{{ $exp->description }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- Expertise Section -->
        <section id="expertise" class="py-5 border-bottom" style="border-color: var(--nordic-border) !important;">
            <h2 class="h3 font-serif mb-4">Technical Expertise &amp; Core Stack</h2>
            <div class="row g-4">
                @foreach ($skillCategories as $cat)
                    <div class="col-sm-6">
                        <h3 class="h6 font-serif mb-2">{{ $cat->name }}</h3>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach ($cat->skills as $sk)
                                <span class="badge-nordic">{{ $sk->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-5 border-bottom" style="border-color: var(--nordic-border) !important;">
            <h2 class="h3 font-serif mb-3">About Alif Ahmed</h2>
            <p class="lead mb-4" style="line-height: 1.8; color: var(--nordic-muted);">
                {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
            </p>
            <p class="small text-muted mb-0">
                Structured Execution Process · High Concurrency Database Profiling
            </p>
        </section>

        <!-- Education Section -->
        <section id="education" class="py-5 border-bottom" style="border-color: var(--nordic-border) !important;">
            <h2 class="h3 font-serif mb-3">Education &amp; Credentials</h2>
            @foreach ($educations as $edu)
                <div class="mb-3">
                    <h3 class="h6 font-serif fw-bold mb-1">{{ $edu->degree }}</h3>
                    <div class="small text-muted">{{ $edu->institution }} · {{ $edu->subject }}</div>
                </div>
            @endforeach
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-5 text-center">
            <h2 class="display-5 font-serif fw-normal mb-3">Initiate Collaboration</h2>
            <p class="lead text-muted mb-4 mx-auto" style="max-width: 500px; font-size: 1.15rem;">
                Direct inquiries for technical project leadership, high-concurrency systems, and attribution architecture.
            </p>
            <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="btn btn-nordic px-4 py-2">
                Write to {{ $contact->email ?? 'admin@alifahmed.com' }}
            </a>
        </section>

    </div>
</div>
@endsection
