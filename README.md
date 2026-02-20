# Frenchmen Theme

Custom WordPress theme for Frenchmen Party - Caribbean's ultimate all-inclusive party experience.

## Features

- **Custom Design**: Built from scratch with no plugin dependencies
- **Energetic Animations**: Scroll-triggered animations, animated counters, hover effects
- **Video Hero**: Full-screen video background with audio toggle
- **Responsive**: Mobile-first design with smooth mobile navigation
- **Performance**: Optimized CSS/JS with Vite build system
- **Accessibility**: WCAG compliant with proper focus states and ARIA labels
- **Modern CSS**: Uses CSS custom properties, logical properties, container queries

## Requirements

- WordPress 6.0+
- PHP 8.0+
- Node.js 18+ (for development)

## Installation

1. Upload the `frenchmen` folder to `/wp-content/themes/`
2. Activate the theme in WordPress Admin → Appearance → Themes
3. Set your front page to display a static page (Settings → Reading)
4. Upload a custom logo (Appearance → Customize → Site Identity)

## Development

### Setup

```bash
cd wp-content/themes/frenchmen
npm install
```

### Commands

```bash
# Development with hot reload
npm run dev

# Build for production
npm run build

# Watch mode
npm run watch
```

### File Structure

```
frenchmen/
├── assets/           # Compiled CSS/JS
├── inc/              # PHP includes
├── src/              # Source CSS/JS
│   ├── css/
│   │   ├── base/
│   │   ├── components/
│   │   └── sections/
│   └── js/
├── template-parts/   # Template partials
│   └── sections/     # Home page sections
├── templates/        # Page templates
├── functions.php
├── front-page.php
├── header.php
├── footer.php
└── style.css
```

## Page Templates

- **Home Page**: Uses `front-page.php` with all sections
- **Food Court**: Template for food vendor showcase

## Customizer Options

- Hero video URL
- Hero title and subtitle
- Ticket URL
- Contact email

## Theme Sections

1. **Hero** - Video background with BlockO branding
2. **About** - Brand story with image grid
3. **Stats** - Animated counters (25+ Years, 6 Events, 1 Vibe)
4. **Parties** - Event logos by category
5. **Featured Event** - BlockO spotlight
6. **Radio** - SoundCloud embed
7. **Map** - Google Maps
8. **Gallery** - Album cards
9. **CTA** - Ticket call-to-action
10. **Contact** - Email and social links

## Credits

- **Theme**: Elite Dev Studios
- **Client**: Frenchmen Party

## License

GNU General Public License v2 or later
