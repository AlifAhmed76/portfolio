@extends('themes.nordic-minimal.layouts.app')

@section('title', ($page->title ?? 'Page') . ' | Md. Alif Ahmed')

@section('content')
<div class="container py-5" style="max-width: 880px;">
    <div class="mb-4">
        <a href="{{ url('/') }}" class="small text-muted text-decoration-none">← Return Home</a>
    </div>

    <article class="p-4 p-md-5 border rounded-3" style="background: var(--nordic-surface);">
        <h1 class="display-4 font-serif fw-bold mb-4">{{ $page->title }}</h1>
        <div class="content-body text-muted leading-relaxed">
            {!! $page->content ?? '' !!}
        </div>
    </article>
</div>
@endsection
