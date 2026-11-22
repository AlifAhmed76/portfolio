@extends('themes.nordic-minimal.layouts.app')

@section('title', 'Projects & Architectural Case Studies | Md. Alif Ahmed')

@section('content')
<div class="container py-5" style="max-width: 960px;">
    <div class="mb-5 pb-3 border-bottom" style="border-color: var(--nordic-border) !important;">
        <a href="{{ url('/') }}" class="small text-muted text-decoration-none mb-3 d-inline-block">← Return Home</a>
        <h1 class="display-4 font-serif fw-bold mb-2">Projects &amp; Case Studies</h1>
        <p class="lead text-muted">Complete architectural index of production engineering systems.</p>
    </div>

    <div class="row g-5">
        @forelse ($projects ?? [] as $project)
            <div class="col-md-6">
                <article class="h-100 d-flex flex-column">
                    <span class="badge-nordic mb-2 align-self-start">{{ $project->category?->name ?? 'Production' }}</span>
                    <h2 class="h4 font-serif fw-bold mb-2">{{ $project->title }}</h2>
                    <p class="small text-muted mb-4 flex-grow-1 leading-relaxed">{{ $project->summary }}</p>
                    <a href="{{ url('/projects/' . $project->slug) }}" class="small fw-semibold text-decoration-underline text-reset mt-auto">
                        Explore Case Study →
                    </a>
                </article>
            </div>
        @empty
            <div class="col-12 py-5 text-center text-muted">
                <p>No published projects cataloged.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
