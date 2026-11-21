@props(['settings' => []])
@php
    $title = $settings['title'] ?? 'About Me';
    $subtitle = $settings['subtitle'] ?? 'Professional Background & Focus';
    $bio = $settings['bio'] ?? '';
    $highlights = $settings['highlights'] ?? '';
    if (is_string($highlights)) {
        $highlightsArray = array_filter(array_map('trim', explode(',', $highlights)));
    } else {
        $highlightsArray = (array) $highlights;
    }
@endphp

<section class="block-about py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="mb-4 text-center">
                    <span class="text-uppercase text-success small fw-bold tracking-wider">{{ $subtitle }}</span>
                    <h2 class="h1 fw-bold mt-1">{{ $title }}</h2>
                </div>
                <div class="card p-4 p-md-5 border-0 shadow-sm rounded-4" style="background: rgba(255,255,255,0.03); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.08) !important;">
                    <div class="fs-5 text-secondary mb-4 leading-relaxed">
                        {!! nl2br(e($bio)) !!}
                    </div>
                    @if (!empty($highlightsArray))
                        <div class="border-top pt-4 mt-2" style="border-color: rgba(255,255,255,0.08) !important;">
                            <h6 class="text-uppercase text-secondary small fw-bold mb-3">Key Highlights</h6>
                            <div class="row g-3">
                                @foreach ($highlightsArray as $highlight)
                                    <div class="col-sm-6 col-md-4">
                                        <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05);">
                                            <i data-lucide="check-circle" class="text-success mb-2" style="width: 18px; height: 18px;"></i>
                                            <div class="fw-semibold small">{{ $highlight }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
