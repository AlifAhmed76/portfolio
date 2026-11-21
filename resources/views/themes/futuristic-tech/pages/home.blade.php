@extends('themes.futuristic-tech.layouts.app')

@section('title', 'Alif Ahmed // Systems Architecture & Lead')

@section('content')
<div class="container py-5">
    <div class="tech-panel p-5 mb-5">
        <div class="font-mono text-cyan small mb-3">
            [STATUS: {{ strtoupper($contact->availability_status ?? 'AVAILABLE') }}]
        </div>
        <h1 class="display-4 fw-bold mb-3 font-mono">{{ $profile->name ?? 'Md. Alif Ahmed' }}</h1>
        <h3 class="h4 text-cyan mb-3">{{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}</h3>
        <p class="lead text-secondary mb-4 font-mono" style="max-width: 700px;">
            {{ $profile->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}
        </p>
        <div class="d-flex gap-3">
            <a href="{{ url('/projects') }}" class="btn btn-cyan font-mono px-4 py-2">&gt; INSPECT_PROJECTS()</a>
            <a href="{{ url('/#contact') }}" class="btn btn-outline-secondary font-mono px-4 py-2">&gt; CONNECT()</a>
        </div>
    </div>

    <div>
        <h3 class="h4 font-mono text-cyan mb-4">// DEPLOYED_CASE_STUDIES</h3>
        <div class="row g-4">
            @forelse ($featuredProjects ?? [] as $project)
                <div class="col-md-6">
                    <div class="tech-panel p-4 h-100 d-flex flex-column">
                        <span class="badge bg-secondary-subtle text-secondary small align-self-start mb-2 font-mono">
                            {{ $project->category?->name ?? 'SYSTEM' }}
                        </span>
                        <h4 class="h5 fw-bold mb-2">{{ $project->title }}</h4>
                        <p class="small text-secondary mb-3 flex-grow-1">{{ $project->summary }}</p>
                        <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-outline-info font-mono mt-auto align-self-start">
                            &gt; CASE_TELEMETRY
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-secondary font-mono">NO_SYSTEMS_REGISTERED</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
