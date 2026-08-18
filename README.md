# Aimeos.org theme for Pagible

This Composer package provides the Aimeos.org frontend theme, extension
builder and TYPO3 importer for [Pagible CMS](https://pagible.com).

It contains the theme schema, Blade views, public assets, the ZIP generator,
its download route, the supported Aimeos, Laravel and TYPO3 extension
templates, and a generic TYPO3 migration command.

## Requirements

- PHP 8.2 or newer
- PHP ZIP extension
- `aimeos/pagible-core` 0.12
- `aimeos/pagible-theme` 0.12

## Installation

```bash
composer require aimeos/pagible-aimeosorg
php artisan vendor:publish --tag=cms-theme
```

Before stable 0.12 releases of `aimeos/pagible-core` and
`aimeos/pagible-theme` are available, the host application must provide
compatible 0.12 development branches or branch aliases. Keep the package
constraints at `^0.12` instead of weakening them.

Select `aimeos` as the Pagible page theme. Laravel package discovery registers
`Aimeos\Cms\AimeosServiceProvider` automatically.

## Extension builder

The `aimeos::extension-builder` content element displays the extension form.
The package automatically registers the CSRF-protected download endpoint at
`POST /cmsapi/extension-builder` and limits generation to five requests per
minute and host/IP pair.

Available templates:

- Aimeos extensions: 2022.x through 2026.x
- Laravel theme extensions: 2022.x through 2026.x
- TYPO3 extensions: 2022.x through 2026.x

TYPO3 packages include the matching Aimeos extension under
`Resources/Private/Extensions/<project-name>`. Generated ZIP files replace the
`<extname>` and `<EXTNAME>` placeholders and rename application theme
directories to the chosen project name.

## TYPO3 importer

Configure a Laravel database connection for the TYPO3 database, then import
all pages for the selected TYPO3 domain:

```bash
php artisan aimeos:import \
    --connection=typo3 \
    --domain=example.org:1 \
    --theme=your-theme \
    --file-base=https://example.org/fileadmin
```

Use one or more `--page` options to re-import only selected TYPO3 page IDs:

```bash
php artisan aimeos:import --connection=typo3 --domain=example.org:1 --page=106
```

Add `--dry-run` to inspect the selected pages without creating or updating
Pagible content. Run `php artisan help aimeos:import` for all options.

The importer handles TYPO3 pages, redirects, shared content references and the
stock header, text, text-with-image, image, HTML and shortcut elements. It also
converts Bootstrap Package accordions and carousels. Unknown content types are
imported only when they contain a regular heading or body text; extension-
specific plugin behavior is not migrated.

## Theme contents

```text
pagible-aimeosorg/
├── composer.json
├── schema.json
├── routes/aimeos.php
├── src/
│   ├── AimeosServiceProvider.php
│   ├── Commands/AimeosImport.php
│   ├── ExtensionBuilder.php
│   └── Controllers/ExtensionController.php
├── resources/extensions/
├── public/
└── views/
```

The service provider registers the `aimeos` schema and view namespace, the
`aimeos:import` command, the extension-builder rate limiter and download route,
and publishes assets to `public/vendor/cms/aimeos`.

## License

The theme package is licensed under the MIT License. Generated extension
templates retain the license declarations contained in their package files.
