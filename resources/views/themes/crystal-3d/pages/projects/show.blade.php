@extends('themes.crystal-3d.layouts.app')

@section('title', $project->title . ' | Alif Ahmed')

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ url('/projects') }}" class="text-secondary text-decoration-none small">
            ← Back to All Projects
        </a>
    </div>

    <div class="crystal-surface p-4 p-md-5 mb-5">
        <span class="badge bg-emerald-subtle text-emerald mb-2">{{ $project->category?->name ?? 'Case Study' }}</span>
        <h1 class="display-5 fw-bold mb-3">{{ $project->title }}</h1>
        <p class="lead text-secondary mb-4">{{ $project->summary }}</p>

        @if ($project->coverImage)
            <div class="ratio ratio-16x9 rounded overflow-hidden mb-4 border border-secondary-subtle">
                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="object-fit-cover">
            </div>
        @endif

        @if ($project->detail)
            <div class="row g-4 my-4">
                <div class="col-md-6">
                    <div class="p-4 rounded bg-body-tertiary h-100">
                        <h4 class="h5 fw-bold text-danger mb-2">The Challenge</h4>
                        <p class="small text-secondary mb-0">{{ $project->detail->challenge }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded bg-body-tertiary h-100">
                        <h4 class="h5 fw-bold text-success mb-2">The Solution</h4>
                        <p class="small text-secondary mb-0">{{ $project->detail->solution }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded bg-body-tertiary h-100">
                        <h4 class="h5 fw-bold text-info mb-2">Implementation</h4>
                        <p class="small text-secondary mb-0">{{ $project->detail->implementation }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded bg-body-tertiary h-100">
                        <h4 class="h5 fw-bold text-warning mb-2">Measurable Outcome</h4>
                        <p class="small text-secondary mb-0">{{ $project->detail->outcome }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($project->links->isNotEmpty())
            <div class="d-flex gap-3 mt-4 pt-3 border-top border-secondary-subtle">
                @foreach ($project->links as $link)
                    <a href="{{ $link->url }}" target="_blank" class="btn btn-emerald btn-sm">
                        {{ $link->label }} ↗
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
