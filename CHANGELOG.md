# Frenchmen Theme Changelog

## Context Prompt for New Sessions

**Read this to get up to speed on the project:**

This is a custom WordPress theme for "Frenchmen Party" (french-men.local), a Caribbean all-inclusive party brand. The theme was built from scratch without Elementor or plugin dependencies, using Vite for CSS/JS compilation.

### Key Information
- **Local URL**: http://french-men.local/
- **GitHub**: https://github.com/elitedevstudios/frenchmen.git
- **Theme Location**: `wp-content/themes/frenchmen/`
- **Build Tool**: Vite with PostCSS (postcss-import, postcss-nesting, autoprefixer)
- **FontAwesome**: CDN v6.5.1 (not kit)

### Theme Structure
```
frenchmen/
├── assets/           # Compiled CSS/JS
├── src/
│   ├── css/          # Source CSS (BEM, logical properties, container queries)
│   │   ├── base/     # variables, reset, typography, utilities, animations
│   │   ├── components/ # buttons, header, mobile-nav, footer
│   │   └── sections/ # hero, about, stats, parties, featured, radio, map, gallery, cta, contact
│   └── js/main.js    # Scroll animations, counters, mobile menu, audio toggle
├── inc/              # PHP includes (theme-setup, enqueue, template-functions, customizer)
├── template-parts/sections/ # Section PHP templates
├── templates/        # Page templates (Food Court)
└── front-page.php    # Home page template
```

### Home Page Sections
1. **Hero** - BlockO video background, "Frenchmen Soca Season" subtitle
2. **About** - Brand story with image grid
3. **Stats** - Animated counters (25+ years, 6 events, 1 vibe)
4. **Parties** - 3 categories with logos, BlockO marked as "Upcoming"
5. **Featured Event** - BlockO spotlight
6. **Radio** - SoundCloud embed with wave animation
7. **Map** - Google Maps (Pearly Beach, Ocho Rios)
8. **Gallery** - Photo album cards
9. **CTA** - "Super Early Birds Available"
10. **Contact** - Email + social links
11. **Footer**

### Build Commands
```bash
cd wp-content/themes/frenchmen
npm run dev    # Development with HMR
npm run build  # Production build
npm run watch  # Watch mode
```

### Design System
- **Colors**: Beach-themed palette with gold (#f5c518), teal, sand tones
- **Fonts**: Montserrat (headings), Inter (body)
- **CSS**: BEM naming, logical properties, oklch colors

---

## Version History

### [1.0.2] - 2026-02-20

#### Fixed
- **Food Court page** - Images now display in full (removed aspect-ratio cropping)
- **Gallery section** - Now uses 3-column grid layout with responsive breakpoints
- **Gallery section** - Logo, text, and buttons are now centered
- **Gallery section** - "View Album" buttons now have defined coral/red styling

#### Added
- **Radio section** - Equalizer animation effect (animated bars in background)

---

### [1.0.1] - 2026-02-20

#### Fixed
- FontAwesome switched from kit to CDN (v6.5.1) - kit URL was returning 403
- SoundCloud embed URL format corrected
- Animation visibility - elements now visible by default, animations trigger on scroll

#### Changed
- Simplified animation CSS to ensure content displays without JS

---

### [1.0.0] - 2026-02-20

#### Added
- Initial custom theme build
- All home page sections (hero, about, stats, parties, featured, radio, map, gallery, cta, contact)
- Vite build system with PostCSS
- Mobile-responsive navigation
- Scroll-triggered animations
- Animated number counters
- Hero video with audio toggle
- Food Court page template
- WordPress Customizer options (hero video, titles, ticket URL, contact email)
- 404 page
- README documentation

---

## Pending Improvements

- [x] ~~Food Court page - display full menu item images (not cropped)~~ ✅ v1.0.2
- [x] ~~Radio section - add equalizer animation effect (like original site)~~ ✅ v1.0.2
- [x] ~~Gallery section - 3x3 grid, centered content, more defined buttons~~ ✅ v1.0.2
- [ ] Re-enable scroll animations with proper triggering
