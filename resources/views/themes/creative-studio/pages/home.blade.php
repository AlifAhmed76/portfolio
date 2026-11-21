@extends('themes.creative-studio.layouts.app')

@section('title', 'Alif Ahmed — Creative Engineering Studio')

@section('content')
<div class="container py-5">
    <div class="studio-card p-5 mb-5">
        <span class="badge bg-warning-subtle text-warning border border-warning-subtle mb-3">
            {{ $contact->availability_status ?? 'Available' }}
        </span>
        <h1 class="display-3 fw-bolder mb-3">{{ $profile->name ?? 'Md. Alif Ahmed' }}</h1>
        <h3 class="h4 text-warning mb-4">{{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}</h3>
        <p class="lead text-secondary mb-4" style="max-width: 720px;">
            {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
        </p>
        <a href="{{ url('/projects') }}" class="btn btn-studio">Explore Selected Cases</a>
    </div>

    <div>
        <h2 class="h3 fw-bold mb-4">Projects & Case Studies</h2>
        <div class="row g-4">
            @forelse ($featuredProjects ?? [] as $project)
                <div class="col-md-6">
                    <div class="studio-card p-4 h-100 d-flex flex-column">
                        <span class="badge bg-secondary-subtle text-secondary small align-self-start mb-2">
                            {{ $project->category?->name ?? 'Production' }}
                        </span>
                        <h4 class="h5 fw-bold mb-2">{{ $project->title }}</h4>
                        <p class="small text-secondary mb-3 flex-grow-1">{{ $project->summary }}</p>
                        <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-outline-warning mt-auto align-self-start">
                            View Case
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-secondary">No projects to show.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
