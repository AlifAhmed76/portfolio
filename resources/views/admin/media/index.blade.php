@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-2 border-bottom border-secondary-subtle">
        <div>
            <h1 class="h3 fw-bold mb-1">Media Library</h1>
            <p class="text-secondary small mb-0">Centralized storage for portraits, avatars, project covers, documents, and assets.</p>
        </div>
        <div>
            <button class="btn btn-emerald" type="button" data-bs-toggle="collapse" data-bs-target="#uploadCollapse">
                <i data-lucide="upload" class="me-1" style="width: 16px; height: 16px;"></i> Upload Media
            </button>
        </div>
    </div>

    <!-- Upload Box (Collapsible) -->
    <div class="collapse mb-4" id="uploadCollapse">
        <div class="admin-card p-4">
            <h5 class="fw-bold mb-3">Upload New File</h5>
            <form action="{{ route('admin.media.upload') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <div class="col-md-7">
                        <label for="file" class="form-label small text-secondary">Select File (Images: JPG, PNG, WebP, SVG | Docs: PDF, DOCX, TXT - Max 20MB)</label>
                        <input type="file" name="file" id="file" class="form-control" required>
                    </div>
                    <div class="col-md-5">
                        <label for="alt_text" class="form-label small text-secondary">Alt Text / Description (Optional)</label>
                        <input type="text" name="alt_text" id="alt_text" class="form-control" placeholder="Descriptive alt text for accessibility">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-emerald">
                        <i data-lucide="check" class="me-1" style="width: 16px; height: 16px;"></i> Upload Now
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Filter and Search Bar -->
    <div class="admin-card p-3 mb-4">
        <form method="GET" action="{{ route('admin.media.index') }}" class="row g-2 align-items-center">
            <div class="col-sm-4 col-md-3">
                <select name="type" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All File Types</option>
                    <option value="image" {{ request('type') === 'image' ? 'selected' : '' }}>Images Only</option>
                    <option value="document" {{ request('type') === 'document' ? 'selected' : '' }}>Documents Only</option>
                </select>
            </div>
            <div class="col-sm-8 col-md-5">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Search by filename or alt text..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-secondary">
                        <i data-lucide="search" style="width: 14px; height: 14px;"></i>
                    </button>
                </div>
            </div>
            @if (request()->hasAny(['type', 'search']))
                <div class="col-auto">
                    <a href="{{ route('admin.media.index') }}" class="btn btn-sm btn-link text-secondary">Clear Filters</a>
                </div>
            @endif
        </form>
    </div>

    <!-- Media Grid -->
    <div class="row g-3 mb-4">
        @forelse ($mediaItems as $media)
            <div class="col-6 col-sm-4 col-md-3 col-xl-2">
                <div class="admin-card h-100 d-flex flex-column overflow-hidden position-relative">
                    <div class="ratio ratio-1x1 bg-body-secondary d-flex align-items-center justify-content-center overflow-hidden">
                        @if ($media->isImage())
                            <img src="{{ $media->url }}" alt="{{ $media->alt_text }}" class="object-fit-cover w-100 h-100" loading="lazy">
                        @else
                            <div class="d-flex flex-column align-items-center justify-content-center text-secondary">
                                <i data-lucide="file-text" style="width: 36px; height: 36px;"></i>
                                <span class="small mt-1 text-uppercase">{{ pathinfo($media->path, PATHINFO_EXTENSION) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-2 d-flex flex-column flex-grow-1">
                        <small class="fw-semibold text-truncate mb-1" title="{{ $media->original_name }}">{{ $media->original_name }}</small>
                        <div class="text-muted small mt-auto d-flex justify-content-between align-items-center">
                            <span>{{ round($media->size / 1024) }} KB</span>
                            <div class="d-flex gap-1">
                                <button type="button" class="btn btn-xs btn-outline-secondary p-1" title="Copy URL" onclick="navigator.clipboard.writeText('{{ $media->url }}'); alert('Media URL copied to clipboard!');">
                                    <i data-lucide="copy" style="width: 12px; height: 12px;"></i>
                                </button>
                                <form action="{{ route('admin.media.destroy', $media) }}" method="POST" onsubmit="return confirm('Delete this media item?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-outline-danger p-1" title="Delete">
                                        <i data-lucide="trash-2" style="width: 12px; height: 12px;"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="admin-card p-5 text-center text-secondary">
                    <i data-lucide="images" class="mb-2" style="width: 48px; height: 48px; opacity: 0.5;"></i>
                    <h5>No Media Found</h5>
                    <p class="small mb-0">Upload portraits, project covers, or resume documents above to populate your library.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div>
        {{ $mediaItems->links() }}
    </div>
</div>
@endsection
