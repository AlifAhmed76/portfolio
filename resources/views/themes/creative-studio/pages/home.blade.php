@extends('themes.creative-studio.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Creative Engineering Studio')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@section('content')
<div class="container py-5">

    <!-- Section 1: Hero -->
    <section id="hero" class="studio-card p-5 mb-5 position-relative overflow-hidden">
        <div class="row align-items-center g-4">
            <div class="{{ ($profile?->avatar || $profile?->profileImage) ? 'col-lg-8' : 'col-12' }}">
                <span class="badge bg-warning-subtle text-warning border border-warning-subtle mb-3 px-3 py-2">
                    {{ $contact->availability_status ?? 'Available for Select Projects' }}
                </span>
                <h1 class="display-3 fw-bolder mb-3">{{ $profile->name ?? 'Md. Alif Ahmed' }}</h1>
                <h2 class="h3 text-warning mb-4">{{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}</h2>
                <p class="lead text-secondary mb-4" style="max-width: 760px;">
                    {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                    Bespoke Laravel architectures, automated courier logistics pipelines, and resilient Meta Conversion API server-side tracking.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#projects" class="btn btn-warning fw-bold px-4 py-2">Explore Projects</a>
                    <a href="#contact" class="btn btn-outline-warning fw-bold px-4 py-2">Get in Touch</a>
                </div>
            </div>
            @if ($profile?->avatar || $profile?->profileImage)
                <div class="col-lg-4 text-center">
                    <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name }}" class="rounded-circle shadow-lg border border-warning p-1" style="width: 170px; height: 170px; object-fit: cover;">
                </div>
            @endif
        </div>
    </section>

    <!-- Section 2: Metrics -->
    <section id="highlights" class="mb-5">
        <div class="row g-4">
            @foreach ($stats as $stat)
                <div class="col-6 col-lg-3">
                    <div class="studio-card p-4 text-center">
                        <h3 class="display-6 fw-bold text-warning mb-1">{{ $stat['value'] }}</h3>
                        <p class="small text-secondary mb-0">{{ $stat['label'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 3: About -->
    <section id="about" class="studio-card p-5 mb-5">
        <span class="badge bg-warning-subtle text-warning mb-2">About Alif Ahmed</span>
        <h2 class="h2 fw-bold mb-4">Engineering With Architectural Discipline</h2>
        <p class="lead text-secondary mb-4">{{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}</p>
        <p class="text-secondary mb-0">From complex inventory reconciliation to sub-second checkout pipelines, my focus is delivering resilient web applications that convert users and safeguard commercial revenue.</p>
    </section>

    <!-- Section 4: Skills -->
    <section id="expertise" class="mb-5">
        <h2 class="h3 fw-bold mb-4">Technical Expertise</h2>
        <div class="row g-4">
            @foreach ($skillCategories as $cat)
                <div class="col-md-6 col-lg-3">
                    <div class="studio-card p-4 h-100">
                        <h3 class="h5 fw-bold text-warning mb-3">{{ $cat->name }}</h3>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                            @foreach ($cat->skills as $s)
                                <li class="small fw-semibold text-body">⚡ {{ $s->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 5: Projects -->
    <section id="projects" class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 fw-bold mb-0">Featured Projects &amp; Case Studies</h2>
            <a href="{{ url('/projects') }}" class="text-warning text-decoration-none">All Projects →</a>
        </div>
        <div class="row g-4">
            @foreach ($featuredProjects as $project)
                <div class="col-md-6 col-lg-4">
                    <div class="studio-card p-4 h-100 d-flex flex-column">
                        @if ($project->coverImage)
                            <div class="mb-3 overflow-hidden rounded" style="height: 160px;">
                                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                            </div>
                        @endif
                        <span class="badge bg-warning-subtle text-warning small align-self-start mb-2">{{ $project->category?->name ?? 'Production' }}</span>
                        <h3 class="h5 fw-bold mb-2">{{ $project->title }}</h3>
                        <p class="small text-secondary mb-4 flex-grow-1">{{ $project->summary }}</p>
                        <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-outline-warning mt-auto align-self-start">Read Case Study</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 6: Services -->
    <section id="services" class="mb-5">
        <h2 class="h3 fw-bold mb-4">Services &amp; Capabilities</h2>
        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4">
                    <div class="studio-card p-4 h-100">
                        <h3 class="h5 fw-bold mb-2">{{ $srv->title }}</h3>
                        <p class="small text-secondary mb-0">{{ $srv->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 7: Experience -->
    <section id="experience" class="studio-card p-5 mb-5">
        <h2 class="h3 fw-bold mb-4">Professional Timeline</h2>
        <div class="d-flex flex-column gap-4">
            @foreach ($experiences as $exp)
                <div class="border-start border-warning ps-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="h5 fw-bold mb-0">{{ $exp->designation }}</h3>
                        <span class="small text-warning">{{ \Carbon\Carbon::parse($exp->start_date)->format('M Y') }} — {{ $exp->is_current ? 'Present' : \Carbon\Carbon::parse($exp->end_date)->format('M Y') }}</span>
                    </div>
                    <p class="text-secondary small mb-2">{{ $exp->company }}</p>
                    <p class="small text-secondary mb-0">{{ $exp->description }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 8: Education -->
    <section id="education" class="mb-5">
        <h2 class="h3 fw-bold mb-4">Credentials</h2>
        @foreach ($educations as $edu)
            <div class="studio-card p-4">
                <h3 class="h5 fw-bold mb-1">{{ $edu->degree }}</h3>
                <p class="small text-warning mb-0">{{ $edu->institution }} • {{ $edu->subject }}</p>
            </div>
        @endforeach
    </section>

    <!-- Section 9: Process -->
    <section id="process" class="studio-card p-5 mb-5">
        <h2 class="h3 fw-bold mb-4">Methodology</h2>
        <div class="row g-4">
            <div class="col-md-4"><strong>01. Architecture</strong><p class="small text-secondary">Discovery and schema planning.</p></div>
            <div class="col-md-4"><strong>02. Clean Code</strong><p class="small text-secondary">Service layer and database indexing.</p></div>
            <div class="col-md-4"><strong>03. Automation</strong><p class="small text-secondary">Logistics, payment, and Meta CAPI pipelines.</p></div>
            <div class="col-md-6"><strong>04. Hardening</strong><p class="small text-secondary">Security audits and unit testing.</p></div>
            <div class="col-md-6"><strong>05. Deployment</strong><p class="small text-secondary">Docker CI/CD and production scaling.</p></div>
        </div>
    </section>

    <!-- Section 10: Blog -->
    @if ($recentPosts->isNotEmpty())
        <section id="blog" class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 fw-bold mb-0">Insights &amp; Articles</h2>
                <a href="{{ url('/blog') }}" class="text-warning text-decoration-none">All Articles →</a>
            </div>
            <div class="row g-4">
                @foreach ($recentPosts as $post)
                    <div class="col-md-6">
                        <div class="studio-card p-4 h-100">
                            <span class="badge bg-warning-subtle text-warning small mb-2">{{ $post->category?->name ?? 'Article' }}</span>
                            <h3 class="h5 fw-bold mb-2"><a href="{{ url('/blog/' . $post->slug) }}" class="text-body text-decoration-none">{{ $post->title }}</a></h3>
                            <p class="small text-secondary mb-3">{{ $post->summary }}</p>
                            <a href="{{ url('/blog/' . $post->slug) }}" class="small text-warning fw-semibold">Read Article →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Section 11: Contact -->
    <section id="contact" class="studio-card p-5 mb-5">
        <h2 class="h3 fw-bold mb-4">Start a Conversation</h2>
        @if (session('contact_success'))
            <div class="alert alert-success mb-4">{{ session('contact_success') }}</div>
        @endif
        <form action="{{ route('contact.submit') }}" method="POST">
            @csrf
            <input type="text" name="hp_website" style="display:none !important;" tabindex="-1" autocomplete="off">
            <div class="row g-3 mb-3">
                <div class="col-md-6"><input type="text" name="name" class="form-control" placeholder="Your Name" required></div>
                <div class="col-md-6"><input type="email" name="email" class="form-control" placeholder="Your Email" required></div>
            </div>
            <div class="mb-3"><input type="text" name="subject" class="form-control" placeholder="Subject"></div>
            <div class="mb-3"><textarea name="message" rows="4" class="form-control" placeholder="Message" required></textarea></div>
            <button type="submit" class="btn btn-warning fw-bold px-4 py-2">Submit Inquiry</button>
        </form>
    </section>

</div>
@endsection
