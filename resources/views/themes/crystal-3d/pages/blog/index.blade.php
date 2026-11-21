@extends('themes.crystal-3d.layouts.app')

@section('title', 'Articles & Technical Insights | Md. Alif Ahmed')
@section('meta_description', 'Architectural deep dives, custom Laravel engineering, courier API integrations, and server-side tracking insights.')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <span class="section-tag">// Engineering Articles</span>
        <h1 class="display-4 fw-bold mb-3">Technical Insights & Systems Design</h1>
        <p class="lead text-secondary mx-auto" style="max-width: 680px;">
            Documenting architectural patterns, e-commerce integrations, Meta Conversion API implementations, and performance benchmarks.
        </p>
    </div>

    <!-- Category Filter Pills -->
    @if ($categories->isNotEmpty())
        <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
            <a href="{{ route('blog.index') }}" class="btn btn-sm {{ !request('category') ? 'btn-emerald' : 'btn-outline-secondary' }}">
                All Topics
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" class="btn btn-sm {{ request('category') === $cat->slug ? 'btn-emerald' : 'btn-outline-secondary' }}">
                    {{ $cat->name }} ({{ $cat->posts_count }})
                </a>
            @endforeach
        </div>
    @endif

    <!-- Articles Grid -->
    <div class="row g-4">
        @forelse ($posts as $post)
            <div class="col-md-6 col-lg-4">
                <article class="crystal-surface h-100 p-4 crystal-card-hover d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="badge bg-secondary-subtle text-secondary small">
                            {{ $post->category?->name ?? 'Article' }}
                        </span>
                        <span class="text-secondary small font-monospace" style="font-size: 11px;">
                            <i data-lucide="clock" style="width: 12px; height: 12px; display: inline;"></i>
                            {{ $post->reading_time }} min read
                        </span>
                    </div>

                    <h2 class="h5 fw-bold mb-2">
                        <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-light">
                            {{ $post->title }}
                        </a>
                    </h2>

                    <p class="text-secondary small mb-3 flex-grow-1 leading-relaxed">
                        {{ $post->summary ?: Str::limit(strip_tags($post->content), 120) }}
                    </p>

                    <div class="pt-3 border-top mt-auto d-flex justify-content-between align-items-center" style="border-color: var(--theme-border) !important;">
                        <small class="text-secondary">{{ $post->published_at ? $post->published_at->format('M d, Y') : '' }}</small>
                        <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-sm btn-outline-emerald py-1 px-3">
                            Read Article &rarr;
                        </a>
                    </div>
                </article>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-secondary">
                <i data-lucide="newspaper" class="mb-2" style="width: 36px; height: 36px;"></i>
                <p class="mb-0">No articles published in this category yet.</p>
            </div>
        @endforelse
    </div>

    @if ($posts->hasPages())
        <div class="d-flex justify-content-center mt-5">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
