<?php
/**
 * Maillot Vert theme bootstrap.
 *
 * @package MaillotVert
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'MV_THEME_VERSION' ) ) {
	define( 'MV_THEME_VERSION', wp_get_theme()->get( 'Version' ) );
}

// Kept for backwards compatibility with older template code.
if ( ! defined( 'THEME_VERSION' ) ) {
	define( 'THEME_VERSION', MV_THEME_VERSION );
}

if ( ! defined( 'MV_TEXT_DOMAIN' ) ) {
	define( 'MV_TEXT_DOMAIN', 'maillot-vert' );
}

/*-------------------------------------------------------------*/
/*------------------------ THEME SETUP ------------------------*/
/*-------------------------------------------------------------*/

/**
 * Register the features WordPress expects a theme to declare.
 */
function mv_theme_setup(): void {
	load_theme_textdomain( MV_TEXT_DOMAIN, get_template_directory() . '/languages' );

	// Without this WordPress never outputs a <title> tag.
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support(
		'html5',
		[
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		]
	);

	register_nav_menus(
		[
			'footer'    => __( 'Footer', 'maillot-vert' ),
			'footer_legal' => __( 'Footer – legal links', 'maillot-vert' ),
		]
	);

	// Show the front-end styles inside the block editor.
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/main.css' );
}
add_action( 'after_setup_theme', 'mv_theme_setup' );

/**
 * Give the theme's blocks their own category in the inserter.
 *
 * The block.json files referenced "Maillot Vert" without anything ever
 * registering it, so the blocks ended up in the generic bucket.
 *
 * @param array $categories Registered block categories.
 *
 * @return array
 */
function mv_block_categories( array $categories ): array {
	array_unshift(
		$categories,
		[
			'slug'  => 'maillot-vert',
			'title' => __( 'Maillot Vert', 'maillot-vert' ),
			'icon'  => null,
		]
	);

	return $categories;
}
add_filter( 'block_categories_all', 'mv_block_categories' );

/*-------------------------------------------------------------*/
/*-------------------------- ASSETS ---------------------------*/
/*-------------------------------------------------------------*/

/**
 * Register and enqueue the front-end assets.
 *
 * Splide is only *registered* here – the gallery-slider block declares it as a
 * dependency in its block.json, so it is loaded on pages that actually use it.
 */
function mv_enqueue_assets(): void {
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'mv-fonts', 'https://use.typekit.net/doe6ray.css', [], null );
	wp_enqueue_style( 'mv-style', $uri . '/assets/css/main.css', [ 'mv-fonts' ], MV_THEME_VERSION );

	wp_enqueue_script( 'mv-main', $uri . '/assets/js/main.js', [], MV_THEME_VERSION, true );
}
add_action( 'wp_enqueue_scripts', 'mv_enqueue_assets' );

/**
 * Register the scripts the blocks reference from their block.json.
 */
function mv_register_block_assets(): void {
	$uri = get_template_directory_uri();

	/*
	 * Splide is registered on init, not on wp_enqueue_scripts: the block styles
	 * declared in block.json resolve their handles while the block renders, and
	 * a handle that is not registered by then is silently dropped.
	 */
	wp_register_script( 'splide', $uri . '/assets/js/plugins/splide/splide.min.js', [], '4.1.4', true );
	wp_register_style( 'splide-style', $uri . '/assets/js/plugins/splide/splide-core.min.css', [], '4.1.4' );

	wp_register_script(
		'block-gallery-slider',
		$uri . '/components/blocks/gallery-slider/gallery-slider.js',
		[ 'splide' ],
		MV_THEME_VERSION,
		true
	);

	/*
	 * Shared by both manifest blocks: the read-on overlay, the year filter and
	 * the card styling. Referenced by handle from their block.json, so it only
	 * loads on pages that use one of them.
	 */
	wp_register_style(
		'mv-manifest',
		$uri . '/assets/css/manifest.css',
		[],
		MV_THEME_VERSION
	);

	wp_register_script(
		'mv-manifest',
		$uri . '/assets/js/manifest.js',
		[],
		MV_THEME_VERSION,
		true
	);

	wp_localize_script(
		'mv-manifest',
		'mvManifest',
		[
			'close' => __( 'Close', 'maillot-vert' ),
		]
	);

	wp_register_script(
		'block-manifest-teaser',
		$uri . '/components/blocks/manifest-teaser/manifest-teaser.js',
		[ 'splide' ],
		MV_THEME_VERSION,
		true
	);
}
add_action( 'init', 'mv_register_block_assets' );

/**
 * Warm up the connection to the webfont host before the CSS asks for it.
 *
 * @param array  $urls          URLs for the given relation.
 * @param string $relation_type Relation type.
 *
 * @return array
 */
function mv_resource_hints( array $urls, string $relation_type ): array {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = [
			'href'        => 'https://use.typekit.net',
			'crossorigin' => 'anonymous',
		];
		$urls[] = [
			'href'        => 'https://p.typekit.net',
			'crossorigin' => 'anonymous',
		];
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'mv_resource_hints', 10, 2 );

/*-------------------------------------------------------------*/
/*--------------------- DEPENDENCY GUARDS ---------------------*/
/*-------------------------------------------------------------*/

/**
 * The theme relies on ACF Pro. Fail loudly in wp-admin instead of fatally.
 */
function mv_check_dependencies(): void {
	if ( function_exists( 'get_field' ) ) {
		return;
	}

	echo '<div class="notice notice-error"><p><strong>Maillot Vert:</strong> '
		. esc_html__( 'Advanced Custom Fields Pro is required for this theme. All blocks and theme options are inactive until the plugin is enabled.', 'maillot-vert' )
		. '</p></div>';
}
add_action( 'admin_notices', 'mv_check_dependencies' );

/**
 * Current language code, WPML or not.
 *
 * Replaces the direct ICL_LANGUAGE_CODE usage which caused a fatal error
 * whenever WPML was deactivated.
 *
 * @return string Two-letter language code.
 */
function mv_current_language(): string {
	$lang = apply_filters( 'wpml_current_language', null );

	if ( ! $lang ) {
		$lang = substr( (string) get_locale(), 0, 2 );
	}

	return $lang ? $lang : 'de';
}

/*-------------------------------------------------------------*/
/*--------------------- LOAD THEME FILES ----------------------*/
/*-------------------------------------------------------------*/

/**
 * Require every PHP file inside a theme folder, in a stable order.
 *
 * @param string $relative_path Path relative to the theme root.
 */
function mv_require_folder( string $relative_path ): void {
	$files = glob( get_template_directory() . '/' . trim( $relative_path, '/' ) . '/*.php' );

	if ( ! $files ) {
		return;
	}

	sort( $files );

	foreach ( $files as $file ) {
		require_once $file;
	}
}

mv_require_folder( 'extensions/helper' );
mv_require_folder( 'components/elements' );
mv_require_folder( 'extensions/acf' );

require_once get_template_directory() . '/components/blocks/blocks-register.php';

/*-------------------------------------------------------------*/
/*----------------------- MEDIA / UPLOADS ---------------------*/
/*-------------------------------------------------------------*/

/**
 * Allow a small set of extra upload types.
 *
 * SVG stays restricted to users who can manage options, because an SVG is an
 * executable document: any author-level account could otherwise upload a file
 * containing <script> and turn it into stored XSS.
 *
 * @param array $mime_types Allowed mime types.
 *
 * @return array
 */
function mv_upload_mimes( array $mime_types ): array {
	$mime_types['eps'] = 'application/postscript';
	$mime_types['obj'] = 'model/obj';
	$mime_types['fbx'] = 'model/fbx';

	if ( current_user_can( 'manage_options' ) ) {
		$mime_types['svg']  = 'image/svg+xml';
		$mime_types['svgz'] = 'image/svg+xml';
	}

	return $mime_types;
}
add_filter( 'upload_mimes', 'mv_upload_mimes' );

/**
 * Let WordPress accept an SVG whose real mime type it cannot introspect.
 *
 * Unlike the previous implementation this does not switch the check off for
 * every file type – it only fills in the blank for SVG, and only for users who
 * are allowed to upload one in the first place.
 *
 * @param array  $data     File data.
 * @param string $file     Full path to the file.
 * @param string $filename The name of the file.
 * @param array  $mimes    Allowed mime types.
 *
 * @return array
 */
function mv_allow_svg_filetype( $data, $file, $filename, $mimes ) {
	if ( ! empty( $data['ext'] ) && ! empty( $data['type'] ) ) {
		return $data;
	}

	$check = wp_check_filetype( $filename, $mimes );

	if ( 'svg' === $check['ext'] && current_user_can( 'manage_options' ) ) {
		$data['ext']  = 'svg';
		$data['type'] = 'image/svg+xml';
	}

	return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'mv_allow_svg_filetype', 10, 4 );

/**
 * Strip the dangerous parts out of an uploaded SVG.
 *
 * A minimal, dependency-free sanitiser: it removes scripts, event handlers,
 * external references and javascript: URLs. For a hardened setup consider the
 * "Safe SVG" plugin or enshrined/svg-sanitize via Composer.
 *
 * @param array $file An element of $_FILES.
 *
 * @return array
 */
function mv_sanitize_svg_upload( array $file ): array {
	if ( empty( $file['tmp_name'] ) || empty( $file['name'] ) ) {
		return $file;
	}

	if ( 'svg' !== strtolower( (string) pathinfo( $file['name'], PATHINFO_EXTENSION ) ) ) {
		return $file;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		$file['error'] = __( 'Only administrators may upload SVG files.', 'maillot-vert' );

		return $file;
	}

	$svg = file_get_contents( $file['tmp_name'] ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Reading the upload before it is stored.

	if ( false === $svg ) {
		return $file;
	}

	$clean = mv_sanitize_svg_markup( $svg );

	if ( null === $clean ) {
		$file['error'] = __( 'This SVG could not be parsed and was rejected.', 'maillot-vert' );

		return $file;
	}

	file_put_contents( $file['tmp_name'], $clean ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_file_put_contents -- Rewriting the upload in place.

	return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'mv_sanitize_svg_upload' );

/**
 * Remove scripting and external references from SVG markup.
 *
 * @param string $svg Raw SVG markup.
 *
 * @return string|null Cleaned markup, or null when the file is not parseable.
 */
function mv_sanitize_svg_markup( string $svg ): ?string {
	if ( ! class_exists( 'DOMDocument' ) ) {
		return null;
	}

	// Drop anything before the root element (DOCTYPE / entity tricks).
	$start = strpos( $svg, '<svg' );

	if ( false === $start ) {
		return null;
	}

	$svg = substr( $svg, $start );

	$previous = libxml_use_internal_errors( true );
	$dom      = new DOMDocument();
	$loaded   = $dom->loadXML( $svg, LIBXML_NONET | LIBXML_NOENT );
	libxml_clear_errors();
	libxml_use_internal_errors( $previous );

	if ( ! $loaded || ! $dom->documentElement ) {
		return null;
	}

	$forbidden_tags = [ 'script', 'foreignObject', 'iframe', 'embed', 'object', 'handler', 'set', 'audio', 'video' ];

	foreach ( $forbidden_tags as $tag ) {
		$nodes = $dom->getElementsByTagName( $tag );

		for ( $i = $nodes->length - 1; $i >= 0; $i-- ) {
			$node = $nodes->item( $i );

			if ( $node && $node->parentNode ) {
				$node->parentNode->removeChild( $node );
			}
		}
	}

	$xpath = new DOMXPath( $dom );
	$nodes = $xpath->query( '//*' );

	if ( $nodes ) {
		foreach ( $nodes as $node ) {
			if ( ! $node instanceof DOMElement || ! $node->hasAttributes() ) {
				continue;
			}

			for ( $i = $node->attributes->length - 1; $i >= 0; $i-- ) {
				$attribute = $node->attributes->item( $i );

				if ( ! $attribute ) {
					continue;
				}

				$name  = strtolower( $attribute->nodeName );
				$value = preg_replace( '/\s+/', '', strtolower( $attribute->nodeValue ) );

				$is_event   = 0 === strpos( $name, 'on' );
				$is_script  = false !== strpos( (string) $value, 'javascript:' ) || false !== strpos( (string) $value, 'data:text/html' );
				$is_foreign = in_array( $name, [ 'xlink:href', 'href' ], true )
					&& '' !== (string) $value
					&& 0 !== strpos( (string) $value, '#' )
					&& 0 !== strpos( (string) $value, 'data:image/' );

				if ( $is_event || $is_script || $is_foreign ) {
					$node->removeAttribute( $attribute->nodeName );
				}
			}
		}
	}

	return (string) $dom->saveXML();
}

/*-------------------------------------------------------------*/
/*------------------------- COMMENTS --------------------------*/
/*-------------------------------------------------------------*/

/**
 * The site has no use for comments – switch them off everywhere.
 */
function mv_disable_comments_admin(): void {
	global $pagenow;

	if ( 'edit-comments.php' === $pagenow ) {
		wp_safe_redirect( admin_url() );
		exit;
	}

	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );

	foreach ( get_post_types() as $post_type ) {
		if ( post_type_supports( $post_type, 'comments' ) ) {
			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}
add_action( 'admin_init', 'mv_disable_comments_admin' );

add_filter( 'comments_open', '__return_false', 20 );
add_filter( 'pings_open', '__return_false', 20 );
add_filter( 'comments_array', '__return_empty_array', 10 );

add_action(
	'admin_menu',
	static function (): void {
		remove_menu_page( 'edit-comments.php' );
	}
);

add_action(
	'init',
	static function (): void {
		if ( is_admin_bar_showing() ) {
			remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
		}
	}
);
