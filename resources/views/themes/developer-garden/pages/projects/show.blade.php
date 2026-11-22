@extends('themes.developer-garden.layouts.app')

@section('title', $project->title . ' — Engineering Specs')

@section('content')
<div class="container py-5" style="max-width: 860px;">
    <div class="mb-4">
        <a href="{{ url('/projects') }}" class="garden-link small font-mono d-inline-flex align-items-center gap-1">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            <span>back to projects index</span>
        </a>
    </div>

    <article class="garden-card p-4 p-md-5">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="garden-tag">{{ $project->category?->name ?? 'Production Architecture' }}</span>
        </div>

        <h1 class="display-5 fw-bold font-mono text-white mb-3">{{ $project->title }}</h1>
        <p class="lead text-secondary mb-4 leading-relaxed">{{ $project->summary }}</p>

        @if ($project->coverImage)
            <div class="mb-5 overflow-hidden rounded border border-secondary" style="max-height: 400px;">
                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 object-fit-cover">
            </div>
        @endif

        @if ($project->detail)
            <div class="mb-4">
                <h3 class="h5 font-mono text-success mb-2">// The Architectural Challenge</h3>
                <p class="text-secondary leading-relaxed">{{ $project->detail->challenge }}</p>
            </div>

            <div class="mb-4">
                <h3 class="h5 font-mono text-success mb-2">// Technical Solution & Implementation</h3>
                <p class="text-secondary leading-relaxed">{{ $project->detail->solution }}</p>
            </div>
        @endif

        <div class="pt-4 border-top mt-5" style="border-color: var(--garden-border) !important;">
            <div class="small font-mono text-secondary mb-2">Technologies Used:</div>
            <div class="d-flex flex-wrap gap-2">
                @foreach ($project->skills as $skill)
                    <span class="badge bg-dark border border-secondary text-light font-mono px-3 py-2">
                        {{ $skill->name }}
                    </span>
                @endforeach
            </div>
        </div>
    </article>
</div>
@endsection
