@extends('themes.minimal-professional.layouts.app')

@section('title', 'Alif Ahmed — Web Developer & Technical Project Lead')

@section('content')
<div class="container py-4">
    <div class="py-5 border-bottom mb-5">
        <span class="badge bg-light text-dark border mb-3">{{ $contact->availability_status ?? 'Available' }}</span>
        <h1 class="display-4 fw-normal mb-2">{{ $profile->name ?? 'Md. Alif Ahmed' }}</h1>
        <p class="h5 text-muted mb-4">{{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}</p>
        <p class="lead mb-4" style="max-width: 650px;">{{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}</p>
        <a href="{{ url('/projects') }}" class="btn btn-minimal px-4 py-2">Selected Work</a>
    </div>

    <div>
        <h3 class="h4 mb-4">Selected Case Studies</h3>
        <div class="row g-4">
            @forelse ($featuredProjects ?? [] as $project)
                <div class="col-md-6">
                    <div class="minimal-border p-4 h-100">
                        <span class="small text-muted text-uppercase">{{ $project->category?->name ?? 'Case' }}</span>
                        <h4 class="h5 fw-bold mt-1 mb-2">{{ $project->title }}</h4>
                        <p class="small text-secondary mb-3">{{ $project->summary }}</p>
                        <a href="{{ url('/projects/' . $project->slug) }}" class="small fw-semibold text-dark text-decoration-underline">View Details →</a>
                    </div>
                </div>
            @empty
                <p class="text-muted">No projects listed.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
