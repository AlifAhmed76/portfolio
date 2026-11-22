@extends('themes.interactive-spotlight.layouts.app')

@section('title', 'Selected Works & Case Studies | Md. Alif Ahmed')

@section('content')
<div class="container py-5">
    <div class="mb-5">
        <a href="{{ url('/') }}" class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1 font-mono mb-3">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            <span>Back to Home</span>
        </a>
        <h1 class="display-4 fw-bold text-white mb-2">Interactive Showcases</h1>
        <p class="text-secondary lead">Full architectural breakdowns of enterprise solutions, courier hubs, and attribution engines.</p>
    </div>

    <div class="row g-4">
        @forelse ($projects ?? [] as $project)
            <div class="col-lg-6">
                <div class="spot-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="mb-3 overflow-hidden rounded-3 border" style="height: 220px; background: rgba(0,0,0,0.4); border-color: var(--spot-border) !important;">
                            @if ($project->coverImage)
                                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 d-flex flex-column justify-content-between p-4" style="background: radial-gradient(circle at 80% 20%, rgba(6, 182, 212, 0.25), #030712);">
                                    <span class="small font-mono text-cyan">SYSTEM BUILD</span>
                                    <div class="h5 fw-bold text-white">{{ $project->title }}</div>
                                </div>
                            @endif
                        </div>

                        <span class="badge mb-2" style="background: rgba(6, 182, 212, 0.2); color: var(--spot-cyan-glow);">
                            {{ $project->category?->name ?? 'Architecture' }}
                        </span>
                        <h2 class="h4 fw-bold text-white mb-2">{{ $project->title }}</h2>
                        <p class="small text-secondary mb-3 leading-relaxed">{{ $project->summary }}</p>
                    </div>

                    <div>
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            @foreach ($project->skills as $s)
                                <span class="badge bg-secondary-subtle text-light small">{{ $s->name }}</span>
                            @endforeach
                        </div>
                        <a href="{{ url('/projects/' . $project->slug) }}" class="btn-spot btn-sm w-100 justify-content-center">
                            Inspect Case Study →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-secondary">
                <p>Showcases loading...</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
