# Code-Review: Maillot Vert Theme

Review-Stand: v1.0.24 · Umgesetzt in: v1.1.0 · 2026-09-03

> **Status: alle 32 Punkte umgesetzt.** Die Änderungen liegen im Working Tree,
> es wurde nichts committet. `git diff` zeigt den vollständigen Umfang,
> `git checkout -- .` verwirft alles.
>
> Verifiziert mit: PHP-8.4-Lint über alle 38 PHP-Dateien, 40 Render-Szenarien
> je Block (sichtbar / versteckt / Editor-Vorschau / leere Felder), Unit-Test
> des Datums-Helpers, Angriffstest des SVG-Sanitizers, Balance-Check des
> kompilierten CSS.
>
> **Noch offen (braucht deine Hand):**
> 1. `npm install` – die alte `node_modules` (Gulp 4, 2024) läuft nicht mehr
>    unter Node 22+. Der Build ist auf die reine Sass-CLI umgestellt.
> 2. Frontend einmal durchklicken – das Markup mehrerer Blöcke wurde
>    semantisch geändert (Details unten in den jeweiligen Punkten).
> 3. Footer-Menü unter *Design → Menüs* der Position „Footer" zuweisen
>    (bis dahin greift ein Fallback auf `home_url()`).

Grundsätzlich ein sauber gedachtes, schlankes ACF-Block-Theme: klare Ordnerstruktur,
ein Block = ein Ordner (block.json + php + acf.php + css), CSS-Variablen für Typo/Farben,
Auto-Loader für Components/Helper/ACF. Die folgenden Punkte sind nach Dringlichkeit sortiert.

---

## 🔴 Bugs, die jetzt live wirken

### 1. Alle Favicon-Links sind 404
`header.php` verlinkt auf `/assets/images/favicon/…`, die Dateien liegen aber in `/assets/favicon/`.
Betrifft apple-touch-icon, favicon-16/32, site.webmanifest, safari-pinned-tab.
Zusätzlich: `<link rel="shortcut icon" href=""/>` mit leerem `href` lässt den Browser die Seite
selbst nochmal laden – ersatzlos löschen.

### 2. SCSS-Pipeline zerstört das echte Stylesheet
`assets/scss/main.scss` enthält 6 Zeilen (u. a. `body { background-color: red; }`),
`assets/css/main.css` enthält 271 gepflegte Zeilen. Ein `npm start` überschreibt main.css
komplett mit rotem Hintergrund. Entweder SCSS wirklich als Quelle aufbauen (main.css → main.scss
migrieren) oder Gulp/SCSS ganz entfernen. Aktuell ist es eine Zeitbombe im Repo.

### 3. Ungültige CSS-Syntax in main.css
```css
a { &:hover { cursor: pointer; } }
```
Das ist SCSS, kein CSS – der Browser verwirft den ganzen Block. Nach `a {` bricht der Parser ab.

### 4. `the_title($supporter)` in supporter-strip/-list
`the_title()` nimmt `$before, $after, $echo` – keine Post-ID. Es wird also der Titel des
*aktuellen* Posts ausgegeben, mit dem Supporter-Objekt als Präfix. Korrekt:
`esc_attr( get_the_title( $supporter ) )`.

### 5. `get_the_terms(...)[0]` ohne Guard (supporter-strip)
Hat ein Supporter keine `partner-category`, liefert `get_the_terms()` `false`/`WP_Error`
→ Fatal Error in PHP 8. Ebenso: `foreach ($supporters …)` läuft ohne `if ($supporters)`.

### 6. `ICL_LANGUAGE_CODE` / `icl_get_languages()` ungeschützt
`header.php` und `components/elements/header.php` sterben mit Fatal Error, sobald WPML
deaktiviert ist (Update, Staging, Lizenz abgelaufen). Immer `defined()` / `function_exists()`
prüfen bzw. konsequent `apply_filters('wpml_current_language', null)` nutzen (wie im Footer).
Gleiches gilt für ACF: `if (!function_exists('get_field')) return;`

### 7. `strftime()` in `extensions/helper/date.php`
Seit PHP 8.1 deprecated, in PHP 9 entfernt. Auch `date()` nutzt die Server-Zeitzone,
nicht die WordPress-Zeitzone. Ersetzen durch `wp_date()` bzw. `IntlDateFormatter`.

### 8. `frontpage.php` wird nie geladen
Die Template-Hierarchie kennt nur `front-page.php` (mit Bindestrich). Datei umbenennen
oder löschen.

### 9. Block-Scripts existieren nicht
Jede `block.json` deklariert `"script": "block-hero"`, `"block-facts"` usw. – registriert ist
in `blocks-register.php` aber nur `block-gallery-slider`. `location-teaser` zeigt außerdem
per Copy-Paste auf `block-facts`. Nicht registrierte Handles → `_doing_it_wrong`-Notices.
Alle unbenutzten `script`-Keys entfernen.

---

## 🟠 Sicherheit

### 10. Kein Output-Escaping
Praktisch jedes `echo get_field(...)` geht ungefiltert raus – in Attribute (`href`, `src`,
`target`, `alt`), in Text und in `style`. Jeder Redakteur mit Editor-Rechten kann damit
JavaScript einschleusen. Konsequent:

| Kontext | Funktion |
|---|---|
| Text | `esc_html()` |
| Attribut | `esc_attr()` |
| URL | `esc_url()` |
| WYSIWYG/HTML | `wp_kses_post()` |

Grep-Hilfe: `grep -rn "echo get_field" components/`

### 11. SVG-Upload mit deaktivierter MIME-Prüfung
`my_svgs_disable_real_mime_check()` gibt den vom Dateinamen abgeleiteten Typ zurück,
ohne echte Prüfung – zusammen mit erlaubtem `svg`, `json`, `obj`, `fbx` ein klassischer
Stored-XSS-Vektor (SVG darf `<script>` enthalten). Mindestens:
- Upload auf Administratoren beschränken (`current_user_can('manage_options')`)
- SVGs beim Upload sanitizen (z. B. `enshrined/svg-sanitize` oder Plugin "Safe SVG")
- die MIME-Check-Deaktivierung ganz entfernen

---

## 🟡 WordPress-Standards / SEO

### 12. Kein einziges `add_theme_support()`
Es fehlen u. a.:
```php
add_theme_support('title-tag');        // aktuell hat die Seite gar kein <title>!
add_theme_support('post-thumbnails');
add_theme_support('html5', ['style','script','navigation-widgets']);
add_theme_support('responsive-embeds');
add_theme_support('align-wide');
add_editor_style();                    // Block-Editor sieht Frontend-Styles
```
`title-tag` ist der wichtigste Punkt – ohne SEO-Plugin liefert die Seite keinen Titel.

### 13. `wp_body_open()` fehlt
Direkt nach `<body>` einfügen – viele Plugins (Analytics, Consent, GTM) hängen dort ein.

### 14. Bootstrap 3.3.7 per CDN im `<head>`
Hart verlinkt, nicht enqueued, render-blocking, von 2016, und `maxcdn.bootstrapcdn.com`
ist abgekündigt. Im Theme wird keine einzige Bootstrap-Klasse benutzt – ersatzlos raus.
Falls doch nötig: über `wp_enqueue_style()` mit lokaler Kopie.

### 15. Text-Domain
`style.css` hat keinen `Text Domain:`-Header, `load_theme_textdomain()` wird nie aufgerufen,
und `__('WEBSEITE', 'MV')` nutzt eine Domain, die es nicht gibt. Entweder sauber aufsetzen
(`maillot-vert` als Domain, `/languages`-Ordner) oder das eine `__()` durch Klartext ersetzen.

### 16. `index.php` hat keinen Loop
```php
get_header(); the_content(); get_footer();
```
funktioniert nur zufällig auf singulären Seiten. Auf Archiven, Suche und 404 wird nichts
gerendert. Minimal:
```php
while (have_posts()) { the_post(); the_content(); }
```
Und ergänzen: `404.php`, `search.php`, ggf. `page.php` / `single.php`.

### 17. Kein `screenshot.png`
Im Theme-Wechsler erscheint ein graues Feld. 1200×900 px reicht.
Ebenso fehlen in `style.css`: `Description`, `License`, `Requires at least`, `Requires PHP`.

---

## 🟢 Performance & Bilder

### 18. Bilder als reine URLs statt `wp_get_attachment_image()`
Alle ACF-Bildfelder liefern offenbar "URL" und werden als `<img src="…">` ausgegeben.
Damit gibt es **kein `srcset`, kein `sizes`, kein `loading="lazy"`, kein `width`/`height`**
→ auf Mobile werden Desktop-Originale geladen, plus Layout-Shift (CLS).

Umstellen auf ACF-Rückgabetyp "Image Array"/"ID" und:
```php
echo wp_get_attachment_image($id, 'large', false, [
    'alt'     => $alt,
    'loading' => 'lazy',
]);
```
Für das Hero-Bild stattdessen `loading="eager"` + `fetchpriority="high"`.

### 19. Schriften ohne `preconnect`
```html
<link rel="preconnect" href="https://use.typekit.net" crossorigin>
<link rel="preconnect" href="https://p.typekit.net" crossorigin>
```
Spart typisch 100–300 ms beim First Paint.

### 20. Splide wird immer geladen
`splide.min.js` + CSS landen auf jeder Seite, auch ohne Gallery-Block. Besser über
`block.json` → `"viewScript"` bzw. `"viewStyle"`, dann lädt WordPress es nur bei
tatsächlich vorhandenem Block. Splide-Version ist außerdem als `'1.0'` hardcodiert.

### 21. GSAP + ScrollTrigger liegen ungenutzt im Repo
Werden nirgends enqueued. Entweder nutzen oder löschen (spart Repo-Größe und Verwirrung).
Ebenso: `assets/js/main.js` ist leer und wird nie eingebunden.

---

## 🔵 Wartbarkeit / Architektur

### 22. ~20 Zeilen Copy-Paste-Boilerplate in jedem Block
Der `$anchor` / `$visibility` / "Hidden"-Badge-Block ist zehnmal identisch dupliziert –
inklusive der Inkonsistenzen (mal `<?php echo $anchor; ?> class=`, mal ohne Leerzeichen).
Vorschlag: ein Helper.

```php
// extensions/helper/block.php
function mv_block_open(array $block, string $class = ''): void { … }
function mv_block_close(array $block): void { … }
```
Dann pro Block zwei Zeilen statt zwanzig. Ein zentraler Fix wirkt sofort überall.

### 23. `is_admin()` erkennt die Block-Vorschau nicht zuverlässig
ACF rendert Block-Previews über die REST-API, dort ist `is_admin()` `false`.
ACF stellt dafür `$is_preview` (bzw. `$block['data']`) im Render-Template bereit – das ist
die richtige Prüfung.

### 24. Sichtbarkeits-Logik über Inline-`display:none`
Versteckte Blöcke werden trotzdem gerendert und ausgeliefert (Inhalt steht im HTML,
Bilder werden geladen, Google indexiert sie). Sauberer: früher `return;` im Template.

### 25. Layout über Inline-Styles
`style="width:30%"`, `style="text-align:right"`, `style="padding-top:0"` etc. verteilt über
footer.php und alle Blöcke. Das umgeht das Stylesheet, ist nicht responsive überschreibbar
und macht Anpassungen teuer. In `main.css` bzw. die Block-CSS verschieben.

### 26. Hardcodierte Domain im Footer
```php
<a href="https://maillot-vert.ch/<?= $language; ?>/about">About</a>
```
Bricht auf Local/Staging. Besser: WP-Menü (`register_nav_menus()` + `wp_nav_menu()`) oder
ACF-Link-Felder in den Theme-Optionen – die Struktur dafür existiert ja schon.

### 27. Kleinigkeiten
- `THEME_VERSION` wird definiert, aber nie benutzt; stattdessen wird die Version dreimal
  neu über `wp_get_theme()` geholt.
- Funktion heißt `mv_register_style()`, macht aber auch `enqueue_script` → `mv_enqueue_assets()`.
- `REAME.md` (Tippfehler) und leer.
- `.DS_Store`-Dateien liegen im Repo, obwohl in `.gitignore` – mit
  `git rm --cached` entfernen.
- `#main-container` hat zweimal `max-width` (140px, dann 100%).
- `package.json` deklariert `"watch": "gulp watch"`, der Task existiert im Gulpfile nicht.
- Leerer Media-Query `@media screen and (min-width: 860px) {}`.
- Auskommentierter Code (Background-Element, footer-center) → löschen, Git hat die Historie.

---

## ♿ Accessibility

### 28. `<a><button>…</button></a>`
Ungültiges HTML und für Screenreader/Tastatur kaputt. Entweder `<a class="btn">` oder
`<button>` mit JS – nicht beides ineinander.

### 29. Keine semantischen Landmarks
`#header-container`, `#main-container`, `#footer-container` sind alles `<div>`s.
→ `<header>`, `<main>`, `<footer>` + ein "Skip to content"-Link.

### 30. Alt-Texte
`alt=""` (facts, program, location-teaser), `alt="Mailott Vert Hero Image"` (Tippfehler,
und kein echter Alt-Text), `alt="MV Gallery Image 3"`. Alt-Text sollte aus der Mediathek
kommen: `get_post_meta($id, '_wp_attachment_image_alt', true)`.

### 31. Sprachumschalter
Der aktive Sprach-Button hat keinen `aria-current`, das Container-`div` kein `aria-label`.
Externe Links mit `target="_blank"` brauchen `rel="noopener noreferrer"` (im Footer + allen
Blöcken).

### 32. Überschriften-Hierarchie
`<h3>` wird als Block-Titel verwendet, `<h5>`/`<h6>` als Fließtext-Styling. Größe sollte über
die vorhandenen Utility-Klassen (`.fl`, `.fs`, `.fxs`) kommen, die Ebene über die Semantik.

---

## Umsetzung – was konkret passiert ist

### Neue Dateien
| Datei | Zweck |
|---|---|
| `extensions/helper/block.php` | `mv_block_open/close`, `mv_the_image`, `mv_the_link`, `mv_icon` – ersetzt die Boilerplate in allen 10 Blöcken |
| `404.php`, `search.php`, `searchform.php` | fehlende Templates |
| `README.md` | Setup, Struktur, Konventionen |
| `phpcs.xml`, `.editorconfig` | WordPress-Coding-Standard, einheitliche Formatierung |
| `screenshot.png` | Theme-Wechsler |

### Entfernt
`gulpfile.js`, `package-lock.json` (Deps komplett getauscht), ungenutztes
GSAP + ScrollTrigger, `REAME.md`, alle `.DS_Store`.

### Markup-Änderungen, die du im Frontend prüfen solltest
| Block | vorher | nachher |
|---|---|---|
| facts | `div.facts-item-wrapper > div.fact-item` | `ul > li` (gleiche Klassen, Liste zurückgesetzt) |
| team-grid | `div.team-grid-members > div` | `ul > li` |
| supporter-list | `div.block-supporter-list-wrapper > div` | `ul > li` |
| supporter-strip | `a > div.supporter-item` | unverändert, aber ohne Website wird `div.supporter-link` statt `a` gerendert |
| program | `div > h4 + p` | `dl > div > dt + dd` (`.program-row__title`) |
| ticket | `h3/h5/h4/h6` als Text-Styling | `h2` + `p` mit Größen-Utilities |
| hero | Untertitel als `h3` | `p.hero-subtitle` |
| alle | `<a><button></button></a>` | `<a class="mv-button">` |
| alle | versteckte Blöcke wurden gerendert und per Inline-CSS versteckt | werden gar nicht mehr gerendert; im Editor mit „Hidden"-Badge sichtbar |

### Bewusste Entscheidungen
- **ACF-Bildfelder liefern jetzt `id` statt `url`.** Nur das Rückgabeformat
  wurde geändert – in der Datenbank steht ohnehin die Attachment-ID, es gehen
  keine Inhalte verloren. `mv_image()` versteht zur Sicherheit weiterhin auch
  URLs.
- **Gulp raus, Sass-CLI rein.** Gulp 4 ist EOL und stirbt unter aktuellem Node
  mit `xtend is not a function`. `npm run build` / `npm run watch` machen jetzt
  dasselbe ohne die Abhängigkeitskette.
- **`assets/css/main.css` wurde einmalig aus dem neuen SCSS erzeugt**, damit das
  Theme sofort läuft. Ab `npm install` übernimmt das wieder Sass.
- **Block-Kategorie**: `block.json` verwies auf `"Maillot Vert"`, registriert war
  nichts. Jetzt Slug `maillot-vert`, in `functions.php` registriert.
- **`anchor`-Support** war in keiner `block.json` deklariert, obwohl alle
  Templates `$block['anchor']` lesen – nachgetragen.
- **SVG-Uploads**: nur noch für Administratoren, mit Sanitizing beim Upload
  (Scripts, `on*`-Handler, `javascript:`-URLs und externe Referenzen werden
  entfernt). Für mehr Härte: „Safe SVG" oder `enshrined/svg-sanitize`.
- **PHP-Kompatibilität**: bewusst bei 7.4-kompatibler Syntax geblieben, obwohl
  der Theme-Header 8.0 verlangt – falls die Produktion noch älter läuft.

### Nachtrag: Layout-Überarbeitung (nach dem Review)

Farben, Typo-Stufen und Formensprache unverändert. Geändert wurde, wie sich die
Elemente Platz teilen.

| Block | vorher | nachher |
|---|---|---|
| ticket | beide CTA-Boxen `position:absolute`, Container-Höhe 0, aufgefangen mit `padding-bottom:100px` | `repeat(auto-fit, minmax(260px,1fr))` im Fluss, Karte wächst mit dem Inhalt |
| facts | `max-height:60vh` + `max-height:420px` auf column-wrap, Bild absolut mit negativen Offsets | Grid ohne Höhendeckel; Bild überlappt via `grid-area`, aber erst ab 1100 px |
| team-grid | `4 × 25 % + 3 × 4 % = 112 %` | `repeat(auto-fill, minmax(200px,1fr))` |
| supporter-strip | `48 % + 48 % + 4 %`, exakt auf Kante | Auto-fit-Grid; Initialpartner spannen die volle Zeile |
| program | Text lag über dem absolut gesetzten Bild | zwei Grid-Spalten; unter 820 px rutscht das Bild über den Text |
| hero | Bild `max-width: calc(200%/100*70)` = 140 % der Spalte; unter 960 px 40 %+40 % | `minmax(0,1.05fr) minmax(0,1fr)`, Bild auf 100 % |
| location-teaser | 60 % + 35 % (5 % unbelegt) | zwei Grid-Spalten |
| container | `.container-width-full: 100vw` (Scrollbar-Overflow) | `100%`, Klassen mit `.block-container` qualifiziert |

**Global**

- Abstandsskala `--s-1`…`--s-6` plus `--gutter`; vertikaler Rhythmus über
  `.mv-block + .mv-block` statt der Mischung aus `10vw` / `5vh` / `50px` / nichts.
- Typo-Untergrenzen weicher: `--fl` von fix 35 px auf `clamp(1.9rem, 5vw, 3.1rem)`,
  Fließtext von 20 px auf `clamp(1rem, 1.4vw, 1.25rem)`. Dazu `text-wrap: balance`
  für Überschriften, `hyphens: auto` und `max-width: 68ch` für Absätze.
- Breakpoints einheitlich bei 560 / 820 / 1100 statt nur 960 / 680.
- `overflow-x: clip` statt `hidden` am Body — erzeugt keinen Scroll-Container,
  `position: sticky` funktioniert weiter.
- Uhrzeiten und Preise mit `font-variant-numeric: tabular-nums`.

**Animation** (neu, vorher gab es keine)

Blöcke blenden beim Scrollen mit 14 px Versatz über 500 ms ein, Rasterkinder mit
45 ms Stagger (bei max. 8 Elementen gedeckelt). Karten heben sich beim Hover um
3 px, Programmzeilen rücken 4 px ein. Die versteckenden Regeln greifen nur, wenn
`main.js` die Klasse `js-anim` setzt — ohne JavaScript, in alten Browsern und bei
`prefers-reduced-motion` ist sofort alles sichtbar. Zusätzlich blendet ein Timeout
nach 3 s alles ein, was der IntersectionObserver nicht erwischt hat.

### Nachtrag: Hover- und Press-States

Neu ergänzt, wo interaktive Elemente bisher gar keine Rückmeldung hatten:
Links im Redaktionsinhalt (wachsende Unterstreichung statt Ein/Aus), Logo,
Footer- und Legal-Links, LinkedIn-Icon, Mail-Icon im Team, Beitrags-Teaser,
Suchfeld-Fokus, Manifest-Karten und Galeriebilder. Dazu ein `:active`-Zustand
für Buttons und Chips, damit ein Klick sich gedrückt anfühlt.

**Alle Hover-Regeln liegen jetzt in `@media (hover: hover) and (pointer: fine)`.**
Das betrifft auch die vorher schon vorhandenen: Auf einem Touchscreen bleibt ein
`:hover` nach dem Antippen hängen, das Element bleibt also „beleuchtet“, bis man
woanders hintippt. Der gedrückte Zustand der Filter-Chips
(`[aria-pressed="true"]`) und alle `:focus-visible`-Regeln bleiben bewusst
ausserhalb des Guards — die gelten für Tastatur und Touch genauso.

**Was bewusst keinen Hover bekommt:** Hero-, Facts-, Programm- und
Location-Bilder. Ein Bild, das auf den Cursor reagiert, verspricht einen Klick,
den es nicht gibt. Einzige Ausnahme sind die Galeriebilder mit 3 % Zoom — dort
liest es sich als „das ist ein Foto“, nicht als Schaltfläche.

**Manifest-Karten** heben sich nur, solange der „Weiterlesen“-Knopf selbst
überfahren wird (`:has(.mv-manifest-card__more:hover)`), und nur bei Karten, die
tatsächlich gekürzt sind. Die Karte ist kein Link, also soll sie sich auch nicht
wie einer anfühlen.

### Wenn etwas schiefgeht
```bash
git diff                 # alles ansehen
git checkout -- <datei>  # einzelne Datei zurück
git checkout -- .        # alles zurück
```
