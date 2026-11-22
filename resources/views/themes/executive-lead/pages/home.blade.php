@extends('themes.executive-lead.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@section('content')
<div class="container py-4">

    <!-- Hero Section -->
    <section id="hero" class="py-5 mb-5">
        <div class="exec-card p-4 p-lg-5" style="background: radial-gradient(circle at 85% 15%, rgba(245, 158, 11, 0.15), rgba(17, 34, 64, 0.98));">
            <div class="row align-items-center g-5">
                <div class="col-lg-8">
                    <span class="badge-gold mb-3 d-inline-block">
                        {{ $contact->availability_status ?? 'Available for Select Projects & Leadership Roles' }}
                    </span>

                    <h1 class="display-3 fw-bold mb-2">
                        {{ $profile->name ?? 'Md. Alif Ahmed' }}
                    </h1>

                    <h2 class="h4 text-warning fw-semibold mb-3">
                        {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
                    </h2>

                    <p class="lead mb-4" style="max-width: 680px; color: var(--exec-text);">
                        {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                        Specialized in custom Laravel backends, high-conversion e-commerce storefronts, multi-carrier courier API integrations, and resilient Meta Conversion API server-side tracking pipelines.
                    </p>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="#projects" class="btn btn-gold px-4 py-3">Explore Enterprise Cases</a>
                        <a href="#contact" class="btn btn-gold-outline px-4 py-3">Initiate Collaboration</a>
                    </div>
                </div>

                @if ($profile?->avatar || $profile?->profileImage)
                    <div class="col-lg-4 text-center">
                        <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name }}" class="rounded-circle shadow-lg border border-3 border-warning p-1" style="width: 180px; height: 180px; object-fit: cover;">
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Metrics -->
    <section id="highlights" class="mb-5">
        <div class="row g-4">
            @foreach ($stats as $stat)
                <div class="col-6 col-lg-3">
                    <div class="exec-card p-4 text-center h-100">
                        <div class="display-6 fw-bold text-warning mb-1">{{ $stat['value'] }}</div>
                        <p class="small text-secondary mb-0 fw-medium">{{ $stat['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Projects -->
    <section id="projects" class="mb-5 py-4">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <span class="badge-gold mb-2 d-inline-block">Commercial Deliveries</span>
                <h2 class="h2 fw-bold mb-0">Featured Projects &amp; Case Studies</h2>
            </div>
            <a href="{{ url('/projects') }}" class="btn btn-sm btn-gold-outline">Full Case Archive →</a>
        </div>

        <div class="row g-4">
            @forelse ($featuredProjects as $project)
                <div class="col-md-6 col-lg-4">
                    <div class="exec-card p-4 h-100 d-flex flex-column">
                        <div class="mb-3 overflow-hidden rounded-3" style="height: 190px; background: #0a192f;">
                            @if ($project->coverImage)
                                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 d-flex flex-column justify-content-between p-3" style="background: radial-gradient(circle at 80% 20%, rgba(245, 158, 11, 0.25), #0a192f);">
                                    <span class="badge-gold align-self-start">{{ $project->category?->name ?? 'Production' }}</span>
                                    <div class="text-white fw-bold">{{ $project->title }}</div>
                                </div>
                            @endif
                        </div>

                        <span class="badge-gold align-self-start mb-2">{{ $project->category?->name ?? 'Production' }}</span>
                        <h3 class="h5 fw-bold mb-2">{{ $project->title }}</h3>
                        <p class="small text-secondary mb-3 flex-grow-1 leading-relaxed">{{ $project->summary }}</p>

                        <div class="d-flex flex-wrap gap-1 mb-3">
                            @foreach ($project->skills->take(3) as $s)
                                <span class="badge bg-secondary-subtle text-light small">{{ $s->name }}</span>
                            @endforeach
                        </div>

                        <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-gold mt-auto">Read Case Study →</a>
                    </div>
                </div>
            @empty
                <p class="text-secondary text-center py-4">Projects loading...</p>
            @endforelse
        </div>
    </section>

    <!-- Services -->
    <section id="services" class="mb-5 py-4">
        <h2 class="h2 fw-bold mb-4">Services &amp; Architecture</h2>
        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4">
                    <div class="exec-card p-4 h-100">
                        <h3 class="h5 fw-bold text-warning mb-2">{{ $srv->title }}</h3>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $srv->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Expertise -->
    <section id="expertise" class="mb-5 py-4">
        <h2 class="h2 fw-bold mb-4">Technical Expertise &amp; Core Stack</h2>
        <div class="row g-4">
            @foreach ($skillCategories as $cat)
                <div class="col-md-6 col-lg-3">
                    <div class="exec-card p-4 h-100">
                        <h3 class="h6 fw-bold text-warning mb-3">{{ $cat->name }}</h3>
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

    <!-- Experience -->
    <section id="experience" class="mb-5 py-4">
        <h2 class="h2 fw-bold mb-4">Professional Experience</h2>
        <div class="d-flex flex-column gap-3">
            @foreach ($experiences as $exp)
                <div class="exec-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h3 class="h5 fw-bold mb-1">{{ $exp->designation }}</h3>
                            <div class="text-warning small fw-semibold">{{ $exp->company }}</div>
                        </div>
                        <span class="badge-gold">
                            {{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} — {{ $exp->is_current ? 'Present' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('Y') : '') }}
                        </span>
                    </div>
                    <p class="small text-secondary mb-0">{{ $exp->description }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- About -->
    <section id="about" class="mb-5 py-4">
        <div class="exec-card p-4 p-md-5">
            <h2 class="h2 fw-bold mb-3">About Alif Ahmed</h2>
            <p class="text-secondary lead mb-4">
                {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
            </p>
            <div class="small text-warning">
                Structured Execution Process · High Concurrency Database Profiling
            </div>
        </div>
    </section>

    <!-- Education -->
    <section id="education" class="mb-5 py-4">
        <h2 class="h2 fw-bold mb-4">Education &amp; Credentials</h2>
        @foreach ($educations as $edu)
            <div class="exec-card p-4 mb-3">
                <h3 class="h5 fw-bold mb-1">{{ $edu->degree }}</h3>
                <div class="text-warning small mb-1">{{ $edu->institution }}</div>
                <div class="small text-secondary">{{ $edu->subject }}</div>
            </div>
        @endforeach
    </section>

    <!-- Contact -->
    <section id="contact" class="py-5 text-center">
        <div class="exec-card p-5">
            <h2 class="display-5 fw-bold mb-3">Initiate Collaboration</h2>
            <p class="text-secondary lead mb-4 mx-auto" style="max-width: 600px;">
                Direct inquiries for engineering leadership, courier automation, and conversion tracking architecture.
            </p>
            <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="btn btn-gold px-5 py-3">
                Connect Directly ({{ $contact->email ?? 'admin@alifahmed.com' }})
            </a>
        </div>
    </section>

</div>
@endsection
