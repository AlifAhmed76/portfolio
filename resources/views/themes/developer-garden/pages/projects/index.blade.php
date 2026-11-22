@extends('themes.developer-garden.layouts.app')

@section('title', 'Projects & Systems Directory | Md. Alif Ahmed')

@section('content')
<div class="container py-5" style="max-width: 900px;">
    <div class="mb-5">
        <a href="{{ url('/') }}" class="garden-link small font-mono d-inline-flex align-items-center gap-1 mb-3">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            <span>back to garden</span>
        </a>
        <h1 class="display-5 fw-bold font-mono text-white mb-2">// Selected Projects & Case Studies</h1>
        <p class="text-secondary lead">Full architectural breakdowns of enterprise solutions, courier hubs, and attribution engines.</p>
    </div>

    <div class="d-flex flex-column gap-3">
        @forelse ($projects ?? [] as $project)
            <div class="garden-card p-4">
                <div class="row align-items-center g-3">
                    <div class="col-md-3">
                        <span class="garden-tag">{{ $project->category?->name ?? 'Architecture' }}</span>
                    </div>
                    <div class="col-md-7">
                        <h2 class="h5 fw-bold mb-1">
                            <a href="{{ url('/projects/' . $project->slug) }}" class="garden-link">
                                {{ $project->title }}
                            </a>
                        </h2>
                        <p class="small text-secondary mb-2">{{ $project->summary }}</p>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach ($project->skills as $s)
                                <span class="small font-mono text-secondary me-2">#{{ $s->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-2 text-md-end">
                        <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-outline-success font-mono">
                            Breakdown →
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-secondary text-center py-4">No projects found.</p>
        @endforelse
    </div>
</div>
@endsection
