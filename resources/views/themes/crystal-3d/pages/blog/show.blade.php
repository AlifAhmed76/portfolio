@extends('themes.crystal-3d.layouts.app')

@section('title', ($post->meta_title ?: $post->title) . ' | Md. Alif Ahmed')
@section('meta_description', $post->meta_description ?: ($post->summary ?: Str::limit(strip_tags($post->content), 150)))

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <!-- Breadcrumbs -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb small">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-secondary text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-secondary text-decoration-none">Articles</a></li>
                    <li class="breadcrumb-item active text-light" aria-current="page">{{ Str::limit($post->title, 40) }}</li>
                </ol>
            </nav>

            <article class="crystal-surface p-4 p-md-5 mb-5">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                    @if ($post->category)
                        <span class="badge bg-emerald-subtle text-emerald border border-emerald-subtle">
                            {{ $post->category->name }}
                        </span>
                    @endif
                    <span class="text-secondary small font-monospace">
                        <i data-lucide="clock" style="width: 14px; height: 14px; display: inline;"></i>
                        {{ $post->reading_time }} min read
                    </span>
                    <span class="text-secondary small">
                        Published on {{ $post->published_at ? $post->published_at->format('F d, Y') : 'Draft' }}
                    </span>
                </div>

                <h1 class="display-5 fw-bold mb-4 tracking-tight">{{ $post->title }}</h1>

                <div class="d-flex align-items-center gap-3 py-3 border-top border-bottom mb-4" style="border-color: var(--theme-border) !important;">
                    <div class="d-inline-block rounded-circle bg-emerald text-dark fw-bold text-center" style="width: 40px; height: 40px; line-height: 40px;">
                        AA
                    </div>
                    <div>
                        <div class="fw-bold text-light">Md. Alif Ahmed</div>
                        <small class="text-secondary">Web Developer | Technical Project Lead | E-commerce Solutions Specialist</small>
                    </div>
                </div>

                @if ($post->summary)
                    <p class="lead text-secondary mb-4 fst-italic">
                        {{ $post->summary }}
                    </p>
                @endif

                <div class="article-body text-light leading-relaxed fs-6 mb-5" style="line-height: 1.8;">
                    {!! nl2br(e($post->content)) !!}
                </div>

                @if ($post->tags->isNotEmpty())
                    <div class="pt-4 border-top" style="border-color: var(--theme-border) !important;">
                        <span class="text-secondary small me-2">Filed under:</span>
                        @foreach ($post->tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" class="badge bg-dark border border-secondary text-secondary text-decoration-none me-1">
                                #{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </article>

            @if ($relatedPosts->isNotEmpty())
                <div class="mb-5">
                    <h3 class="h4 fw-bold mb-4">Related Engineering Articles</h3>
                    <div class="row g-3">
                        @foreach ($relatedPosts as $rel)
                            <div class="col-md-4">
                                <div class="crystal-surface p-3 h-100">
                                    <h5 class="h6 fw-bold mb-2">
                                        <a href="{{ route('blog.show', $rel->slug) }}" class="text-decoration-none text-light">
                                            {{ $rel->title }}
                                        </a>
                                    </h5>
                                    <small class="text-secondary">{{ $rel->published_at ? $rel->published_at->format('M d, Y') : '' }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Structured Data (JSON-LD) -->
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
    "name": "Md. Alif Ahmed",
    "jobTitle": "Web Developer | Technical Project Lead | E-commerce Solutions Specialist"
  },
  "publisher": {
    "@type": "Person",
    "name": "Md. Alif Ahmed"
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ url()->current() }}"
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "Home",
      "item": "{{ url('/') }}"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Articles",
      "item": "{{ route('blog.index') }}"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "{{ addslashes($post->title) }}",
      "item": "{{ url()->current() }}"
    }
  ]
}
</script>
@endsection
