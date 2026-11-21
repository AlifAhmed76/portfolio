@extends('layouts.admin')

@section('title', 'Services & Solutions')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-2 border-bottom border-secondary-subtle">
        <div>
            <h1 class="h3 fw-bold mb-1">Services & Solutions</h1>
            <p class="text-secondary small mb-0">Manage technical offerings, consulting capabilities, and client solutions.</p>
        </div>
        <div>
            <button class="btn btn-emerald" type="button" data-bs-toggle="modal" data-bs-target="#addServiceModal">
                <i data-lucide="plus" class="me-1" style="width: 16px; height: 16px;"></i> Add New Service
            </button>
        </div>
    </div>

    <!-- Services Table -->
    <div class="admin-card p-0 overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="text-secondary bg-body-tertiary">
                    <tr>
                        <th style="width: 50px;">Icon</th>
                        <th>Service Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td>
                                <div class="rounded p-2 bg-success-subtle text-success d-inline-flex">
                                    <i data-lucide="{{ $service->icon ?: 'sparkles' }}" style="width: 18px; height: 18px;"></i>
                                </div>
                            </td>
                            <td class="fw-bold">{{ $service->title }}</td>
                            <td class="text-secondary">{{ Str::limit($service->description, 100) }}</td>
                            <td>
                                @if ($service->is_enabled)
                                    <span class="badge bg-success-subtle text-success">Active</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">Hidden</span>
                                @endif
                            </td>
                            <td>{{ $service->sort_order }}</td>
                            <td class="text-end">
                                <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete service {{ $service->title }}?');">
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
                            <td colspan="6" class="text-center py-5 text-secondary">
                                <i data-lucide="sparkles" class="mb-2" style="width: 40px; height: 40px; opacity: 0.5;"></i>
                                <p class="mb-2">No services registered yet.</p>
                                <button class="btn btn-sm btn-emerald" type="button" data-bs-toggle="modal" data-bs-target="#addServiceModal">Create Service</button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Service Modal -->
<div class="modal fade" id="addServiceModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.services.store') }}" method="POST" class="modal-content admin-card">
            @csrf
            <div class="modal-header border-secondary-subtle">
                <h5 class="modal-title h6 fw-bold">Add Service Offering</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="service_title" class="form-label small text-secondary">Service Title</label>
                    <input type="text" name="title" id="service_title" class="form-control" required placeholder="e.g. Custom Laravel Web Applications">
                </div>
                <div class="mb-3">
                    <label for="service_desc" class="form-label small text-secondary">Description</label>
                    <textarea name="description" id="service_desc" rows="3" class="form-control" placeholder="Architecting secure, performant web applications with Laravel, REST APIs, and database optimization..."></textarea>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label for="service_icon" class="form-label small text-secondary">Lucide Icon</label>
                        <input type="text" name="icon" id="service_icon" class="form-control" value="sparkles" placeholder="code, layout, shopping-bag...">
                    </div>
                    <div class="col-6">
                        <label for="service_sort" class="form-label small text-secondary">Sort Order</label>
                        <input type="number" name="sort_order" id="service_sort" class="form-control" value="0">
                    </div>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_enabled" id="service_enabled" value="1" checked>
                    <label class="form-check-label small" for="service_enabled">Visible on Public Site</label>
                </div>
            </div>
            <div class="modal-footer border-secondary-subtle">
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-sm btn-emerald">Add Service</button>
            </div>
        </form>
    </div>
</div>
@endsection
