@extends('themes.minimal-professional.layouts.app')

@section('title', $project->title . ' | Alif Ahmed')

@section('content')
<div class="container py-4">
    <a href="{{ url('/projects') }}" class="small text-muted mb-4 d-inline-block">← Back to Projects</a>
    <h1 class="h2 fw-bold mb-2">{{ $project->title }}</h1>
    <p class="lead text-secondary mb-4">{{ $project->summary }}</p>

    @if ($project->detail)
        <div class="row g-4 my-4">
            <div class="col-md-6">
                <h5>Challenge</h5>
                <p class="small text-secondary">{{ $project->detail->challenge }}</p>
            </div>
            <div class="col-md-6">
                <h5>Solution</h5>
                <p class="small text-secondary">{{ $project->detail->solution }}</p>
            </div>
            <div class="col-md-6">
                <h5>Implementation</h5>
                <p class="small text-secondary">{{ $project->detail->implementation }}</p>
            </div>
            <div class="col-md-6">
                <h5>Outcome</h5>
                <p class="small text-secondary">{{ $project->detail->outcome }}</p>
            </div>
        </div>
    @endif
</div>
@endsection
