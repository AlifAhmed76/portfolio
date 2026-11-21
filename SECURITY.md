# Security Architecture & Threat Model

## 1. Security Overview
The **Md. Alif Ahmed Portfolio CMS** implements defense-in-depth principles across authentication, administrative file editing, contact spam defense, and database operations.

---

## 2. Threat Model & Mitigations

### Threat A: Path Traversal & Remote Code Execution in Code Editor
- **Risk**: Malicious attempts to read or overwrite critical files (`.env`, `routes/web.php`, `config/database.php`, `vendor/`) via relative paths (`../../`).
- **Mitigations**:
  1. **Strict Allowlist**: Only files residing inside `resources/views/themes/` are editable.
  2. **Strict Denylist**: Explicitly blocks `.env`, `config`, `routes`, `vendor`, `bootstrap`, `storage`, `database`, `app`, `artisan`.
  3. **Path Traversal Defense**: Rejects null bytes (`\0`), `..`, absolute paths (leading slashes, Windows drive letters `C:`), and hidden files (`.*`).
  4. **Realpath Boundary Validation**: Resolves canonical paths and asserts they remain strictly inside the project root.
  5. **Pre-Save Backups**: Every file edit automatically records an immutable snapshot in `code_revisions` with a SHA-256 hash.
  6. **Syntax Checks**: Rejects PHP/Blade syntax errors (`php -l`) and invalid JSON (`json_decode`) prior to disk writes.
  7. **Role Restriction**: Access is strictly gated to the `owner` role via `CodeEditorController` guards.

### Threat B: Contact Form Spam & Denial of Service
- **Risk**: Automated bots spamming message inboxes and exhausting server database resources.
- **Mitigations**:
  1. **Honeypot Field**: An invisible field `hp_website` (hidden via `display:none !important;` with `tabindex="-1"`) attracts automated bot submissions. If filled, the request is silently discarded with a 200 response without writing to the database.
  2. **Rate Limiting**: The public submission routes (`POST /` and `POST /contact`) enforce a strict `throttle:3,10` middleware (maximum 3 inquiries per 10 minutes per IP address).

### Threat C: Brute-Force Authentication Attacks
- **Risk**: Automated credential stuffing attacks against `/admin/login`.
- **Mitigations**:
  1. **Throttling**: `LoginRequest` throttles authentication attempts to a maximum of 5 attempts per minute per email/IP pair using Laravel's `RateLimiter`.
  2. **Session Regeneration**: Calls `$request->session()->regenerate()` upon successful authentication to eliminate session fixation vulnerabilities.

### Threat D: Cross-Site Scripting (XSS) & Cross-Site Request Forgery (CSRF)
- **Mitigations**:
  1. **CSRF Protection**: All state-modifying requests (`POST`, `PUT`, `PATCH`, `DELETE`) require a valid CSRF token verified by `VerifyCsrfToken` middleware.
  2. **Blade Escaping**: Public data rendering uses `{{ $var }}` (HTML entity escaping).
  3. **Custom HTML Block Sanitization**: Strips `<script>`, inline event handlers (`onclick`, `onload`, `onerror`), and `javascript:` URLs.

### Threat E: SQL Injection
- **Mitigations**:
  1. **Eloquent ORM & Query Builder**: 100% of database queries use PDO prepared statements with parameter binding. Zero raw SQL string concatenation.

---

## 3. Audit Logging
Every sensitive administrative action is logged to `activity_logs`:
- Admin login, logout, and failed attempts
- Profile & contact updates
- Theme preview, publication, and rollback
- Page builder draft save, publish, and revision restore
- Code editor file save, rollback, and syntax errors
- Message status changes (read, archived, deleted)
