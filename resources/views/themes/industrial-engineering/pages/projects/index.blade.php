@extends('themes.industrial-engineering.layouts.app')

@section('title', 'Structural Drawings & Production Systems | Md. Alif Ahmed')

@section('content')
<div class="container py-5">
    <div class="mb-5">
        <a href="{{ url('/') }}" class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1 font-mono mb-3">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            <span>RETURN TO SPEC</span>
        </a>
        <h1 class="display-4 fw-bold text-white mb-2">// PRODUCTION DRAWINGS</h1>
        <p class="text-secondary lead">Full architectural breakdowns of enterprise solutions, courier hubs, and attribution engines.</p>
    </div>

    <div class="d-flex flex-column gap-4">
        @forelse ($projects ?? [] as $idx => $project)
            <div class="eng-card p-4 p-md-5">
                <div class="row g-4 align-items-center">
                    <div class="col-lg-7">
                        <div class="font-mono small text-warning mb-2">
                            [DWG REF: EXP-00{{ $idx + 1 }} · {{ strtoupper($project->category?->name ?? 'SYSTEM') }}]
                        </div>
                        <h2 class="h4 fw-bold text-white mb-2">{{ $project->title }}</h2>
                        <p class="small text-secondary mb-3 leading-relaxed">{{ $project->summary }}</p>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            @foreach ($project->skills as $s)
                                <span class="badge bg-dark border border-secondary text-light font-mono small">{{ $s->name }}</span>
                            @endforeach
                        </div>

                        <a href="{{ url('/projects/' . $project->slug) }}" class="btn-eng btn-sm">
                            Inspect Engineering Specs →
                        </a>
                    </div>
                    <div class="col-lg-5">
                        <div class="overflow-hidden border border-secondary" style="height: 180px; background: #0f172a;">
                            @if ($project->coverImage)
                                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 d-flex flex-column justify-content-between p-3" style="background: radial-gradient(circle at 80% 20%, rgba(249, 115, 22, 0.25), #0f172a);">
                                    <span class="font-mono small text-warning">STRUCTURAL SPEC</span>
                                    <div class="h5 font-mono fw-bold text-white">{{ $project->title }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-secondary text-center py-4">Drawings loading...</p>
        @endforelse
    </div>
</div>
@endsection
