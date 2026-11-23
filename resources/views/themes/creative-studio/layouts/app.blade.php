<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Alif Ahmed — Creative Engineering Studio')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --theme-accent: #f59e0b;
            --theme-bg: #0d1117;
            --theme-surface: #161b22;
            --theme-border: #30363d;
        }
        body {
            background-color: var(--theme-bg);
            font-family: system-ui, -apple-system, sans-serif;
            color: #e6edf3;
        }
        .studio-card {
            background: var(--theme-surface);
            border: 1px solid var(--theme-border);
            border-radius: 1.25rem;
        }
        .btn-studio {
            background: var(--theme-accent);
            color: #000;
            font-weight: 700;
            border-radius: 9999px;
            padding: 0.6rem 1.5rem;
        }
        .btn-studio:hover { background: #d97706; color: #000; }
    </style>
    @stack('styles')
</head>
<body>
    @if (request()->has('theme_preview'))
        <div class="alert alert-warning py-1 px-3 small text-center mb-0">
            <strong>Preview:</strong> Creative Studio Theme (Live site unchanged)
        </div>
    @endif

    <nav class="navbar navbar-expand-lg border-bottom border-secondary-subtle py-3">
        <div class="container">
            <a class="navbar-brand fw-bolder text-warning" href="{{ isset($currentWorkspace) && $currentWorkspace->slug !== 'default' ? url('/u/' . $currentWorkspace->slug) : url('/') }}">
                {{ $profile->name ?? 'Portfolio Builder' }}
            </a>
            <div class="d-flex gap-3">
                <a href="{{ url('/projects') }}" class="nav-link text-secondary">Work</a>
                <a href="{{ url('/#contact') }}" class="nav-link text-secondary">Contact</a>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="border-top border-secondary-subtle py-4 mt-5 text-center text-muted small">
        <p class="mb-0">© {{ date('Y') }} {{ $profile->name ?? 'Portfolio Builder' }} • Creative Studio Theme</p>
    </footer>
    <script>lucide.createIcons();</script>
</body>
</html>
