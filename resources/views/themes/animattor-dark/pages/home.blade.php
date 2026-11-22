@extends('themes.animattor-dark.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@section('content')
<div class="container py-4">

    <!-- Hero Section -->
    <section id="hero" class="py-5 mb-4">
        <div class="animattor-card p-4 p-lg-5 position-relative overflow-hidden" style="background: radial-gradient(circle at 85% 15%, rgba(139, 92, 246, 0.25), rgba(23, 21, 48, 0.95));">
            <div class="row align-items-center g-5">
                <div class="col-lg-7 text-center text-lg-start">
                    <div class="d-inline-flex align-items-center gap-2 badge-violet mb-3">
                        <span class="rounded-circle p-1" style="background: #8b5cf6;"></span>
                        <span>{{ $contact->availability_status ?? 'Available for Select Projects & Leadership Roles' }}</span>
                    </div>

                    <h1 class="display-3 fw-bold mb-2">
                        {{ $profile->name ?? 'Md. Alif Ahmed' }}
                    </h1>

                    <h2 class="h4 text-violet-glow fw-semibold mb-3">
                        {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
                    </h2>

                    <p class="lead text-secondary mb-4" style="max-width: 680px;">
                        {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                        Specialized in custom Laravel backends, high-conversion e-commerce storefronts, multi-carrier courier API integrations, and resilient Meta Conversion API server-side tracking pipelines.
                    </p>

                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3">
                        <a href="#projects" class="btn btn-violet px-4 py-3 d-inline-flex align-items-center gap-2">
                            <i data-lucide="layers" style="width: 18px; height: 18px;"></i>
                            <span>Explore Case Studies</span>
                        </a>
                        <a href="#contact" class="btn btn-violet-outline px-4 py-3 d-inline-flex align-items-center gap-2">
                            <i data-lucide="mail" style="width: 18px; height: 18px;"></i>
                            <span>Initiate Collaboration</span>
                        </a>
                    </div>
                </div>

                <div class="col-lg-5 text-center">
                    <div class="p-4 rounded-4 animattor-card position-relative shadow-lg" style="background: rgba(13, 12, 29, 0.85); border-color: rgba(139, 92, 246, 0.4);">
                        @if ($profile?->avatar || $profile?->profileImage)
                            <div class="mb-4">
                                <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name }}" class="rounded-circle shadow-lg border border-2 border-violet p-1" style="width: 150px; height: 150px; object-fit: cover;">
                            </div>
                        @else
                            <div class="p-4 rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; background: radial-gradient(circle, rgba(139, 92, 246, 0.4), transparent); border: 2px solid #8b5cf6;">
                                <span class="display-6 fw-bold text-violet-glow">AA</span>
                            </div>
                        @endif

                        <div class="d-flex flex-column gap-2 text-start">
                            <div class="d-flex justify-content-between align-items-center p-2 px-3 rounded-3 border border-secondary-subtle">
                                <span class="small fw-semibold"><i data-lucide="shield-check" class="text-violet-glow me-1" style="width: 15px; height: 15px;"></i> Enterprise Architecture</span>
                                <span class="badge bg-violet text-white small">Verified</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-2 px-3 rounded-3 border border-secondary-subtle">
                                <span class="small fw-semibold"><i data-lucide="activity" class="text-violet-glow me-1" style="width: 15px; height: 15px;"></i> Server-Side CAPI Tracking</span>
                                <span class="badge bg-violet text-white small">99.8% Match</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center p-2 px-3 rounded-3 border border-secondary-subtle">
                                <span class="small fw-semibold"><i data-lucide="truck" class="text-violet-glow me-1" style="width: 15px; height: 15px;"></i> Multi-Courier Logistics Hub</span>
                                <span class="badge bg-violet text-white small">Automated</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Metrics -->
    <section id="highlights" class="mb-5 pb-3">
        <div class="row g-4">
            @foreach ($stats as $stat)
                <div class="col-6 col-lg-3">
                    <div class="animattor-card p-4 h-100 text-center">
                        <h3 class="display-6 fw-bold text-violet-glow mb-1">{{ $stat['value'] }}</h3>
                        <p class="small text-secondary mb-0 fw-medium">{{ $stat['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Projects -->
    <section id="projects" class="mb-5 py-4">
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
            <div>
                <span class="badge-violet mb-2 d-inline-block">Production Engineering</span>
                <h2 class="h2 fw-bold mb-1">Featured Projects &amp; Case Studies</h2>
                <p class="text-secondary mb-0">Production systems solving real commercial, logistics, and attribution problems.</p>
            </div>
            <a href="{{ url('/projects') }}" class="btn btn-violet-outline btn-sm">View All Projects →</a>
        </div>

        <div class="row g-4">
            @forelse ($featuredProjects as $project)
                <div class="col-md-6 col-lg-4">
                    <div class="animattor-card p-4 h-100 d-flex flex-column">
                        <div class="mb-3 overflow-hidden rounded-4" style="height: 190px; background: #0f172a;">
                            @if ($project->coverImage)
                                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 d-flex flex-column justify-content-between p-3" style="background: radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.3), #0b1120);">
                                    <span class="badge-violet align-self-start">{{ $project->category?->name ?? 'Enterprise Solution' }}</span>
                                    <div class="text-white fw-bold">{{ $project->title }}</div>
                                </div>
                            @endif
                        </div>

                        <span class="badge-violet align-self-start mb-2">{{ $project->category?->name ?? 'Enterprise Solution' }}</span>
                        <h3 class="h5 fw-bold mb-2">{{ $project->title }}</h3>
                        <p class="small text-secondary mb-3 flex-grow-1">{{ $project->summary }}</p>

                        <div class="d-flex flex-wrap gap-1 mb-3">
                            @foreach ($project->skills->take(3) as $s)
                                <span class="badge bg-secondary-subtle text-light small" style="font-size: 0.7rem;">{{ $s->name }}</span>
                            @endforeach
                        </div>

                        <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-violet mt-auto">Read Case Study →</a>
                    </div>
                </div>
            @empty
                <p class="text-secondary text-center py-4">No published projects available.</p>
            @endforelse
        </div>
    </section>

    <!-- Services -->
    <section id="services" class="mb-5 py-4">
        <h2 class="h2 fw-bold mb-4">Services &amp; Architecture</h2>
        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4">
                    <div class="animattor-card p-4 h-100">
                        <h3 class="h5 fw-bold text-violet-glow mb-2">{{ $srv->title }}</h3>
                        <p class="small text-secondary mb-0">{{ $srv->description }}</p>
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
                    <div class="animattor-card p-4 h-100">
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

    <!-- Experience -->
    <section id="experience" class="mb-5 py-4">
        <h2 class="h2 fw-bold mb-4">Professional Experience</h2>
        <div class="d-flex flex-column gap-3">
            @foreach ($experiences as $exp)
                <div class="animattor-card p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h3 class="h5 fw-bold mb-1">{{ $exp->designation }}</h3>
                            <div class="text-violet-glow small">{{ $exp->company }}</div>
                        </div>
                        <span class="badge-violet">
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
        <div class="animattor-card p-4 p-md-5">
            <h2 class="h2 fw-bold mb-3">About Alif Ahmed</h2>
            <p class="text-secondary lead mb-4">
                {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
            </p>
            <div class="small text-violet-glow">
                Structured Execution Process · High Concurrency Database Profiling
            </div>
        </div>
    </section>

    <!-- Education -->
    <section id="education" class="mb-5 py-4">
        <h2 class="h2 fw-bold mb-4">Education &amp; Credentials</h2>
        @foreach ($educations as $edu)
            <div class="animattor-card p-4 mb-3">
                <h3 class="h5 fw-bold mb-1">{{ $edu->degree }}</h3>
                <div class="text-violet-glow small mb-1">{{ $edu->institution }}</div>
                <div class="small text-secondary">{{ $edu->subject }}</div>
            </div>
        @endforeach
    </section>

    <!-- Contact -->
    <section id="contact" class="py-5 text-center">
        <div class="animattor-card p-5">
            <h2 class="display-5 fw-bold mb-3">Initiate Collaboration</h2>
            <p class="text-secondary lead mb-4 mx-auto" style="max-width: 600px;">
                Available for technical architecture, performance optimization, and sprint execution.
            </p>
            <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="btn btn-violet px-5 py-3">
                Get in Touch ({{ $contact->email ?? 'admin@alifahmed.com' }})
            </a>
        </div>
    </section>

</div>
@endsection
