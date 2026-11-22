@extends('themes.executive-lead.layouts.app')

@section('title', 'Projects & Architectural Case Studies | Md. Alif Ahmed')

@section('content')
<div class="container py-5" style="max-width: 960px;">
    <div class="mb-5 text-center">
        <span class="badge-gold mb-2 d-inline-block">Commercial Deliveries</span>
        <h1 class="display-4 fw-bold mb-2">Projects &amp; Case Studies</h1>
        <p class="text-secondary lead">Full architectural breakdowns of enterprise solutions, courier hubs, and attribution engines.</p>
    </div>

    <div class="row g-4">
        @forelse ($projects ?? [] as $project)
            <div class="col-md-6">
                <article class="exec-card p-4 h-100 d-flex flex-column">
                    <span class="badge-gold align-self-start mb-2">{{ $project->category?->name ?? 'Production' }}</span>
                    <h2 class="h5 fw-bold mb-2">{{ $project->title }}</h2>
                    <p class="small text-secondary mb-4 flex-grow-1 leading-relaxed">{{ $project->summary }}</p>
                    <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-gold mt-auto">
                        Explore Case Study →
                    </a>
                </article>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-secondary">
                <p>No published projects found.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
