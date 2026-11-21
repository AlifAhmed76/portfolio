@extends('themes.futuristic-tech.layouts.app')

@section('title', 'Md. Alif Ahmed — Web Developer & Technical Project Lead')

@section('content')
<div class="container py-4">
    <!-- Telemetry Hero -->
    <div class="tech-panel p-5 mb-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge bg-dark border border-cyan text-cyan">SYS_STATUS: {{ $contact->availability_status ?? 'ONLINE' }}</span>
            <code class="text-secondary small">NODE::ALIF-PORTFOLIO-V1</code>
        </div>
        <h1 class="display-4 fw-bold mb-2 text-light">{{ $profile->name ?? 'Md. Alif Ahmed' }}</h1>
        <h3 class="h5 text-cyan mb-3 font-monospace">> {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}</h3>
        <p class="lead text-secondary mb-4" style="max-width: 720px;">{{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}</p>
        <div class="d-flex gap-3">
            <a href="#projects" class="btn btn-tech">[ EXAMINE_CASES ]</a>
            <a href="#contact" class="btn btn-outline-cyan">[ CONNECT ]</a>
        </div>
    </div>

    <!-- Telemetry Highlights -->
    <div class="row g-3 mb-5">
        <div class="col-sm-6 col-lg-3"><div class="tech-panel p-3 text-center"><code class="text-cyan d-block mb-1">LARAVEL_CORE</code><div class="fw-bold">Enterprise Backend</div></div></div>
        <div class="col-sm-6 col-lg-3"><div class="tech-panel p-3 text-center"><code class="text-cyan d-block mb-1">LOGISTICS_API</code><div class="fw-bold">Courier Automations</div></div></div>
        <div class="col-sm-6 col-lg-3"><div class="tech-panel p-3 text-center"><code class="text-cyan d-block mb-1">SERVER_CAPI</code><div class="fw-bold">Meta Attribution</div></div></div>
        <div class="col-sm-6 col-lg-3"><div class="tech-panel p-3 text-center"><code class="text-cyan d-block mb-1">SEC_HARDENING</code><div class="fw-bold">Core Web Vitals</div></div></div>
    </div>

    <!-- About -->
    <div class="tech-panel p-4 mb-5" id="about">
        <code class="text-cyan d-block mb-2">// 01_BIOGRAPHY_STREAM</code>
        <h2 class="h3 fw-bold mb-3 text-light">Technical Background & Methodology</h2>
        <p class="text-secondary leading-relaxed mb-0">{{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}</p>
    </div>

    <!-- Projects -->
    <div class="mb-5" id="projects">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="h4 fw-bold text-light mb-0"><span class="text-cyan">></span> REPOSITORY_SHOWCASE</h3>
            <a href="{{ route('projects.index') }}" class="text-cyan small text-decoration-none">INDEX_ALL_REPOS →</a>
        </div>
        <div class="row g-4">
            @forelse ($featuredProjects as $project)
                <div class="col-md-6">
                    <div class="tech-panel p-4 h-100 d-flex flex-column">
                        <div class="small text-cyan font-monospace mb-2">#{{ $project->slug }}</div>
                        <h4 class="h5 fw-bold text-light mb-2">{{ $project->title }}</h4>
                        <p class="small text-secondary mb-3 flex-grow-1">{{ $project->summary }}</p>
                        <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-sm btn-tech align-self-start mt-auto">READ_DEPLOYMENT_LOG &rarr;</a>
                    </div>
                </div>
            @empty
                <p class="text-secondary">No repository logs registered.</p>
            @endforelse
        </div>
    </div>

    <!-- Contact -->
    <div class="tech-panel p-4" id="contact">
        <code class="text-cyan d-block mb-2">// 02_COMMUNICATION_LINK</code>
        <h3 class="h4 fw-bold text-light mb-4">Transmit Secure Message</h3>
        <form action="{{ route('home') }}#contact" method="POST">
            @csrf
            <input type="text" name="hp_website" style="display:none !important;" tabindex="-1" autocomplete="off">
            <div class="row g-2 mb-2">
                <div class="col-6"><input type="text" name="name" class="form-control bg-dark text-light border-secondary" placeholder="NAME" required></div>
                <div class="col-6"><input type="email" name="email" class="form-control bg-dark text-light border-secondary" placeholder="EMAIL" required></div>
            </div>
            <div class="mb-2"><input type="text" name="subject" class="form-control bg-dark text-light border-secondary" placeholder="SUBJECT"></div>
            <div class="mb-3"><textarea name="message" rows="4" class="form-control bg-dark text-light border-secondary" placeholder="MESSAGE_PAYLOAD" required></textarea></div>
            <button type="submit" class="btn btn-tech w-100">[ EXECUTE_TRANSMISSION ]</button>
        </form>
    </div>
</div>
@endsection
