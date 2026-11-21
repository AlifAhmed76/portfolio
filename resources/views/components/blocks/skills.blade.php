@props(['settings' => []])
@php
    $title = $settings['title'] ?? 'Technical Expertise';
    $subtitle = $settings['subtitle'] ?? 'Core Technologies & Architectural Competencies';
    $layout = $settings['layout'] ?? 'grouped';
    $showEvidence = (bool) ($settings['show_evidence'] ?? true);
    $categories = \App\Models\SkillCategory::with(['skills' => fn($q) => $q->orderBy('sort_order')])->orderBy('sort_order')->get();
@endphp

<section class="block-skills py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-uppercase text-success small fw-bold tracking-wider">{{ $subtitle }}</span>
            <h2 class="h1 fw-bold mt-1">{{ $title }}</h2>
        </div>
        <div class="row g-4">
            @forelse ($categories as $category)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 p-4 border-0 rounded-4 shadow-sm" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08) !important;">
                        <h4 class="h5 fw-bold mb-3 text-success d-flex align-items-center gap-2">
                            <i data-lucide="cpu" style="width: 18px; height: 18px;"></i>
                            {{ $category->name }}
                        </h4>
                        <div class="d-flex flex-column gap-3">
                            @foreach ($category->skills as $skill)
                                <div class="skill-item">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fw-semibold small">{{ $skill->name }}</span>
                                        @if ($skill->years_experience)
                                            <span class="badge bg-secondary-subtle text-secondary small">{{ $skill->years_experience }}y exp</span>
                                        @endif
                                    </div>
                                    @if ($showEvidence && $skill->description)
                                        <div class="text-secondary small">{{ $skill->description }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-secondary py-4">No skills registered yet.</div>
            @endforelse
        </div>
    </div>
</section>
