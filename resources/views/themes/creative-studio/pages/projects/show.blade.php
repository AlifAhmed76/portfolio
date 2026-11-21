@extends('themes.creative-studio.layouts.app')

@section('title', $project->title . ' | Creative Studio')

@section('content')
<div class="container py-5">
    <a href="{{ url('/projects') }}" class="btn btn-sm btn-outline-secondary mb-4">← Back to Showcase</a>

    <div class="studio-card p-5 mb-5">
        <span class="badge bg-warning-subtle text-warning mb-2">{{ $project->category?->name ?? 'Production' }}</span>
        <h1 class="display-4 fw-bolder mb-3">{{ $project->title }}</h1>
        <p class="lead text-secondary mb-4">{{ $project->summary }}</p>

        @if ($project->detail)
            <div class="row g-4 my-4">
                <div class="col-md-6">
                    <div class="p-4 rounded bg-body-tertiary">
                        <h4 class="h6 text-warning text-uppercase fw-bold">The Challenge</h4>
                        <p class="small text-secondary mb-0">{{ $project->detail->challenge }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded bg-body-tertiary">
                        <h4 class="h6 text-success text-uppercase fw-bold">The Solution</h4>
                        <p class="small text-secondary mb-0">{{ $project->detail->solution }}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
