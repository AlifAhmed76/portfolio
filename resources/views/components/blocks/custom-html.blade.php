@props(['settings' => []])
@php
    $html = $settings['html'] ?? '';
@endphp

<section class="block-custom-html py-4">
    <div class="container">
        {!! $html !!}
    </div>
</section>
