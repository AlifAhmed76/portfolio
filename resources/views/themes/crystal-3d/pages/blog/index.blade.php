@extends('themes.' . ($activeTheme->slug ?? 'crystal-3d') . '.layouts.app')

@section('title', 'Technical Insights & Engineering Journal | ' . ($profile->name ?? 'Md. Alif Ahmed'))
@section('meta_description', 'Architectural deep dives, custom Laravel engineering, courier logistics API automations, Meta Conversion API implementations, and performance benchmarks.')

@push('styles')
<style>
    :root {
        --blog-accent: {{ $themeTokens['accent_color'] ?? '#10b981' }};
    }
    .blog-hero-badge {
        font-family: var(--font-mono, monospace);
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--blog-accent);
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.25);
        padding: 6px 16px;
        border-radius: 9999px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .blog-search-box {
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 12px;
        padding: 10px 16px;
        color: inherit;
        transition: all 0.2s ease;
    }
    .blog-search-box:focus-within {
        border-color: var(--blog-accent);
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
    }
    .blog-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 16px;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .blog-card:hover {
        transform: translateY(-4px);
        border-color: var(--blog-accent);
        box-shadow: 0 16px 32px -12px rgba(0, 0, 0, 0.35);
    }
    .blog-spotlight {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.04) 0%, rgba(255, 255, 255, 0.01) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        border-radius: 20px;
    }
    .blog-pill {
        font-size: 0.82rem;
        font-weight: 500;
        padding: 6px 14px;
        border-radius: 9999px;
        text-decoration: none;
        transition: all 0.2s ease;
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: inherit;
        opacity: 0.85;
    }
    .blog-pill:hover, .blog-pill.active {
        opacity: 1;
        background: var(--blog-accent);
        border-color: var(--blog-accent);
        color: #ffffff !important;
    }
    .article-title-link {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    .article-title-link:hover {
        color: var(--blog-accent) !important;
    }
</style>
@endpush

@section('content')
<div class="container py-5" style="max-width: 1140px;">

    <!-- Section 1: Journal Hero Banner -->
    <header class="text-center py-4 mb-5">
        <div class="blog-hero-badge mb-3">
            <i data-lucide="sparkles" style="width: 14px; height: 14px;"></i>
            <span>Engineering Journal &amp; Systems Design</span>
        </div>
        <h1 class="display-4 fw-bolder mb-3" style="letter-spacing: -0.03em;">
            Technical Insights &amp; Architecture
        </h1>
        <p class="lead text-secondary mx-auto mb-4" style="max-width: 720px; font-size: 1.15rem; line-height: 1.7;">
            Documenting resilient Laravel architectures, multi-carrier courier API automations, Meta Conversion API server-side telemetry, and sub-second performance benchmarks.
        </p>

        <!-- Search Form -->
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <form action="{{ route('blog.index') }}" method="GET" class="blog-search-box d-flex align-items-center gap-2">
                    @if (request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <i data-lucide="search" class="text-secondary" style="width: 18px; height: 18px; flex-shrink: 0;"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search articles, patterns, or tech..." class="form-control border-0 bg-transparent p-0 shadow-none" style="color: inherit;">
                    @if (request('q'))
                        <a href="{{ route('blog.index', array_filter(['category' => request('category')])) }}" class="text-secondary text-decoration-none small">
                            <i data-lucide="x" style="width: 16px; height: 16px;"></i>
                        </a>
                    @endif
                    <button type="submit" class="btn btn-sm btn-primary px-3 rounded-3" style="background: var(--blog-accent); border-color: var(--blog-accent); color: #fff;">
                        Search
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Section 2: Topic Filter Bar -->
    @if ($categories->isNotEmpty())
        <div class="d-flex flex-wrap justify-content-center align-items-center gap-2 mb-5">
            <a href="{{ route('blog.index', array_filter(['q' => request('q')])) }}" class="blog-pill {{ !request('category') ? 'active' : '' }}">
                All Topics
            </a>
            @foreach ($categories as $cat)
                <a href="{{ route('blog.index', array_filter(['category' => $cat->slug, 'q' => request('q')])) }}" class="blog-pill {{ request('category') === $cat->slug ? 'active' : '' }}">
                    {{ $cat->name }} <span class="opacity-75">({{ $cat->posts_count }})</span>
                </a>
            @endforeach
        </div>
    @endif

    <!-- Section 3: Spotlight Featured Post (If on page 1 without filters) -->
    @if ($featuredPost && !request('q') && !request('category') && !request('tag'))
        <section class="mb-5 pb-3">
            <div class="blog-spotlight p-4 p-md-5">
                <div class="row align-items-center g-4">
                    <div class="col-lg-5">
                        <div class="overflow-hidden rounded-3 border" style="height: 240px; background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.1) !important;">
                            @if ($featuredPost->coverImage)
                                <img src="{{ $featuredPost->coverImage->url }}" alt="{{ $featuredPost->title }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <div class="w-100 h-100 d-flex flex-column justify-content-between p-4" style="background: radial-gradient(circle at 80% 20%, rgba(16, 185, 129, 0.25), rgba(0,0,0,0.4));">
                                    <span class="badge align-self-start" style="background: var(--blog-accent); color: #fff;">
                                        {{ $featuredPost->category?->name ?? 'Featured Architecture' }}
                                    </span>
                                    <div>
                                        <div class="text-secondary small font-monospace">LATEST PUBLICATION</div>
                                        <div class="h5 fw-bold text-white mb-0">{{ $featuredPost->title }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: var(--blog-accent); border: 1px solid rgba(16, 185, 129, 0.3);">
                                ★ SPOTLIGHT DEEP DIVE
                            </span>
                            <span class="small text-secondary font-monospace">
                                <i data-lucide="clock" style="width: 13px; height: 13px; display: inline;"></i>
                                {{ $featuredPost->reading_time }} min read
                            </span>
                            <span class="small text-secondary">
                                {{ $featuredPost->published_at ? $featuredPost->published_at->format('M d, Y') : '' }}
                            </span>
                        </div>

                        <h2 class="display-6 fw-bold mb-3">
                            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="article-title-link">
                                {{ $featuredPost->title }}
                            </a>
                        </h2>

                        <p class="text-secondary mb-4 leading-relaxed" style="font-size: 1.05rem;">
                            {{ $featuredPost->summary ?: Str::limit(strip_tags($featuredPost->content), 180) }}
                        </p>

                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 pt-3 border-top" style="border-color: rgba(255,255,255,0.08) !important;">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold small" style="width: 32px; height: 32px; background: var(--blog-accent);">
                                    AA
                                </div>
                                <span class="small fw-semibold">{{ $profile->name ?? 'Md. Alif Ahmed' }}</span>
                            </div>
                            <a href="{{ route('blog.show', $featuredPost->slug) }}" class="btn btn-sm px-4 py-2 fw-semibold" style="background: var(--blog-accent); color: #fff;">
                                Read Technical Breakdown →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Section 4: Articles Grid -->
    <section>
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="h4 fw-bold mb-0">
                @if (request('q'))
                    Search Results for <span style="color: var(--blog-accent);">"{{ request('q') }}"</span>
                @elseif (request('category'))
                    Category: <span style="color: var(--blog-accent);">{{ $categories->firstWhere('slug', request('category'))->name ?? request('category') }}</span>
                @else
                    All Published Articles
                @endif
            </h3>
            <span class="small text-secondary">{{ $posts->total() }} {{ Str::plural('Article', $posts->total()) }}</span>
        </div>

        <div class="row g-4">
            @forelse ($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <article class="blog-card h-100 p-4 d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-secondary-subtle text-secondary small">
                                {{ $post->category?->name ?? 'Architecture' }}
                            </span>
                            <span class="text-secondary small font-monospace" style="font-size: 0.78rem;">
                                <i data-lucide="clock" style="width: 12px; height: 12px; display: inline;"></i>
                                {{ $post->reading_time }} min read
                            </span>
                        </div>

                        <h2 class="h5 fw-bold mb-3 leading-snug">
                            <a href="{{ route('blog.show', $post->slug) }}" class="article-title-link">
                                {{ $post->title }}
                            </a>
                        </h2>

                        <p class="text-secondary small mb-4 flex-grow-1 leading-relaxed" style="opacity: 0.9;">
                            {{ $post->summary ?: Str::limit(strip_tags($post->content), 130) }}
                        </p>

                        <div class="pt-3 border-top mt-auto d-flex justify-content-between align-items-center" style="border-color: rgba(255,255,255,0.08) !important;">
                            <div class="small text-secondary">
                                {{ $post->published_at ? $post->published_at->format('M d, Y') : '' }}
                            </div>
                            <a href="{{ route('blog.show', $post->slug) }}" class="small fw-semibold text-decoration-none d-inline-flex align-items-center gap-1" style="color: var(--blog-accent);">
                                <span>Read Article</span>
                                <i data-lucide="arrow-right" style="width: 14px; height: 14px;"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="p-5 blog-card mx-auto" style="max-width: 500px;">
                        <i data-lucide="newspaper" class="text-secondary mb-3" style="width: 48px; height: 48px;"></i>
                        <h4 class="h5 fw-bold mb-2">No Articles Found</h4>
                        <p class="small text-secondary mb-4">
                            @if (request('q'))
                                No engineering articles matched your search query "{{ request('q') }}".
                            @else
                                No articles have been published in this category yet.
                            @endif
                        </p>
                        <a href="{{ route('blog.index') }}" class="btn btn-sm btn-outline-secondary">
                            Reset Filters &amp; View All Articles
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($posts->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $posts->links() }}
            </div>
        @endif
    </section>

</div>
@endsection
