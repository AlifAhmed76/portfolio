@props(['blocks' => []])

@if (is_array($blocks) && (isset($blocks['html']) || (isset($blocks['mode']) && $blocks['mode'] === 'grapesjs')))
    @if (!empty($blocks['css']))
        <style>
            {!! $blocks['css'] !!}
        </style>
    @endif
    <div class="grapesjs-page-content">
        {!! $blocks['html'] ?? '' !!}
    </div>
@elseif (!empty($blocks) && is_array($blocks))
    <div class="page-builder-content">
        @foreach ($blocks as $block)
            @if (!empty($block['enabled']))
                @php
                    $type = $block['type'] ?? '';
                    $settings = $block['settings'] ?? [];
                @endphp

                @switch($type)
                    @case('hero')
                        <x-blocks.hero :settings="$settings" />
                        @break
                    @case('about')
                        <x-blocks.about :settings="$settings" />
                        @break
                    @case('skills')
                        <x-blocks.skills :settings="$settings" />
                        @break
                    @case('projects')
                        <x-blocks.projects :settings="$settings" />
                        @break
                    @case('services')
                        <x-blocks.services :settings="$settings" />
                        @break
                    @case('experience')
                        <x-blocks.experience :settings="$settings" />
                        @break
                    @case('contact')
                        <x-blocks.contact :settings="$settings" />
                        @break
                    @case('custom_html')
                        <x-blocks.custom-html :settings="$settings" />
                        @break
                @endswitch
            @endif
        @endforeach
    </div>
@endif
