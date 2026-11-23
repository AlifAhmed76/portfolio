@extends('layouts.admin')

@section('title', 'Visual Builder: ' . $page->title)

@push('styles')
<!-- GrapesJS Core Styles -->
<link rel="stylesheet" href="https://unpkg.com/grapesjs/dist/css/grapes.min.css">
<style>
    /* Full-screen capable Visual Builder Studio styling */
    .gjs-editor-container {
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid var(--admin-border);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4);
    }
    .gjs-cv-canvas {
        background: #060913 !important;
        width: 100%;
        height: 100%;
    }
    .gjs-block {
        user-select: none;
        min-height: 75px !important;
        padding: 10px !important;
        border: 1px solid rgba(255, 255, 255, 0.08) !important;
        border-radius: 8px !important;
        background: #101726 !important;
        color: #e2e8f0 !important;
        transition: all 0.2s ease !important;
    }
    .gjs-block:hover {
        border-color: #10b981 !important;
        color: #10b981 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }
    .gjs-block-label {
        font-size: 0.75rem !important;
        font-weight: 600 !important;
    }
    .gjs-pn-views-container {
        background: #0f172a !important;
        border-left: 1px solid rgba(255, 255, 255, 0.08) !important;
    }
    .gjs-pn-panels {
        background: #0b1120 !important;
    }
    .gjs-sm-sector .gjs-sm-sector-title {
        background: #1e293b !important;
        color: #94a3b8 !important;
        font-weight: 600 !important;
        font-size: 0.8rem !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
    }
    .gjs-sm-property {
        border-color: rgba(255, 255, 255, 0.05) !important;
    }
    .gjs-field {
        background-color: #0b1120 !important;
        border: 1px solid rgba(255, 255, 255, 0.15) !important;
        color: #f8fafc !important;
        border-radius: 4px !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">
    <!-- Top Action Bar -->
    <div class="admin-card p-3 mb-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-outline-secondary" title="Back to Page Manager">
                <i data-lucide="arrow-left" style="width: 14px; height: 14px;"></i>
            </a>
            <div>
                <div class="d-flex align-items-center gap-2">
                    <h1 class="h5 fw-bold mb-0 text-white">{{ $page->title }}</h1>
                    <code class="text-emerald small px-2 py-0 bg-dark rounded border border-secondary-subtle">/{{ $page->slug }}</code>
                    <span id="pageStatusBadge" class="badge {{ $page->status === 'published' ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning border border-warning-subtle' }} px-2 py-1">
                        {{ ucfirst($page->status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Viewport Controls & Actions -->
        <div class="d-flex align-items-center gap-2">
            <!-- Responsive Device Viewport Switchers -->
            <div class="btn-group btn-group-sm me-2" role="group">
                <button type="button" class="btn btn-outline-secondary active" id="btnDeviceDesktop" title="Desktop View (100%)">
                    <i data-lucide="monitor" style="width: 14px; height: 14px;"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="btnDeviceTablet" title="Tablet View (768px)">
                    <i data-lucide="tablet" style="width: 14px; height: 14px;"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="btnDeviceMobile" title="Mobile View (375px)">
                    <i data-lucide="smartphone" style="width: 14px; height: 14px;"></i>
                </button>
            </div>

            <!-- Undo / Redo -->
            <div class="btn-group btn-group-sm me-2" role="group">
                <button type="button" class="btn btn-outline-secondary" id="btnUndo" title="Undo (Ctrl+Z)">
                    <i data-lucide="undo-2" style="width: 14px; height: 14px;"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="btnRedo" title="Redo (Ctrl+Y)">
                    <i data-lucide="redo-2" style="width: 14px; height: 14px;"></i>
                </button>
            </div>

            <!-- View Code Modal Trigger -->
            <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#codeViewModal" title="View & Inspect Code">
                <i data-lucide="code" style="width: 14px; height: 14px;"></i>
                <span>Code</span>
            </button>

            <!-- Revisions Modal Trigger -->
            <button type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#revisionsModal">
                <i data-lucide="history" style="width: 14px; height: 14px;"></i>
                <span>Revisions ({{ $page->revisions->count() }})</span>
            </button>

            <!-- Save Draft -->
            <button type="button" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1" id="btnSaveDraft">
                <i data-lucide="save" style="width: 14px; height: 14px;"></i>
                <span id="saveDraftText">Save Draft</span>
            </button>

            <!-- Publish Button -->
            <button type="button" class="btn btn-sm btn-emerald d-flex align-items-center gap-1" id="btnPublish">
                <i data-lucide="send" style="width: 14px; height: 14px;"></i>
                <span id="publishText">Publish</span>
            </button>

            @if ($page->isPublished())
                <a href="{{ url('/' . $page->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="View Live Page">
                    <i data-lucide="external-link" style="width: 14px; height: 14px;"></i>
                </a>
            @endif
        </div>
    </div>

    <!-- Alert / Toast Banner -->
    <div id="builderAlert" class="alert d-none mb-3"></div>

    <!-- Visual Builder Layout -->
    <div class="row g-3">
        <!-- Main GrapesJS Canvas Container -->
        <div class="col-12">
            <div class="gjs-editor-container" style="min-height: 780px; position: relative;">
                <div id="gjs" style="height: 780px; overflow: hidden;"></div>
            </div>
        </div>
    </div>
</div>

<!-- 1. Revisions Modal with 1-Click Code Rollback -->
<div class="modal fade" id="revisionsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark border border-secondary text-light">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                    <i data-lucide="history" class="text-emerald"></i>
                    <span>Page Revisions & Code History</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 text-light">
                        <thead class="table-dark text-secondary small">
                            <tr>
                                <th class="ps-3">Snapshot #</th>
                                <th>Saved Date & Time</th>
                                <th>Published By</th>
                                <th class="text-end pe-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($page->revisions as $rev)
                                <tr>
                                    <td class="ps-3">
                                        <span class="badge bg-secondary font-monospace">Rev #{{ $rev->revision_number }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold">{{ $rev->created_at->format('M d, Y · h:i A') }}</div>
                                        <small class="text-secondary">{{ $rev->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        <span class="small text-secondary">{{ $rev->creator?->name ?? 'Author' }}</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <form action="{{ route('admin.pages.builder.restore', [$page, $rev->revision_number]) }}" method="POST" onsubmit="return confirm('Restore Revision #{{ $rev->revision_number }}? This will replace your canvas with this snapshot.');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center gap-1">
                                                <i data-lucide="rotate-ccw" style="width: 14px; height: 14px;"></i>
                                                <span>Restore Snapshot</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-secondary">
                                        <i data-lucide="history" class="mb-2" style="width: 32px; height: 32px;"></i>
                                        <p class="mb-1">No revisions recorded yet.</p>
                                        <small>Every time you click "Publish", a permanent snapshot revision is automatically created.</small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 2. Code Inspection & Export Modal -->
<div class="modal fade" id="codeViewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-dark border border-secondary text-light">
            <div class="modal-header border-bottom border-secondary">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2">
                    <i data-lucide="code-2" class="text-info"></i>
                    <span>Generated HTML & CSS Code</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-3">
                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label small text-secondary fw-bold">HTML Structure</label>
                        <textarea id="modalHtmlCode" class="form-control bg-black text-light font-monospace small" rows="18" readonly></textarea>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small text-secondary fw-bold">CSS Styling Rules</label>
                        <textarea id="modalCssCode" class="form-control bg-black text-info font-monospace small" rows="18" readonly></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-top border-secondary">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="navigator.clipboard.writeText(document.getElementById('modalHtmlCode').value); alert('HTML copied to clipboard!');">
                    <i data-lucide="copy" style="width: 14px; height: 14px;" class="me-1"></i> Copy HTML
                </button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- GrapesJS Core Library -->
<script src="https://unpkg.com/grapesjs/dist/grapes.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const rawContent = @json($blocks ?? []);
    const saveDraftUrl = @json(route('admin.pages.builder.save-draft', $page));
    const publishUrl = @json(route('admin.pages.builder.publish', $page));
    const csrfToken = '{{ csrf_token() }}';

    const alertEl = document.getElementById('builderAlert');

    function showAlert(type, msg) {
        alertEl.className = `alert alert-${type} mb-3 shadow-sm`;
        alertEl.innerHTML = `<i data-lucide="${type === 'success' ? 'check-circle' : 'alert-circle'}" class="me-2" style="width: 16px; height: 16px;"></i> <span>${msg}</span>`;
        alertEl.classList.remove('d-none');
        if (window.lucide) lucide.createIcons();
        setTimeout(() => alertEl.classList.add('d-none'), 5000);
    }

    // Determine initial HTML & CSS from page content
    let initialHtml = '';
    let initialCss = '';
    let initialComponents = null;
    let initialStyle = null;

    if (rawContent) {
        if (rawContent.html) {
            initialHtml = rawContent.html;
            initialCss = rawContent.css || '';
            initialComponents = rawContent.components || null;
            initialStyle = rawContent.style || null;
        } else if (Array.isArray(rawContent) && rawContent.length > 0) {
            // Starter blocks fallback
            initialHtml = `
                <div class="py-5 text-center" style="font-family: system-ui, sans-serif; background: #070a14; color: #f8fafc; min-height: 100vh; padding: 40px 20px;">
                    <div style="max-width: 900px; margin: 0 auto;">
                        <span style="display: inline-block; padding: 6px 14px; border-radius: 9999px; background: rgba(16, 185, 129, 0.15); color: #10b981; font-size: 0.85rem; font-weight: 600; margin-bottom: 20px; border: 1px solid rgba(16, 185, 129, 0.3);">
                            ✦ Available for High-Impact Projects
                        </span>
                        <h1 style="font-size: 3rem; font-weight: 800; line-height: 1.15; margin-bottom: 20px; color: #ffffff;">
                            ${@json($page->title)}
                        </h1>
                        <p style="font-size: 1.25rem; color: #94a3b8; max-width: 700px; margin: 0 auto 35px auto; line-height: 1.6;">
                            Crafting scalable web architectures, custom Laravel solutions, and seamless user experiences.
                        </p>
                        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                            <a href="#projects" style="display: inline-block; padding: 12px 28px; background: #10b981; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600;">Explore Projects &rarr;</a>
                            <a href="#contact" style="display: inline-block; padding: 12px 28px; background: rgba(255,255,255,0.08); color: #f8fafc; text-decoration: none; border-radius: 8px; font-weight: 600; border: 1px solid rgba(255,255,255,0.15);">Get in Touch</a>
                        </div>
                    </div>
                </div>
            `;
        }
    }

    if (!initialHtml) {
        initialHtml = `
            <div style="font-family: system-ui, sans-serif; background: #070a14; color: #f8fafc; min-height: 100vh; padding: 60px 20px;">
                <div style="max-width: 960px; margin: 0 auto; text-align: center;">
                    <span style="display: inline-block; padding: 6px 14px; border-radius: 9999px; background: rgba(16, 185, 129, 0.15); color: #10b981; font-size: 0.85rem; font-weight: 600; margin-bottom: 20px;">
                        ✦ Professional Portfolio Builder
                    </span>
                    <h1 style="font-size: 3.25rem; font-weight: 800; line-height: 1.15; margin-bottom: 20px; color: #ffffff;">
                        ${@json($page->title)}
                    </h1>
                    <p style="font-size: 1.2rem; color: #94a3b8; max-width: 680px; margin: 0 auto 35px auto;">
                        Drag and drop blocks from the right panel to customize your layout. Click any text to edit directly.
                    </p>
                    <div style="display: flex; gap: 16px; justify-content: center;">
                        <a href="#work" style="display: inline-block; padding: 12px 28px; background: #10b981; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600;">View Portfolio</a>
                        <a href="#contact" style="display: inline-block; padding: 12px 28px; background: rgba(255,255,255,0.08); color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600;">Contact Me</a>
                    </div>
                </div>
            </div>
        `;
    }

    // Initialize GrapesJS Visual Editor
    const editor = grapesjs.init({
        container: '#gjs',
        fromElement: false,
        height: '780px',
        width: 'auto',
        storageManager: false, // We handle storage via AJAX to Laravel backend
        canvas: {
            styles: [
                'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
                'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap'
            ]
        },
        deviceManager: {
            devices: [
                { id: 'desktop', name: 'Desktop', width: '' },
                { id: 'tablet', name: 'Tablet', width: '768px', widthMedia: '992px' },
                { id: 'mobile', name: 'Mobile', width: '375px', widthMedia: '480px' }
            ]
        },
        blockManager: {
            appendTo: '#blocks-container',
            blocks: []
        }
    });

    // Populate Custom Elementor-style Drag-and-Drop Blocks
    const bm = editor.BlockManager;

    // 1. Structure Blocks
    bm.add('section-1col', {
        label: '1 Column Section',
        category: 'Layout & Grid',
        content: '<div style="padding: 40px 20px; max-width: 1100px; margin: 0 auto;"><p style="font-size: 1.1rem; color: #94a3b8;">Container block. Insert your widgets here.</p></div>',
        attributes: { class: 'gjs-fonts gjs-f-b1' }
    });

    bm.add('section-2col', {
        label: '2 Columns (50/50)',
        category: 'Layout & Grid',
        content: `
            <div style="display: flex; flex-wrap: wrap; gap: 24px; padding: 30px 20px; max-width: 1100px; margin: 0 auto;">
                <div style="flex: 1 1 300px; background: #0f172a; padding: 24px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                    <h3 style="color: #ffffff; font-size: 1.25rem;">Left Column</h3>
                    <p style="color: #94a3b8; font-size: 0.95rem;">Describe your core feature or architectural competency here.</p>
                </div>
                <div style="flex: 1 1 300px; background: #0f172a; padding: 24px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                    <h3 style="color: #ffffff; font-size: 1.25rem;">Right Column</h3>
                    <p style="color: #94a3b8; font-size: 0.95rem;">Add technical details, metrics, or complementary visual elements.</p>
                </div>
            </div>
        `,
        attributes: { class: 'gjs-fonts gjs-f-b2' }
    });

    bm.add('section-3col', {
        label: '3 Columns (33/33/33)',
        category: 'Layout & Grid',
        content: `
            <div style="display: flex; flex-wrap: wrap; gap: 20px; padding: 30px 20px; max-width: 1100px; margin: 0 auto;">
                <div style="flex: 1 1 250px; background: #0f172a; padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                    <h4 style="color: #ffffff;">Feature One</h4>
                    <p style="color: #94a3b8; font-size: 0.9rem;">Modern Laravel engineering with robust domain modeling.</p>
                </div>
                <div style="flex: 1 1 250px; background: #0f172a; padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                    <h4 style="color: #ffffff;">Feature Two</h4>
                    <p style="color: #94a3b8; font-size: 0.9rem;">Meta Conversion API and high-accuracy server-side tracking.</p>
                </div>
                <div style="flex: 1 1 250px; background: #0f172a; padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08);">
                    <h4 style="color: #ffffff;">Feature Three</h4>
                    <p style="color: #94a3b8; font-size: 0.9rem;">Enterprise courier integrations with real-time automated dispatch.</p>
                </div>
            </div>
        `,
        attributes: { class: 'gjs-fonts gjs-f-b3' }
    });

    // 2. Portfolio Blocks
    bm.add('portfolio-hero', {
        label: 'Hero Profile Showcase',
        category: 'Portfolio Elements',
        content: `
            <section style="padding: 70px 20px; background: radial-gradient(circle at 50% 0%, rgba(16, 185, 129, 0.15) 0%, #070a14 70%); text-align: center;">
                <div style="max-width: 850px; margin: 0 auto;">
                    <div style="display: inline-block; padding: 6px 16px; border-radius: 9999px; background: rgba(16, 185, 129, 0.12); color: #10b981; font-size: 0.85rem; font-weight: 600; margin-bottom: 24px; border: 1px solid rgba(16, 185, 129, 0.3);">
                        ● Available for Select Projects
                    </div>
                    <h1 style="font-size: 3.25rem; font-weight: 800; color: #ffffff; line-height: 1.15; margin-bottom: 20px;">
                        Engineering Digital Experiences & Business Solutions
                    </h1>
                    <p style="font-size: 1.2rem; color: #94a3b8; line-height: 1.6; margin-bottom: 35px;">
                        Technical Project Lead and Full-Stack Developer specializing in custom Laravel architectures and enterprise e-commerce platforms.
                    </p>
                    <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                        <a href="#projects" style="padding: 14px 32px; background: #10b981; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.35);">View Projects &rarr;</a>
                        <a href="#contact" style="padding: 14px 32px; background: #1e293b; color: #f8fafc; text-decoration: none; border-radius: 8px; font-weight: 600; border: 1px solid rgba(255,255,255,0.1);">Initiate Contact</a>
                    </div>
                </div>
            </section>
        `
    });

    bm.add('project-card', {
        label: 'Project Case Study Card',
        category: 'Portfolio Elements',
        content: `
            <div style="background: #0f172a; border-radius: 12px; border: 1px solid rgba(255, 255, 255, 0.08); overflow: hidden; max-width: 450px; margin: 20px auto; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.4);">
                <div style="height: 200px; background: #1e293b; display: flex; align-items: center; justify-content: center; color: #64748b; font-weight: 600;">
                    [ Project Preview Image ]
                </div>
                <div style="padding: 24px;">
                    <span style="font-size: 0.75rem; font-weight: 700; color: #10b981; text-transform: uppercase; letter-spacing: 0.05em;">Enterprise SaaS</span>
                    <h3 style="color: #ffffff; font-size: 1.35rem; margin-top: 8px; margin-bottom: 12px;">Flagship E-Commerce Engine</h3>
                    <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">
                        Custom order orchestration hub with multi-carrier API integrations and automated dispatch workflows.
                    </p>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 20px;">
                        <span style="padding: 4px 10px; background: rgba(255,255,255,0.06); color: #cbd5e1; border-radius: 6px; font-size: 0.75rem;">Laravel 11</span>
                        <span style="padding: 4px 10px; background: rgba(255,255,255,0.06); color: #cbd5e1; border-radius: 6px; font-size: 0.75rem;">Vue.js</span>
                        <span style="padding: 4px 10px; background: rgba(255,255,255,0.06); color: #cbd5e1; border-radius: 6px; font-size: 0.75rem;">MySQL</span>
                    </div>
                    <a href="#" style="color: #10b981; text-decoration: none; font-weight: 600; font-size: 0.95rem;">View Full Case Study &rarr;</a>
                </div>
            </div>
        `
    });

    bm.add('skills-cloud', {
        label: 'Skills Badge Matrix',
        category: 'Portfolio Elements',
        content: `
            <div style="padding: 40px 20px; max-width: 900px; margin: 0 auto; text-align: center;">
                <h3 style="color: #ffffff; margin-bottom: 24px; font-size: 1.75rem;">Core Technical Competencies</h3>
                <div style="display: flex; flex-wrap: wrap; gap: 12px; justify-content: center;">
                    <span style="padding: 10px 20px; background: #0f172a; color: #10b981; border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 9999px; font-weight: 600; font-size: 0.9rem;">PHP / Laravel</span>
                    <span style="padding: 10px 20px; background: #0f172a; color: #38bdf8; border: 1px solid rgba(56, 189, 248, 0.3); border-radius: 9999px; font-weight: 600; font-size: 0.9rem;">JavaScript / Vue</span>
                    <span style="padding: 10px 20px; background: #0f172a; color: #f43f5e; border: 1px solid rgba(244, 63, 94, 0.3); border-radius: 9999px; font-weight: 600; font-size: 0.9rem;">Meta CAPI Tracking</span>
                    <span style="padding: 10px 20px; background: #0f172a; color: #fbbf24; border: 1px solid rgba(251, 191, 36, 0.3); border-radius: 9999px; font-weight: 600; font-size: 0.9rem;">Courier APIs</span>
                    <span style="padding: 10px 20px; background: #0f172a; color: #a855f7; border: 1px solid rgba(168, 85, 247, 0.3); border-radius: 9999px; font-weight: 600; font-size: 0.9rem;">REST Architecture</span>
                </div>
            </div>
        `
    });

    bm.add('service-feature-box', {
        label: 'Service Feature Box',
        category: 'Portfolio Elements',
        content: `
            <div style="background: #0f172a; padding: 32px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.08); max-width: 480px; margin: 20px auto;">
                <div style="width: 48px; height: 48px; border-radius: 10px; background: rgba(16, 185, 129, 0.15); display: flex; align-items: center; justify-content: center; color: #10b981; font-size: 1.5rem; margin-bottom: 20px;">
                    ⚡
                </div>
                <h3 style="color: #ffffff; font-size: 1.35rem; margin-bottom: 12px;">Custom Web Applications</h3>
                <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.6; margin-bottom: 20px;">
                    End-to-end bespoke web engineering built for high throughput, seamless usability, and maintainability.
                </p>
                <ul style="color: #cbd5e1; font-size: 0.9rem; line-height: 1.8; padding-left: 20px; margin-bottom: 0;">
                    <li>Domain-driven design</li>
                    <li>Automated test pipelines</li>
                    <li>Sub-second query optimization</li>
                </ul>
            </div>
        `
    });

    bm.add('contact-form-block', {
        label: 'Contact Collaboration Box',
        category: 'Portfolio Elements',
        content: `
            <div style="background: #0f172a; padding: 40px; border-radius: 14px; border: 1px solid rgba(255, 255, 255, 0.08); max-width: 600px; margin: 40px auto; text-align: center;">
                <h2 style="color: #ffffff; font-size: 2rem; margin-bottom: 12px;">Let's Build Something Exceptional</h2>
                <p style="color: #94a3b8; font-size: 1rem; margin-bottom: 30px;">Have an upcoming project or technical architecture challenge? Drop a message below.</p>
                <form action="/contact" method="POST" style="text-align: left;">
                    <div style="margin-bottom: 16px;">
                        <label style="color: #cbd5e1; font-size: 0.85rem; display: block; margin-bottom: 6px;">Your Name</label>
                        <input type="text" name="name" placeholder="John Doe" style="width: 100%; padding: 12px; background: #070a14; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: #ffffff;" required>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label style="color: #cbd5e1; font-size: 0.85rem; display: block; margin-bottom: 6px;">Email Address</label>
                        <input type="email" name="email" placeholder="john@example.com" style="width: 100%; padding: 12px; background: #070a14; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: #ffffff;" required>
                    </div>
                    <div style="margin-bottom: 24px;">
                        <label style="color: #cbd5e1; font-size: 0.85rem; display: block; margin-bottom: 6px;">Message & Project Details</label>
                        <textarea name="message" rows="4" placeholder="Tell me about your goals, timeline, and tech requirements..." style="width: 100%; padding: 12px; background: #070a14; border: 1px solid rgba(255,255,255,0.15); border-radius: 8px; color: #ffffff;" required></textarea>
                    </div>
                    <button type="submit" style="width: 100%; padding: 14px; background: #10b981; color: #ffffff; font-weight: 700; border: none; border-radius: 8px; cursor: pointer;">Send Message &rarr;</button>
                </form>
            </div>
        `
    });

    // 3. Content Blocks
    bm.add('text-heading', {
        label: 'Headline',
        category: 'Basic Typography',
        content: '<h2 style="color: #ffffff; font-size: 2.25rem; font-weight: 700; margin-bottom: 16px;">Compelling Section Title</h2>'
    });

    bm.add('text-paragraph', {
        label: 'Paragraph Text',
        category: 'Basic Typography',
        content: '<p style="color: #94a3b8; font-size: 1.05rem; line-height: 1.7; margin-bottom: 20px;">Write your story or detailed project explanation here. Clean typography and optimal contrast.</p>'
    });

    bm.add('button-primary', {
        label: 'CTA Button',
        category: 'Basic Typography',
        content: '<a href="#" style="display: inline-block; padding: 12px 28px; background: #10b981; color: #ffffff; text-decoration: none; border-radius: 8px; font-weight: 600;">Action Button</a>'
    });

    bm.add('custom-html-block', {
        label: 'Custom HTML / Embed',
        category: 'Advanced',
        content: '<div style="padding: 24px; border: 1px dashed rgba(255,255,255,0.2); border-radius: 8px; text-align: center; color: #cbd5e1;"><p class="mb-0">Insert your custom HTML embed code here.</p></div>'
    });

    // Set initial components
    if (initialComponents) {
        editor.setComponents(initialComponents);
    } else {
        editor.setComponents(initialHtml);
    }
    if (initialStyle) {
        editor.setStyle(initialStyle);
    } else if (initialCss) {
        editor.setStyle(initialCss);
    }

    // Top Control Bar Event Listeners
    // 1. Device Viewports
    document.getElementById('btnDeviceDesktop').addEventListener('click', function() {
        editor.setDevice('Desktop');
        setDeviceActive(this);
    });
    document.getElementById('btnDeviceTablet').addEventListener('click', function() {
        editor.setDevice('Tablet');
        setDeviceActive(this);
    });
    document.getElementById('btnDeviceMobile').addEventListener('click', function() {
        editor.setDevice('Mobile');
        setDeviceActive(this);
    });

    function setDeviceActive(btn) {
        document.querySelectorAll('#btnDeviceDesktop, #btnDeviceTablet, #btnDeviceMobile').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    // 2. Undo / Redo
    document.getElementById('btnUndo').addEventListener('click', () => editor.UndoManager.undo());
    document.getElementById('btnRedo').addEventListener('click', () => editor.UndoManager.redo());

    // 3. View Code Modal Population
    const codeModal = document.getElementById('codeViewModal');
    codeModal.addEventListener('show.bs.modal', function() {
        document.getElementById('modalHtmlCode').value = editor.getHtml();
        document.getElementById('modalCssCode').value = editor.getCss();
    });

    // 4. Save Draft AJAX
    document.getElementById('btnSaveDraft').addEventListener('click', function() {
        const btn = this;
        const textSpan = document.getElementById('saveDraftText');
        btn.disabled = true;
        textSpan.textContent = 'Saving...';

        const payload = {
            mode: 'grapesjs',
            html: editor.getHtml(),
            css: editor.getCss(),
            components: editor.getComponents(),
            style: editor.getStyle()
        };

        fetch(saveDraftUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ blocks: payload })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            textSpan.textContent = 'Save Draft';
            if (data.success) {
                showAlert('success', '✓ Draft successfully saved.');
            } else {
                showAlert('danger', data.message || 'Error saving draft.');
            }
        })
        .catch(err => {
            console.error(err);
            btn.disabled = false;
            textSpan.textContent = 'Save Draft';
            showAlert('danger', 'Network error while saving draft.');
        });
    });

    // 5. Publish Page AJAX
    document.getElementById('btnPublish').addEventListener('click', function() {
        const btn = this;
        const textSpan = document.getElementById('publishText');
        btn.disabled = true;
        textSpan.textContent = 'Publishing...';

        const payload = {
            mode: 'grapesjs',
            html: editor.getHtml(),
            css: editor.getCss(),
            components: editor.getComponents(),
            style: editor.getStyle()
        };

        fetch(publishUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ blocks: payload })
        })
        .then(res => res.json())
        .then(data => {
            btn.disabled = false;
            textSpan.textContent = 'Publish';
            if (data.success) {
                showAlert('success', '✓ Page published successfully! Snapshot revision created.');
                const badge = document.getElementById('pageStatusBadge');
                if (badge) {
                    badge.className = 'badge bg-success-subtle text-success border border-success-subtle px-2 py-1';
                    badge.textContent = 'Published';
                }
            } else {
                showAlert('danger', data.message || 'Error publishing page.');
            }
        })
        .catch(err => {
            console.error(err);
            btn.disabled = false;
            textSpan.textContent = 'Publish';
            showAlert('danger', 'Network error while publishing page.');
        });
    });
});
</script>
@endpush
@endsection
