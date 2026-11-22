@extends('themes.animattor-dark.layouts.app')

@section('title', 'Projects & Architectural Case Studies | Md. Alif Ahmed')

@section('content')
<div class="container py-5">
    <div class="mb-5 text-center">
        <span class="badge-violet mb-2 d-inline-block">Production Engineering</span>
        <h1 class="display-4 fw-bold mb-2">Projects &amp; Case Studies</h1>
        <p class="text-secondary lead">In-depth technical breakdowns of production systems and solutions.</p>
    </div>

    <div class="row g-4">
        @forelse ($projects ?? [] as $project)
            <div class="col-md-6 col-lg-4">
                <div class="animattor-card p-4 h-100 d-flex flex-column">
                    <span class="badge-violet align-self-start mb-2">{{ $project->category?->name ?? 'Project' }}</span>
                    <h2 class="h5 fw-bold mb-2">{{ $project->title }}</h2>
                    <p class="small text-secondary mb-4 flex-grow-1">{{ $project->summary }}</p>
                    <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-violet mt-auto">
                        Explore Case Study →
                    </a>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-secondary">
                <p>No published projects available at this moment.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
