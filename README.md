# Maillot Vert – WordPress Theme

Custom block theme for [maillot-vert.ch](https://maillot-vert.ch). Content is built
from ten project specific ACF blocks; there are no page builder plugins involved.

## Requirements

| | |
|---|---|
| PHP | 8.0+ |
| WordPress | 6.4+ |
| Plugins | Advanced Custom Fields **Pro** (required), WPML (optional – the theme degrades gracefully without it) |
| Node | 18+ (only for building the stylesheet) |

## Getting started

```bash
npm install      # once
npm run watch    # rebuilds assets/css/main.css while you edit the SCSS
npm run build    # one-off production build
```

> **assets/css/main.css is generated.** Edit `assets/scss/main.scss` instead –
> anything written directly into the CSS file is lost on the next build.

## Structure

```
assets/
  css/main.css          generated – do not edit
  scss/main.scss        global styles (source of truth)
  js/main.js            small site-wide behaviour
  favicon/              favicons referenced from header.php
components/
  elements/             PHP classes/functions loaded by functions.php.
                        These files are require_once'd, so they must only
                        *define* things and never echo markup at load time.
  blocks/
    blocks-register.php registers every block + its field group
    <block>/
      block.json        block metadata (styles/scripts are wired here)
      <block>.php       render template
      <block>.acf.php   local field group
      <block>.css       block styles, loaded only when the block is used
extensions/
  acf/                  options pages, post types, taxonomies, shared fields
  helper/               date formatting, block helpers
```

## Wo Feldgruppen registriert werden – und warum das zwei Muster sind

Das ist die eine Stolperfalle im Theme. Beide Muster sind richtig, aber nicht
austauschbar:

| Ort | Geladen | Registrierung |
|---|---|---|
| `extensions/acf/*.acf.php` | beim Laden von `functions.php` | `add_action( 'acf/include_fields', … )` |
| `components/blocks/<block>/<block>.acf.php` | von `blocks-register.php` auf `init` | `acf_add_local_field_group()` **direkt** |

Die Block-Feldgruppen werden erst auf `init` geladen. Zu diesem Zeitpunkt hat ACF
`acf/include_fields` bereits ausgelöst — ein dort nachträglich registrierter
Callback läuft nie, und der Block erscheint im Editor **ohne jedes Feld**, ohne
Fehlermeldung. `acf_add_local_field_group()` schreibt direkt in ACFs lokalen
Speicher, der später beim Rendern des Editors gelesen wird; der direkte Aufruf ist
deshalb korrekt und das, was alle Blöcke hier tun.

Symptom, falls es doch passiert: Der Block lässt sich einfügen und rendert im
Frontend, aber die Seitenleiste bleibt leer.

## Writing a block template

Every render template follows the same three-line pattern:

```php
if ( ! mv_block_open( $block, 'block-foo-container default-container', ! empty( $is_preview ) ) ) {
    return;   // the block is switched off – render nothing at all
}
// ... markup ...
mv_block_close();
```

`mv_block_open()` handles the anchor, the `display` toggle and the editor-only
"Hidden" badge.

Helpers available inside templates (see `extensions/helper/block.php`):

| Helper | Purpose |
|---|---|
| `mv_the_image( $field, $size, $attr )` | responsive `<img>` with srcset, dimensions and lazy loading |
| `mv_the_link( $field, $classes )` | escaped anchor, adds `rel="noopener noreferrer"` for `_blank` |
| `mv_icon( $name )` | inlines an SVG from `assets/images/icons` |

## Manifeste

Kurze Reflexionen von Teilnehmenden auf die Frage
*„Before you leave, take a moment to reflect. What's staying with me from tonight?
(a key contact, a key moment, a key learning)"*.

| Baustein | Wo |
|---|---|
| Post-Type `manifest` | `extensions/acf/manifest_posttype.acf.php` |
| Taxonomie `manifest-year` | `extensions/acf/manifest_years.acf.php` |
| Felder + Options-Schalter | `extensions/acf/manifest_fields.acf.php` |
| Karte, Kürzung, Abfragen | `extensions/helper/manifest.php` |
| Block „Manifest Teaser" | `components/blocks/manifest-teaser/` |
| Block „Manifest Wall" | `components/blocks/manifest-wall/` |
| Overlay + Jahresfilter | `assets/js/manifest.js`, `assets/scss/manifest.scss` |

**Der Post-Type ist bewusst nicht öffentlich abfragbar.** Ein Manifest hat keine
Detailseite — es wird im Slider, auf der Wall und im Overlay gelesen. Ohne
`publicly_queryable => false` würde WordPress für jeden Eintrag eine leere
Single-View ausliefern und indexieren lassen.

**Die Karten sind anonym.** Die Felder `author_name` und `author_role` existieren
bereits an jedem Manifest, werden aber nicht ausgegeben. Der einzige Schalter dafür
liegt unter *Theme Settings → Manifeste → Namen anzeigen*; sobald er an ist,
erscheinen Name und Funktion auf jeder Karte und im Overlay. Bis dahin trägt die
Karte nur das Jahr.

**Gekürzt wird serverseitig.** `mv_manifest_card()` schneidet ein Statement an der
Wortgrenze ab (420 Zeichen im Teaser, 320 auf der Wall). Nur eine tatsächlich
gekürzte Karte bekommt den „Weiterlesen"-Knopf und ein `<template>` mit dem
Volltext — bei kurzen Texten gibt es kein Overlay, weil es nichts nachzuliefern
gäbe. Manifeste ohne Statement werden übersprungen.

**Eine zweite Achse** (key contact / key moment / key learning) wäre eine weitere
Taxonomie nach dem Muster von `manifest_years.acf.php` plus eine zweite Chip-Reihe
im Wall-Template.

## Conventions

- **Escape on output.** `esc_html()` for text, `esc_attr()` for attributes,
  `esc_url()` for URLs, `wp_kses_post()` for WYSIWYG fields.
- **No inline styles in templates.** Layout belongs in the block's CSS file.
- Buttons are `<a class="mv-button">` – never `<a><button></button></a>`.
- ACF image fields return the **attachment ID** so `mv_the_image()` can build a
  responsive image.

## Notes

- SVG uploads are restricted to administrators and sanitised on upload
  (`functions.php`). Do not loosen this without a replacement sanitiser.
- The block category `maillot-vert` is registered in `functions.php`; block.json
  files must use that slug.
- Splide is only loaded on pages that actually contain the gallery slider.
