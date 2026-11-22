@extends('themes.minimal-professional.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@section('content')
<div class="container py-5" style="max-width: 1040px;">

    <!-- Section 1: Hero -->
    <section id="hero" class="py-5 border-bottom mb-5">
        <span class="badge bg-light text-dark border mb-3 px-3 py-2 text-uppercase fw-normal" style="letter-spacing: 0.05em; font-size: 0.75rem;">
            {{ $contact->availability_status ?? 'Available for Select Projects' }}
        </span>
        <h1 class="display-3 fw-normal mb-2" style="letter-spacing: -0.03em;">{{ $profile->name ?? 'Md. Alif Ahmed' }}</h1>
        <p class="h4 text-muted fw-normal mb-4">{{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}</p>
        <p class="lead mb-4 text-secondary" style="max-width: 720px; line-height: 1.7;">
            {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
            Specializing in high-throughput Laravel architectures, automated courier logistics pipelines, and resilient Meta Conversion API server-side tracking.
        </p>
        <div class="d-flex gap-3">
            <a href="#projects" class="btn btn-dark px-4 py-2">Selected Work</a>
            <a href="#contact" class="btn btn-outline-dark px-4 py-2">Contact</a>
        </div>
    </section>

    <!-- Section 2: Key Metrics -->
    <section id="highlights" class="py-4 border-bottom mb-5">
        <div class="row g-4">
            @foreach ($stats as $stat)
                <div class="col-6 col-md-3">
                    <h3 class="display-6 fw-bold mb-0">{{ $stat['value'] }}</h3>
                    <p class="small text-muted mb-0">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 3: About -->
    <section id="about" class="py-4 border-bottom mb-5">
        <h2 class="h5 text-uppercase text-muted fw-normal mb-4" style="letter-spacing: 0.08em;">About &amp; Approach</h2>
        <div class="row g-5">
            <div class="col-lg-8">
                <p class="lead mb-4">{{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}</p>
                <p class="text-secondary">With a strong focus on architectural clarity, defensive schema design, and sub-second execution speeds, I design systems that solve complex commercial friction, safeguard revenue, and scale seamlessly.</p>
            </div>
            <div class="col-lg-4 border-start">
                <h3 class="h6 fw-bold text-uppercase mb-3">Snapshot</h3>
                <p class="small text-muted mb-1">Location</p>
                <p class="small fw-semibold mb-3">{{ $contact->location ?? 'Dhaka, Bangladesh' }}</p>
                <p class="small text-muted mb-1">Languages</p>
                <p class="small fw-semibold mb-3">English (Fluent), Bengali (Native)</p>
                <p class="small text-muted mb-1">Direct Email</p>
                <p class="small fw-semibold mb-0"><a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="text-dark">{{ $contact->email ?? 'admin@alifahmed.com' }}</a></p>
            </div>
        </div>
    </section>

    <!-- Section 4: Skills Matrix -->
    <section id="expertise" class="py-4 border-bottom mb-5">
        <h2 class="h5 text-uppercase text-muted fw-normal mb-4" style="letter-spacing: 0.08em;">Competencies</h2>
        <div class="row g-4">
            @foreach ($skillCategories as $cat)
                <div class="col-md-6">
                    <div class="p-4 border rounded-1 h-100">
                        <h3 class="h6 fw-bold text-uppercase mb-3">{{ $cat->name }}</h3>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach ($cat->skills as $s)
                                <span class="badge bg-light text-dark border p-2">{{ $s->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 5: Projects -->
    <section id="projects" class="py-4 border-bottom mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h5 text-uppercase text-muted fw-normal mb-0" style="letter-spacing: 0.08em;">Selected Engineering Cases</h2>
            <a href="{{ url('/projects') }}" class="small text-dark text-decoration-underline">All Projects →</a>
        </div>
        <div class="row g-4">
            @foreach ($featuredProjects as $project)
                <div class="col-md-6">
                    <div class="p-4 border rounded-1 h-100 d-flex flex-column">
                        <span class="small text-muted text-uppercase">{{ $project->category?->name ?? 'System' }}</span>
                        <h3 class="h5 fw-bold mt-1 mb-2">{{ $project->title }}</h3>
                        <p class="small text-secondary mb-4 flex-grow-1">{{ $project->summary }}</p>
                        <div class="d-flex gap-3 mt-auto">
                            <a href="{{ url('/projects/' . $project->slug) }}" class="small fw-semibold text-dark text-decoration-underline">Read Case Study →</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 6: Services -->
    <section id="services" class="py-4 border-bottom mb-5">
        <h2 class="h5 text-uppercase text-muted fw-normal mb-4" style="letter-spacing: 0.08em;">Engineering Capabilities</h2>
        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4">
                    <div class="p-4 border rounded-1 h-100">
                        <h3 class="h6 fw-bold mb-2">{{ $srv->title }}</h3>
                        <p class="small text-secondary mb-0">{{ $srv->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 7: Experience -->
    <section id="experience" class="py-4 border-bottom mb-5">
        <h2 class="h5 text-uppercase text-muted fw-normal mb-4" style="letter-spacing: 0.08em;">Career History</h2>
        <div class="d-flex flex-column gap-4">
            @foreach ($experiences as $exp)
                <div class="border-start ps-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h3 class="h6 fw-bold mb-0">{{ $exp->designation }}</h3>
                        <span class="small text-muted">{{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} — {{ $exp->is_current ? 'Present' : \Carbon\Carbon::parse($exp->end_date)->format('Y') }}</span>
                    </div>
                    <p class="small text-muted mb-2">{{ $exp->company }}</p>
                    <p class="small text-secondary mb-0">{{ $exp->description }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 8: Education -->
    <section id="education" class="py-4 border-bottom mb-5">
        <h2 class="h5 text-uppercase text-muted fw-normal mb-4" style="letter-spacing: 0.08em;">Credentials</h2>
        @foreach ($educations as $edu)
            <div class="p-3 border rounded-1">
                <h3 class="h6 fw-bold mb-1">{{ $edu->degree }}</h3>
                <p class="small text-muted mb-0">{{ $edu->institution }} • {{ $edu->subject }}</p>
            </div>
        @endforeach
    </section>

    <!-- Section 9: Process -->
    <section id="process" class="py-4 border-bottom mb-5">
        <h2 class="h5 text-uppercase text-muted fw-normal mb-4" style="letter-spacing: 0.08em;">Methodology</h2>
        <div class="row g-3">
            <div class="col-md-4"><div class="p-3 border"><strong>01. Architecture</strong><p class="small text-muted mb-0 mt-1">Schema, contract, and concurrency planning.</p></div></div>
            <div class="col-md-4"><div class="p-3 border"><strong>02. Clean Engineering</strong><p class="small text-muted mb-0 mt-1">Custom Laravel service layers and DB optimization.</p></div></div>
            <div class="col-md-4"><div class="p-3 border"><strong>03. Automation &amp; APIs</strong><p class="small text-muted mb-0 mt-1">Couriers, payment, and Meta CAPI pipelines.</p></div></div>
            <div class="col-md-6"><div class="p-3 border"><strong>04. Hardening</strong><p class="small text-muted mb-0 mt-1">Automated test suites and CSRF/rate limiting.</p></div></div>
            <div class="col-md-6"><div class="p-3 border"><strong>05. Deployment</strong><p class="small text-muted mb-0 mt-1">Containerized Docker CI/CD and telemetry monitoring.</p></div></div>
        </div>
    </section>

    <!-- Section 10: Blog -->
    @if ($recentPosts->isNotEmpty())
        <section id="blog" class="py-4 border-bottom mb-5">
            <h2 class="h5 text-uppercase text-muted fw-normal mb-4" style="letter-spacing: 0.08em;">Selected Writings</h2>
            <div class="row g-4">
                @foreach ($recentPosts as $post)
                    <div class="col-md-6">
                        <div class="p-4 border rounded-1 h-100">
                            <span class="small text-muted text-uppercase">{{ $post->category?->name ?? 'Article' }}</span>
                            <h3 class="h6 fw-bold mt-1 mb-2"><a href="{{ url('/blog/' . $post->slug) }}" class="text-dark">{{ $post->title }}</a></h3>
                            <p class="small text-secondary mb-3">{{ $post->summary }}</p>
                            <a href="{{ url('/blog/' . $post->slug) }}" class="small text-dark fw-semibold">Read →</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Section 11: Contact -->
    <section id="contact" class="py-4 mb-5">
        <h2 class="h5 text-uppercase text-muted fw-normal mb-4" style="letter-spacing: 0.08em;">Contact</h2>
        <div class="row g-5">
            <div class="col-lg-5">
                <p class="lead mb-4">Open for technical leadership roles and high-complexity contract engagements.</p>
                <p class="small text-muted mb-1">Email</p>
                <p class="fw-semibold mb-3"><a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="text-dark">{{ $contact->email ?? 'admin@alifahmed.com' }}</a></p>
                <p class="small text-muted mb-1">Location</p>
                <p class="fw-semibold mb-0">{{ $contact->location ?? 'Dhaka, Bangladesh' }}</p>
            </div>
            <div class="col-lg-7">
                @if (session('contact_success'))
                    <div class="alert alert-success">{{ session('contact_success') }}</div>
                @endif
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <input type="text" name="hp_website" style="display:none !important;" tabindex="-1" autocomplete="off">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control rounded-0" placeholder="Your Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control rounded-0" placeholder="Your Email" required>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="subject" class="form-control rounded-0" placeholder="Subject">
                    </div>
                    <div class="mb-3">
                        <textarea name="message" rows="4" class="form-control rounded-0" placeholder="Message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-dark rounded-0 px-4 py-2">Send Message</button>
                </form>
            </div>
        </div>
    </section>

</div>
@endsection
