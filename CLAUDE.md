# Frenchmen Theme — Claude Code Context

## Project Overview
Custom WordPress theme for **Frenchmen Party** — a Caribbean all-inclusive party brand.
- Theme slug: `frenchmen`
- Version: 1.0.0
- Built by: Elite Dev Studios
- PHP 8.0+, WordPress 6.0+

## Stack
- **WordPress** custom theme (no page builder)
- **Vite 5** — asset bundler (`npm run dev` / `npm run build` / `npm run watch`)
- **PostCSS** with `postcss-import`, `postcss-nesting`, `autoprefixer`
- **No JS framework** — vanilla JS (`src/js/main.js`)

## Directory Structure
```
themes/frenchmen/
├── src/
│   ├── css/
│   │   ├── main.css                  # CSS entry point
│   │   ├── base/                     # variables, reset, typography, utilities
│   │   ├── components/               # buttons, etc.
│   │   └── sections/                 # stats, parties, map, contact
│   └── js/
│       └── main.js                   # JS entry point
├── assets/                           # Vite build output (do not edit directly)
│   ├── css/style.css
│   └── js/main.js
├── template-parts/sections/          # Page section partials
│   ├── section-hero.php
│   ├── section-about.php
│   ├── section-stats.php
│   ├── section-parties.php
│   ├── section-featured-event.php
│   ├── section-radio.php
│   ├── section-map.php
│   ├── section-gallery.php
│   ├── section-cta.php
│   └── section-contact.php
├── inc/
│   ├── theme-setup.php
│   ├── enqueue.php
│   ├── template-functions.php
│   └── customizer.php
├── functions.php
├── front-page.php
├── header.php
├── index.php
├── vite.config.js
├── postcss.config.js
└── package.json
```

## Key Conventions
- CSS constants defined in `src/css/base/variables.css`
- Sections are self-contained PHP partials in `template-parts/sections/`
- Assets built to `assets/` — never edit files there directly
- Theme constants: `FM_THEME_VERSION`, `FM_THEME_DIR`, `FM_THEME_URI`

## Development Workflow
```bash
cd themes/frenchmen
npm run dev      # Vite dev server
npm run build    # Production build
npm run watch    # Watch mode
```

## Notes
- Local Sites (Local by Flywheel) environment
- One-page layout loaded via `front-page.php`
