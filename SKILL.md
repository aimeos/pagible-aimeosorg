---
name: aimeos
description: Aimeos.org enterprise ecommerce theme and downloadable extension builder for Pagible CMS.
license: MIT
metadata:
  author: Aimeos
---

# Aimeos Theme Design System

## Direction

Use a confident enterprise ecommerce style: white navigation and content surfaces, deep navy feature areas, warm gold rules and accents, and technical imagery with ample whitespace. The visual reference is aimeos.org, adapted to the shared Pagible view markup.

## Foundations

- Use `Noto Sans` when available, followed by `Arial, Helvetica, sans-serif`, and keep the existing Pico typography scale.
- Use `--pico-*` variables for theme colors. Primary is warm gold; secondary is technical blue; contrast is deep navy.
- Keep geometry square by default. Small radii are allowed only where the native control requires a visible boundary.
- Keep content widths readable and section spacing generous.
- Use thin borders, rules and underlines for hierarchy instead of heavy shadows.
- Reserve navy surfaces for the first hero, focused feature bands and the footer.

## Components

- Header: white, gold lower rule, restrained navigation, wide logo lockup.
- Hero: navy field, light heading, gold subtitle, generated commerce-network artwork on the right at desktop widths.
- Buttons: rectangular, strong contrast, visible hover and focus states.
- Cards: flat white surfaces with a gold top rule; do not use floating rounded tiles.
- Statistics: calm three-column figures with fine separators; keep values concise and provide labels in text.
- Logo cloud: a compact pale strip of linked image files; every logo needs a meaningful organization name.
- Documentation: navy sidebar accents, clear current-page state and readable code blocks.
- Footer: pale blue-grey content area followed by a navy legal bar.
- Extension builder: centered create/submit actions, accessible reveal behavior, validated project names and server-generated ZIP downloads.

## Accessibility

- Preserve the skip link, semantic navigation, search dialog and native disclosure controls.
- Maintain WCAG 2.2 AA contrast and a visible `:focus-visible` outline.
- Keep touch targets at least 2.25rem and respect `prefers-reduced-motion`.
- Use logical properties so the theme remains usable in RTL languages.

## Do

- Style the classes already emitted by `theme/views/`.
- Prefer existing Pico variables and direct rem values over new token layers.
- Keep technical decoration non-essential and prevent it from obscuring copy.
- Test the header, hero, cards, docs sidebar and footer at mobile and desktop widths.

## Do not

- Do not add web fonts or utility-class frameworks. Keep JavaScript scoped to focused component interactions such as the extension builder.
- Do not bake headings or calls to action into images.
- Do not turn every component into a dark panel.
- Do not introduce demo content or a package-local demo seeder.
