<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Portfolio | Portfolio Builder</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        :root {
            --admin-accent: #10b981;
            --admin-accent-hover: #059669;
        }
        body {
            background: radial-gradient(circle at 50% 10%, #13232c, #070b12 80%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, sans-serif;
            padding: 2rem 1rem;
        }
        .register-card {
            width: 100%;
            max-width: 520px;
            background: rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            border-radius: 1.25rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6);
            padding: 2.5rem;
        }
        .brand-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.35);
            color: var(--admin-accent);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.25rem;
        }
        .btn-emerald {
            background: var(--admin-accent);
            border-color: var(--admin-accent);
            color: #ffffff;
            font-weight: 600;
        }
        .btn-emerald:hover {
            background: var(--admin-accent-hover);
            border-color: var(--admin-accent-hover);
            color: #ffffff;
        }
        .form-control:focus {
            border-color: var(--admin-accent);
            box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25);
        }
        .url-preview-badge {
            font-size: 0.8rem;
            background: rgba(16, 185, 129, 0.1);
            color: var(--admin-accent);
            border: 1px solid rgba(16, 185, 129, 0.25);
            border-radius: 6px;
            padding: 4px 8px;
            display: block;
            margin-top: 6px;
            word-break: break-all;
        }
    </style>
</head>
<body>
    <div class="register-card">
        <div class="text-center mb-4">
            <div class="brand-icon">
                <i data-lucide="layers" style="width: 30px; height: 30px;"></i>
            </div>
            <h1 class="h3 fw-bold mb-1 tracking-tight text-white">PORTFOLIO BUILDER</h1>
            <p class="text-secondary small mb-0">Create your dynamic portfolio & showcase your projects</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger py-2 px-3 small mb-3">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf

            <!-- Full Name / Display Name -->
            <div class="mb-3">
                <label for="name" class="form-label small text-secondary">Full Name / Public Display Name</label>
                <div class="input-group">
                    <span class="input-group-text bg-body-secondary border-secondary-subtle">
                        <i data-lucide="user" style="width: 16px; height: 16px;"></i>
                    </span>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required autofocus placeholder="e.g. John Doe" oninput="suggestUsername(this.value)">
                </div>
                <small class="text-muted" style="font-size: 0.75rem;">This name will appear on your frontend navbar and portfolio identity.</small>
            </div>

            <!-- Username / Handle -->
            <div class="mb-3">
                <label for="username" class="form-label small text-secondary">Username / URL Slug</label>
                <div class="input-group">
                    <span class="input-group-text bg-body-secondary border-secondary-subtle font-monospace text-secondary" style="font-size: 0.85rem;">/u/</span>
                    <input type="text" name="username" id="username" class="form-control font-monospace" value="{{ old('username') }}" required placeholder="john-doe" oninput="updateUrlPreview(this.value)">
                </div>
                <div id="urlPreview" class="url-preview-badge">
                    <i data-lucide="link" style="width: 12px; height: 12px;" class="me-1"></i>
                    <span>{{ url('/u') }}/<strong id="slugPlaceholder">john-doe</strong></span>
                </div>
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label small text-secondary">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-body-secondary border-secondary-subtle">
                        <i data-lucide="mail" style="width: 16px; height: 16px;"></i>
                    </span>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autocomplete="email" placeholder="john@example.com">
                </div>
            </div>

            <!-- Password -->
            <div class="row g-3 mb-4">
                <div class="col-sm-6">
                    <label for="password" class="form-label small text-secondary">Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-body-secondary border-secondary-subtle">
                            <i data-lucide="lock" style="width: 16px; height: 16px;"></i>
                        </span>
                        <input type="password" name="password" id="password" class="form-control" required autocomplete="new-password" placeholder="Min. 8 characters">
                    </div>
                </div>
                <div class="col-sm-6">
                    <label for="password_confirmation" class="form-label small text-secondary">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text bg-body-secondary border-secondary-subtle">
                            <i data-lucide="check" style="width: 16px; height: 16px;"></i>
                        </span>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password" placeholder="Confirm password">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-emerald w-100 py-2 d-flex align-items-center justify-content-center gap-2 shadow-sm">
                <span>Create My Portfolio</span>
                <i data-lucide="arrow-right" style="width: 16px; height: 16px;"></i>
            </button>
        </form>

        <div class="text-center mt-4 pt-3 border-top border-secondary-subtle">
            <span class="text-secondary small">Already have an account?</span>
            <a href="{{ route('admin.login') }}" class="text-emerald text-decoration-none fw-semibold small ms-1">
                Sign In to Dashboard &rarr;
            </a>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function updateUrlPreview(val) {
            const clean = val.toLowerCase().replace(/[^a-z0-9_-]/g, '-').replace(/^-+|-+$/g, '');
            document.getElementById('slugPlaceholder').innerText = clean || 'your-slug';
        }

        function suggestUsername(name) {
            const usernameInput = document.getElementById('username');
            if (!usernameInput.dataset.touched) {
                const slug = name.toLowerCase().trim().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
                usernameInput.value = slug;
                updateUrlPreview(slug);
            }
        }

        document.getElementById('username').addEventListener('input', function() {
            this.dataset.touched = 'true';
        });
    </script>
</body>
</html>
