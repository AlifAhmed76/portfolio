<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Md. Alif Ahmed — Web Developer | Technical Project Lead')</title>
    <meta name="description" content="@yield('meta_description', 'Dedicated Web Developer & Technical Project Lead specializing in custom Laravel engineering, enterprise e-commerce solutions, RESTful API architecture, and Meta Conversion API.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --font-main: 'Inter', system-ui, -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
            --accent-teal: #14b8a6;
            --accent-teal-light: #5eead4;
            --accent-teal-rgb: 20, 184, 166;
            --bg-color: #0f172a;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --card-hover-bg: rgba(30, 41, 59, 0.7);
            --card-border: rgba(148, 163, 184, 0.12);
        }

        [data-bs-theme="light"] {
            --bg-color: #f8fafc;
            --text-primary: #0f172a;
            --text-secondary: #475569;
            --card-hover-bg: rgba(255, 255, 255, 0.9);
            --card-border: rgba(203, 213, 225, 0.8);
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-secondary);
            font-family: var(--font-main);
            line-height: 1.65;
            overflow-x: hidden;
            scroll-behavior: smooth;
        }

        h1, h2, h3, h4, h5, h6, .text-heading {
            color: var(--text-primary);
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        /* Ambient Cursor Spotlight (Brittany Chiang style) */
        .spotlight-glow {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            pointer-events: none;
            z-index: 1;
            background: radial-gradient(650px circle at var(--mouse-x, -500px) var(--mouse-y, -500px), rgba(var(--accent-teal-rgb), 0.08), transparent 80%);
        }

        .split-card {
            border: 1px solid transparent;
            border-radius: 0.75rem;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .split-card:hover {
            background-color: var(--card-hover-bg);
            border-color: var(--card-border);
            box-shadow: 0 10px 30px -15px rgba(0, 0, 0, 0.5);
        }

        .tech-pill {
            font-size: 0.75rem;
            font-family: var(--font-mono);
            padding: 4px 12px;
            border-radius: 9999px;
            background: rgba(var(--accent-teal-rgb), 0.12);
            color: var(--accent-teal-light);
            border: 1px solid rgba(var(--accent-teal-rgb), 0.25);
            display: inline-block;
        }

        [data-bs-theme="light"] .tech-pill {
            color: #0f766e;
            background: rgba(20, 184, 166, 0.15);
        }

        /* Nav link indicators */
        .split-nav-link {
            display: flex;
            align-items: center;
            gap: 16px;
            color: var(--text-secondary);
            text-decoration: none;
            padding: 8px 0;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            transition: all 0.2s ease;
        }

        .split-nav-indicator {
            width: 32px;
            height: 1px;
            background-color: var(--text-secondary);
            transition: width 0.2s ease, background-color 0.2s ease;
        }

        .split-nav-link:hover,
        .split-nav-link.active {
            color: var(--text-primary);
        }

        .split-nav-link:hover .split-nav-indicator,
        .split-nav-link.active .split-nav-indicator {
            width: 64px;
            background-color: var(--accent-teal-light);
        }

        .beacon-pulse {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: var(--accent-teal);
            display: inline-block;
            box-shadow: 0 0 0 0 rgba(var(--accent-teal-rgb), 0.7);
            animation: beaconAnim 2s infinite;
        }
        @keyframes beaconAnim {
            to { box-shadow: 0 0 0 8px rgba(var(--accent-teal-rgb), 0); }
        }

        .project-img-preview {
            border-radius: 8px;
            border: 1px solid var(--card-border);
            transition: transform 0.3s ease;
        }

        .split-card:hover .project-img-preview {
            transform: scale(1.03);
            border-color: rgba(var(--accent-teal-rgb), 0.4);
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Spotlight mouse follow overlay -->
    <div class="spotlight-glow" id="cursorSpotlight"></div>

    @if (request()->has('theme_preview'))
        <div class="alert alert-warning py-2 px-3 small text-center mb-0 border-0 rounded-0 position-relative z-3 d-flex align-items-center justify-content-center gap-2">
            <i data-lucide="eye" style="width: 16px; height: 16px;"></i>
            <strong>Theme Preview Mode:</strong> Rendering with <code>Split Engineer</code>. Live site remains unaffected.
            <a href="{{ url('/') }}" class="btn btn-xs btn-outline-dark ms-2">Exit Preview</a>
        </div>
    @endif

    <main class="position-relative z-2">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();

        // Mouse Spotlight Glow tracking
        document.addEventListener('mousemove', e => {
            document.documentElement.style.setProperty('--mouse-x', `${e.clientX}px`);
            document.documentElement.style.setProperty('--mouse-y', `${e.clientY}px`);
        });

        // ScrollSpy Active Link Tracking
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.split-nav-link');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(sec => {
                const top = sec.offsetTop - 180;
                if (pageYOffset >= top) {
                    current = sec.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
