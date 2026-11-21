# Md. Alif Ahmed — Portfolio & Enterprise CMS

> **Web Developer | Technical Project Lead | E-commerce Solutions Specialist**  
> *Building Digital Experiences. Engineering Business Solutions.*

A production-grade personal portfolio CMS engineered with Laravel 11, MariaDB/MySQL, and Bootstrap 5. Featuring an extensible Multi-Theme Engine (4 complete themes), Visual Page Builder with JSON schema revisions, Trusted Code Editor with allowlist security and immutable backups, Dynamic Technical Blog, Spam-Protected Contact Inbox, Comprehensive SEO (dynamic sitemap.xml, robots.txt, JSON-LD), and Automated SHA-256 Backups.

---

## 🌟 Highlights & Key Features

- **Identity & Precision**: Specifically crafted for **Md. Alif Ahmed** with the official title *"Web Developer | Technical Project Lead | E-commerce Solutions Specialist"* (strictly NO "Sr."). All personal content is database-driven and manageable via `/admin`.
- **Multi-Workspace Scoped Architecture**: Clean database schema scoping via `BelongsToWorkspace` trait and global query scopes. Resolved strictly server-side from the authenticated user token (never from client request inputs).
- **Theme Engine Studio (4 Complete Themes)**:
  1. **Crystal 3D (Default)**: Dark-first editorial identity with emerald accents (`#10b981`), frosted glass surfaces (`backdrop-filter: blur(16px)`), signature CSS 3D crystal depth facet on Hero card, and responsive typography.
  2. **Minimal Professional**: Crisp, high-contrast monochrome layout focused on recruiter scannability.
  3. **Creative Studio**: Bold expressive typography, warm amber contrast, and storytelling layout.
  4. **Futuristic Tech**: Terminal-inspired dark telemetry aesthetic with monospace accents.
  - *Non-Destructive Previews*: Cryptographically signed HMAC preview tokens (`?theme_preview=...`).
  - *Transactional Publishing & Instant Rollback*: Zero downtime and automated history snapshots.
- **Visual Page Builder (`/admin/pages/{page}/builder`)**:
  - Drag-and-drop & accessible reordering of 8 validated block types (`hero`, `about`, `skills`, `projects`, `services`, `experience`, `contact`, `custom_html`).
  - Strict HTML sanitization blocking `<script>` tags, inline event handlers, and `javascript:` URLs.
  - Responsive preview iframe (Desktop 100%, Tablet 768px, Mobile 375px switcher).
  - Draft autosaving and atomic publishing with revision snapshots.
- **Trusted Code Editor (`/admin/code-editor`)**:
  - Integrated CodeMirror 6 code editor with dark syntax theme.
  - Strict directory allowlist (`resources/views/themes/*`).
  - Active path traversal defense (blocking `..`, leading slashes, null bytes, `.env`, `config/`, `routes/`, `vendor/`).
  - Syntax integrity validation (`php -l` and `json_decode`) before saving.
  - Pre-save immutable revision tracking with SHA-256 checksums and one-click rollback.
  - Strictly restricted to `owner` role.
- **Dynamic Blog CMS (`/blog`)**:
  - Category and tag management, automatic reading time calculation (~200 wpm), draft/publish scheduling.
  - Search and filterable public blog feed.
  - Structured data (JSON-LD `BlogPosting` and `BreadcrumbList`).
- **Contact Inbox & Spam Defense (`/admin/contacts`)**:
  - Public submission protected by an invisible honeypot field (`hp_website`) and IP rate limiting (3 submissions per 10 minutes).
  - Admin inbox with unread counter, detail viewer, archiving, and deletion.
- **Comprehensive SEO & Discovery**:
  - Dynamic `GET /sitemap.xml` generating XML entries for all published pages, projects, and articles.
  - Dynamic `GET /robots.txt` disallowing admin routes and preview tokens.
- **Automated Backup System**:
  - `php artisan portfolio:backup`: Exports 34 database tables, archives media assets, and computes SHA-256 manifest checksums.
- **Automated Test Coverage**:
  - 45 feature and unit tests with 252 assertions passing 100% in both SQLite in-memory and MySQL (`alif_portfolio_test`).

---

## 🚀 Quick Start Guide

### 1. Requirements
- PHP 8.2+ (with `pdo_mysql`, `mbstring`, `gd`, `zip`, `intl`, `sodium`)
- MariaDB 10.4+ or MySQL 8.0+
- Composer 2.7+
- Node.js 18+ and npm

### 2. Installation
```bash
# 1. Clone repository
git clone https://github.com/alifahmed/portfolio.git
cd portfolio

# 2. Install PHP and JS dependencies
composer install
npm install

# 3. Configure environment
cp .env.example .env
php artisan key:generate

# 4. Run migrations and database seeder
php artisan migrate --seed
php artisan storage:link

# 5. Compile frontend assets
npm run build
```

### 3. Launching the Local Server
```bash
# Start Laravel development server
php artisan serve
```
- **Public Site**: [http://127.0.0.1:8000](http://127.0.0.1:8000)
- **Admin Panel**: [http://127.0.0.1:8000/admin](http://127.0.0.1:8000/admin)

---

## 🔐 Default Admin Credentials

| Parameter | Default Value | Notes |
| :--- | :--- | :--- |
| **Login URL** | `/admin/login` | Rate-limited to 5 attempts/min |
| **Email** | `admin@alifahmed.com` | Configurable via `ADMIN_EMAIL` in `.env` |
| **Password** | `ChangeMeInProd123!` | Configurable via `ADMIN_PASSWORD` in `.env` |
| **Role** | `owner` | Highest privilege |

---

## 🧪 Running Automated Tests

```bash
# Run standard SQLite in-memory test suite (45 tests)
php artisan test

# Run full MySQL test suite against test database
php vendor/phpunit/phpunit/phpunit -c phpunit.mysql.xml
```

---

## 📁 Key Documentation References
- [DESIGN.md](file:///c:/Users/oxioa/Desktop/Portfolio/DESIGN.md) — Design tokens, color system, typography scale, and glassmorphism levels.
- [DEPLOYMENT.md](file:///c:/Users/oxioa/Desktop/Portfolio/DEPLOYMENT.md) — Production VPS guide (Ubuntu, Nginx, PHP-FPM, SSL, Supervisor, Cron).
- [THEMES.md](file:///c:/Users/oxioa/Desktop/Portfolio/THEMES.md) — Theme engine architecture, manifests, and preview mechanics.
- [BLOCKS.md](file:///c:/Users/oxioa/Desktop/Portfolio/BLOCKS.md) — Visual Page Builder block catalog, JSON schemas, and sanitization rules.
- [SECURITY.md](file:///c:/Users/oxioa/Desktop/Portfolio/SECURITY.md) — Threat model, Code Editor sandbox, honeypot spam protection, and audit logs.
- [TEST_REPORT.md](file:///c:/Users/oxioa/Desktop/Portfolio/TEST_REPORT.md) — Test suite results across SQLite and MariaDB.
- [KNOWN_ISSUES.md](file:///c:/Users/oxioa/Desktop/Portfolio/KNOWN_ISSUES.md) — Documented environment behaviors and unconfirmed owner items.
