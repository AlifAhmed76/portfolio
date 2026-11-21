# Known Issues & Environmental Mitigations

1. **Local MySQL Windows Sandbox Isolation**:
   - In standard sandbox mode on Windows, network sockets (port 3306) are blocked with error 10013. When connecting to local MySQL daemon for migration/testing commands, execution requires `BypassSandbox: true` or fallback to SQLite for local file-based sandbox operations. Full MySQL tests are executed with database connectivity enabled.
2. **Owner Content Verification**:
   - In accordance with Spec Appendix A, all unverified owner information (exact client metrics, personal phone numbers, custom domain configurations) is populated with clearly marked placeholders until verified by the owner.
