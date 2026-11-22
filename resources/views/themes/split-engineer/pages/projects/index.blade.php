@extends('themes.split-engineer.layouts.app')

@section('title', 'Projects & Architectural Case Studies | Md. Alif Ahmed')

@section('content')
<div class="container py-5" style="max-width: 960px;">
    <div class="mb-5">
        <a href="{{ url('/') }}" class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1 mb-3">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            <span>Back to Home</span>
        </a>
        <h1 class="display-5 fw-bold text-heading mb-2">Selected Projects & Case Studies</h1>
        <p class="text-secondary lead">Full architectural breakdowns of enterprise solutions, courier hubs, and attribution engines.</p>
    </div>

    <div class="d-flex flex-column gap-4">
        @forelse ($projects ?? [] as $project)
            <div class="split-card p-4">
                <div class="row g-4 align-items-center">
                    <div class="col-md-4">
                        <div class="project-img-preview overflow-hidden" style="height: 140px; background: #1e293b;">
                            @if ($project->coverImage)
                                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 d-flex flex-column justify-content-between p-3" style="background: radial-gradient(circle at 80% 20%, rgba(20, 184, 166, 0.25), #0b1120);">
                                    <span class="small font-mono text-teal-light" style="font-size: 0.68rem;">{{ $project->category?->name ?? 'System' }}</span>
                                    <div class="small fw-bold text-white text-truncate">{{ $project->title }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="small font-mono text-teal-light mb-1" style="color: var(--accent-teal-light);">
                            {{ $project->category?->name ?? 'Engineering' }}
                        </div>
                        <h2 class="h5 fw-bold text-heading mb-2">
                            <a href="{{ url('/projects/' . $project->slug) }}" class="text-decoration-none text-reset d-inline-flex align-items-center gap-1">
                                <span>{{ $project->title }}</span>
                                <i data-lucide="arrow-up-right" style="width: 16px; height: 16px;" class="text-secondary"></i>
                            </a>
                        </h2>
                        <p class="small text-secondary mb-3 leading-relaxed">{{ $project->summary }}</p>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach ($project->skills as $s)
                                <span class="tech-pill">{{ $s->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 text-secondary">
                <p>No published projects found.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
