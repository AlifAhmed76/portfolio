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
        @php
            $themeMeta = [
                'split-engineer' => [
                    'layout' => '50/50 Sticky Split · ScrollSpy',
                    'ref' => 'brittanychiang.com',
                    'bg' => '#0f172a',
                    'border' => '#14b8a6',
                    'accent' => '#14b8a6',
                    'icon' => 'layout-grid',
                ],
                'editorial-brutalist' => [
                    'layout' => 'Full-Bleed Magazine · Bold Display',
                    'ref' => 'antonandirene.com',
                    'bg' => '#09090b',
                    'border' => '#e11d48',
                    'accent' => '#e11d48',
                    'icon' => 'newspaper',
                ],
                'animattor-dark' => [
                    'layout' => 'Bento Box Grid · Infinite Marquee · 3D Radar',
                    'ref' => 'animattor.co · sitewise.agency',
                    'bg' => '#0d0c1d',
                    'border' => '#8b5cf6',
                    'accent' => '#8b5cf6',
                    'icon' => 'sparkles',
                ],
                'craft-playful' => [
                    'layout' => 'Neobrutalist Stickers · Yearly Chapters',
                    'ref' => 'joshwcomeau.com · lynnandtonic.com',
                    'bg' => '#0f111a',
                    'border' => '#ec4899',
                    'accent' => '#ec4899',
                    'icon' => 'palette',
                ],
                'nordic-minimal' => [
                    'layout' => 'Scandinavian Monograph · Quiet Serif Flow',
                    'ref' => 'vanschneider.com',
                    'bg' => '#f7f5f0',
                    'border' => '#1c1917',
                    'accent' => '#1c1917',
                    'icon' => 'book-open',
                ],
                'executive-lead' => [
                    'layout' => 'Executive KPI Command Center · Governance',
                    'ref' => 'Enterprise Leadership Suite',
                    'bg' => '#0a192f',
                    'border' => '#d97706',
                    'accent' => '#d97706',
                    'icon' => 'briefcase',
                ],
                'crystal-3d' => [
                    'layout' => 'Glassmorphic 3D Surfaces · Emerald Glow',
                    'ref' => 'Recommended Default',
                    'bg' => '#090d16',
                    'border' => '#10b981',
                    'accent' => '#10b981',
                    'icon' => 'box',
                ],
                'creative-studio' => [
                    'layout' => 'High-Impact Typography · Asymmetric Studio',
                    'ref' => 'Creative Agency Studio',
                    'bg' => '#0d1117',
                    'border' => '#f59e0b',
                    'accent' => '#f59e0b',
                    'icon' => 'film',
                ],
                'futuristic-tech' => [
                    'layout' => 'Cyberpunk Terminal · Monospace HUD',
                    'ref' => 'Terminal / Cyber HUD',
                    'bg' => '#050811',
                    'border' => '#06b6d4',
                    'accent' => '#06b6d4',
                    'icon' => 'terminal',
                ],
                'minimal-professional' => [
                    'layout' => 'Recruiter Monograph · Clean High Contrast',
                    'ref' => 'Editorial Light Minimal',
                    'bg' => '#ffffff',
                    'border' => '#0f766e',
                    'accent' => '#0f766e',
                    'icon' => 'file-text',
                ],
            ];
        @endphp

        @foreach ($themes as $theme)
            @php 
                $isActive = ($activeTheme->id === $theme->id); 
                $meta = $themeMeta[$theme->slug] ?? [
                    'layout' => 'Custom Architecture',
                    'ref' => 'Design Studio',
                    'bg' => '#111827',
                    'border' => '#6b7280',
                    'accent' => '#10b981',
                    'icon' => 'layers',
                ];
            @endphp
            <div class="col-md-6 col-xl-4 col-xxl-3">
                <div class="admin-card h-100 d-flex flex-column overflow-hidden border-2 {{ $isActive ? 'border-success shadow' : '' }}">
                    
                    <!-- Visual Mockup Banner -->
                    <div class="p-3 d-flex flex-column justify-content-between position-relative overflow-hidden" 
                         style="background: {{ $meta['bg'] }}; height: 110px; border-bottom: 2px solid {{ $meta['border'] }};">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-black bg-opacity-75 text-white font-mono" style="font-size: 0.7rem; border: 1px solid rgba(255,255,255,0.2);">
                                v{{ $theme->version }}
                            </span>
                            @if ($isActive)
                                <span class="badge bg-success text-white shadow-sm">
                                    <i data-lucide="check-circle" style="width: 12px; height: 12px;" class="me-1"></i> Live Active
                                </span>
                            @else
                                <span class="badge bg-dark bg-opacity-50 text-white-50" style="font-size: 0.68rem;">
                                    {{ $theme->slug }}
                                </span>
                            @endif
                        </div>

                        <div>
                            <div class="small fw-bold text-truncate" style="color: {{ $meta['accent'] }}; font-size: 0.72rem; letter-spacing: 0.05em; text-transform: uppercase;">
                                ✦ {{ $meta['ref'] }}
                            </div>
                            <h4 class="h5 fw-bold mb-0 text-truncate" style="color: {{ $theme->slug === 'nordic-minimal' || $theme->slug === 'minimal-professional' ? '#111827' : '#ffffff' }};">
                                {{ $theme->name }}
                            </h4>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4 d-flex flex-column flex-grow-1">
                        <!-- Layout Structure Pill -->
                        <div class="mb-3">
                            <span class="badge bg-body-tertiary text-body border border-secondary-subtle d-inline-flex align-items-center gap-1 p-2" style="font-size: 0.72rem;">
                                <i data-lucide="{{ $meta['icon'] }}" style="width: 12px; height: 12px;"></i>
                                <span>{{ $meta['layout'] }}</span>
                            </span>
                        </div>

                        <p class="small text-secondary mb-3 flex-grow-1" style="font-size: 0.84rem; line-height: 1.5;">
                            {{ $theme->manifest_json['description'] ?? 'High performance portfolio theme.' }}
                        </p>

                        <div class="mb-3 d-flex align-items-center justify-content-between small pt-2 border-top border-secondary-subtle">
                            <span class="text-secondary" style="font-size: 0.78rem;">Palette Accent:</span>
                            <span class="badge font-mono" style="background-color: {{ $theme->manifest_json['tokens']['accent_color'] ?? '#10b981' }}; color: #fff; font-size: 0.72rem;">
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
