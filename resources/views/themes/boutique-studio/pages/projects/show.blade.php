@extends('themes.boutique-studio.layouts.app')

@section('title', $project->title . ' — Commercial Case Study')

@section('content')
<div class="container py-5" style="max-width: 900px;">
    <div class="mb-4">
        <a href="{{ url('/projects') }}" class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            <span>Back to Case Studies</span>
        </a>
    </div>

    <article class="studio-card p-4 p-md-5">
        <span class="badge mb-3" style="background: rgba(163, 230, 53, 0.15); color: var(--studio-accent);">
            {{ $project->category?->name ?? 'Commercial Build' }}
        </span>

        <h1 class="display-4 font-display fw-bold text-white mb-3">{{ $project->title }}</h1>
        <p class="lead text-secondary mb-4 leading-relaxed">{{ $project->summary }}</p>

        @if ($project->coverImage)
            <div class="mb-5 overflow-hidden rounded-3 border" style="max-height: 420px; border-color: rgba(255,255,255,0.1) !important;">
                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 object-fit-cover">
            </div>
        @endif

        @if ($project->detail)
            <div class="mb-5 p-4 rounded-3" style="background: rgba(255,255,255,0.02); border-left: 4px solid var(--studio-accent);">
                <h3 class="h5 font-display text-white mb-2">The Business Challenge</h3>
                <p class="text-secondary mb-0 leading-relaxed">{{ $project->detail->challenge }}</p>
            </div>

            <div class="mb-5 p-4 rounded-3" style="background: rgba(255,255,255,0.02); border-left: 4px solid var(--studio-accent);">
                <h3 class="h5 font-display text-white mb-2">The Architectural Solution</h3>
                <p class="text-secondary mb-0 leading-relaxed">{{ $project->detail->solution }}</p>
            </div>
        @endif

        <div class="pt-4 border-top" style="border-color: var(--studio-border) !important;">
            <div class="small text-secondary mb-2">Production Technologies:</div>
            <div class="d-flex flex-wrap gap-2">
                @foreach ($project->skills as $skill)
                    <span class="badge bg-dark border border-secondary text-light px-3 py-2">
                        {{ $skill->name }}
                    </span>
                @endforeach
            </div>
        </div>
    </article>
</div>
@endsection
