@extends('themes.boutique-studio.layouts.app')

@section('title', 'Commercial Portfolio & Case Studies | Md. Alif Ahmed')

@section('content')
<div class="container py-5">
    <div class="mb-5">
        <a href="{{ url('/') }}" class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1 mb-3">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            <span>Back to Studio</span>
        </a>
        <h1 class="display-4 font-display fw-bold text-white mb-2">Selected Commercial Deliveries</h1>
        <p class="text-secondary lead">Bespoke Laravel architectures, automated courier logistics pipelines, and resilient server-side telemetry.</p>
    </div>

    <div class="row g-4">
        @forelse ($projects ?? [] as $project)
            <div class="col-md-6">
                <div class="studio-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        <div class="mb-3 overflow-hidden rounded-3 border" style="height: 220px; background: #16171b; border-color: rgba(255,255,255,0.08) !important;">
                            @if ($project->coverImage)
                                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 d-flex flex-column justify-content-between p-4" style="background: radial-gradient(circle at 80% 20%, rgba(163, 230, 53, 0.2), #121316);">
                                    <span class="small font-display text-white-50">{{ $project->category?->name ?? 'Solution' }}</span>
                                    <div class="h5 font-display fw-bold text-white">{{ $project->title }}</div>
                                </div>
                            @endif
                        </div>

                        <span class="badge mb-2" style="background: rgba(163, 230, 53, 0.15); color: var(--studio-accent);">
                            {{ $project->category?->name ?? 'Production' }}
                        </span>
                        <h2 class="h4 font-display fw-bold text-white mb-2">{{ $project->title }}</h2>
                        <p class="small text-secondary mb-3 leading-relaxed">{{ $project->summary }}</p>
                    </div>

                    <div>
                        <div class="d-flex flex-wrap gap-1 mb-3">
                            @foreach ($project->skills as $s)
                                <span class="badge bg-dark border border-secondary text-light small">{{ $s->name }}</span>
                            @endforeach
                        </div>
                        <a href="{{ url('/projects/' . $project->slug) }}" class="btn-lime btn-sm w-100 text-center justify-content-center">
                            Inspect Case Delivery →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-secondary">
                <p>Commercial deliveries loading...</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
