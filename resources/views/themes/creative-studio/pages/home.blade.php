@extends('themes.creative-studio.layouts.app')

@section('title', 'Md. Alif Ahmed — Web Developer & Technical Project Lead')

@section('content')
<div class="container py-4">
    <!-- Hero -->
    <div class="studio-card p-5 mb-5 text-center">
        <span class="badge bg-warning text-dark mb-3 px-3 py-2 fw-bold">● {{ $contact->availability_status ?? 'Available' }}</span>
        <h1 class="display-3 fw-bold mb-3 tracking-tight">{{ $profile->name ?? 'Md. Alif Ahmed' }}</h1>
        <h3 class="h4 text-warning fw-semibold mb-3">{{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}</h3>
        <p class="lead text-secondary mx-auto mb-4" style="max-width: 720px;">{{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="#projects" class="btn btn-studio px-4 py-2">Explore Cases</a>
            <a href="#contact" class="btn btn-outline-light px-4 py-2">Get in Touch</a>
        </div>
    </div>

    <!-- Highlights -->
    <div class="row g-3 mb-5">
        <div class="col-sm-6 col-lg-3"><div class="studio-card p-4 text-center"><h5 class="fw-bold mb-1">Custom Laravel</h5><small class="text-secondary">Enterprise Engineering</small></div></div>
        <div class="col-sm-6 col-lg-3"><div class="studio-card p-4 text-center"><h5 class="fw-bold mb-1">Logistics APIs</h5><small class="text-secondary">Courier Automations</small></div></div>
        <div class="col-sm-6 col-lg-3"><div class="studio-card p-4 text-center"><h5 class="fw-bold mb-1">Meta CAPI</h5><small class="text-secondary">Server-Side Tracking</small></div></div>
        <div class="col-sm-6 col-lg-3"><div class="studio-card p-4 text-center"><h5 class="fw-bold mb-1">Security Audit</h5><small class="text-secondary">Hardening & Speed</small></div></div>
    </div>

    <!-- About -->
    <div class="studio-card p-5 mb-5" id="about">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <span class="text-warning text-uppercase small fw-bold">01 Narrative</span>
                <h2 class="display-6 fw-bold mb-3">Architecting Enterprise Digital Systems</h2>
                <p class="text-secondary leading-relaxed">{{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}</p>
            </div>
            <div class="col-lg-5">
                <div class="p-4 border border-secondary rounded-4 bg-dark">
                    <h5 class="fw-bold text-light mb-3">Core Pillars</h5>
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small text-secondary">
                        <li>✦ Scalable Database Schemas & Indexing</li>
                        <li>✦ Automated Logistics Webhooks</li>
                        <li>✦ First-Party Attribution Pipelines</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects -->
    <div class="mb-5" id="projects">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 fw-bold mb-0">Production Work</h2>
            <a href="{{ route('projects.index') }}" class="text-warning text-decoration-none">View All Cases →</a>
        </div>
        <div class="row g-4">
            @forelse ($featuredProjects as $project)
                <div class="col-md-6">
                    <div class="studio-card p-4 h-100 d-flex flex-column">
                        <span class="badge bg-secondary-subtle text-secondary align-self-start mb-2">{{ $project->category?->name ?? 'Case' }}</span>
                        <h4 class="h4 fw-bold mb-2">{{ $project->title }}</h4>
                        <p class="small text-secondary mb-3 flex-grow-1">{{ $project->summary }}</p>
                        <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-sm btn-studio align-self-start mt-auto">Read Breakdown &rarr;</a>
                    </div>
                </div>
            @empty
                <p class="text-secondary">No featured projects available.</p>
            @endforelse
        </div>
    </div>

    <!-- Services -->
    <div class="studio-card p-5 mb-5" id="services">
        <h2 class="h3 fw-bold mb-4 text-center">Engineering Services</h2>
        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-4">
                    <div class="p-4 rounded-4 border border-secondary bg-dark h-100">
                        <h5 class="fw-bold text-light mb-2">{{ $srv->title }}</h5>
                        <p class="small text-secondary mb-3">{{ $srv->description }}</p>
                        @if ($srv->deliverables)
                            <small class="text-warning d-block">{{ $srv->deliverables }}</small>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Contact -->
    <div class="studio-card p-5" id="contact">
        <div class="row g-4">
            <div class="col-lg-5">
                <h2 class="display-6 fw-bold mb-3">Let's Connect</h2>
                <p class="text-secondary">{{ $contact->location ?? 'Available Worldwide' }}</p>
                <p class="text-light fw-bold">{{ $contact->email ?? '' }}</p>
            </div>
            <div class="col-lg-7">
                <form action="{{ route('home') }}#contact" method="POST">
                    @csrf
                    <input type="text" name="hp_website" style="display:none !important;" tabindex="-1" autocomplete="off">
                    <div class="row g-2 mb-2">
                        <div class="col-6"><input type="text" name="name" class="form-control" placeholder="Your Name" required></div>
                        <div class="col-6"><input type="email" name="email" class="form-control" placeholder="Your Email" required></div>
                    </div>
                    <div class="mb-2"><input type="text" name="subject" class="form-control" placeholder="Subject"></div>
                    <div class="mb-3"><textarea name="message" rows="4" class="form-control" placeholder="Project details" required></textarea></div>
                    <button type="submit" class="btn btn-studio w-100">Transmit Message</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
