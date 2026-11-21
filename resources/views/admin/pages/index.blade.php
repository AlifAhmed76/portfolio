@extends('layouts.admin')

@section('title', 'Page Manager')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1">Page Manager</h1>
        <p class="text-secondary mb-0">Create, compose, and publish dynamic landing pages and custom layouts.</p>
    </div>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
        <i data-lucide="plus"></i>
        <span>Create New Page</span>
    </a>
</div>

<div class="card border-0 shadow-sm" style="background: var(--admin-card-bg); border: 1px solid var(--admin-border) !important;">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0" style="color: var(--admin-text);">
            <thead class="table-dark" style="background: var(--admin-sidebar-bg);">
                <tr>
                    <th scope="col" class="ps-4">Title</th>
                    <th scope="col">Slug / Route</th>
                    <th scope="col">Template</th>
                    <th scope="col">Status</th>
                    <th scope="col">Revisions</th>
                    <th scope="col">Last Updated</th>
                    <th scope="col" class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pages as $page)
                    <tr>
                        <td class="ps-4">
                            <span class="fw-bold">{{ $page->title }}</span>
                        </td>
                        <td>
                            <code class="text-info">/{{ $page->slug }}</code>
                            @if ($page->isPublished())
                                <a href="{{ url('/' . $page->slug) }}" target="_blank" class="text-secondary ms-1" title="View live page">
                                    <i data-lucide="external-link" style="width: 14px; height: 14px;"></i>
                                </a>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary">
                                {{ $page->template ? $page->template->name : 'Blank Canvas' }}
                            </span>
                        </td>
                        <td>
                            @if ($page->status === 'published')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                    <i data-lucide="check" style="width: 12px; height: 12px;"></i> Published
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-1">
                                    <i data-lucide="clock" style="width: 12px; height: 12px;"></i> Draft
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-dark border border-secondary text-secondary">
                                {{ $page->revisions_count }} revisions
                            </span>
                        </td>
                        <td class="text-secondary small">
                            {{ $page->updated_at->diffForHumans() }}
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end align-items-center gap-2">
                                <a href="{{ route('admin.pages.builder', $page) }}" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center gap-1">
                                    <i data-lucide="layout-template" style="width: 14px; height: 14px;"></i>
                                    <span>Visual Builder</span>
                                </a>
                                <a href="{{ route('admin.pages.edit', $page) }}" class="btn btn-sm btn-outline-secondary" title="Page Settings">
                                    <i data-lucide="settings" style="width: 14px; height: 14px;"></i>
                                </a>
                                <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" onsubmit="return confirm('Permanently delete this page and all revisions?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Page">
                                        <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-secondary">
                            <i data-lucide="file-text" class="mb-2" style="width: 32px; height: 32px;"></i>
                            <p class="mb-2">No pages found in workspace.</p>
                            <a href="{{ route('admin.pages.create') }}" class="btn btn-sm btn-primary">Create Your First Page</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if ($pages->hasPages())
        <div class="p-3 border-top" style="border-color: var(--admin-border) !important;">
            {{ $pages->links() }}
        </div>
    @endif
</div>
@endsection
