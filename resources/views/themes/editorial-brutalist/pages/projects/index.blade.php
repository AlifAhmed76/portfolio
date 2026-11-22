@extends('themes.editorial-brutalist.layouts.app')

@section('title', 'Projects & Architectural Case Studies | Md. Alif Ahmed')

@section('content')
<div class="container px-4 py-5">
    <div class="mb-5 pb-3 brutalist-border-bottom">
        <a href="{{ url('/') }}" class="editorial-nav-link p-0 mb-3 d-inline-block">← Return Home</a>
        <h1 class="display-4 font-display text-uppercase fw-bold mb-2">Projects &amp; Case Studies</h1>
        <p class="lead text-secondary">Complete architectural index of production implementations.</p>
    </div>

    <div class="row g-4">
        @forelse ($projects ?? [] as $idx => $project)
            <div class="col-md-6">
                <article class="p-4 brutalist-border h-100 d-flex flex-column" style="background: var(--surface-noir);">
                    <div class="case-number mb-2">0{{ $idx + 1 }}</div>
                    <span class="badge-editorial mb-2 align-self-start">{{ $project->category?->name ?? 'Production' }}</span>
                    <h2 class="h4 font-display text-uppercase fw-bold mb-2">{{ $project->title }}</h2>
                    <p class="small text-secondary mb-4 flex-grow-1 leading-relaxed">{{ $project->summary }}</p>
                    <a href="{{ url('/projects/' . $project->slug) }}" class="btn-brutalist mt-auto py-2 text-center" style="font-size: 0.75rem;">
                        Inspect Architecture →
                    </a>
                </article>
            </div>
        @empty
            <div class="col-12 py-5 text-center text-secondary">
                <p>No published projects cataloged.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
