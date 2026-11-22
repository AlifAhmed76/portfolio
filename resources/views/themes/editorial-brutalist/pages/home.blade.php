@extends('themes.editorial-brutalist.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@section('content')
<!-- Hero Section: Oversized Editorial Statement -->
<section id="hero" class="brutalist-border-bottom py-5">
    <div class="container px-4 py-lg-5">
        <div class="mb-4">
            <span class="badge-editorial">
                [ STATUS: {{ strtoupper($contact->availability_status ?? 'Available for Select Projects & Leadership Roles') }} ]
            </span>
        </div>

        <div class="row align-items-center g-4 mb-4">
            <div class="{{ ($profile?->avatar || $profile?->profileImage) ? 'col-lg-8' : 'col-12' }}">
                <h1 class="display-2 font-display fw-bold mb-3 text-uppercase" style="line-height: 1.05;">
                    {{ $profile->name ?? 'Md. Alif Ahmed' }}
                </h1>

                <h2 class="h4 font-display text-uppercase mb-4" style="color: var(--accent-crimson); letter-spacing: 0.05em;">
                    {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
                </h2>

                <p class="lead text-secondary mb-4" style="max-width: 820px; font-size: 1.25rem;">
                    {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                    Architecting custom Laravel backends, mission-critical logistics API automations, and resilient server-side telemetry.
                </p>

                <div class="d-flex flex-wrap gap-3">
                    <a href="#projects" class="btn-brutalist">Explore Cases ↓</a>
                    <a href="#contact" class="btn-brutalist-outline">Discuss Sprints →</a>
                </div>
            </div>

            @if ($profile?->avatar || $profile?->profileImage)
                <div class="col-lg-4 text-center">
                    <div class="p-2 brutalist-border d-inline-block">
                        <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" 
                             alt="{{ $profile->name }}" 
                             class="img-fluid" 
                             style="max-width: 280px; filter: grayscale(100%) contrast(110%); object-fit: cover;">
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<!-- Highlights Metrics Bar -->
<section id="highlights" class="brutalist-border-bottom">
    <div class="container-fluid px-0">
        <div class="row g-0">
            @foreach ($stats as $idx => $stat)
                <div class="col-6 col-md-3 brutalist-border-bottom {{ $idx < 3 ? 'border-end' : '' }} p-4 text-center" style="border-color: var(--border-stark) !important;">
                    <div class="font-display display-5 fw-bold mb-1" style="color: var(--accent-crimson);">{{ $stat['value'] }}</div>
                    <div class="small text-secondary text-uppercase font-mono">{{ $stat['label'] }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Projects Section: Numbered Case Studies (Anton & Irene / Van Schneider style) -->
<section id="projects" class="py-5 brutalist-border-bottom">
    <div class="container px-4 py-4">
        <div class="d-flex justify-content-between align-items-end mb-5 pb-3 brutalist-border-bottom">
            <div>
                <span class="badge-editorial mb-2 d-inline-block">Selected Works</span>
                <h2 class="display-5 font-display text-uppercase fw-bold mb-0">Featured Projects &amp; Case Studies</h2>
            </div>
            <a href="{{ url('/projects') }}" class="editorial-nav-link text-decoration-underline">Archive →</a>
        </div>

        <div class="d-flex flex-column gap-5">
            @forelse ($featuredProjects as $index => $project)
                <article class="editorial-card p-4 p-lg-5 brutalist-border position-relative" style="background: var(--surface-noir);">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-5">
                            <div class="case-number mb-2">0{{ $index + 1 }}</div>
                            <span class="badge-editorial mb-2 d-inline-block">
                                {{ $project->category?->name ?? 'Enterprise Solution' }}
                            </span>
                            <h3 class="h2 font-display fw-bold text-uppercase mb-3">
                                <a href="{{ url('/projects/' . $project->slug) }}" class="text-decoration-none text-reset">
                                    {{ $project->title }}
                                </a>
                            </h3>
                            <p class="text-secondary mb-4 leading-relaxed">
                                {{ $project->summary }}
                            </p>
                            <div class="d-flex flex-wrap gap-2 mb-4">
                                @foreach ($project->skills as $skill)
                                    <span class="badge-editorial">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                            <a href="{{ url('/projects/' . $project->slug) }}" class="btn-brutalist py-2 px-3" style="font-size: 0.78rem;">
                                Read Architecture Case Study →
                            </a>
                        </div>
                        <div class="col-lg-7">
                            <div class="brutalist-border overflow-hidden" style="height: 320px; background: #000;">
                                @if ($project->coverImage)
                                    <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover" style="filter: grayscale(30%);">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column justify-content-between p-4" style="background: linear-gradient(135deg, #18181b 0%, #09090b 100%);">
                                        <span class="badge-editorial align-self-start">{{ $project->category?->name ?? 'Production' }}</span>
                                        <div class="font-display h3 fw-bold text-uppercase text-white">{{ $project->title }}</div>
                                        <div class="small text-secondary font-mono">[ ARCHITECTURAL CASE STUDY READY ]</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <p class="text-secondary text-center py-5">No published projects available.</p>
            @endforelse
        </div>
    </div>
</section>

<!-- About Section -->
<section id="about" class="py-5 brutalist-border-bottom">
    <div class="container px-4 py-4">
        <div class="row g-5">
            <div class="col-lg-4">
                <span class="badge-editorial mb-2 d-inline-block">Profile Monograph</span>
                <h2 class="display-6 font-display text-uppercase fw-bold">Engineering Philosophy</h2>
            </div>
            <div class="col-lg-8">
                <p class="lead mb-4 text-stark" style="font-size: 1.25rem;">
                    {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
                </p>
                <div class="row g-4 pt-4 brutalist-border-top">
                    <div class="col-sm-6">
                        <div class="font-display fw-bold text-uppercase h6 mb-1">Custom Laravel Engineering</div>
                        <p class="small text-secondary mb-0">Clean service architectures and test-driven development.</p>
                    </div>
                    <div class="col-sm-6">
                        <div class="font-display fw-bold text-uppercase h6 mb-1">Logistics &amp; Courier APIs</div>
                        <p class="small text-secondary mb-0">Pathao, RedX, and Steadfast automated consignment dispatch.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section id="services" class="py-5 brutalist-border-bottom">
    <div class="container px-4 py-4">
        <span class="badge-editorial mb-2 d-inline-block">Capabilities</span>
        <h2 class="display-6 font-display text-uppercase fw-bold mb-4">Core Services &amp; Solutions</h2>

        <div class="row g-0 brutalist-border">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4 p-4 brutalist-border">
                    <div class="font-display h5 fw-bold text-uppercase mb-2">{{ $srv->title }}</div>
                    <p class="small text-secondary mb-0 leading-relaxed">{{ $srv->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Experience Section -->
<section id="experience" class="py-5 brutalist-border-bottom">
    <div class="container px-4 py-4">
        <span class="badge-editorial mb-2 d-inline-block">Track Record</span>
        <h2 class="display-6 font-display text-uppercase fw-bold mb-4">Professional Experience</h2>

        <div class="d-flex flex-column brutalist-border">
            @foreach ($experiences as $exp)
                <div class="p-4 brutalist-border d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                    <div>
                        <div class="font-display h5 fw-bold text-uppercase mb-1">{{ $exp->designation }}</div>
                        <div class="small font-mono text-secondary mb-2">{{ $exp->company }}</div>
                        <p class="small text-secondary mb-0" style="max-width: 680px;">{{ $exp->description }}</p>
                    </div>
                    <div class="small font-mono text-secondary text-nowrap">
                        {{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} — {{ $exp->is_current ? 'PRESENT' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('Y') : 'PAST') }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Skills & Competency Matrix -->
<section id="expertise" class="py-5 brutalist-border-bottom">
    <div class="container px-4 py-4">
        <span class="badge-editorial mb-2 d-inline-block">Stack</span>
        <h2 class="display-6 font-display text-uppercase fw-bold mb-4">Competency Matrix</h2>

        <div class="row g-4">
            @foreach ($skillCategories as $category)
                <div class="col-md-6 col-lg-3">
                    <div class="p-4 brutalist-border h-100">
                        <div class="font-display h6 fw-bold text-uppercase mb-3 pb-2 brutalist-border-bottom">
                            {{ $category->name }}
                        </div>
                        <div class="d-flex flex-column gap-2">
                            @foreach ($category->skills as $sk)
                                <div class="small text-secondary">
                                    <strong class="text-stark">{{ $sk->name }}</strong>
                                    @if ($sk->description)
                                        <div style="font-size: 0.75rem;">{{ $sk->description }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Process Section -->
<section id="process" class="py-5 brutalist-border-bottom">
    <div class="container px-4 py-4">
        <span class="badge-editorial mb-2 d-inline-block">Methodology</span>
        <h2 class="display-6 font-display text-uppercase fw-bold mb-3">Structured Execution Process</h2>
        <p class="text-secondary lead" style="max-width: 720px;">
            Defensive engineering at every stage: requirement decomposition, schema normalization, async worker isolation, and verified server-side telemetry.
        </p>
    </div>
</section>

<!-- Education Section -->
<section id="education" class="py-5 brutalist-border-bottom">
    <div class="container px-4 py-4">
        <span class="badge-editorial mb-2 d-inline-block">Academic Credentials</span>
        <h2 class="display-6 font-display text-uppercase fw-bold mb-4">Education &amp; Credentials</h2>

        @foreach ($educations as $edu)
            <div class="p-4 brutalist-border mb-3">
                <div class="font-display h5 fw-bold text-uppercase mb-1">{{ $edu->degree }}</div>
                <div class="small font-mono text-secondary mb-1">{{ $edu->institution }}</div>
                <div class="small text-secondary">{{ $edu->subject }}</div>
            </div>
        @endforeach
    </div>
</section>

<!-- Contact Section -->
<section id="contact" class="py-5">
    <div class="container px-4 py-5 text-center">
        <span class="badge-editorial mb-3 d-inline-block">Inquiries</span>
        <h2 class="display-3 font-display text-uppercase fw-bold mb-3">Initiate Collaboration</h2>
        <p class="lead text-secondary mb-4 mx-auto" style="max-width: 600px;">
            Direct discussions for technical project leadership, high-concurrency Laravel systems, and e-commerce tracking architecture.
        </p>
        <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="btn-brutalist px-5 py-3" style="font-size: 1rem;">
            Send Direct Message ({{ $contact->email ?? 'admin@alifahmed.com' }})
        </a>
    </div>
</section>
@endsection
