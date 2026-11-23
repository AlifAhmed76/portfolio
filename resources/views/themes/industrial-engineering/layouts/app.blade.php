<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Industrial & Systems Engineering')</title>
    <meta name="description" content="@yield('meta_description', $profile->bio ?? 'Technical project lead and systems architect specializing in structural Laravel engineering and logistics automation.')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --eng-bg: #0f172a;
            --eng-surface: #1e293b;
            --eng-border: rgba(249, 115, 22, 0.25);
            --eng-orange: #f97316;
            --eng-orange-dim: rgba(249, 115, 22, 0.12);
            --eng-text: #f1f5f9;
            --font-display: 'Space Grotesk', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }
        body {
            background-color: var(--eng-bg);
            color: var(--eng-text);
            font-family: var(--font-display);
            line-height: 1.7;
            min-height: 100vh;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 40px 40px;
        }
        .font-mono { font-family: var(--font-mono); }
        .eng-nav {
            background: rgba(15, 23, 42, 0.95);
            border-bottom: 2px solid var(--eng-orange);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .eng-card {
            background: rgba(30, 41, 59, 0.8);
            border: 1px solid var(--eng-border);
            position: relative;
            transition: all 0.2s ease;
        }
        .eng-card::before {
            content: '+';
            position: absolute;
            top: -8px;
            left: -8px;
            color: var(--eng-orange);
            font-family: var(--font-mono);
            font-size: 14px;
        }
        .eng-card::after {
            content: '+';
            position: absolute;
            bottom: -8px;
            right: -8px;
            color: var(--eng-orange);
            font-family: var(--font-mono);
            font-size: 14px;
        }
        .eng-card:hover {
            border-color: var(--eng-orange);
            background: rgba(30, 41, 59, 0.95);
        }
        .btn-eng {
            background: var(--eng-orange);
            color: #0f172a;
            font-weight: 700;
            font-family: var(--font-mono);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 1px solid var(--eng-orange);
        }
        .btn-eng:hover {
            background: #ea580c;
            color: #ffffff;
        }
        .btn-eng-outline {
            border: 1px solid var(--eng-orange);
            color: var(--eng-orange);
            font-weight: 700;
            font-family: var(--font-mono);
            text-transform: uppercase;
            padding: 10px 20px;
            border-radius: 4px;
            text-decoration: none;
            background: transparent;
        }
        .btn-eng-outline:hover {
            background: var(--eng-orange-dim);
            color: var(--eng-orange);
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="eng-nav py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ isset($currentWorkspace) && $currentWorkspace->slug !== 'default' ? url('/u/' . $currentWorkspace->slug) : url('/') }}" class="text-white text-decoration-none fw-bold font-mono d-flex align-items-center gap-2">
                <span class="text-warning">⬡</span>
                <span>{{ $profile->name ?? 'Portfolio Builder' }}</span>
            </a>
            <nav class="d-none d-md-flex align-items-center gap-4 font-mono small">
                <a href="{{ url('/#about') }}" class="text-secondary text-decoration-none hover-white">01_SPEC</a>
                <a href="{{ url('/#projects') }}" class="text-secondary text-decoration-none hover-white">02_STRUCTURES</a>
                <a href="{{ url('/#services') }}" class="text-secondary text-decoration-none hover-white">03_SERVICES</a>
                <a href="{{ url('/blog') }}" class="text-secondary text-decoration-none hover-white">04_JOURNAL</a>
                <a href="{{ url('/#contact') }}" class="btn-eng py-1 px-3 small">INITIATE_SPRINT</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="py-5 border-top" style="border-color: rgba(255,255,255,0.08) !important;">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-3 font-mono small text-secondary">
            <div>
                [STRUCTURAL SPEC] © {{ date('Y') }} {{ $profile->name ?? 'Md. Alif Ahmed' }} — Rigorous Laravel Architecture
            </div>
            <a href="{{ url('/admin/login') }}" class="text-secondary text-decoration-none">CONSOLE_LOGIN()</a>
        </div>
    </footer>

    <script>lucide.createIcons();</script>
    @stack('scripts')
</body>
</html>