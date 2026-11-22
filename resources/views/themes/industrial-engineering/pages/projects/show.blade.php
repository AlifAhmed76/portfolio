@extends('themes.industrial-engineering.layouts.app')

@section('title', $project->title . ' — Technical Specification')

@section('content')
<div class="container py-5" style="max-width: 900px;">
    <div class="mb-4">
        <a href="{{ url('/projects') }}" class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1 font-mono">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            <span>RETURN TO DRAWINGS</span>
        </a>
    </div>

    <article class="eng-card p-4 p-md-5">
        <span class="font-mono small text-warning mb-2 d-block">
            [DWG REF: {{ strtoupper($project->slug) }} // SPEC SHEET]
        </span>

        <h1 class="display-4 fw-bold text-white mb-3">{{ $project->title }}</h1>
        <p class="lead text-secondary mb-4 leading-relaxed">{{ $project->summary }}</p>

        @if ($project->coverImage)
            <div class="mb-5 overflow-hidden border border-secondary" style="max-height: 400px;">
                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 object-fit-cover">
            </div>
        @endif

        @if ($project->detail)
            <div class="mb-5 p-4 border border-secondary" style="background: rgba(15, 23, 42, 0.9);">
                <h3 class="h5 font-mono text-warning mb-2">// 01_ARCHITECTURAL CHALLENGE</h3>
                <p class="text-secondary mb-0 leading-relaxed">{{ $project->detail->challenge }}</p>
            </div>

            <div class="mb-5 p-4 border border-secondary" style="background: rgba(15, 23, 42, 0.9);">
                <h3 class="h5 font-mono text-warning mb-2">// 02_ENGINEERING IMPLEMENTATION</h3>
                <p class="text-secondary mb-0 leading-relaxed">{{ $project->detail->solution }}</p>
            </div>
        @endif

        <div class="pt-4 border-top" style="border-color: rgba(255,255,255,0.1) !important;">
            <div class="small font-mono text-warning mb-2">SYSTEM COMPONENTS:</div>
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
