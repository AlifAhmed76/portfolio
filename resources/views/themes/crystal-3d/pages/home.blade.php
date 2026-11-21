@extends('themes.crystal-3d.layouts.app')

@section('title', 'Alif Ahmed — Web Developer & Technical Project Lead')

@section('content')
<div class="container py-5">
    <!-- Hero Section -->
    <div class="crystal-surface p-5 mb-5 text-center">
        <span class="badge bg-emerald-subtle text-emerald border border-emerald-subtle mb-3 px-3 py-2">
            {{ $contact->availability_status ?? 'Available for Select Projects' }}
        </span>
        <h1 class="display-4 fw-bold mb-3">{{ $profile->name ?? 'Md. Alif Ahmed' }}</h1>
        <h3 class="h4 text-emerald fw-semibold mb-3">{{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}</h3>
        <p class="lead text-secondary mx-auto mb-4" style="max-width: 700px;">
            {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
        </p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ url('/projects') }}" class="btn btn-emerald px-4 py-2">View Projects</a>
            <a href="{{ url('/#contact') }}" class="btn btn-outline-secondary px-4 py-2">Get in Touch</a>
        </div>
    </div>

    <!-- Featured Projects Grid -->
    <div class="mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 fw-bold mb-0">Featured Engineering Cases</h2>
            <a href="{{ url('/projects') }}" class="text-emerald text-decoration-none">View All Projects →</a>
        </div>
        <div class="row g-4">
            @forelse ($featuredProjects ?? [] as $project)
                <div class="col-md-6 col-lg-4">
                    <div class="crystal-surface p-4 h-100 d-flex flex-column">
                        <span class="badge bg-secondary-subtle text-secondary small align-self-start mb-2">
                            {{ $project->category?->name ?? 'Solution' }}
                        </span>
                        <h4 class="h5 fw-bold mb-2">{{ $project->title }}</h4>
                        <p class="small text-secondary mb-3 flex-grow-1">{{ $project->summary }}</p>
                        <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-outline-emerald mt-auto">
                            Read Case Study
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4 text-secondary">
                    <p>Projects being loaded.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

