@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<div class="container-fluid p-0">
    <!-- Page Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-2 border-bottom border-secondary-subtle">
        <div>
            <h1 class="h3 fw-bold mb-1">System Overview</h1>
            <p class="text-secondary small mb-0">
                Workspace: <strong>{{ $stats['workspace_name'] }}</strong> • Portfolio Owner: <strong>{{ $stats['owner_name'] }}</strong>
            </p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-success-subtle text-success border border-success-subtle p-2 px-3 d-flex align-items-center gap-2">
                <span class="spinner-grow spinner-grow-sm text-success" style="width: 8px; height: 8px;" role="status"></span>
                <span>Active Theme: <strong>{{ strtoupper($stats['active_theme']) }}</strong></span>
            </span>
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="admin-card p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-secondary small text-uppercase fw-semibold">Published Projects</span>
                    <h3 class="fw-bold mb-0 mt-1">{{ $stats['published_projects_count'] }}</h3>
                    <small class="text-muted">{{ $stats['draft_projects_count'] }} drafts</small>
                </div>
                <div class="p-3 rounded-3 bg-primary-subtle text-primary">
                    <i data-lucide="folder-check" style="width: 24px; height: 24px;"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="admin-card p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-secondary small text-uppercase fw-semibold">Blog Posts</span>
                    <h3 class="fw-bold mb-0 mt-1">{{ $stats['posts_count'] }}</h3>
                    <small class="text-muted">Dynamic CMS</small>
                </div>
                <div class="p-3 rounded-3 bg-info-subtle text-info">
                    <i data-lucide="newspaper" style="width: 24px; height: 24px;"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="admin-card p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-secondary small text-uppercase fw-semibold">Inbox Messages</span>
                    <h3 class="fw-bold mb-0 mt-1">{{ $stats['unread_messages_count'] }}</h3>
                    <small class="text-muted">Unread inquiries</small>
                </div>
                <div class="p-3 rounded-3 bg-warning-subtle text-warning">
                    <i data-lucide="mail-unread" style="width: 24px; height: 24px;"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="admin-card p-3 d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-secondary small text-uppercase fw-semibold">Architecture</span>
                    <h5 class="fw-bold mb-0 mt-1 text-truncate" style="max-width: 140px;">Multi-Tenant</h5>
                    <small class="text-success">Scoped Server-Side</small>
                </div>
                <div class="p-3 rounded-3 bg-success-subtle text-success">
                    <i data-lucide="layers" style="width: 24px; height: 24px;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Dashboard Row -->
    <div class="row g-4 mb-4">
        <!-- Identity Summary Card -->
        <div class="col-lg-7">
            <div class="admin-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                        <i data-lucide="user" class="text-success"></i>
                        <span>Portfolio Identity</span>
                    </h5>
                    <span class="badge bg-secondary-subtle text-secondary">Phase 1 Configured</span>
                </div>

                <div class="p-3 rounded bg-body-tertiary mb-3 border border-secondary-subtle">
                    <div class="row g-2">
                        <div class="col-sm-4 text-secondary small">Owner Name:</div>
                        <div class="col-sm-8 fw-semibold">{{ $profile?->name ?? 'Md. Alif Ahmed' }}</div>
                        <div class="col-sm-4 text-secondary small">Title / Designation:</div>
                        <div class="col-sm-8 fw-semibold text-success">{{ $profile?->designation ?? 'Web Developer | Technical Project Lead | E-commerce Solutions Specialist' }}</div>
                        <div class="col-sm-4 text-secondary small">Headline:</div>
                        <div class="col-sm-8">{{ $profile?->headline ?? 'Building Digital Experiences. Engineering Business Solutions.' }}</div>
                    </div>
                </div>

                <div class="alert alert-info py-2 px-3 small d-flex align-items-center gap-2 mb-0">
                    <i data-lucide="info" style="width: 18px; height: 18px;"></i>
                    <span>All personal content is database-backed and dynamic. Complete CRUD management interface arrives in Phase 2.</span>
                </div>
            </div>
        </div>

        <!-- System Diagnostics Card -->
        <div class="col-lg-5">
            <div class="admin-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0 d-flex align-items-center gap-2">
                        <i data-lucide="server" class="text-primary"></i>
                        <span>System Health</span>
                    </h5>
                    <span class="badge bg-success-subtle text-success">Verified Healthy</span>
                </div>

                <ul class="list-group list-group-flush small">
                    <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                        <span class="text-secondary">PHP Version</span>
                        <span class="badge bg-body-secondary text-body">{{ $systemHealth['php_version'] }}</span>
                    </li>
                    <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                        <span class="text-secondary">Laravel Version</span>
                        <span class="badge bg-body-secondary text-body">{{ $systemHealth['laravel_version'] }}</span>
                    </li>
                    <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                        <span class="text-secondary">Active Database</span>
                        <span class="badge bg-success-subtle text-success">{{ strtoupper($systemHealth['database']) }}</span>
                    </li>
                    <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                        <span class="text-secondary">Cache Driver</span>
                        <span class="badge bg-body-secondary text-body">{{ strtoupper($systemHealth['cache_driver']) }}</span>
                    </li>
                    <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center px-0">
                        <span class="text-secondary">Storage Writable</span>
                        <span class="badge bg-success-subtle text-success"><i data-lucide="check" style="width: 14px; height: 14px;"></i> Writable</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Recent Audit Activity -->
    <div class="admin-card p-4">
        <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
            <i data-lucide="activity" class="text-warning"></i>
            <span>Security & Audit Activity</span>
        </h5>

        @if ($recentActivities->isEmpty())
            <div class="text-center py-4 text-secondary small">
                <i data-lucide="shield" class="mb-2" style="width: 32px; height: 32px; opacity: 0.5;"></i>
                <p class="mb-0">No security audit events logged yet. Login and configuration changes will appear here.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 small">
                    <thead class="text-secondary">
                        <tr>
                            <th>Action</th>
                            <th>Actor</th>
                            <th>Details</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentActivities as $log)
                            <tr>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td>{{ $log->user?->name ?? 'System' }}</td>
                                <td class="text-muted">{{ json_encode($log->metadata) }}</td>
                                <td class="text-secondary">{{ $log->created_at->diffForHumans() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
