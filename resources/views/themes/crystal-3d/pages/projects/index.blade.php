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
                <div class="crystal-card-3d p-4 h-100 d-flex flex-column">
                    <div class="project-card-visual mb-3 position-relative overflow-hidden" style="height: 180px; background: #0f172a; border-radius: 12px;">
                        @if ($project->coverImage)
                            <img src="{{ $project->coverImage->url }}" alt="{{ $project->title }}" class="w-100 h-100 object-fit-cover project-img-zoom">
                        @else
                            <div class="editorial-project-cover w-100 h-100 d-flex flex-column justify-content-between p-3" style="background: radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.2), transparent 60%), linear-gradient(135deg, #0b1120 0%, #020617 100%);">
                                <span class="badge bg-emerald-subtle text-emerald small font-monospace align-self-start">{{ $project->category?->name ?? 'Production' }}</span>
                                <div class="text-white fw-bold">{{ $project->title }}</div>
                            </div>
                        @endif
                    </div>
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
