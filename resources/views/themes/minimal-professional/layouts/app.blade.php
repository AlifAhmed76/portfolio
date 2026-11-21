<!DOCTYPE html>
<html lang="en" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Alif Ahmed — Portfolio')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --theme-accent: #0f766e;
            --theme-bg: #ffffff;
            --theme-border: #e2e8f0;
        }
        body {
            background-color: var(--theme-bg);
            font-family: system-ui, -apple-system, serif;
            color: #1e293b;
        }
        .minimal-border {
            border: 1px solid var(--theme-border);
            border-radius: 4px;
        }
        .btn-minimal {
            background: #0f172a;
            color: #ffffff;
            border-radius: 4px;
            font-weight: 500;
        }
        .btn-minimal:hover { background: #334155; color: #fff; }
    </style>
    @stack('styles')
</head>
<body>
    @if (request()->has('theme_preview'))
        <div class="alert alert-warning py-1 px-3 small text-center mb-0">
            <strong>Preview:</strong> Minimal Professional Theme (Live site unchanged)
        </div>
    @endif

    <header class="border-bottom py-3 mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ url('/') }}" class="h5 fw-bold text-dark text-decoration-none mb-0 tracking-wide">
                ALIF AHMED
            </a>
            <nav class="d-flex gap-3 small">
                <a href="{{ url('/#about') }}" class="text-secondary text-decoration-none">About</a>
                <a href="{{ url('/projects') }}" class="text-secondary text-decoration-none">Projects</a>
                <a href="{{ url('/#contact') }}" class="text-secondary text-decoration-none">Contact</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="border-top py-4 mt-5 text-center text-muted small">
        <p class="mb-0">© {{ date('Y') }} Md. Alif Ahmed • Minimal Professional Theme</p>
    </footer>
    <script>lucide.createIcons();</script>
</body>
</html>
