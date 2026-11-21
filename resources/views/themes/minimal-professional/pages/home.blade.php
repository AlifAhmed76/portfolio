@extends('themes.minimal-professional.layouts.app')

@section('title', 'Md. Alif Ahmed — Web Developer & Technical Project Lead')

@section('content')
<div class="container py-4">
    <!-- Hero -->
    <section class="py-5 border-bottom mb-5">
        <span class="badge bg-light text-dark border mb-3 px-3 py-2">
            ● {{ $contact->availability_status ?? 'Available for Select Projects' }}
        </span>
        <h1 class="display-3 fw-normal mb-2 tracking-tight">{{ $profile->name ?? 'Md. Alif Ahmed' }}</h1>
        <p class="h5 text-muted mb-4">{{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}</p>
        <p class="lead mb-4 text-secondary" style="max-width: 720px;">{{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}</p>
        <div class="d-flex gap-3">
            <a href="#projects" class="btn btn-minimal px-4 py-2">Selected Work &darr;</a>
            <a href="#contact" class="btn btn-outline-dark px-4 py-2">Contact &rarr;</a>
        </div>
    </section>

    <!-- Highlights -->
    <section class="py-4 border-bottom mb-5">
        <div class="row g-4">
            <div class="col-sm-6 col-lg-3">
                <div class="p-3 border">
                    <small class="text-uppercase text-muted d-block mb-1">Architecture</small>
                    <div class="fw-bold">Custom Laravel Engineering</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-3 border">
                    <small class="text-uppercase text-muted d-block mb-1">Commerce</small>
                    <div class="fw-bold">E-Commerce & Courier Logistics</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-3 border">
                    <small class="text-uppercase text-muted d-block mb-1">Attribution</small>
                    <div class="fw-bold">Meta Conversion API Pipelines</div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="p-3 border">
                    <small class="text-uppercase text-muted d-block mb-1">Reliability</small>
                    <div class="fw-bold">Speed & Security Hardening</div>
                </div>
            </div>
        </div>
    </section>

    <!-- About -->
    <section class="py-4 border-bottom mb-5" id="about">
        <div class="row g-4">
            <div class="col-lg-4">
                <h3 class="h5 text-uppercase tracking-wider text-muted">About</h3>
                <h4 class="h2 fw-normal">Engineering Philosophy</h4>
            </div>
            <div class="col-lg-8">
                <p class="lead text-secondary mb-3">{{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}</p>
                <p class="text-secondary">Focused on transactional integrity, clear system documentation, and high-performance server architectures.</p>
            </div>
        </div>
    </section>

    <!-- Expertise -->
    <section class="py-4 border-bottom mb-5" id="expertise">
        <h3 class="h5 text-uppercase tracking-wider text-muted mb-4">Competencies</h3>
        <div class="row g-4">
            @foreach ($skillCategories as $cat)
                <div class="col-md-6 col-lg-3">
                    <div class="p-3 border h-100">
                        <h5 class="fw-bold border-bottom pb-2 mb-3">{{ $cat->name }}</h5>
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-2 small">
                            @foreach ($cat->skills as $skill)
                                <li>
                                    <span class="fw-semibold">{{ $skill->name }}</span>
                                    @if ($skill->description)
                                        <div class="text-muted" style="font-size: 11px;">{{ $skill->description }}</div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Projects -->
    <section class="py-4 border-bottom mb-5" id="projects">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="h4 fw-normal mb-0">Case Studies</h3>
            <a href="{{ route('projects.index') }}" class="small fw-semibold text-dark text-decoration-underline">All Projects →</a>
        </div>
        <div class="row g-4">
            @forelse ($featuredProjects as $project)
                <div class="col-md-6">
                    <div class="border p-4 h-100 d-flex flex-column">
                        <span class="small text-muted text-uppercase mb-1">{{ $project->category?->name ?? 'Case' }}</span>
                        <h4 class="h4 fw-bold mb-2">{{ $project->title }}</h4>
                        <p class="small text-secondary mb-3 flex-grow-1">{{ $project->summary }}</p>
                        <a href="{{ route('projects.show', $project->slug) }}" class="small fw-semibold text-dark text-decoration-underline mt-auto">Examine Case Study &rarr;</a>
                    </div>
                </div>
            @empty
                <p class="text-muted">No projects available.</p>
            @endforelse
        </div>
    </section>

    <!-- Services -->
    <section class="py-4 border-bottom mb-5" id="services">
        <h3 class="h5 text-uppercase tracking-wider text-muted mb-4">Services</h3>
        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-4">
                    <div class="p-4 border h-100">
                        <h5 class="fw-bold mb-2">{{ $srv->title }}</h5>
                        <p class="small text-secondary mb-3">{{ $srv->description }}</p>
                        @if ($srv->deliverables)
                            <small class="text-muted d-block border-top pt-2">Deliverables: {{ $srv->deliverables }}</small>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Experience & Education -->
    <section class="py-4 border-bottom mb-5" id="experience">
        <div class="row g-5">
            <div class="col-lg-6">
                <h4 class="h5 fw-bold mb-4">Experience</h4>
                <div class="border-start ps-3">
                    @forelse ($experiences as $exp)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-1">{{ $exp->designation }}</h6>
                            <small class="text-muted d-block mb-1">{{ $exp->company }} &bull; {{ $exp->start_date ? $exp->start_date->format('Y') : '' }} - {{ $exp->is_current ? 'Present' : ($exp->end_date ? $exp->end_date->format('Y') : '') }}</small>
                            <p class="small text-secondary mb-0">{{ $exp->description }}</p>
                        </div>
                    @empty
                        <p class="small text-muted">Pending: owner to confirm.</p>
                    @endforelse
                </div>
            </div>
            <div class="col-lg-6">
                <h4 class="h5 fw-bold mb-4">Education</h4>
                <div class="border-start ps-3">
                    @forelse ($educations as $edu)
                        <div class="mb-4">
                            <h6 class="fw-bold mb-1">{{ $edu->degree }}</h6>
                            <small class="text-muted d-block mb-1">{{ $edu->institution }}</small>
                            <p class="small text-secondary mb-0">{{ $edu->description }}</p>
                        </div>
                    @empty
                        <p class="small text-muted">Pending: owner to confirm.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Working Process -->
    <section class="py-4 border-bottom mb-5" id="process">
        <h3 class="h5 text-uppercase tracking-wider text-muted mb-4">Process</h3>
        <div class="row g-3">
            <div class="col-sm-6 col-lg-3"><div class="p-3 border"><strong>01</strong> Discovery & Scope</div></div>
            <div class="col-sm-6 col-lg-3"><div class="p-3 border"><strong>02</strong> Architecture & APIs</div></div>
            <div class="col-sm-6 col-lg-3"><div class="p-3 border"><strong>03</strong> Full-Stack Build</div></div>
            <div class="col-sm-6 col-lg-3"><div class="p-3 border"><strong>04</strong> QA & Hardening</div></div>
        </div>
    </section>

    <!-- Contact -->
    <section class="py-4" id="contact">
        <div class="row g-5">
            <div class="col-lg-5">
                <h3 class="h4 fw-normal mb-3">Initiate Contact</h3>
                <p class="text-secondary small mb-4">Available for technical project lead and full-stack development.</p>
                @if ($contact && $contact->email)
                    <div class="mb-2"><strong class="small">Email:</strong> <a href="mailto:{{ $contact->email }}" class="text-dark">{{ $contact->email }}</a></div>
                @endif
                @if ($contact && $contact->location)
                    <div class="mb-3"><strong class="small">Location:</strong> <span class="text-muted">{{ $contact->location }}</span></div>
                @endif
            </div>
            <div class="col-lg-7">
                <form action="{{ route('home') }}#contact" method="POST">
                    @csrf
                    <input type="text" name="hp_website" style="display:none !important;" tabindex="-1" autocomplete="off">
                    <div class="row g-2 mb-2">
                        <div class="col-6"><input type="text" name="name" class="form-control" placeholder="Name" required></div>
                        <div class="col-6"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
                    </div>
                    <div class="mb-2"><input type="text" name="subject" class="form-control" placeholder="Subject"></div>
                    <div class="mb-3"><textarea name="message" rows="4" class="form-control" placeholder="Message" required></textarea></div>
                    <button type="submit" class="btn btn-minimal">Transmit Message</button>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
