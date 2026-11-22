@extends('themes.futuristic-tech.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' // Systems Architecture & Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@section('content')
<div class="container py-5">

    <!-- Section 1: Hero -->
    <section id="hero" class="tech-panel p-5 mb-5 font-mono">
        <div class="row align-items-center g-4">
            <div class="{{ ($profile?->avatar || $profile?->profileImage) ? 'col-lg-8' : 'col-12' }}">
                <div class="d-flex justify-content-between align-items-center text-cyan small mb-3">
                    <span>[SYS_STATUS: {{ strtoupper($contact->availability_status ?? 'AVAILABLE') }}]</span>
                    <span>NODE::ALIF-PORTFOLIO-V1</span>
                </div>
                <h1 class="display-4 fw-bold mb-3">{{ $profile->name ?? 'Md. Alif Ahmed' }}</h1>
                <h2 class="h4 text-cyan mb-3">{{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}</h2>
                <p class="lead text-secondary mb-4" style="max-width: 760px;">
                    {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                    High-throughput Laravel backends, multi-carrier courier API integrations, and resilient Meta Conversion API server-side telemetry.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="#projects" class="btn btn-cyan font-mono px-4 py-2">&gt; INSPECT_PROJECTS()</a>
                    <a href="#contact" class="btn btn-outline-secondary font-mono px-4 py-2">&gt; TRANSMIT_MESSAGE()</a>
                </div>
            </div>
            @if ($profile?->avatar || $profile?->profileImage)
                <div class="col-lg-4 text-center">
                    <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name }}" class="rounded border border-info p-1 shadow-lg" style="width: 170px; height: 170px; object-fit: cover;">
                </div>
            @endif
        </div>
    </section>

    <!-- Section 2: Metrics -->
    <section id="highlights" class="mb-5 font-mono">
        <div class="row g-4">
            @foreach ($stats as $stat)
                <div class="col-6 col-lg-3">
                    <div class="tech-panel p-4 text-center">
                        <div class="display-6 fw-bold text-cyan mb-1">{{ $stat['value'] }}</div>
                        <div class="small text-secondary">{{ strtoupper($stat['label']) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 3: About -->
    <section id="about" class="tech-panel p-5 mb-5 font-mono">
        <div class="text-cyan small mb-2">// IDENTITY_BUFFER</div>
        <h2 class="h3 fw-bold mb-4">SYSTEM_PHILOSOPHY</h2>
        <p class="text-secondary leading-relaxed mb-4">{{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}</p>
        <p class="text-secondary mb-0">Priority directive: Ensure transaction integrity, protect attribution telemetry from client drops, and maintain sub-100ms response cycles under peak concurrency.</p>
    </section>

    <!-- Section 4: Skills -->
    <section id="expertise" class="mb-5 font-mono">
        <h2 class="h4 text-cyan mb-4">// SKILL_VECTORS</h2>
        <div class="row g-4">
            @foreach ($skillCategories as $cat)
                <div class="col-md-6 col-lg-3">
                    <div class="tech-panel p-4 h-100">
                        <div class="text-cyan small fw-bold mb-3">&gt; {{ strtoupper($cat->name) }}</div>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2">
                            @foreach ($cat->skills as $s)
                                <li class="small text-secondary">[OK] {{ $s->name }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 5: Projects -->
    <section id="projects" class="mb-5 font-mono">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h4 text-cyan mb-0">// DEPLOYED_CASE_STUDIES</h2>
            <a href="{{ url('/projects') }}" class="small text-cyan text-decoration-none">&gt; VIEW_ALL</a>
        </div>
        <div class="row g-4">
            @foreach ($featuredProjects as $project)
                <div class="col-md-6 col-lg-4">
                    <div class="tech-panel p-4 h-100 d-flex flex-column">
                        @if ($project->coverImage)
                            <div class="mb-3 overflow-hidden rounded border border-secondary" style="height: 160px;">
                                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                            </div>
                        @endif
                        <span class="badge bg-secondary-subtle text-secondary small align-self-start mb-2">{{ $project->category?->name ?? 'SYSTEM' }}</span>
                        <h3 class="h5 fw-bold mb-2">{{ $project->title }}</h3>
                        <p class="small text-secondary mb-4 flex-grow-1">{{ $project->summary }}</p>
                        <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-outline-info mt-auto align-self-start">&gt; CASE_TELEMETRY</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 6: Services -->
    <section id="services" class="mb-5 font-mono">
        <h2 class="h4 text-cyan mb-4">// CORE_CAPABILITIES</h2>
        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4">
                    <div class="tech-panel p-4 h-100">
                        <h3 class="h6 fw-bold text-cyan mb-2">&gt; {{ $srv->title }}</h3>
                        <p class="small text-secondary mb-0">{{ $srv->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 7: Experience -->
    <section id="experience" class="tech-panel p-5 mb-5 font-mono">
        <h2 class="h4 text-cyan mb-4">// CAREER_CHRONOLOGY</h2>
        <div class="d-flex flex-column gap-4">
            @foreach ($experiences as $exp)
                <div class="border-start border-info ps-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <h3 class="h6 fw-bold mb-0">{{ $exp->designation }}</h3>
                        <span class="small text-cyan">[{{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} - {{ $exp->is_current ? 'PRESENT' : \Carbon\Carbon::parse($exp->end_date)->format('Y') }}]</span>
                    </div>
                    <div class="small text-secondary mb-2">&gt; {{ $exp->company }}</div>
                    <p class="small text-secondary mb-0">{{ $exp->description }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Section 8: Education -->
    <section id="education" class="mb-5 font-mono">
        <h2 class="h4 text-cyan mb-4">// ACADEMIC_CREDENTIALS</h2>
        @foreach ($educations as $edu)
            <div class="tech-panel p-4">
                <h3 class="h6 fw-bold mb-1">&gt; {{ $edu->degree }}</h3>
                <p class="small text-secondary mb-0">{{ $edu->institution }} // {{ $edu->subject }}</p>
            </div>
        @endforeach
    </section>

    <!-- Section 9: Process -->
    <section id="process" class="tech-panel p-5 mb-5 font-mono">
        <h2 class="h4 text-cyan mb-4">// EXECUTION_PIPELINE</h2>
        <div class="row g-4">
            <div class="col-md-4"><strong>[01] ARCHITECTURE</strong><p class="small text-secondary">Discovery and schema planning.</p></div>
            <div class="col-md-4"><strong>[02] ENGINEERING</strong><p class="small text-secondary">Clean service layers and DB optimization.</p></div>
            <div class="col-md-4"><strong>[03] AUTOMATION</strong><p class="small text-secondary">Couriers, payment, and Meta CAPI pipelines.</p></div>
            <div class="col-md-6"><strong>[04] HARDENING</strong><p class="small text-secondary">Security audits and automated testing.</p></div>
            <div class="col-md-6"><strong>[05] DEPLOYMENT</strong><p class="small text-secondary">Docker CI/CD and production telemetry.</p></div>
        </div>
    </section>

    <!-- Section 10: Blog -->
    @if ($recentPosts->isNotEmpty())
        <section id="blog" class="mb-5 font-mono">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 text-cyan mb-0">// TELEMETRY_NOTES</h2>
                <a href="{{ url('/blog') }}" class="small text-cyan text-decoration-none">&gt; VIEW_ALL</a>
            </div>
            <div class="row g-4">
                @foreach ($recentPosts as $post)
                    <div class="col-md-6">
                        <div class="tech-panel p-4 h-100">
                            <span class="badge bg-info-subtle text-cyan small mb-2">{{ $post->category?->name ?? 'NOTE' }}</span>
                            <h3 class="h6 fw-bold mb-2"><a href="{{ url('/blog/' . $post->slug) }}" class="text-light text-decoration-none">{{ $post->title }}</a></h3>
                            <p class="small text-secondary mb-3">{{ $post->summary }}</p>
                            <a href="{{ url('/blog/' . $post->slug) }}" class="small text-cyan fw-semibold">&gt; READ_ENTRY</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    <!-- Section 11: Contact -->
    <section id="contact" class="tech-panel p-5 mb-5 font-mono">
        <h2 class="h4 text-cyan mb-4">// INITIALIZE_TRANSMISSION</h2>
        @if (session('contact_success'))
            <div class="alert alert-success font-mono mb-4">{{ session('contact_success') }}</div>
        @endif
        <form action="{{ route('contact.submit') }}" method="POST">
            @csrf
            <input type="text" name="hp_website" style="display:none !important;" tabindex="-1" autocomplete="off">
            <div class="row g-3 mb-3">
                <div class="col-md-6"><input type="text" name="name" class="form-control font-mono bg-dark text-light border-secondary" placeholder="NAME" required></div>
                <div class="col-md-6"><input type="email" name="email" class="form-control font-mono bg-dark text-light border-secondary" placeholder="EMAIL" required></div>
            </div>
            <div class="mb-3"><input type="text" name="subject" class="form-control font-mono bg-dark text-light border-secondary" placeholder="SUBJECT"></div>
            <div class="mb-3"><textarea name="message" rows="4" class="form-control font-mono bg-dark text-light border-secondary" placeholder="MESSAGE_PAYLOAD" required></textarea></div>
            <button type="submit" class="btn btn-cyan font-mono px-4 py-2">&gt; TRANSMIT()</button>
        </form>
    </section>

</div>
@endsection
