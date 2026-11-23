<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Fintech & Systems Architecture')</title>
    <meta name="description" content="@yield('meta_description', $profile->bio ?? 'High-throughput systems engineering, courier API automations, and resilient server-side telemetry.')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --saas-bg: #070913;
            --saas-surface: #0f1325;
            --saas-border: rgba(99, 102, 241, 0.2);
            --saas-accent: #6366f1;
            --saas-accent-glow: #818cf8;
            --saas-teal: #10b981;
            --saas-text: #f8fafc;
            --font-mono: 'JetBrains Mono', monospace;
        }
        body {
            background-color: var(--saas-bg);
            color: var(--saas-text);
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            line-height: 1.7;
            min-height: 100vh;
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(99, 102, 241, 0.12) 0%, transparent 45%),
                radial-gradient(circle at 85% 75%, rgba(16, 185, 129, 0.08) 0%, transparent 45%);
            background-attachment: fixed;
        }
        .font-mono { font-family: var(--font-mono); }
        .saas-nav {
            background: rgba(7, 9, 19, 0.85);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--saas-border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .saas-card {
            background: rgba(15, 19, 37, 0.7);
            backdrop-filter: blur(12px);
            border: 1px solid var(--saas-border);
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        .saas-card:hover {
            border-color: rgba(99, 102, 241, 0.5);
            box-shadow: 0 12px 30px -10px rgba(99, 102, 241, 0.25);
            transform: translateY(-3px);
        }
        .btn-saas {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: #ffffff;
            font-weight: 600;
            border-radius: 12px;
            padding: 10px 24px;
            border: 1px solid rgba(255,255,255,0.15);
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }
        .btn-saas:hover {
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.5);
            color: #ffffff;
            transform: translateY(-2px);
        }
        .btn-saas-outline {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--saas-border);
            color: #ffffff;
            font-weight: 600;
            border-radius: 12px;
            padding: 10px 24px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-saas-outline:hover {
            border-color: var(--saas-accent-glow);
            color: var(--saas-accent-glow);
            background: rgba(99, 102, 241, 0.08);
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="saas-nav py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ isset($currentWorkspace) && $currentWorkspace->slug !== 'default' ? url('/u/' . $currentWorkspace->slug) : url('/') }}" class="text-white text-decoration-none fw-bold fs-5 d-flex align-items-center gap-2">
                <span class="p-2 rounded-3 text-white" style="background: linear-gradient(135deg, #6366f1, #10b981);">
                    <i data-lucide="layers" style="width: 18px; height: 18px;"></i>
                </span>
                <span>{{ $profile->name ?? 'Portfolio Builder' }}</span>
            </a>
            <nav class="d-none d-md-flex align-items-center gap-4 small fw-medium">
                <a href="{{ url('/#about') }}" class="text-secondary text-decoration-none hover-white">Platform</a>
                <a href="{{ url('/#projects') }}" class="text-secondary text-decoration-none hover-white">Deployments</a>
                <a href="{{ url('/#services') }}" class="text-secondary text-decoration-none hover-white">Services</a>
                <a href="{{ url('/blog') }}" class="text-secondary text-decoration-none hover-white">Changelog</a>
                <a href="{{ url('/#contact') }}" class="btn-saas btn-sm py-2 px-3">Launch Sprint</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="py-5 border-top" style="border-color: var(--saas-border) !important;">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="small text-secondary font-mono">
                [SYS::LIVE] © {{ date('Y') }} {{ $profile->name ?? 'Md. Alif Ahmed' }} — Zero-Loss Telemetry
            </div>
            <div class="d-flex gap-3 small text-secondary">
                <a href="{{ url('/admin/login') }}" class="text-secondary text-decoration-none">Admin Hub</a>
            </div>
        </div>
    </footer>

    <script>lucide.createIcons();</script>
    @stack('scripts')
</body>
</html>