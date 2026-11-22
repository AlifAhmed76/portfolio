@extends('themes.fintech-saas.layouts.app')

@section('title', 'Deployments & Architecture Portfolio | Md. Alif Ahmed')

@section('content')
<div class="container py-5">
    <div class="mb-5">
        <a href="{{ url('/') }}" class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1 font-mono mb-3">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            <span>back to terminal</span>
        </a>
        <h1 class="display-4 fw-bold text-white mb-2">Engineered Deployments</h1>
        <p class="text-secondary lead">Full architectural breakdowns of enterprise solutions, courier hubs, and attribution engines.</p>
    </div>

    <div class="row g-4">
        @forelse ($projects ?? [] as $project)
            <div class="col-lg-6">
                <div class="saas-card p-4 p-md-5 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="mb-3 overflow-hidden rounded-3 border" style="height: 200px; background: rgba(0,0,0,0.3); border-color: var(--saas-border) !important;">
                            @if ($project->coverImage)
                                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 d-flex flex-column justify-content-between p-4" style="background: radial-gradient(circle at 80% 20%, rgba(99, 102, 241, 0.25), rgba(7, 9, 19, 0.9));">
                                    <span class="small font-mono text-white-50">PRODUCTION DEPLOYMENT</span>
                                    <div class="h5 fw-bold text-white">{{ $project->title }}</div>
                                </div>
                            @endif
                        </div>

                        <span class="badge mb-2" style="background: rgba(99, 102, 241, 0.2); color: var(--saas-accent-glow);">
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
                        <a href="{{ url('/projects/' . $project->slug) }}" class="btn-saas btn-sm w-100 justify-content-center">
                            Inspect Telemetry →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-secondary">
                <p>Deployments loading...</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
