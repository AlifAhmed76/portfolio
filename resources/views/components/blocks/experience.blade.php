@props(['settings' => []])
@php
    $title = $settings['title'] ?? 'Experience & Education';
    $subtitle = $settings['subtitle'] ?? 'Professional Timeline';
    $showType = $settings['show_type'] ?? 'all';

    $experiences = in_array($showType, ['all', 'work']) 
        ? \App\Models\Experience::orderByDesc('start_date')->get() 
        : collect();
    $educations = in_array($showType, ['all', 'education']) 
        ? \App\Models\Education::orderByDesc('start_date')->get() 
        : collect();
@endphp

<section class="block-experience py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-uppercase text-success small fw-bold tracking-wider">{{ $subtitle }}</span>
            <h2 class="h1 fw-bold mt-1">{{ $title }}</h2>
        </div>
        <div class="row g-5">
            @if ($experiences->isNotEmpty())
                <div class="{{ $educations->isNotEmpty() ? 'col-lg-6' : 'col-lg-8 mx-auto' }}">
                    <h3 class="h4 fw-bold mb-4 d-flex align-items-center gap-2">
                        <i data-lucide="briefcase" class="text-success"></i>
                        Professional Roles
                    </h3>
                    <div class="timeline position-relative ps-4" style="border-left: 2px solid rgba(255,255,255,0.1);">
                        @foreach ($experiences as $exp)
                            <div class="mb-4 position-relative">
                                <div class="position-absolute rounded-circle bg-success" style="width: 10px; height: 10px; left: -21px; top: 6px;"></div>
                                <h5 class="fw-bold mb-1">{{ $exp->job_title }}</h5>
                                <div class="text-success small fw-semibold mb-1">{{ $exp->company }} &bull; {{ $exp->location ?? 'Remote' }}</div>
                                <div class="text-secondary small mb-2">
                                    {{ $exp->start_date ? $exp->start_date->format('M Y') : '' }} - 
                                    {{ $exp->is_current ? 'Present' : ($exp->end_date ? $exp->end_date->format('M Y') : '') }}
                                </div>
                                <p class="text-secondary small mb-0">{{ $exp->description }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($educations->isNotEmpty())
                <div class="{{ $experiences->isNotEmpty() ? 'col-lg-6' : 'col-lg-8 mx-auto' }}">
                    <h3 class="h4 fw-bold mb-4 d-flex align-items-center gap-2">
                        <i data-lucide="graduation-cap" class="text-success"></i>
                        Education & Qualifications
                    </h3>
                    <div class="timeline position-relative ps-4" style="border-left: 2px solid rgba(255,255,255,0.1);">
                        @foreach ($educations as $edu)
                            <div class="mb-4 position-relative">
                                <div class="position-absolute rounded-circle bg-primary" style="width: 10px; height: 10px; left: -21px; top: 6px;"></div>
                                <h5 class="fw-bold mb-1">{{ $edu->degree }}</h5>
                                <div class="text-primary small fw-semibold mb-1">{{ $edu->institution }}</div>
                                <div class="text-secondary small mb-2">
                                    {{ $edu->start_date ? $edu->start_date->format('Y') : '' }} - 
                                    {{ $edu->end_date ? $edu->end_date->format('Y') : 'Present' }}
                                </div>
                                @if ($edu->description)
                                    <p class="text-secondary small mb-0">{{ $edu->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
