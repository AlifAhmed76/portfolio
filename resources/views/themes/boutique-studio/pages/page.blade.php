@extends('themes.boutique-studio.layouts.app')

@section('title', ($page->title ?? 'Page') . ' | Md. Alif Ahmed')

@section('content')
<div class="container py-5" style="max-width: 900px;">
    <div class="mb-4">
        <a href="{{ url('/') }}" class="text-secondary text-decoration-none small d-inline-flex align-items-center gap-1">
            <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            <span>Back to Studio</span>
        </a>
    </div>

    <article class="studio-card p-4 p-md-5">
        <h1 class="display-5 font-display fw-bold text-white mb-4">{{ $page->title }}</h1>
        <div class="content-body text-secondary leading-relaxed">
            {!! $page->content ?? '' !!}
        </div>
    </article>
</div>
@endsection
