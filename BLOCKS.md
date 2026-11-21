# Visual Page Builder & Block Architecture

## 1. Overview
The Visual Page Builder allows the portfolio owner to compose, order, configure, and publish custom pages and landing experiences using validated, reusable block schemas. It features atomic draft saves, pre-publish revision snapshots, responsive preview viewports, and strict XSS sanitization.

---

## 2. Block Schema Catalog

### 1. Hero Banner (`hero`)
- **Settings**:
  - `badge` (string): Availability or status badge text.
  - `headline` (string): Primary large display title.
  - `subheadline` (string): Value proposition lead paragraph.
  - `cta_primary_label` (string): Primary button text.
  - `cta_primary_url` (string): Primary button destination (`#projects`, `/contact`, etc.).
  - `cta_secondary_label` (string): Secondary action text.
  - `cta_secondary_url` (string): Secondary action URL.

### 2. About Narrative (`about`)
- **Settings**:
  - `title` (string): Section headline.
  - `subtitle` (string): Small category label.
  - `bio` (text): Multiline bio paragraph.
  - `highlights` (comma-separated string or array): Key technical competencies.

### 3. Skills Matrix (`skills`)
- **Settings**:
  - `title` (string): Section headline.
  - `subtitle` (string): Eyebrow subtitle.
  - `layout` (enum: `grouped`, `cloud`, `list`): Display structure.
  - `show_evidence` (bool): Whether to display descriptive competency evidence.

### 4. Project Showcase (`projects`)
- **Settings**:
  - `title` (string): Section headline.
  - `subtitle` (string): Eyebrow subtitle.
  - `limit` (int): Number of project cards to display (default 6).
  - `featured_only` (bool): Filter to only starred projects.
  - `layout` (enum: `grid`, `carousel`).

### 5. Specialized Services (`services`)
- **Settings**:
  - `title` (string): Section headline.
  - `subtitle` (string): Eyebrow subtitle.

### 6. Career Timeline (`experience`)
- **Settings**:
  - `title` (string): Section headline.
  - `subtitle` (string): Eyebrow subtitle.
  - `show_type` (enum: `all`, `work`, `education`): Filters timeline items.

### 7. Contact Block (`contact`)
- **Settings**:
  - `title` (string): Section headline.
  - `subtitle` (string): Eyebrow subtitle.
  - `form_enabled` (bool): Toggle interactive message form.
  - `show_socials` (bool): Display verified network profile badges.

### 8. Custom HTML (`custom_html`)
- **Settings**:
  - `html` (string): Sanitized HTML snippet.
  - **Sanitization Rule**: Strict regex filter strips all `<script>`, `<noscript>`, `<iframe>`, `<object>`, `<embed>`, inline event handlers (`onclick`, `onload`, `onerror`), and `javascript:` URIs prior to storage and rendering.

---

## 3. Builder Data Structure & JSON Contract
Page blocks are stored in `pages.content_json` as an ordered array:
```json
[
  {
    "id": "block-1700000000",
    "type": "hero",
    "enabled": true,
    "settings": {
      "headline": "Web Developer | Technical Project Lead",
      "subheadline": "Building enterprise web applications...",
      "badge": "Available for Select Projects"
    }
  }
]
```

---

## 4. Revisions & Publishing Pipeline
1. **Save Draft**: Persists changes to `pages.content_json` without modifying published output or creating revisions.
2. **Publish**:
   - Validates all blocks against schema definitions.
   - Computes next `revision_number` and saves snapshot in `page_revisions`.
   - Sets `pages.status = 'published'` and updates `published_at`.
   - Flushes frontend cache via `CacheInvalidationService`.
3. **Restore**: Selecting any previous revision reloads its exact block tree into the canvas with instant preview.
