@extends('layouts.admin')

@section('title', 'Projects & Case Studies')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-2 border-bottom border-secondary-subtle">
        <div>
            <h1 class="h3 fw-bold mb-1">Projects & Case Studies</h1>
            <p class="text-secondary small mb-0">Manage technical portfolio projects, architectural case studies, live links, and outcomes.</p>
        </div>
        <div>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-emerald">
                <i data-lucide="plus" class="me-1" style="width: 16px; height: 16px;"></i> Create New Project
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="admin-card p-3 mb-4">
        <form method="GET" action="{{ route('admin.projects.index') }}" class="row g-2 align-items-center">
            <div class="col-sm-4 col-md-3">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published Only</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Drafts Only</option>
                </select>
            </div>
            <div class="col-sm-4 col-md-3">
                <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-4 col-md-4">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control" placeholder="Search projects by title..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-outline-secondary">
                        <i data-lucide="search" style="width: 14px; height: 14px;"></i>
                    </button>
                </div>
            </div>
            @if (request()->hasAny(['status', 'category', 'search']))
                <div class="col-auto">
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-link text-secondary">Clear</a>
                </div>
            @endif
        </form>
    </div>

    <!-- Projects Table -->
    <div class="admin-card p-0 overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="text-secondary bg-body-tertiary">
                    <tr>
                        <th style="width: 60px;">Cover</th>
                        <th>Title / Slug</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Featured</th>
                        <th>Order</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($projects as $project)
                        <tr>
                            <td>
                                @if ($project->coverImage)
                                    <img src="{{ $project->coverImage->url }}" alt="" class="rounded object-fit-cover" style="width: 44px; height: 36px;">
                                @else
                                    <div class="rounded bg-body-secondary d-flex align-items-center justify-content-center text-secondary" style="width: 44px; height: 36px;">
                                        <i data-lucide="image" style="width: 16px; height: 16px;"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $project->title }}</div>
                                <code class="small text-muted">/projects/{{ $project->slug }}</code>
                            </td>
                            <td>
                                <span class="badge bg-body-secondary text-body">
                                    {{ $project->category?->name ?? 'Uncategorized' }}
                                </span>
                            </td>
                            <td>
                                @if ($project->status === 'published')
                                    <span class="badge bg-success-subtle text-success">Published</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">Draft</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('admin.projects.featured', $project) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-link p-0 text-decoration-none" title="Toggle Featured">
                                        @if ($project->is_featured)
                                            <i data-lucide="star" class="text-warning fill-warning" style="width: 16px; height: 16px; fill: currentColor;"></i>
                                        @else
                                            <i data-lucide="star" class="text-secondary" style="width: 16px; height: 16px;"></i>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td>{{ $project->sort_order }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-outline-secondary me-1" title="Edit">
                                    <i data-lucide="edit-3" style="width: 14px; height: 14px;"></i>
                                </a>
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete project: {{ $project->title }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i data-lucide="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-secondary">
                                <i data-lucide="folder-git-2" class="mb-2" style="width: 40px; height: 40px; opacity: 0.5;"></i>
                                <p class="mb-2">No projects found in this workspace.</p>
                                <a href="{{ route('admin.projects.create') }}" class="btn btn-sm btn-emerald">Create First Project</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>{{ $projects->links() }}</div>
</div>
@endsection
