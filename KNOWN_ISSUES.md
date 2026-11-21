# Known Behaviors, Architecture Notes & Owner Confirmation List

## 1. System Architecture & Environment Behaviors

### 1. Database Collation & MariaDB Compatibility
- **Observation**: Laravel 11's default collation `utf8mb4_0900_ai_ci` is only supported on MySQL 8.0+.
- **Resolution**: `config/database.php` default collation is configured to `utf8mb4_unicode_ci`. This guarantees 100% compatibility across local MariaDB 10.4+, production MySQL 8.0+, and shared hosting environments without collation mismatch errors.

### 2. Multi-Workspace Architecture
- **Behavior**: The application architecture is fully multi-workspace enabled.
- **Scoping**: `workspace_id` is resolved strictly server-side from the authenticated user (`auth()->user()->workspace_id`) or the default active workspace. It is **never** accepted from untrusted client request input.

### 3. Windows Sandbox `is_readable` CRT Behavior
- **Observation**: Under certain Windows sandboxed security tokens, PHP's CRT `is_readable()` call can return `false` on files where `file_get_contents()` and `fopen()` succeed.
- **Resolution**: PHPUnit bootstrap verification uses `file_exists()` to guarantee reliable test suite execution across sandboxed and host environments.

---

## 2. Appendix A: Unconfirmed Owner Content Checklist
In accordance with Master Prompt instructions, no fake metrics or unverified personal credentials were invented. All unverified fields are pre-populated with clear, database-editable placeholders that the owner can update anytime from the `/admin` panel:

- [ ] **Contact Phone Number**: `Pending: owner to confirm` (Manage in `/admin/identity`)
- [ ] **WhatsApp Number**: `Pending: owner to confirm` (Manage in `/admin/identity`)
- [ ] **GitHub Profile URL**: `https://github.com/Pending-owner-to-confirm` (Manage in `/admin/identity`)
- [ ] **LinkedIn Profile URL**: `https://linkedin.com/in/Pending-owner-to-confirm` (Manage in `/admin/identity`)
- [ ] **Facebook Profile URL**: `https://facebook.com/Pending-owner-to-confirm` (Manage in `/admin/identity`)
- [ ] **Exact Case Study Percentage Metric**: Marked as "Pending: owner to confirm" in Enterprise E-Commerce case study outcome (Manage in `/admin/projects`)
- [ ] **Academic Institution & Degree Details**: Marked as "Pending: owner to confirm" (Manage in `/admin/experience`)
