@extends('themes.craft-playful.layouts.app')

@section('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Web Developer & Technical Project Lead')
@section('meta_description', $profile->bio ?? 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')

@push('styles')
<style>
    /* Neobrutalist / Playful Craft styling (Josh W Comeau & Lynn and Tonic) */
    .neo-card {
        background: #181b2a;
        border: 3px solid #2d334d;
        box-shadow: 6px 6px 0px #ec4899;
        border-radius: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .neo-card:hover {
        transform: translate(-3px, -3px);
        box-shadow: 9px 9px 0px #ec4899;
    }
    .neo-card-alt {
        background: #181b2a;
        border: 3px solid #2d334d;
        box-shadow: 6px 6px 0px #3b82f6;
        border-radius: 16px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .neo-card-alt:hover {
        transform: translate(-3px, -3px);
        box-shadow: 9px 9px 0px #3b82f6;
    }
    .neo-badge {
        font-family: var(--font-mono);
        font-weight: 700;
        font-size: 0.8rem;
        background: #ec4899;
        color: #fff;
        padding: 4px 14px;
        border-radius: 8px;
        border: 2px solid #2d334d;
        box-shadow: 3px 3px 0px #000;
        display: inline-block;
        transform: rotate(-2deg);
    }
    .year-chapter-pill {
        font-family: var(--font-mono);
        font-size: 1.5rem;
        font-weight: 800;
        color: #f472b6;
        letter-spacing: -0.03em;
    }
</style>
@endpush

@section('content')
<div class="container py-5" style="max-width: 1080px;">

    <!-- Playful Hero (Sticker / Neobrutalist Box) -->
    <section id="hero" class="mb-5 pb-4">
        <div class="neo-card p-4 p-md-5 position-relative overflow-hidden">
            <div class="row align-items-center g-4">
                <div class="col-lg-8">
                    <div class="neo-badge mb-3">
                        ⚡ {{ $contact->availability_status ?? 'Available for Select Projects & Leadership Roles' }}
                    </div>

                    <h1 class="display-3 fw-bolder mb-2">
                        Hey there! I'm <span class="craft-gradient-text">{{ $profile->name ?? 'Md. Alif Ahmed' }}</span>
                    </h1>

                    <h2 class="h4 text-light fw-bold mb-3">
                        {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
                    </h2>

                    <p class="lead text-secondary mb-4 leading-relaxed" style="max-width: 650px;">
                        {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
                        Specialized in custom Laravel backends, multi-carrier courier API automations, and resilient Meta Conversion API server-side tracking pipelines.
                    </p>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="#projects" class="btn btn-craft px-4 py-3 fw-bold">Explore My Works 🛠️</a>
                        <a href="#contact" class="btn btn-craft-outline px-4 py-3 fw-bold">Initiate Collaboration 👋</a>
                    </div>
                </div>

                @if ($profile?->avatar || $profile?->profileImage)
                    <div class="col-lg-4 text-center">
                        <div class="p-2 d-inline-block rounded-circle" style="border: 3px solid #ec4899; box-shadow: 5px 5px 0px #3b82f6;">
                            <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name }}" class="rounded-circle" style="width: 170px; height: 170px; object-fit: cover;">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Metrics Sticker Strip -->
    <section id="highlights" class="mb-5 pb-2">
        <div class="row g-3">
            @foreach ($stats as $idx => $stat)
                <div class="col-6 col-md-3">
                    <div class="neo-card-alt p-3 text-center h-100">
                        <div class="display-6 fw-bolder craft-gradient-text mb-0">{{ $stat['value'] }}</div>
                        <div class="small text-secondary fw-semibold mt-1">{{ $stat['label'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Lynn Fisher / Yearly Chapter Exhibition for Projects -->
    <section id="projects" class="mb-5 py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <span class="neo-badge mb-2 d-inline-block">Exhibition Archive</span>
                <h2 class="display-5 fw-bolder text-white mb-0">Featured Projects &amp; Case Studies</h2>
            </div>
            <a href="{{ url('/projects') }}" class="btn btn-sm btn-craft-outline fw-bold">Browse All Projects →</a>
        </div>

        <div class="d-flex flex-column gap-4">
            @forelse ($featuredProjects as $idx => $project)
                <div class="{{ $idx % 2 === 0 ? 'neo-card' : 'neo-card-alt' }} p-4 p-md-5">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-5">
                            <div class="year-chapter-pill mb-1">PROJECT // 0{{ $idx + 1 }}</div>
                            <span class="badge bg-dark border border-secondary text-pink mb-2">{{ $project->category?->name ?? 'Production' }}</span>
                            <h3 class="h3 fw-bold text-white mb-2">{{ $project->title }}</h3>
                            <p class="text-secondary small mb-3 leading-relaxed">{{ $project->summary }}</p>

                            <div class="d-flex flex-wrap gap-1 mb-4">
                                @foreach ($project->skills as $skill)
                                    <span class="craft-chip">{{ $skill->name }}</span>
                                @endforeach
                            </div>

                            <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-craft px-4 py-2">
                                Inspect Architecture Case Study ↗
                            </a>
                        </div>
                        <div class="col-lg-7">
                            <div class="rounded-3 overflow-hidden border border-2 border-secondary" style="height: 240px; background: #0f111a;">
                                @if ($project->coverImage)
                                    <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                                @else
                                    <div class="w-100 h-100 d-flex flex-column justify-content-between p-4" style="background: radial-gradient(circle at 80% 20%, rgba(236, 72, 153, 0.3), #0f111a);">
                                        <span class="craft-chip align-self-start">{{ $project->category?->name ?? 'Production' }}</span>
                                        <div class="h4 fw-bold text-white">{{ $project->title }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-secondary text-center py-4">Projects loading...</p>
            @endforelse
        </div>
    </section>

    <!-- Services Cards (Playful Sticky note blocks) -->
    <section id="services" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Services &amp; Engineering Solutions</h2>
        <div class="row g-4">
            @foreach ($services as $srv)
                <div class="col-md-6 col-lg-4">
                    <div class="neo-card p-4 h-100">
                        <h3 class="h5 fw-bold text-pink mb-2">{{ $srv->title }}</h3>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $srv->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Experience Timeline -->
    <section id="experience" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Professional Experience</h2>
        <div class="d-flex flex-column gap-3">
            @foreach ($experiences as $exp)
                <div class="neo-card-alt p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h3 class="h5 fw-bold text-white mb-1">{{ $exp->designation }}</h3>
                            <div class="craft-gradient-text small fw-bold">{{ $exp->company }}</div>
                        </div>
                        <span class="neo-badge">
                            {{ \Carbon\Carbon::parse($exp->start_date)->format('Y') }} — {{ $exp->is_current ? 'Present' : ($exp->end_date ? \Carbon\Carbon::parse($exp->end_date)->format('Y') : '') }}
                        </span>
                    </div>
                    <p class="small text-secondary mb-0 leading-relaxed">{{ $exp->description }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Competencies -->
    <section id="expertise" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Technical Expertise &amp; Core Stack</h2>
        <div class="row g-4">
            @foreach ($skillCategories as $cat)
                <div class="col-md-6 col-lg-3">
                    <div class="neo-card p-4 h-100">
                        <h3 class="h6 fw-bold text-pink mb-3">{{ $cat->name }}</h3>
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

    <!-- About Section -->
    <section id="about" class="mb-5 py-4">
        <div class="neo-card p-4 p-md-5">
            <h2 class="display-6 fw-bold text-white mb-3">About Alif Ahmed</h2>
            <p class="lead text-secondary mb-4 leading-relaxed">
                {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, Meta Conversion API server-side tracking, courier API integrations, and website performance and security optimization.' }}
            </p>
            <div class="small text-light font-mono">
                Structured Execution Process · High Concurrency Database Profiling
            </div>
        </div>
    </section>

    <!-- Education -->
    <section id="education" class="mb-5 py-4">
        <h2 class="display-6 fw-bold text-white mb-4">Education &amp; Credentials</h2>
        @foreach ($educations as $edu)
            <div class="neo-card-alt p-4 mb-3">
                <h3 class="h5 fw-bold text-white mb-1">{{ $edu->degree }}</h3>
                <div class="text-pink small mb-1">{{ $edu->institution }}</div>
                <div class="small text-secondary">{{ $edu->subject }}</div>
            </div>
        @endforeach
    </section>

    <!-- Contact CTA -->
    <section id="contact" class="py-5 text-center">
        <div class="neo-card p-5">
            <h2 class="display-4 fw-bolder text-white mb-3">Initiate Collaboration</h2>
            <p class="lead text-secondary mb-4 mx-auto" style="max-width: 600px;">
                Ready to architect your high-converting web platform or courier API automation pipeline.
            </p>
            <a href="mailto:{{ $contact->email ?? 'admin@alifahmed.com' }}" class="btn btn-craft px-5 py-3 fw-bold" style="font-size: 1.1rem;">
                Say Hello ({{ $contact->email ?? 'admin@alifahmed.com' }}) 👋
            </a>
        </div>
    </section>

</div>
@endsection
