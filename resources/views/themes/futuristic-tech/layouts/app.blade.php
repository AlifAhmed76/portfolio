<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Alif Ahmed // Technical Lead')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --theme-accent: #06b6d4;
            --theme-bg: #050811;
            --theme-surface: #0b1120;
            --theme-border: #1e293b;
        }
        body {
            background-color: var(--theme-bg);
            color: #cbd5e1;
            font-family: system-ui, -apple-system, sans-serif;
        }
        .tech-panel {
            background: var(--theme-surface);
            border: 1px solid var(--theme-border);
            border-radius: 6px;
        }
        .text-cyan { color: var(--theme-accent) !important; }
        .btn-cyan {
            background: var(--theme-accent);
            color: #000;
            font-weight: 700;
            border-radius: 4px;
        }
        .btn-cyan:hover { background: #0891b2; color: #000; }
        .font-mono { font-family: monospace; }
    </style>
    @stack('styles')
</head>
<body>
    @if (request()->has('theme_preview'))
        <div class="alert alert-warning py-1 px-3 small text-center mb-0 font-mono">
            SYS::PREVIEW_MODE // THEME::FUTURISTIC_TECH // LIVE_STATE::PRESERVED
        </div>
    @endif

    <nav class="navbar navbar-expand-lg border-bottom border-secondary-subtle py-3 font-mono">
        <div class="container">
            <a class="navbar-brand fw-bold text-cyan" href="{{ isset($currentWorkspace) && $currentWorkspace->slug !== 'default' ? url('/u/' . $currentWorkspace->slug) : url('/') }}">
                &gt; {{ $profile->name ?? 'Portfolio Builder' }}
            </a>
            <div class="d-flex gap-3 small">
                <a href="{{ url('/projects') }}" class="nav-link text-secondary">//PROJECTS</a>
                <a href="{{ url('/#contact') }}" class="nav-link text-secondary">//CONTACT</a>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="border-top border-secondary-subtle py-4 mt-5 text-center text-muted small font-mono">
        <p class="mb-0">SYS_STATUS: OPTIMAL // © {{ date('Y') }} {{ $profile->name ?? 'Portfolio Builder' }}</p>
    </footer>
    <script>lucide.createIcons();</script>
</body>
</html>
