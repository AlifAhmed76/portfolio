@extends('themes.editorial-brutalist.layouts.app')

@section('title', ($page->title ?? 'Page') . ' | Md. Alif Ahmed')

@section('content')
<div class="container px-4 py-5" style="max-width: 900px;">
    <div class="mb-4">
        <a href="{{ url('/') }}" class="editorial-nav-link p-0">← Return Home</a>
    </div>

    <article class="p-4 p-md-5 brutalist-border" style="background: var(--surface-noir);">
        <h1 class="display-4 font-display text-uppercase fw-bold mb-4">{{ $page->title }}</h1>
        <div class="content-body text-secondary leading-relaxed">
            {!! $page->content ?? '' !!}
        </div>
    </article>
</div>
@endsection
