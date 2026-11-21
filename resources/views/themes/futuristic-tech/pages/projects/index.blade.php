@extends('themes.futuristic-tech.layouts.app')

@section('title', 'Projects // Futuristic Tech')

@section('content')
<div class="container py-5">
    <h1 class="h2 font-mono text-cyan mb-4">// SYSTEM_PROJECT_ARCHIVE</h1>
    <div class="row g-4">
        @forelse ($projects ?? [] as $project)
            <div class="col-md-6">
                <div class="tech-panel p-4 h-100 d-flex flex-column">
                    <span class="badge bg-secondary-subtle text-secondary small align-self-start mb-2 font-mono">
                        {{ $project->category?->name ?? 'SYSTEM' }}
                    </span>
                    <h3 class="h5 fw-bold mb-2">{{ $project->title }}</h3>
                    <p class="small text-secondary mb-3 flex-grow-1">{{ $project->summary }}</p>
                    <a href="{{ url('/projects/' . $project->slug) }}" class="btn btn-sm btn-outline-info font-mono mt-auto align-self-start">
                        &gt; INSPECT
                    </a>
                </div>
            </div>
        @empty
            <p class="text-secondary font-mono">ARCHIVE_EMPTY</p>
        @endforelse
    </div>
</div>
@endsection
