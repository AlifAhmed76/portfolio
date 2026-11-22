@extends('themes.nordic-minimal.layouts.app')

@section('title', $project->title . ' | Case Study | Md. Alif Ahmed')

@section('content')
<div class="container py-5" style="max-width: 880px;">
    <div class="mb-4">
        <a href="{{ url('/projects') }}" class="small text-muted text-decoration-none">← All Works</a>
    </div>

    <article class="mb-5">
        <span class="badge-nordic mb-2 d-inline-block">{{ $project->category?->name ?? 'Case Study' }}</span>
        <h1 class="display-4 font-serif fw-bold mb-3">{{ $project->title }}</h1>
        <p class="lead text-muted mb-4">{{ $project->summary }}</p>

        @if ($project->coverImage)
            <div class="ratio ratio-16x9 rounded overflow-hidden mb-4 border">
                <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="object-fit-cover">
            </div>
        @endif

        @if ($project->detail)
            <div class="row g-4 my-4">
                <div class="col-md-6">
                    <div class="p-4 rounded border h-100" style="background: var(--nordic-surface);">
                        <h4 class="h6 font-serif fw-bold mb-2 text-danger">The Challenge</h4>
                        <p class="small text-muted mb-0 leading-relaxed">{{ $project->detail->challenge }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded border h-100" style="background: var(--nordic-surface);">
                        <h4 class="h6 font-serif fw-bold mb-2 text-success">The Solution</h4>
                        <p class="small text-muted mb-0 leading-relaxed">{{ $project->detail->solution }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded border h-100" style="background: var(--nordic-surface);">
                        <h4 class="h6 font-serif fw-bold mb-2 text-info">Implementation</h4>
                        <p class="small text-muted mb-0 leading-relaxed">{{ $project->detail->implementation }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4 rounded border h-100" style="background: var(--nordic-surface);">
                        <h4 class="h6 font-serif fw-bold mb-2 text-warning">Measurable Outcome</h4>
                        <p class="small text-muted mb-0 leading-relaxed">{{ $project->detail->outcome }}</p>
                    </div>
                </div>
            </div>
        @endif

        @if ($project->links->isNotEmpty())
            <div class="d-flex gap-3 mt-4 pt-3 border-top">
                @foreach ($project->links as $link)
                    <a href="{{ $link->url }}" target="_blank" class="btn btn-nordic btn-sm">
                        {{ $link->label }} ↗
                    </a>
                @endforeach
            </div>
        @endif
    </article>
</div>
@endsection
