@extends('themes.developer-garden.layouts.app')

@section('title', ($page->title ?? 'Page') . ' | Md. Alif Ahmed')

@section('content')
<div class="container py-5" style="max-width: 820px;">
    <div class="mb-4">
        <a href="{{ url('/') }}" class="garden-link small font-mono d-inline-flex align-items-center gap-1">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            <span>back to garden</span>
        </a>
    </div>

    <article class="garden-card p-4 p-md-5">
        <h1 class="display-5 fw-bold mb-4 font-mono">{{ $page->title }}</h1>
        <div class="content-body text-secondary leading-relaxed">
            {!! $page->content ?? '' !!}
        </div>
    </article>
</div>
@endsection
