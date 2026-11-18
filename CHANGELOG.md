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

### [Unreleased, deployed to live 2026-11-18]

#### Changed
- **Mailing list popup now hosts the Constant Contact inline form** ("Frenchmen Standard Sign-Up Form", list "Website Form"). CC script loads only on first open. CC owns fields (email, first/last name required, country), list and spam protection (invisible reCAPTCHA v2). Built-in email form remains as fallback if the CC form ID is cleared in Mailing List > Settings.
- Popup opens **non-modal** (`dialog.show()`) with its own backdrop, focus trap, Escape and scroll lock: with `showModal()` the reCAPTCHA image challenge (appended to body) was inert and unclickable.

#### Fixed
- "Show popup" setting was ignored when unticked (localized `"0"` string is truthy).
- CC IDs in settings are format-validated; malformed input keeps the previous value instead of being stripped into a wrong ID.
- Focus no longer left on a hidden element after closing an auto-opened popup.

### [Unreleased, deployed to live 2026-11-16]

#### Added
- **Mailing list popup** (`inc/mailing-list.php`, `assets/mailing-list/`) - single-email "Get updates on the next event" popup. Opens after 12s or 50% scroll; hidden 14 days after closing, permanently after subscribing; "Get event updates" button in footer nav reopens it. Native `<dialog>`.
- **Mailing List admin** - `fm_subscriber` post type (admins only, no manual add), Export CSV button (formula-escaped, UTF-8 BOM), Settings page for popup copy/timing and reCAPTCHA v3 keys.
- **Spam protection** - honeypot, 2s minimum fill time, 5 attempts/IP/10 min rate limit, reCAPTCHA v3 (action + score checked server-side, fails closed) once both keys are saved. No WP nonce on purpose: page cache would freeze it.
- Popup assets are hand-written and enqueued separately, NOT part of the Vite build.

#### Changed
- **About section** - em dashes removed from copy; image grid now uses Climax photos (scaled WP sizes).
- **Contact section** - em dash removed from subtitle.
- **Food Court page** - 2026 menus per party (Rise Up, NiteCap, Foreplay) with tabs and WebP signs.

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
- [x] ~~Parties section - 3-category grouped layout with admin ordering~~ ✅ v1.0.3
- [ ] Re-enable scroll animations with proper triggering

---

### [1.0.3] - 2026-03-27

#### Added — Parties Section: 3-Category Layout with Admin Ordering

**New CPT: `fm_party_category`** (WP Admin → Party Categories)
- Fields: Title, Category Logo (media uploader), Tagline/Description, Display Order
- Admin list columns: Logo preview, Order, Tagline
- Change the Order number to reorder categories each season

**Updated CPT: `fm_party`**
- New **Category** dropdown to assign each party to a category
- New admin column showing which category each party belongs to

**3 Categories (as confirmed):**

| Order | Category | Tagline | Parties |
|---|---|---|---|
| 1 | Frenchmen Soca Season | Carnival energy all season. | BlockO, Rise Up, Lyme |
| 2 | Frenchmen Weekend | One weekend. Three events. Nonstop energy. | Rise Up, Nitecap, Foreplay |
| 3 | Frenchmen New Year's | Ring in the new year the Frenchmen way. | Climax |

**Visual layout (from approved design screenshot):**
- Each category: large category logo centered → row of event logo cards below
- Event cards: white rounded card, hover lift, optional pulsing UPCOMING badge
- Categories separated by subtle divider, stack vertically

**Key meta keys added:**

| Meta Key | CPT | Purpose |
|---|---|---|
| `_fm_pcat_logo` | `fm_party_category` | Category brand logo attachment ID |
| `_fm_pcat_description` | `fm_party_category` | Tagline text |
| `_fm_pcat_order` | `fm_party_category` | Display order (ASC) |
| `_fm_party_category_id` | `fm_party` | Assigned category post ID |

**Files changed:**
- `inc/custom-post-types.php` — new CPT + meta boxes + admin columns
- `inc/template-functions.php` — new `fm_get_party_categories()` function
- `template-parts/sections/section-parties.php` — rewritten to loop by category
- `src/css/sections/parties.css` — new category block + logo styles

**Setup required after deploy:**
1. WP Admin → **Party Categories** → Create the 3 categories with logos, taglines, and order 1/2/3
2. WP Admin → **Parties** → Edit each party and assign it to a category
3. Run `npm run build` from `themes/frenchmen/`
