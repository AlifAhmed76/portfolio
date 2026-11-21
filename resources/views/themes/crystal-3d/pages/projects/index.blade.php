@extends('themes.crystal-3d.layouts.app')

@section('title', 'Projects & Engineering Case Studies | Alif Ahmed')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold mb-2">Featured Projects & Case Studies</h1>
        <p class="text-secondary lead">In-depth technical breakdowns of production systems and solutions.</p>
    </div>

    <div class="row g-4">
        @forelse ($projects ?? [] as $project)
            <div class="col-md-6 col-lg-4">
                <div class="crystal-surface p-4 h-100 d-flex flex-column">
                    <span class="badge bg-secondary-subtle text-secondary small align-self-start mb-2">
                        {{ $project->category?->name ?? 'Project' }}
                    </span>
                    <h3 class="h5 fw-bold mb-2">{{ $project->title }}</h3>
                    <p class="small text-secondary mb-3 flex-grow-1">{{ $project->summary }}</p>
                    <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-emerald mt-auto">
                        Explore Case Study
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
