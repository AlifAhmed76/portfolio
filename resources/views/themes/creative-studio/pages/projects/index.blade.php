@extends('themes.creative-studio.layouts.app')

@section('title', 'Projects | Creative Studio')

@section('content')
<div class="container py-5">
    <h1 class="display-5 fw-bold mb-4">Selected Work & Case Studies</h1>
    <div class="row g-4">
        @forelse ($projects ?? [] as $project)
            <div class="col-md-6">
                <div class="studio-card p-4 h-100 d-flex flex-column">
                    <span class="badge bg-secondary-subtle text-secondary small align-self-start mb-2">
                        {{ $project->category?->name ?? 'Project' }}
                    </span>
                    <h3 class="h5 fw-bold mb-2">{{ $project->title }}</h3>
                    <p class="small text-secondary mb-3 flex-grow-1">{{ $project->summary }}</p>
                    <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-outline-warning mt-auto align-self-start">
                        Explore Case Study
                    </a>
                </div>
            </div>
        @empty
            <p class="text-secondary">No published projects.</p>
        @endforelse
    </div>
</div>
@endsection
