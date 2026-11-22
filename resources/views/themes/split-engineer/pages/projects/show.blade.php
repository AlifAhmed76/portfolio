@extends('themes.split-engineer.layouts.app')

@section('title', $project->title . ' | Case Study | Md. Alif Ahmed')

@section('content')
<div class="container py-5" style="max-width: 900px;">
    <div class="mb-4">
        <a href="{{ url('/projects') }}" class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            <span>All Projects</span>
        </a>
    </div>

    <article class="split-card p-4 p-md-5 mb-5">
        <span class="tech-pill mb-3">{{ $project->category?->name ?? 'Case Study' }}</span>
        <h1 class="display-5 fw-bold text-heading mb-3">{{ $project->title }}</h1>
        <p class="lead text-secondary mb-4">{{ $project->summary }}</p>

        @if ($project->coverImage)
            <div class="ratio ratio-16x9 rounded overflow-hidden mb-4 border border-secondary-subtle">
                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="object-fit-cover">
            </div>
        @endif

        @if ($project->detail)
            <div class="row g-4 my-4">
                <div class="col-md-6">
                    <div class="p-4 rounded border border-secondary-subtle bg-dark-subtle h-100">
                        <h4 class="h6 fw-bold text-danger mb-2 font-mono">01 // The Challenge</h4>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $project->detail->challenge }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded border border-secondary-subtle bg-dark-subtle h-100">
                        <h4 class="h6 fw-bold text-teal-light mb-2 font-mono" style="color: var(--accent-teal-light);">02 // The Solution</h4>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $project->detail->solution }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded border border-secondary-subtle bg-dark-subtle h-100">
                        <h4 class="h6 fw-bold text-info mb-2 font-mono">03 // Technical Implementation</h4>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $project->detail->implementation }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded border border-secondary-subtle bg-dark-subtle h-100">
                        <h4 class="h6 fw-bold text-warning mb-2 font-mono">04 // Measurable Outcome</h4>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $project->detail->outcome }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="my-4">
            <h4 class="h6 fw-bold text-heading mb-2">Technologies Used</h4>
            <div class="d-flex flex-wrap gap-2">
                @foreach ($project->skills as $skill)
                    <span class="tech-pill">{{ $skill->name }}</span>
                @endforeach
            </div>
        </div>

        @if ($project->links->isNotEmpty())
            <div class="d-flex gap-3 mt-4 pt-3 border-top border-secondary-subtle">
                @foreach ($project->links as $link)
                    <a href="{{ $link->url }}" target="_blank" class="btn btn-sm btn-teal text-white d-inline-flex align-items-center gap-1" style="background-color: var(--accent-teal);">
                        <span>{{ $link->label }}</span>
                        <i data-lucide="external-link" style="width: 14px; height: 14px;"></i>
                    </a>
                @endforeach
            </div>
        @endif
    </article>
</div>
@endsection
