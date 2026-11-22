@extends('themes.animattor-dark.layouts.app')

@section('title', $project->title . ' | Md. Alif Ahmed')

@section('content')
<div class="container py-5" style="max-width: 900px;">
    <div class="mb-4">
        <a href="{{ url('/projects') }}" class="text-secondary text-decoration-none small">
            ← Back to All Projects
        </a>
    </div>

    <article class="animattor-card p-4 p-md-5 mb-5">
        <span class="badge-violet mb-2 d-inline-block">{{ $project->category?->name ?? 'Case Study' }}</span>
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
                    <div class="p-4 rounded border border-secondary-subtle h-100" style="background: rgba(13, 12, 29, 0.7);">
                        <h4 class="h6 fw-bold text-danger mb-2">01 // The Challenge</h4>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $project->detail->challenge }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded border border-secondary-subtle h-100" style="background: rgba(13, 12, 29, 0.7);">
                        <h4 class="h6 fw-bold text-violet-glow mb-2">02 // The Solution</h4>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $project->detail->solution }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded border border-secondary-subtle h-100" style="background: rgba(13, 12, 29, 0.7);">
                        <h4 class="h6 fw-bold text-info mb-2">03 // Implementation</h4>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $project->detail->implementation }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded border border-secondary-subtle h-100" style="background: rgba(13, 12, 29, 0.7);">
                        <h4 class="h6 fw-bold text-warning mb-2">04 // Measurable Outcome</h4>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $project->detail->outcome }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($project->links->isNotEmpty())
            <div class="d-flex gap-3 mt-4 pt-3 border-top border-secondary-subtle">
                @foreach ($project->links as $link)
                    <a href="{{ $link->url }}" target="_blank" class="btn btn-violet btn-sm">
                        {{ $link->label }} ↗
                    </a>
                @endforeach
            </div>
        @endif
    </article>
</div>
@endsection
