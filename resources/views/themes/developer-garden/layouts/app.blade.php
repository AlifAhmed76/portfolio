<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Developer Garden & Digital Notebook')</title>
    <meta name="description" content="@yield('meta_description', $profile->bio ?? 'Personal developer garden, architectural guides, custom Laravel backends, and courier API automations.')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --garden-bg: #181a1b;
            --garden-surface: #22262a;
            --garden-surface-hover: #292e34;
            --garden-border: rgba(255, 255, 255, 0.08);
            --garden-accent: #10b981;
            --garden-accent-dim: rgba(16, 185, 129, 0.12);
            --garden-text: #e2e8f0;
            --garden-text-muted: #94a3b8;
            --font-mono: 'Fira Code', monospace;
        }
        body {
            background-color: var(--garden-bg);
            color: var(--garden-text);
            font-family: 'Inter', -apple-system, sans-serif;
            line-height: 1.7;
            min-height: 100vh;
        }
        .font-mono { font-family: var(--font-mono); }
        .garden-nav {
            background: rgba(24, 26, 27, 0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--garden-border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .garden-card {
            background: var(--garden-surface);
            border: 1px solid var(--garden-border);
            border-radius: 10px;
            transition: all 0.2s ease;
        }
        .garden-card:hover {
            background: var(--garden-surface-hover);
            border-color: rgba(16, 185, 129, 0.3);
        }
        .garden-tag {
            font-family: var(--font-mono);
            font-size: 0.72rem;
            padding: 3px 8px;
            background: var(--garden-accent-dim);
            color: var(--garden-accent);
            border-radius: 4px;
            text-decoration: none;
        }
        .garden-link {
            color: inherit;
            text-decoration: none;
            transition: color 0.15s ease;
        }
        .garden-link:hover {
            color: var(--garden-accent);
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="garden-nav py-3">
        <div class="container d-flex justify-content-between align-items-center" style="max-width: 980px;">
            <a href="{{ isset($currentWorkspace) && $currentWorkspace->slug !== 'default' ? url('/u/' . $currentWorkspace->slug) : url('/') }}" class="garden-link fw-bold font-mono d-flex align-items-center gap-2">
                <span class="text-success">●</span>
                <span>{{ $profile->name ?? 'Portfolio Builder' }}</span>
            </a>
            <nav class="d-flex align-items-center gap-3 font-mono small">
                <a href="{{ url('/#about') }}" class="garden-link">about</a>
                <a href="{{ url('/#projects') }}" class="garden-link">projects</a>
                <a href="{{ url('/#expertise') }}" class="garden-link">stack</a>
                <a href="{{ url('/blog') }}" class="garden-link">journal</a>
                <a href="{{ url('/#contact') }}" class="garden-link">contact</a>
                <a href="{{ url('/admin/login') }}" class="btn btn-sm btn-outline-secondary font-mono" style="font-size: 0.75rem;">admin</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="py-5 border-top" style="border-color: var(--garden-border) !important;">
        <div class="container text-center text-secondary small font-mono" style="max-width: 980px;">
            <div>© {{ date('Y') }} {{ $profile->name ?? 'Md. Alif Ahmed' }} — Personal Digital Garden</div>
            <div class="mt-1" style="font-size: 0.75rem;">Structured execution · Zero-bloat architectures</div>
        </div>
    </footer>

    <script>lucide.createIcons();</script>
    @stack('scripts')
</body>
</html>