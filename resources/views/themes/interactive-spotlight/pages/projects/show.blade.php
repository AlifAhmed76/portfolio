@extends('themes.interactive-spotlight.layouts.app')

@section('title', $project->title . ' — Interactive Case Study')

@section('content')
<div class="container py-5" style="max-width: 900px;">
    <div class="mb-4">
        <a href="{{ url('/projects') }}" class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1 font-mono">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            <span>Back to Showcases</span>
        </a>
    </div>

    <article class="spot-card p-4 p-md-5">
        <div class="d-flex align-items-center gap-2 mb-3">
            <span class="badge" style="background: rgba(6, 182, 212, 0.2); color: var(--spot-cyan-glow);">
                {{ $project->category?->name ?? 'Interactive Showcase' }}
            </span>
        </div>

        <h1 class="display-4 fw-bold text-white mb-3">{{ $project->title }}</h1>
        <p class="lead text-secondary mb-4 leading-relaxed">{{ $project->summary }}</p>

        @if ($project->coverImage)
            <div class="mb-5 overflow-hidden rounded-3 border" style="max-height: 420px; border-color: var(--spot-border) !important;">
                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 object-fit-cover">
            </div>
        @endif

        @if ($project->detail)
            <div class="mb-5 p-4 rounded-3" style="background: rgba(6, 182, 212, 0.05); border-left: 4px solid var(--spot-cyan);">
                <h3 class="h5 fw-bold text-white mb-2">The Production Challenge</h3>
                <p class="text-secondary mb-0 leading-relaxed">{{ $project->detail->challenge }}</p>
            </div>

            <div class="mb-5 p-4 rounded-3" style="background: rgba(6, 182, 212, 0.05); border-left: 4px solid var(--spot-cyan);">
                <h3 class="h5 fw-bold text-white mb-2">The Engineering Solution</h3>
                <p class="text-secondary mb-0 leading-relaxed">{{ $project->detail->solution }}</p>
            </div>
        @endif

        <div class="pt-4 border-top" style="border-color: var(--spot-border) !important;">
            <div class="small font-mono text-secondary mb-2">Core Technologies:</div>
            <div class="d-flex flex-wrap gap-2">
                @foreach ($project->skills as $skill)
                    <span class="badge bg-secondary-subtle text-light font-mono px-3 py-2">
                        {{ $skill->name }}
                    </span>
                @endforeach
            </div>
        </div>
    </article>
</div>
@endsection
