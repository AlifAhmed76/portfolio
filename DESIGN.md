# Design System & Token Architecture

## 1. Design Vision & Philosophy
The portfolio for **Md. Alif Ahmed** is built around an uncompromising modern engineering aesthetic:
- **Default Theme**: *Crystal 3D* — Dark-first, editorial, high-contrast, emerald-accented system featuring subtle CSS 3D prism depth, layered frosted glass surfaces, and typographic clarity.
- **Companion Themes**:
  - *Minimal Professional*: Ultra-clean recruiter-focused editorial layout with monochrome precision.
  - *Creative Studio*: Expressive, high-impact typography with bold contrast and storytelling focus.
  - *Futuristic Tech*: Terminal-inspired dark telemetry aesthetic with monospace accents.
- **Strict Accessibility**: Zero-flash theme toggling (`data-bs-theme="dark"` / `data-bs-theme="light"`), persistent via `localStorage`, compliant with WCAG 2.1 AA contrast standards.

---

## 2. Color Tokens

### Dark Theme (Default)
| Token Name | Value | Purpose |
| :--- | :--- | :--- |
| `--theme-bg` | `#070a12` | Deep void background |
| `--theme-surface` | `rgba(15, 23, 42, 0.72)` | Layered glass card surface |
| `--theme-surface-solid` | `#0f172a` | Non-translucent card surface |
| `--theme-border` | `rgba(255, 255, 255, 0.08)` | Structural facet boundary |
| `--theme-accent` | `#10b981` | Vibrant emerald accent |
| `--theme-accent-hover` | `#059669` | Interactive focus / hover |
| `--theme-accent-rgb` | `16, 185, 129` | Alpha blending |
| `--theme-text-primary`| `#f8fafc` | High-contrast body & headings |
| `--theme-text-secondary`| `#94a3b8`| Subtitles, metadata & captions |
| `--theme-text-muted` | `#64748b` | Footers & timestamps |

### Light Theme
| Token Name | Value | Purpose |
| :--- | :--- | :--- |
| `--theme-bg` | `#f8fafc` | Crisp off-white background |
| `--theme-surface` | `rgba(255, 255, 255, 0.88)`| Translucent glass cards |
| `--theme-surface-solid` | `#ffffff` | Solid elevated cards |
| `--theme-border` | `rgba(0, 0, 0, 0.08)` | Clean dividing lines |
| `--theme-accent` | `#059669` | Deep emerald (contrast ratio > 4.5:1) |
| `--theme-accent-hover` | `#047857` | Darker emerald hover |
| `--theme-text-primary`| `#0f172a` | Deep slate primary text |
| `--theme-text-secondary`| `#475569`| Muted body text |
| `--theme-text-muted` | `#94a3b8` | Subdued borders & metadata |

---

## 3. Typography Scale
- **Heading Font**: `'Plus Jakarta Sans', system-ui, -apple-system, sans-serif`
- **Body Font**: `'Inter', system-ui, -apple-system, sans-serif`
- **Monospace Font**: `'JetBrains Mono', 'Fira Code', 'Courier New', monospace`

| Scale | Size | Line Height | Weight | Application |
| :--- | :--- | :--- | :--- | :--- |
| Display | 3.5rem (56px) | 1.1 | 800 (Bold) | Hero main headline |
| H1 | 2.5rem (40px) | 1.2 | 700 (Bold) | Section headlines |
| H2 | 1.875rem (30px) | 1.25 | 700 (Bold) | Card titles, case titles |
| H3 | 1.5rem (24px) | 1.3 | 600 (Semibold)| Subsection headers |
| H4 | 1.25rem (20px) | 1.4 | 600 (Semibold)| Block titles |
| Body Lead | 1.125rem (18px) | 1.6 | 400 (Regular) | Intro paragraphs |
| Body | 1rem (16px) | 1.65 | 400 (Regular) | Standard prose |
| Small | 0.875rem (14px) | 1.5 | 500 (Medium) | Badges, metadata |
| Micro | 0.75rem (12px) | 1.4 | 600 (Semibold)| Status indicators |

---

## 4. Spacing, Elevation & Glassmorphism
- **Base Unit**: 4px
- **Scale**: `4px, 8px, 12px, 16px, 24px, 32px, 48px, 64px, 96px, 128px`
- **Glass Effects**:
  - `backdrop-filter: blur(16px)`
  - Card outline: `1px solid var(--theme-border)`
  - Crystal prism highlight: `box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37), inset 0 1px 0 0 rgba(255, 255, 255, 0.1)`

---

## 5. Responsive Breakpoints
- **Mobile (Small)**: `360px` (min container padding, full-width cards)
- **Mobile (Standard)**: `390px` (standard smartphone view)
- **Tablet**: `768px` (2-column grids, collapsed sidebar)
- **Desktop (Laptop)**: `1024px` (3-column grids, sticky elements)
- **Wide Desktop**: `1280px+` (Max content container `1200px`)

---

## 6. Motion & Transitions
- Micro-interactions (buttons, badges): `150ms ease-out`
- Card elevation / depth transform: `300ms cubic-bezier(0.16, 1, 0.3, 1)`
- Theme switch color fade: `250ms ease`
- Respects `@media (prefers-reduced-motion: reduce)`: disables 3D depth and transitions.
