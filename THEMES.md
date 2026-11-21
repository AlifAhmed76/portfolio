# Theme Engine Architecture & Specification

## 1. Overview
The Theme Engine powers the multi-aesthetic capability of the **Md. Alif Ahmed Portfolio CMS**. It decouples frontend presentation from core data models while enabling zero-downtime switching, non-destructive HMAC-encrypted previews, transactional publishing, and instant rollback.

---

## 2. Supported Themes

### 1. Crystal 3D (Default Theme)
- **Directory**: `resources/views/themes/crystal-3d/`
- **Aesthetic**: Dark-first editorial identity with vibrant emerald accents (`#10b981`), frosted glass surfaces (`backdrop-filter: blur(16px)`), CSS 3D crystal prism facet on the Hero card, and responsive typography.
- **Tokens**:
  - `accent_color`: `#10b981`
  - `surface_blur`: `16px`
  - `border_opacity`: `0.08`
  - `font_heading`: `Plus Jakarta Sans`
  - `font_body`: `Inter`

### 2. Minimal Professional
- **Directory**: `resources/views/themes/minimal-professional/`
- **Aesthetic**: Monochrome, clean editorial layout focused on recruiter scannability, clear typography, and subtle hairline dividers.
- **Tokens**:
  - `accent_color`: `#0f172a`
  - `surface_blur`: `0px`
  - `border_opacity`: `0.1`

### 3. Creative Studio
- **Directory**: `resources/views/themes/creative-studio/`
- **Aesthetic**: Expressive storytelling layout with amber/gold accents (`#f59e0b`), large display typefaces, and high-impact case study cards.
- **Tokens**:
  - `accent_color`: `#f59e0b`
  - `font_heading`: `Plus Jakarta Sans`

### 4. Futuristic Tech
- **Directory**: `resources/views/themes/futuristic-tech/`
- **Aesthetic**: Dark terminal HUD aesthetic with cyan accents (`#06b6d4`), monospace telemetry status lines, bracket borders, and system diagnostics styling.
- **Tokens**:
  - `accent_color`: `#06b6d4`
  - `font_heading`: `JetBrains Mono`
  - `font_body`: `JetBrains Mono`

---

## 3. Theme Manifest Specification (`theme.json`)
Every theme directory must contain a valid `theme.json` file adhering to this schema:
```json
{
  "slug": "crystal-3d",
  "name": "Crystal 3D",
  "version": "1.0.0",
  "author": "Md. Alif Ahmed",
  "description": "Default dark-first editorial theme with emerald accents and signature CSS 3D crystal depth.",
  "mode": "dark-first",
  "tokens": {
    "accent_color": "#10b981",
    "surface_blur": "16px",
    "border_opacity": "0.15",
    "font_heading": "Plus Jakarta Sans",
    "font_body": "Inter",
    "radius": "1rem"
  }
}
```

---

## 4. View Resolution Cascade
When rendering a theme view (e.g., `pages.home`), `ThemeResolver` resolves templates in the following order:
1. `themes.{active_theme}.{view}` (Theme-specific template)
2. `themes.crystal-3d.{view}` (Baseline fallback)
3. Direct view path (Root fallback)

---

## 5. Non-Destructive Preview & Rollback
- **Preview**: Clicking "Preview Theme" in `/admin/themes` generates a cryptographically signed HMAC token containing `{slug, expires_at}`. Visiting `/?theme_preview={token}` renders the candidate theme without modifying the database or affecting any live visitors.
- **Transactional Publish**:
  1. Validates `theme.json` and required layout views.
  2. Creates a snapshot in `theme_revisions` storing the prior active theme and token overrides.
  3. Updates `workspace_themes` and `SiteSetting::active_theme`.
  4. Flushes the frontend cache via `CacheInvalidationService`.
- **Rollback**: Clicking "Rollback" restores the exact prior theme and tokens atomically.
