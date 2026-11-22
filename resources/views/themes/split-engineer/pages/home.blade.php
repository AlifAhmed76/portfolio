@extends('themes.split-engineer.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@section('content')
<div class="container-xl px-4 px-md-5">
    <div class="row">
        <!-- Left Column: Sticky Profile, Nav & Socials (Brittany Chiang style) -->
        <div class="col-lg-5 col-xl-5 py-5 pe-lg-4">
            <div class="position-lg-sticky top-0 d-flex flex-column justify-content-between" style="min-height: calc(100vh - 6rem);">
                <div>
                    <!-- Status Beacon -->
                    <div class="d-inline-flex align-items-center gap-2 mb-4 px-3 py-1 rounded-pill" style="background: rgba(20, 184, 166, 0.1); border: 1px solid rgba(20, 184, 166, 0.25);">
                        <span class="beacon-pulse"></span>
                        <span class="small font-mono text-teal-light" style="font-size: 0.78rem;">
                            {{ $contact->availability_status ?? 'Available for Select Projects & Leadership Roles' }}
                        </span>
                    </div>

                    @if ($profile?->avatar || $profile?->profileImage)
                        <div class="mb-4">
                            <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" 
                                 alt="{{ $profile->name }}" 
                                 class="rounded-circle border border-2 shadow-lg" 
                                 style="width: 110px; height: 110px; object-fit: cover; border-color: rgba(20, 184, 166, 0.5) !important;">
                        </div>
                    @endif

                    <!-- Identity -->
                    <h1 class="display-5 fw-bold text-heading mb-2">
                        <a href="{{ url('/') }}" class="text-decoration-none text-reset">
                            {{ $profile->name ?? 'Md. Alif Ahmed' }}
                        </a>
                    </h1>

                    <h2 class="h5 fw-medium text-teal-light mb-3" style="color: var(--accent-teal-light);">
                        {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
                    </h2>

                    <p class="mb-4 text-secondary leading-relaxed" style="max-width: 420px; font-size: 0.95rem;">
                        {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                        Specialized in custom Laravel backends, multi-carrier courier API integrations, and resilient Meta Conversion API server-side tracking pipelines.
                    </p>

                    <!-- ScrollSpy Navigation Dock -->
                    <nav class="d-none d-lg-block my-5">
                        <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                            <li><a href="#about" class="split-nav-link active"><span class="split-nav-indicator"></span><span>About</span></a></li>
                            <li><a href="#experience" class="split-nav-link"><span class="split-nav-indicator"></span><span>Experience</span></a></li>
                            <li><a href="#projects" class="split-nav-link"><span class="split-nav-indicator"></span><span>Projects</span></a></li>
                            <li><a href="#services" class="split-nav-link"><span class="split-nav-indicator"></span><span>Services</span></a></li>
                            <li><a href="#expertise" class="split-nav-link"><span class="split-nav-indicator"></span><span>Skills</span></a></li>
                            <li><a href="#process" class="split-nav-link"><span class="split-nav-indicator"></span><span>Process</span></a></li>
                            <li><a href="#education" class="split-nav-link"><span class="split-nav-indicator"></span><span>Education</span></a></li>
                            <li><a href="#contact" class="split-nav-link"><span class="split-nav-indicator"></span><span>Contact</span></a></li>
                        </ul>
                    </nav>
                </div>

                <!-- Footer Socials & Admin Quick Access -->
                <div class="pt-4 mt-auto">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        @foreach ($socialLinks as $link)
                            <a href="{{ $link->url }}" target="_blank" class="text-secondary text-decoration-none" title="{{ $link->label }}">
                                <i data-lucide="{{ $link->platform === 'github' ? 'github' : ($link->platform === 'linkedin' ? 'linkedin' : 'globe') }}" style="width: 20px; height: 20px;"></i>
                            </a>
                        @endforeach
                        <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="text-secondary text-decoration-none" title="Direct Email">
                            <i data-lucide="mail" style="width: 20px; height: 20px;"></i>
                        </a>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ url('/admin/login') }}" class="btn btn-sm btn-outline-secondary py-1 px-3" style="font-size: 0.78rem; border-radius: 9999px;">
                            <i data-lucide="lock" style="width: 12px; height: 12px;" class="me-1"></i> Admin Console
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Narrative Stream (Scrolling Content) -->
        <div class="col-lg-7 col-xl-7 py-5 ps-lg-5">
            
            <!-- Section 1: About -->
            <section id="about" class="mb-5 pb-4">
                <h3 class="d-lg-none h6 fw-bold text-uppercase text-secondary mb-3 font-mono">01 // About</h3>
                <div class="pe-xl-4 leading-relaxed">
                    <p class="mb-4">
                        {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
                    </p>
                    <p class="mb-4 text-secondary">
                        My development methodology is anchored in architectural clarity, defensive database design, and sub-second execution speeds. Whether rescuing cart abandonment with streamlined checkouts or circumventing ad-blockers with resilient server-side telemetry, I build systems engineered to withstand scale and protect company revenue.
                    </p>
                </div>
            </section>

            <!-- Section 2: Experience -->
            <section id="experience" class="mb-5 pb-4">
                <h3 class="d-lg-none h6 fw-bold text-uppercase text-secondary mb-3 font-mono">02 // Experience</h3>
                <div class="d-flex flex-column gap-4">
                    @forelse ($experiences as $exp)
                        <div class="split-card p-3 p-md-4">
                            <div class="row g-2">
                                <div class="col-sm-3">
                                    <div class="small font-mono text-secondary pt-1">
                                        {{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} — {{ $exp->is_current ? 'PRESENT' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('Y') : 'PAST') }}
                                    </div>
                                </div>
                                <div class="col-sm-9">
                                    <h4 class="h6 fw-bold text-heading mb-1 d-flex align-items-center gap-1">
                                        <span>{{ $exp->designation }}</span>
                                        <span class="text-secondary fw-normal">·</span>
                                        <span class="text-teal-light" style="color: var(--accent-teal-light);">{{ $exp->company }}</span>
                                    </h4>
                                    <p class="small text-secondary mb-3 leading-relaxed">
                                        {{ $exp->description }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="small text-secondary">Experience timeline loading...</p>
                    @endforelse
                </div>
            </section>

            <!-- Section 3: Projects -->
            <section id="projects" class="mb-5 pb-4">
                <h3 class="d-lg-none h6 fw-bold text-uppercase text-secondary mb-3 font-mono">03 // Featured Projects</h3>
                <div class="d-flex flex-column gap-4">
                    @forelse ($featuredProjects as $project)
                        <div class="split-card p-3 p-md-4">
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <div class="project-img-preview overflow-hidden" style="height: 110px; background: #1e293b;">
                                        @if ($project->coverImage)
                                            <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                                        @else
                                            <div class="w-100 h-100 d-flex flex-column justify-content-between p-2" style="background: radial-gradient(circle at 80% 20%, rgba(20, 184, 166, 0.25), #0b1120);">
                                                <span class="small font-mono text-teal-light" style="font-size: 0.68rem;">{{ $project->category?->name ?? 'System' }}</span>
                                                <div class="small fw-bold text-white text-truncate">{{ $project->title }}</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <h4 class="h6 fw-bold text-heading mb-2">
                                        <a href="{{ url('/projects/' . $project->slug) }}" class="text-decoration-none text-reset d-inline-flex align-items-center gap-1">
                                            <span>{{ $project->title }}</span>
                                            <i data-lucide="arrow-up-right" style="width: 16px; height: 16px;" class="text-secondary"></i>
                                        </a>
                                    </h4>
                                    <p class="small text-secondary mb-3 leading-relaxed">
                                        {{ $project->summary }}
                                    </p>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ($project->skills->take(4) as $s)
                                            <span class="tech-pill">{{ $s->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="small text-secondary">Projects catalog loading...</p>
                    @endforelse
                </div>
                <div class="mt-4">
                    <a href="{{ url('/projects') }}" class="small fw-semibold text-teal-light text-decoration-none d-inline-flex align-items-center gap-1" style="color: var(--accent-teal-light);">
                        <span>View Full Project Archive</span>
                        <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i>
                    </a>
                </div>
            </section>

            <!-- Section 4: Services -->
            <section id="services" class="mb-5 pb-4">
                <h3 class="d-lg-none h6 fw-bold text-uppercase text-secondary mb-3 font-mono">04 // Services</h3>
                <div class="row g-3">
                    @foreach ($services as $srv)
                        <div class="col-md-6">
                            <div class="split-card p-3 h-100">
                                <h4 class="h6 fw-bold text-heading mb-2">{{ $srv->title }}</h4>
                                <p class="small text-secondary mb-0 leading-relaxed">{{ $srv->description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Section 5: Skills & Competency Matrix -->
            <section id="expertise" class="mb-5 pb-4">
                <h3 class="d-lg-none h6 fw-bold text-uppercase text-secondary mb-3 font-mono">05 // Skills</h3>
                <div class="d-flex flex-column gap-3">
                    @foreach ($skillCategories as $cat)
                        <div class="split-card p-3">
                            <h4 class="small font-mono text-uppercase text-teal-light mb-2" style="color: var(--accent-teal-light);">
                                {{ $cat->name }}
                            </h4>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach ($cat->skills as $sk)
                                    <span class="tech-pill">{{ $sk->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Section 6: Working Process -->
            <section id="process" class="mb-5 pb-4">
                <h3 class="d-lg-none h6 fw-bold text-uppercase text-secondary mb-3 font-mono">06 // Process</h3>
                <div class="split-card p-4">
                    <h4 class="h6 fw-bold text-heading mb-3">Structured Execution Process</h4>
                    <p class="small text-secondary mb-3 leading-relaxed">
                        Every deployment follows a clear engineering lifecycle: architectural assessment, database transaction profiling, automated webhook validation, and stress testing.
                    </p>
                </div>
            </section>

            <!-- Section 7: Education -->
            <section id="education" class="mb-5 pb-4">
                <h3 class="d-lg-none h6 fw-bold text-uppercase text-secondary mb-3 font-mono">07 // Education</h3>
                <div class="d-flex flex-column gap-3">
                    @foreach ($educations as $edu)
                        <div class="split-card p-3">
                            <h4 class="h6 fw-bold text-heading mb-1">{{ $edu->degree }}</h4>
                            <div class="small text-teal-light mb-1" style="color: var(--accent-teal-light);">{{ $edu->institution }}</div>
                            <div class="small text-secondary">{{ $edu->subject }}</div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Section 8: Contact -->
            <section id="contact" class="mb-5">
                <h3 class="d-lg-none h6 fw-bold text-uppercase text-secondary mb-3 font-mono">08 // Contact</h3>
                <div class="split-card p-4 text-center">
                    <h4 class="h5 fw-bold text-heading mb-2">Initiate Collaboration</h4>
                    <p class="small text-secondary mb-4 mx-auto" style="max-width: 480px;">
                        Currently open for select contract architecture, performance engineering, or technical project lead engagements.
                    </p>
                    <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="btn btn-teal px-4 py-2 text-white" style="background-color: var(--accent-teal); border-radius: 9999px;">
                        Say Hello ({{ $contact->email ?? 'admin@alifahmed.com' }})
                    </a>
                </div>
            </section>

            <footer class="pt-4 border-top border-secondary-subtle small text-secondary">
                <p class="mb-0">Designed in the spirit of <a href="https://brittanychiang.com" target="_blank" class="text-reset">Brittany Chiang</a> · Powered by Laravel 11 CMS.</p>
            </footer>

        </div>
    </div>
</div>
@endsection
