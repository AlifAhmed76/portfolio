@extends('themes.minimal-professional.layouts.app')

@section('title', 'Projects | Alif Ahmed')

@section('content')
<div class="container py-4">
    <h1 class="h2 mb-4">Engineering Projects</h1>
    <div class="row g-4">
        @forelse ($projects ?? [] as $project)
            <div class="col-md-6">
                <div class="minimal-border p-4 h-100">
                    <span class="small text-muted text-uppercase">{{ $project->category?->name ?? 'Project' }}</span>
                    <h3 class="h5 fw-bold mt-1 mb-2">{{ $project->title }}</h3>
                    <p class="small text-secondary mb-3">{{ $project->summary }}</p>
                    <a href="{{ url('/projects/' . $project->slug) }}" class="small fw-semibold text-dark text-decoration-underline">View Case Study →</a>
                </div>
            </div>
        @empty
            <p class="text-muted">No published projects.</p>
        @endforelse
    </div>
</div>
@endsection
