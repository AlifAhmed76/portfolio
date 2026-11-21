# Architecture & Technical Decisions Log

### DEC-001: Environment & Framework Selection
- **Context**: Environment has PHP 8.2.12 (ZTS x64), Node.js v22.23.1, npm 10.9.8, MariaDB 10.4.32.
- **Decision**: Installed Laravel 11.57.1 (latest framework release with active support for PHP 8.2+).
- **Rationale**: Laravel 11 provides optimal compatibility with PHP 8.2, native modern folder structure (`bootstrap/app.php`), fast bootstrapping, and full compatibility with shared hosting and VPS environments.

### DEC-002: Tooling & Runtime Binaries
- **Context**: Standalone Git, Composer, and MySQL services required in local Windows environment.
- **Decision**: Configured MinGit 2.44.0, Composer 2.11.2, enabled PHP extensions (`gd`, `zip`, `intl`, `sodium`, `pdo_mysql`, `pdo_sqlite`, `fileinfo`), and started MariaDB 10.4.32 on port 3306.
- **Rationale**: Meets all spec requirements for local development and CI testing without external assumptions.

### DEC-003: Database & Multi-Tenant Scoping
- **Context**: Spec Section 02 & 09 mandates single workspace for launch with clean multi-workspace foundation (`workspace_id` scoping, resolved server-side from user, never from request input).
- **Decision**: All application domain models will include `workspace_id` foreign key and apply a `WorkspaceScope` global scope when in tenant context. Platform owner/super admin operates on their assigned workspace.
- **Rationale**: Guarantees zero cross-workspace data leakage while fulfilling single-workspace launch requirements.
