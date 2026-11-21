@extends('layouts.admin')

@section('title', 'Theme Studio')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-2 border-bottom border-secondary-subtle">
        <div>
            <h1 class="h3 fw-bold mb-1">Theme Studio</h1>
            <p class="text-secondary small mb-0">Select, preview, configure design tokens, and transactionally publish themes with full revision rollback.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success-subtle text-success border border-success-subtle p-2 px-3">
                Live Active Theme: <strong>{{ $activeTheme->name }}</strong> (v{{ $activeTheme->version }})
            </span>
        </div>
    </div>

    <div class="alert alert-info py-2 px-3 small d-flex align-items-center gap-2 mb-4">
        <i data-lucide="info" style="width: 18px; height: 18px;"></i>
        <span>Theme activation changes only the active theme resolver reference. Source files for other themes are never mutated or overwritten.</span>
    </div>

    <!-- Theme Catalog Cards -->
    <div class="row g-4 mb-5">
        @foreach ($themes as $theme)
            @php $isActive = ($activeTheme->id === $theme->id); @endphp
            <div class="col-md-6 col-xl-3">
                <div class="admin-card h-100 d-flex flex-column overflow-hidden border-2 {{ $isActive ? 'border-success' : '' }}">
                    <div class="p-4 bg-body-tertiary border-bottom border-secondary-subtle d-flex justify-content-between align-items-center">
                        <div>
                            <span class="badge bg-body-secondary text-body small">v{{ $theme->version }}</span>
                            <h4 class="h5 fw-bold mb-0 mt-1">{{ $theme->name }}</h4>
                        </div>
                        @if ($isActive)
                            <span class="badge bg-success text-white">Active</span>
                        @endif
                    </div>

                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <p class="small text-secondary mb-3 flex-grow-1">
                            {{ $theme->manifest_json['description'] ?? 'High performance portfolio theme.' }}
                        </p>

                        <div class="mb-3 small">
                            <span class="text-secondary">Palette Accent:</span>
                            <span class="badge" style="background-color: {{ $theme->manifest_json['tokens']['accent_color'] ?? '#10b981' }}; color: #fff;">
                                {{ $theme->manifest_json['tokens']['accent_color'] ?? '#10b981' }}
                            </span>
                        </div>

                        <div class="d-flex gap-2 mt-auto">
                            <a href="{{ route('admin.themes.preview', $theme) }}" target="_blank" class="btn btn-sm btn-outline-secondary w-50 d-flex align-items-center justify-content-center gap-1">
                                <i data-lucide="eye" style="width: 14px; height: 14px;"></i> Preview
                            </a>
                            @if (! $isActive)
                                <form action="{{ route('admin.themes.publish', $theme) }}" method="POST" class="w-50" onsubmit="return confirm('Activate and publish {{ $theme->name }} as the live theme?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-emerald w-100 d-flex align-items-center justify-content-center gap-1">
                                        <i data-lucide="check" style="width: 14px; height: 14px;"></i> Publish
                                    </button>
                                </form>
                            @else
                                <button type="button" class="btn btn-sm btn-outline-success w-50" disabled>Live</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Theme Revisions History -->
    <div class="admin-card p-4">
        <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
            <i data-lucide="history" class="text-warning"></i>
            <span>Theme Activation & Revision History</span>
        </h5>

        @if ($revisions->isEmpty())
            <div class="text-center py-4 text-secondary small">
                <p class="mb-0">No theme revisions recorded yet. Each time a theme is published, an immutable snapshot is recorded here.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="text-secondary bg-body-tertiary">
                        <tr>
                            <th>Rev #</th>
                            <th>Theme</th>
                            <th>Snapshot Tokens</th>
                            <th>Published By</th>
                            <th>Date</th>
                            <th class="text-end">Rollback</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($revisions as $rev)
                            <tr>
                                <td class="fw-bold">#{{ $rev->revision_number }}</td>
                                <td>
                                    <span class="badge bg-body-secondary text-body">{{ $rev->theme->name }}</span>
                                </td>
                                <td>
                                    <code class="text-muted">{{ json_encode($rev->settings_snapshot) }}</code>
                                </td>
                                <td>{{ $rev->creator?->name ?? 'System' }}</td>
                                <td class="text-secondary">{{ $rev->created_at->diffForHumans() }}</td>
                                <td class="text-end">
                                    <form action="{{ route('admin.themes.rollback', $rev) }}" method="POST" class="d-inline" onsubmit="return confirm('Rollback to revision #{{ $rev->revision_number }} ({{ $rev->theme->name }})?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-warning">
                                            Rollback
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
