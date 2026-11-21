@props(['settings' => []])
@php
    $title = $settings['title'] ?? 'Featured Projects';
    $subtitle = $settings['subtitle'] ?? 'Case Studies & Production Implementations';
    $limit = (int) ($settings['limit'] ?? 6);
    $featuredOnly = (bool) ($settings['featured_only'] ?? false);
    
    $query = \App\Models\Project::with(['category', 'featuredImage', 'skills'])->published()->orderBy('sort_order');
    if ($featuredOnly) {
        $query->featured();
    }
    $projects = $query->take($limit)->get();
@endphp

<section class="block-projects py-5" id="projects">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-uppercase text-success small fw-bold tracking-wider">{{ $subtitle }}</span>
            <h2 class="h1 fw-bold mt-1">{{ $title }}</h2>
        </div>
        <div class="row g-4">
            @forelse ($projects as $project)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 rounded-4 shadow-sm overflow-hidden" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08) !important;">
                        @if ($project->featuredImage)
                            <img src="{{ $project->featuredImage->url }}" class="card-img-top" alt="{{ $project->title }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center" style="height: 200px;">
                                <i data-lucide="folder-git-2" class="text-secondary" style="width: 48px; height: 48px;"></i>
                            </div>
                        @endif
                        <div class="card-body p-4 d-flex flex-column">
                            @if ($project->category)
                                <span class="badge bg-secondary-subtle text-secondary align-self-start mb-2">{{ $project->category->name }}</span>
                            @endif
                            <h3 class="h5 fw-bold mb-2">{{ $project->title }}</h3>
                            <p class="text-secondary small flex-grow-1">{{ Str::limit($project->summary, 120) }}</p>
                            <div class="pt-3 border-top mt-auto" style="border-color: rgba(255,255,255,0.08) !important;">
                                <a href="{{ route('projects.show', $project->slug) }}" class="btn btn-sm btn-outline-primary w-100 fw-semibold">
                                    View Case Study &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-secondary py-4">No published projects available.</div>
            @endforelse
        </div>
    </div>
</section>
