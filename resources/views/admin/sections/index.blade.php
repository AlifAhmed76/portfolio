@extends('layouts.admin')

@section('title', 'Homepage Sections')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-2 border-bottom border-secondary-subtle">
        <div>
            <h1 class="h3 fw-bold mb-1">Homepage Section Management</h1>
            <p class="text-secondary small mb-0">Control the display order and visibility of all 11 homepage sections.</p>
        </div>
    </div>

    <div class="admin-card p-0 overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 small">
                <thead class="text-secondary bg-body-tertiary">
                    <tr>
                        <th style="width: 80px;">Order</th>
                        <th>Section Key</th>
                        <th>Display Title</th>
                        <th>Visibility</th>
                        <th class="text-end">Update</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sections as $section)
                        <tr>
                            <td>
                                <form action="{{ route('admin.sections.update', $section) }}" method="POST" id="form_order_{{ $section->id }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="title" value="{{ $section->title }}">
                                    <input type="hidden" name="is_enabled" value="{{ $section->is_enabled ? 1 : 0 }}">
                                    <input type="number" name="sort_order" class="form-control form-control-sm text-center" style="width: 65px;" value="{{ $section->sort_order }}" onchange="document.getElementById('form_order_{{ $section->id }}').submit()">
                                </form>
                            </td>
                            <td>
                                <code>{{ $section->section_key }}</code>
                            </td>
                            <td>
                                <form action="{{ route('admin.sections.update', $section) }}" method="POST" class="d-flex gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="sort_order" value="{{ $section->sort_order }}">
                                    <input type="hidden" name="is_enabled" value="{{ $section->is_enabled ? 1 : 0 }}">
                                    <input type="text" name="title" class="form-control form-control-sm" value="{{ $section->title }}">
                                    <button type="submit" class="btn btn-xs btn-outline-secondary" title="Save Title">
                                        <i data-lucide="check" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.sections.toggle', $section) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-link p-0 text-decoration-none">
                                        @if ($section->is_enabled)
                                            <span class="badge bg-success-subtle text-success">Enabled</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">Disabled</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="text-end">
                                <span class="text-muted small">Updated</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
