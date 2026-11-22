@extends('themes.editorial-brutalist.layouts.app')

@section('title', $project->title . ' | Architecture Case Study | Md. Alif Ahmed')

@section('content')
<div class="container px-4 py-5" style="max-width: 980px;">
    <div class="mb-4">
        <a href="{{ url('/projects') }}" class="editorial-nav-link p-0">← All Projects</a>
    </div>

    <article class="p-4 p-md-5 brutalist-border mb-5" style="background: var(--surface-noir);">
        <span class="badge-editorial mb-2 d-inline-block">{{ $project->category?->name ?? 'Case Study' }}</span>
        <h1 class="display-4 font-display text-uppercase fw-bold mb-3">{{ $project->title }}</h1>
        <p class="lead text-secondary mb-4">{{ $project->summary }}</p>

        @if ($project->coverImage)
            <div class="ratio ratio-16x9 brutalist-border overflow-hidden mb-4">
                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="object-fit-cover" style="filter: grayscale(20%);">
            </div>
        @endif

        @if ($project->detail)
            <div class="row g-4 my-4">
                <div class="col-md-6">
                    <div class="p-4 brutalist-border h-100">
                        <div class="font-display h6 fw-bold text-uppercase mb-2" style="color: var(--accent-crimson);">01 // The Challenge</div>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $project->detail->challenge }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 brutalist-border h-100">
                        <div class="font-display h6 fw-bold text-uppercase mb-2 text-stark">02 // The Solution</div>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $project->detail->solution }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 brutalist-border h-100">
                        <div class="font-display h6 fw-bold text-uppercase mb-2 text-secondary">03 // Implementation</div>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $project->detail->implementation }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 brutalist-border h-100">
                        <div class="font-display h6 fw-bold text-uppercase mb-2 text-stark">04 // Measurable Outcome</div>
                        <p class="small text-secondary mb-0 leading-relaxed">{{ $project->detail->outcome }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="my-4">
            <div class="font-display h6 fw-bold text-uppercase mb-2">Technologies Used</div>
            <div class="d-flex flex-wrap gap-2">
                @foreach ($project->skills as $skill)
                    <span class="badge-editorial">{{ $skill->name }}</span>
                @endforeach
            </div>
        </div>

        @if ($project->links->isNotEmpty())
            <div class="d-flex gap-3 mt-4 pt-3 brutalist-border-top">
                @foreach ($project->links as $link)
                    <a href="{{ $link->url }}" target="_blank" class="btn-brutalist py-2 px-3" style="font-size: 0.8rem;">
                        {{ $link->label }} ↗
                    </a>
                @endforeach
            </div>
        @endif
    </article>
</div>
@endsection
