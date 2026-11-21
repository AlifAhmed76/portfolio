@props(['settings' => []])
@php
    $title = $settings['title'] ?? 'Services & Solutions';
    $subtitle = $settings['subtitle'] ?? 'Full Lifecycle Architecture & Delivery';
    $services = \App\Models\Service::active()->orderBy('sort_order')->get();
@endphp

<section class="block-services py-5">
    <div class="container">
        <div class="text-center mb-5">
            <span class="text-uppercase text-success small fw-bold tracking-wider">{{ $subtitle }}</span>
            <h2 class="h1 fw-bold mt-1">{{ $title }}</h2>
        </div>
        <div class="row g-4">
            @forelse ($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 p-4 border-0 rounded-4 shadow-sm" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08) !important;">
                        <div class="p-3 rounded-3 d-inline-block mb-3" style="background: rgba(16, 185, 129, 0.1); width: fit-content;">
                            <i data-lucide="{{ $service->icon ?? 'sparkles' }}" class="text-success" style="width: 24px; height: 24px;"></i>
                        </div>
                        <h4 class="h5 fw-bold mb-2">{{ $service->title }}</h4>
                        <p class="text-secondary small mb-3 flex-grow-1">{{ $service->description }}</p>
                        @if ($service->deliverables)
                            <div class="border-top pt-3 small text-secondary" style="border-color: rgba(255,255,255,0.08) !important;">
                                <strong class="text-light d-block mb-1">Deliverables:</strong>
                                {{ $service->deliverables }}
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-12 text-center text-secondary py-4">No services configured.</div>
            @endforelse
        </div>
    </div>
</section>
