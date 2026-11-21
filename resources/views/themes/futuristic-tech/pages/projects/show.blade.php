@extends('themes.futuristic-tech.layouts.app')

@section('title', $project->title . ' // Futuristic Tech')

@section('content')
<div class="container py-5">
    <a href="{{ url('/projects') }}" class="btn btn-sm btn-outline-secondary font-mono mb-4">&lt; BACK_TO_ARCHIVE</a>

    <div class="tech-panel p-5 mb-5">
        <span class="badge bg-info-subtle text-cyan font-mono mb-2">{{ $project->category?->name ?? 'PROJECT_SPEC' }}</span>
        <h1 class="display-4 fw-bold font-mono mb-3">{{ $project->title }}</h1>
        <p class="lead text-secondary mb-4">{{ $project->summary }}</p>

        @if ($project->detail)
            <div class="row g-4 my-4 font-mono small">
                <div class="col-md-6">
                    <div class="p-3 tech-panel">
                        <div class="text-danger fw-bold mb-1">// CHALLENGE</div>
                        <p class="mb-0 text-secondary">{{ $project->detail->challenge }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 tech-panel">
                        <div class="text-cyan fw-bold mb-1">// ARCHITECTURE_SOLUTION</div>
                        <p class="mb-0 text-secondary">{{ $project->detail->solution }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
