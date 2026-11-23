<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', ($profile->name ?? 'Md. Alif Ahmed') . ' — Boutique E-Commerce Studio')</title>
    <meta name="description" content="@yield('meta_description', $profile->bio ?? 'Boutique E-Commerce Studio specializing in bespoke Laravel architectures, headless storefronts, and conversion-engineered systems.')">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --studio-bg: #09090b;
            --studio-surface: #121215;
            --studio-border: rgba(255, 255, 255, 0.08);
            --studio-accent: #a3e635;
            --studio-accent-hover: #84cc16;
            --studio-text: #f4f4f5;
            --font-display: 'Syne', sans-serif;
            --font-body: 'Plus Jakarta Sans', sans-serif;
        }
        body {
            background-color: var(--studio-bg);
            color: var(--studio-text);
            font-family: var(--font-body);
            line-height: 1.7;
            min-height: 100vh;
        }
        .font-display { font-family: var(--font-display); }
        .studio-nav {
            background: rgba(9, 9, 11, 0.85);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--studio-border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        .studio-card {
            background: var(--studio-surface);
            border: 1px solid var(--studio-border);
            border-radius: 16px;
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.3s ease;
        }
        .studio-card:hover {
            transform: translateY(-4px);
            border-color: rgba(163, 230, 53, 0.4);
        }
        .btn-lime {
            background: var(--studio-accent);
            color: #09090b;
            font-weight: 700;
            border-radius: 9999px;
            padding: 10px 24px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-lime:hover {
            background: var(--studio-accent-hover);
            color: #09090b;
            transform: scale(1.02);
        }
        .btn-lime-outline {
            border: 1px solid rgba(163, 230, 53, 0.4);
            color: var(--studio-accent);
            font-weight: 600;
            border-radius: 9999px;
            padding: 10px 24px;
            text-decoration: none;
            transition: all 0.2s ease;
        }
        .btn-lime-outline:hover {
            background: rgba(163, 230, 53, 0.1);
            color: var(--studio-accent);
        }
    </style>
    @stack('styles')
</head>
<body>
    <header class="studio-nav py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ isset($currentWorkspace) && $currentWorkspace->slug !== 'default' ? url('/u/' . $currentWorkspace->slug) : url('/') }}" class="text-white text-decoration-none fw-bolder font-display fs-5 d-flex align-items-center gap-2">
                <span class="p-1 rounded-circle" style="background: var(--studio-accent); width: 10px; height: 10px;"></span>
                <span>{{ $profile->name ?? 'Portfolio Builder' }}</span>
            </a>
            <nav class="d-none d-md-flex align-items-center gap-4 small fw-medium">
                <a href="{{ url('/#about') }}" class="text-secondary text-decoration-none hover-white">Agency</a>
                <a href="{{ url('/#projects') }}" class="text-secondary text-decoration-none hover-white">Case Works</a>
                <a href="{{ url('/#services') }}" class="text-secondary text-decoration-none hover-white">Expertise</a>
                <a href="{{ url('/blog') }}" class="text-secondary text-decoration-none hover-white">Insights</a>
                <a href="{{ url('/#contact') }}" class="btn-lime btn-sm py-1 px-3">Hire Studio</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="py-5 border-top" style="border-color: var(--studio-border) !important;">
        <div class="container d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="small text-secondary">
                © {{ date('Y') }} {{ $profile->name ?? 'Md. Alif Ahmed' }} — Boutique E-Commerce Engineering
            </div>
            <div class="d-flex gap-3 small text-secondary">
                <a href="{{ url('/admin/login') }}" class="text-secondary text-decoration-none">Admin Portal</a>
                <span>·</span>
                <span>Sub-Second Latency Guaranteed</span>
            </div>
        </div>
    </footer>

    <script>lucide.createIcons();</script>
    @stack('scripts')
</body>
</html>