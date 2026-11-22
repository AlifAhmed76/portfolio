@extends('themes.' . ($activeTheme->slug ?? 'crystal-3d') . '.layouts.app')

@section('title', ($post->meta_title ?: $post->title) . ' | Md. Alif Ahmed')
@section('meta_description', $post->meta_description ?: ($post->summary ?: Str::limit(strip_tags($post->content), 150)))

@push('styles')
<style>
    :root {
        --blog-accent: {{ $themeTokens['accent_color'] ?? '#10b981' }};
    }
    #readingProgress {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        background: var(--blog-accent);
        width: 0%;
        z-index: 99999;
        transition: width 0.1s linear;
    }
    .article-container {
        max-width: 820px;
        margin: 0 auto;
    }
    .article-surface {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
    }
    /* Markdown Typography Styling */
    .article-markdown-body {
        font-size: 1.125rem;
        line-height: 1.85;
        color: inherit;
    }
    .article-markdown-body h2 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
        color: inherit;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        padding-bottom: 0.5rem;
    }
    .article-markdown-body h3 {
        font-size: 1.35rem;
        font-weight: 600;
        margin-top: 2rem;
        margin-bottom: 0.75rem;
        color: inherit;
    }
    .article-markdown-body p {
        margin-bottom: 1.5rem;
        opacity: 0.92;
    }
    .article-markdown-body ul, .article-markdown-body ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }
    .article-markdown-body li {
        margin-bottom: 0.5rem;
        opacity: 0.92;
    }
    .article-markdown-body blockquote {
        border-left: 4px solid var(--blog-accent);
        background: rgba(16, 185, 129, 0.06);
        padding: 1.25rem 1.75rem;
        border-radius: 0 12px 12px 0;
        font-style: italic;
        margin: 2rem 0;
    }
    .article-markdown-body blockquote p:last-child {
        margin-bottom: 0;
    }
    .article-markdown-body pre {
        background: #0d1117 !important;
        color: #e6edf3 !important;
        padding: 1.25rem 1.5rem;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.12);
        overflow-x: auto;
        font-family: 'JetBrains Mono', 'Fira Code', 'Courier New', monospace;
        font-size: 0.92rem;
        line-height: 1.6;
        margin: 1.75rem 0;
        position: relative;
    }
    .article-markdown-body code {
        font-family: 'JetBrains Mono', 'Fira Code', 'Courier New', monospace;
        font-size: 0.88em;
        padding: 2px 6px;
        border-radius: 6px;
        background: rgba(125, 125, 125, 0.15);
        color: inherit;
    }
    .article-markdown-body pre code {
        background: transparent !important;
        padding: 0 !important;
        color: inherit !important;
    }
    .article-markdown-body img {
        max-width: 100%;
        height: auto;
        border-radius: 12px;
        margin: 2rem 0;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .share-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        padding: 6px 14px;
        border-radius: 9999px;
        border: 1px solid rgba(255, 255, 255, 0.15);
        color: inherit;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.03);
        transition: all 0.2s ease;
    }
    .share-btn:hover {
        border-color: var(--blog-accent);
        color: var(--blog-accent);
        background: rgba(16, 185, 129, 0.08);
    }
</style>
@endpush

@section('content')
<!-- Scroll Reading Progress Bar -->
<div id="readingProgress"></div>

<div class="container py-5">
    <div class="article-container">

        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb small">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-secondary text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-secondary text-decoration-none">Articles</a></li>
                @if ($post->category)
                    <li class="breadcrumb-item"><a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" class="text-secondary text-decoration-none">{{ $post->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active text-truncate" style="max-width: 250px;" aria-current="page">{{ $post->title }}</li>
            </ol>
        </nav>

        <!-- Article Card Wrapper -->
        <article class="article-surface p-4 p-md-5 mb-5 shadow-sm">
            
            <!-- Metadata Header -->
            <header class="mb-4 pb-4 border-bottom" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                    @if ($post->category)
                        <span class="badge" style="background: rgba(16, 185, 129, 0.15); color: var(--blog-accent); border: 1px solid rgba(16, 185, 129, 0.3);">
                            {{ $post->category->name }}
                        </span>
                    @endif
                    <span class="small text-secondary font-monospace">
                        <i data-lucide="clock" style="width: 14px; height: 14px; display: inline;"></i>
                        {{ $post->reading_time }} min read
                    </span>
                    <span class="small text-secondary">
                        Published on {{ $post->published_at ? $post->published_at->format('F d, Y') : 'Draft' }}
                    </span>
                </div>

                <h1 class="display-5 fw-bold mb-4" style="letter-spacing: -0.02em; line-height: 1.2;">
                    {{ $post->title }}
                </h1>

                <!-- Author Row & Share Action -->
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                    <div class="d-flex align-items-center gap-3">
                        @if ($profile?->avatar || $profile?->profileImage)
                            <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name ?? 'Md. Alif Ahmed' }}" class="rounded-circle border" style="width: 44px; height: 44px; object-fit: cover;">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width: 44px; height: 44px; background: var(--blog-accent);">
                                AA
                            </div>
                        @endif
                        <div>
                            <div class="fw-bold">{{ $profile->name ?? 'Md. Alif Ahmed' }}</div>
                            <small class="text-secondary">{{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}</small>
                        </div>
                    </div>

                    <!-- Social Share Buttons -->
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="share-btn" onclick="copyArticleLink()" id="copyLinkBtn">
                            <i data-lucide="link" style="width: 14px; height: 14px;"></i>
                            <span id="copyLinkText">Share Link</span>
                        </button>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" class="share-btn" title="Share on X / Twitter">
                            <i data-lucide="twitter" style="width: 14px; height: 14px;"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" target="_blank" class="share-btn" title="Share on LinkedIn">
                            <i data-lucide="linkedin" style="width: 14px; height: 14px;"></i>
                        </a>
                    </div>
                </div>
            </header>

            <!-- Lead Excerpt Callout -->
            @if ($post->summary)
                <div class="p-4 mb-4 rounded-3" style="background: rgba(16, 185, 129, 0.05); border-left: 4px solid var(--blog-accent);">
                    <p class="lead mb-0 text-secondary" style="font-size: 1.15rem; line-height: 1.7;">
                        {{ $post->summary }}
                    </p>
                </div>
            @endif

            <!-- Article Body (Markdown Parsed with Code Blocks & Headings) -->
            <div class="article-markdown-body mb-5">
                {!! $post->parsed_content ?? Str::markdown($post->content) !!}
            </div>

            <!-- Tags Footer -->
            @if ($post->tags->isNotEmpty())
                <div class="pt-4 border-top d-flex flex-wrap align-items-center gap-2" style="border-color: rgba(255, 255, 255, 0.08) !important;">
                    <span class="text-secondary small me-1">Tags:</span>
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" class="badge bg-secondary-subtle text-secondary text-decoration-none px-3 py-2">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif
        </article>

        <!-- Author Bio Card -->
        <div class="article-surface p-4 p-md-5 mb-5 d-flex flex-column flex-sm-row align-items-center gap-4">
            @if ($profile?->avatar || $profile?->profileImage)
                <img src="{{ $profile->avatar?->url ?? $profile->profileImage?->url }}" alt="{{ $profile->name ?? 'Md. Alif Ahmed' }}" class="rounded-circle border" style="width: 80px; height: 80px; object-fit: cover; flex-shrink: 0;">
            @else
                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold display-6" style="width: 80px; height: 80px; background: var(--blog-accent); flex-shrink: 0;">
                    AA
                </div>
            @endif
            <div class="text-center text-sm-start flex-grow-1">
                <h4 class="h5 fw-bold mb-1">Written by {{ $profile->name ?? 'Md. Alif Ahmed' }}</h4>
                <div class="small fw-semibold mb-2" style="color: var(--blog-accent);">
                    {{ $profile->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}
                </div>
                <p class="small text-secondary mb-3 leading-relaxed">
                    {{ $profile->bio ?? 'Dedicated Web Developer and Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.' }}
                </p>
                <div class="d-flex flex-wrap justify-content-center justify-content-sm-start gap-2">
                    <a href="{{ url('/#contact') }}" class="btn btn-sm btn-outline-secondary">
                        Initiate Collaboration
                    </a>
                    <a href="{{ route('blog.index') }}" class="btn btn-sm btn-outline-secondary">
                        ← Explore More Articles
                    </a>
                </div>
            </div>
        </div>

        <!-- Related Articles Section -->
        @if ($relatedPosts->isNotEmpty())
            <div class="mb-5">
                <h3 class="h4 fw-bold mb-4">Related Engineering Deep Dives</h3>
                <div class="row g-4">
                    @foreach ($relatedPosts as $rel)
                        <div class="col-md-4">
                            <article class="article-surface p-4 h-100 d-flex flex-column">
                                <span class="badge bg-secondary-subtle text-secondary small align-self-start mb-2">
                                    {{ $rel->category?->name ?? 'Technical' }}
                                </span>
                                <h5 class="h6 fw-bold mb-2 flex-grow-1">
                                    <a href="{{ route('blog.show', $rel->slug) }}" class="article-title-link">
                                        {{ $rel->title }}
                                    </a>
                                </h5>
                                <div class="small text-secondary font-monospace mt-2">
                                    {{ $rel->reading_time }} min read
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>

<!-- Structured Data (JSON-LD Schema for SEO) -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BlogPosting",
  "headline": "{{ addslashes($post->title) }}",
  "description": "{{ addslashes($post->summary ?: Str::limit(strip_tags($post->content), 150)) }}",
  "datePublished": "{{ $post->published_at ? $post->published_at->toIso8601String() : '' }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": "{{ addslashes($profile->name ?? 'Md. Alif Ahmed') }}"
  }
}
</script>

@push('scripts')
<script>
    // Reading Progress Bar
    window.addEventListener('scroll', () => {
        const winScroll = document.documentElement.scrollTop || document.body.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        const bar = document.getElementById('readingProgress');
        if (bar) bar.style.width = scrolled + '%';
    });

    // Copy Article Link to Clipboard
    function copyArticleLink() {
        navigator.clipboard.writeText(window.location.href).then(() => {
            const btn = document.getElementById('copyLinkText');
            if (btn) {
                const originalText = btn.innerText;
                btn.innerText = 'Copied!';
                setTimeout(() => { btn.innerText = originalText; }, 2500);
            }
        });
    }
</script>
@endpush
@endsection
