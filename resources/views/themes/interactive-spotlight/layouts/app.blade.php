<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Interactive Spotlight & Systems Lead')</title>
    <meta name="description" content="@yield('meta_description', $profile->bio ?? 'Lead UI/UX & Full-Stack Engineer specializing in high-throughput Laravel backends, Meta Conversion API, and logistics integrations.')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --spot-bg: #030712;
            --spot-surface: rgba(15, 23, 42, 0.65);
            --spot-border: rgba(6, 182, 212, 0.2);
            --spot-cyan: #06b6d4;
            --spot-cyan-glow: #22d3ee;
            --spot-text: #f9fafb;
            --font-mono: 'JetBrains Mono', monospace;
        }
        body {
            background-color: var(--spot-bg);
            color: var(--spot-text);
            font-family: 'Plus Jakarta Sans', -apple-system, sans-serif;
            line-height: 1.7;
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        /* Dynamic Spotlight Cursor Glow */
        #spotlightOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 1;
            background: radial-gradient(600px circle at var(--mouse-x, 50%) var(--mouse-y, 30%), rgba(6, 182, 212, 0.12), transparent 80%);
            transition: background 0.1s ease;
        }
        .spot-nav {
            background: rgba(3, 7, 18, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--spot-border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .spot-card {
            background: var(--spot-surface);
            backdrop-filter: blur(16px);
            border: 1px solid var(--spot-border);
            border-radius: 20px;
            position: relative;
            z-index: 2;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .spot-card:hover {
            border-color: rgba(6, 182, 212, 0.5);
            box-shadow: 0 16px 36px -12px rgba(6, 182, 212, 0.25);
            transform: translateY(-4px);
        }
        .btn-spot {
            background: linear-gradient(135deg, #06b6d4 0%, #0284c7 100%);
            color: #ffffff;
            font-weight: 600;
            border-radius: 9999px;
            padding: 10px 24px;
            border: 1px solid rgba(255,255,255,0.2);
            box-shadow: 0 4px 14px rgba(6, 182, 212, 0.35);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }
        .btn-spot:hover {
            box-shadow: 0 8px 24px rgba(6, 182, 212, 0.5);
            color: #ffffff;
            transform: translateY(-2px);
        }
        .btn-spot-outline {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--spot-border);
            color: var(--spot-cyan-glow);
            font-weight: 600;
            border-radius: 9999px;
            padding: 10px 24px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-spot-outline:hover {
            background: rgba(6, 182, 212, 0.1);
            border-color: var(--spot-cyan-glow);
            color: #ffffff;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="spotlightOverlay"></div>

    <header class="spot-nav py-3">
        <div class="container d-flex justify-content-between align-items-center" style="position: relative; z-index: 10;">
            <a href="{{ isset($currentWorkspace) && $currentWorkspace->slug !== 'default' ? url('/u/' . $currentWorkspace->slug) : url('/') }}" class="text-white text-decoration-none fw-bold fs-5 d-flex align-items-center gap-2">
                <span class="p-1 rounded-circle bg-cyan" style="background: var(--spot-cyan); width: 10px; height: 10px; box-shadow: 0 0 10px var(--spot-cyan);"></span>
                <span>{{ $profile->name ?? 'Portfolio Builder' }}</span>
            </a>
            <nav class="d-none d-md-flex align-items-center gap-4 small fw-medium">
                <a href="{{ url('/#about') }}" class="text-secondary text-decoration-none hover-white">About</a>
                <a href="{{ url('/#projects') }}" class="text-secondary text-decoration-none hover-white">Works</a>
                <a href="{{ url('/#services') }}" class="text-secondary text-decoration-none hover-white">Services</a>
                <a href="{{ url('/blog') }}" class="text-secondary text-decoration-none hover-white">Articles</a>
                <a href="{{ url('/#contact') }}" class="btn-spot btn-sm py-1 px-3">Connect</a>
            </nav>
        </div>
    </header>

    <main style="position: relative; z-index: 5;">
        @yield('content')
    </main>

    <footer class="py-5 border-top" style="border-color: var(--spot-border) !important; position: relative; z-index: 5;">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="small text-secondary font-mono">
                ✦ {{ date('Y') }} {{ $profile->name ?? 'Md. Alif Ahmed' }} — Interactive Creative Engineering
            </div>
            <a href="{{ url('/admin/login') }}" class="small text-secondary text-decoration-none">Admin Workspace</a>
        </div>
    </footer>

    <script>
        lucide.createIcons();
        window.addEventListener('mousemove', e => {
            document.documentElement.style.setProperty('--mouse-x', `${e.clientX}px`);
            document.documentElement.style.setProperty('--mouse-y', `${e.clientY}px`);
        });
    </script>
    @stack('scripts')
</body>
</html>