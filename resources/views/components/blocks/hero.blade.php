@props(['settings' => []])
@php
    $badge = $settings['badge'] ?? 'Available for Technical Projects';
    $headline = $settings['headline'] ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist';
    $subheadline = $settings['subheadline'] ?? 'Engineering resilient architectures, full-stack systems, and enterprise web solutions.';
    $ctaPrimaryLabel = $settings['cta_primary_label'] ?? 'View Projects';
    $ctaPrimaryUrl = $settings['cta_primary_url'] ?? '#projects';
    $ctaSecondaryLabel = $settings['cta_secondary_label'] ?? 'Get In Touch';
    $ctaSecondaryUrl = $settings['cta_secondary_url'] ?? '#contact';
@endphp

<section class="block-hero py-5">
    <div class="container py-lg-4">
        <div class="row align-items-center">
            <div class="col-lg-10 mx-auto text-center">
                @if ($badge)
                    <div class="mb-3">
                        <span class="badge px-3 py-2 rounded-pill border" style="background: rgba(16, 185, 129, 0.12); color: #10b981; border-color: rgba(16, 185, 129, 0.25) !important;">
                            <span class="d-inline-block rounded-circle bg-success me-1" style="width: 8px; height: 8px;"></span>
                            {{ $badge }}
                        </span>
                    </div>
                @endif
                <h1 class="display-4 fw-bold mb-3 tracking-tight">{{ $headline }}</h1>
                <p class="lead text-secondary mb-4 mx-auto" style="max-width: 720px;">{{ $subheadline }}</p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @if ($ctaPrimaryLabel)
                        <a href="{{ $ctaPrimaryUrl }}" class="btn btn-primary px-4 py-2 fw-semibold">
                            {{ $ctaPrimaryLabel }}
                        </a>
                    @endif
                    @if ($ctaSecondaryLabel)
                        <a href="{{ $ctaSecondaryUrl }}" class="btn btn-outline-secondary px-4 py-2 fw-semibold">
                            {{ $ctaSecondaryLabel }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
