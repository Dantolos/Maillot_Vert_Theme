<?php
/**
 * Shared helpers for the ACF block templates.
 *
 * Replaces the ~20 lines of anchor / visibility / preview-badge boilerplate
 * that used to be copy-pasted into every single block render template.
 *
 * @package MaillotVert
 */

defined( 'ABSPATH' ) || exit;

/**
 * Internal stack so mv_block_close() knows how many wrappers to close.
 *
 * @var array<int,bool>
 */
$GLOBALS['mv_block_stack'] = [];

/**
 * Open the outer wrapper of an ACF block.
 *
 * Returns false when the block is switched off and we are on the front end.
 * In that case the caller must `return;` immediately, so hidden blocks are
 * never rendered into the markup at all (previously they were shipped to the
 * browser and only hidden with inline CSS).
 *
 * @param array  $block      The ACF block array.
 * @param string $classes    Additional classes for the wrapper.
 * @param bool   $is_preview True inside the block editor preview.
 *
 * @return bool Whether the block should be rendered.
 */
function mv_block_open( array $block, string $classes = '', bool $is_preview = false ): bool {
	$visible = ! function_exists( 'get_field' ) || (bool) get_field( 'display' );

	if ( ! $visible && ! $is_preview ) {
		return false;
	}

	$show_badge = ! $visible && $is_preview;

	if ( $show_badge ) {
		echo '<div class="mv-hidden-notice"><span class="mv-hidden-notice__badge">'
			. esc_html__( 'Hidden', 'maillot-vert' ) . '</span>';
	}

	$class_list = trim( 'mv-block ' . $classes );

	if ( ! empty( $block['className'] ) ) {
		$class_list .= ' ' . $block['className'];
	}

	if ( ! empty( $block['align'] ) ) {
		$class_list .= ' align' . $block['align'];
	}

	$anchor = '';
	if ( ! empty( $block['anchor'] ) ) {
		$anchor = ' id="' . esc_attr( $block['anchor'] ) . '"';
	}

	printf(
		'<div%1$s class="%2$s">',
		$anchor, // Already escaped above.
		esc_attr( $class_list )
	);

	$GLOBALS['mv_block_stack'][] = $show_badge;

	return true;
}

/**
 * Close the wrapper opened by mv_block_open().
 */
function mv_block_close(): void {
	if ( empty( $GLOBALS['mv_block_stack'] ) ) {
		return;
	}

	$show_badge = array_pop( $GLOBALS['mv_block_stack'] );

	echo '</div>';

	if ( $show_badge ) {
		echo '</div>';
	}
}

/**
 * Render a responsive <img> from an ACF image value.
 *
 * Accepts an attachment ID, an ACF image array or – for backwards
 * compatibility with field groups that still return "url" – a plain URL.
 * Using wp_get_attachment_image() gives us srcset, sizes, width/height
 * (no layout shift) and native lazy loading for free.
 *
 * @param mixed  $image Attachment ID, ACF image array or URL string.
 * @param string $size  Registered image size.
 * @param array  $attr  Additional <img> attributes.
 *
 * @return string HTML, or an empty string when there is no image.
 */
function mv_image( $image, string $size = 'large', array $attr = [] ): string {
	$attr = wp_parse_args(
		$attr,
		[
			'loading'  => 'lazy',
			'decoding' => 'async',
		]
	);

	$id = 0;

	if ( is_array( $image ) ) {
		$id = (int) ( $image['ID'] ?? $image['id'] ?? 0 );

		if ( ! isset( $attr['alt'] ) && ! empty( $image['alt'] ) ) {
			$attr['alt'] = $image['alt'];
		}
	} elseif ( is_numeric( $image ) ) {
		$id = (int) $image;
	} elseif ( is_string( $image ) && '' !== trim( $image ) ) {
		// Legacy fallback: the field still hands us a bare URL.
		$id = attachment_url_to_postid( $image );

		if ( ! $id ) {
			$parts = '';
			foreach ( $attr as $key => $value ) {
				if ( null === $value || false === $value ) {
					continue;
				}
				$parts .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( $value ) );
			}

			if ( ! isset( $attr['alt'] ) ) {
				$parts .= ' alt=""';
			}

			return sprintf( '<img src="%s"%s />', esc_url( $image ), $parts );
		}
	}

	if ( ! $id ) {
		return '';
	}

	if ( ! isset( $attr['alt'] ) ) {
		$alt = (string) get_post_meta( $id, '_wp_attachment_image_alt', true );

		if ( '' !== $alt ) {
			$attr['alt'] = $alt;
		}
	}

	return wp_get_attachment_image( $id, $size, false, $attr );
}

/**
 * Echo the result of mv_image().
 *
 * @param mixed  $image Attachment ID, ACF image array or URL string.
 * @param string $size  Registered image size.
 * @param array  $attr  Additional <img> attributes.
 */
function mv_the_image( $image, string $size = 'large', array $attr = [] ): void {
	echo mv_image( $image, $size, $attr ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in mv_image().
}

/**
 * Render a link from an ACF link field.
 *
 * Handles escaping, adds rel="noopener noreferrer" for _blank targets and
 * avoids the invalid <a><button></button></a> nesting the theme used before –
 * the .mv-button class carries the button styling instead.
 *
 * @param mixed  $link          ACF link array (url/title/target).
 * @param string $classes       Classes for the anchor.
 * @param string $fallback_text Used when the editor left the link title empty.
 *
 * @return string HTML, or an empty string when there is no URL.
 */
function mv_link( $link, string $classes = '', string $fallback_text = '' ): string {
	if ( ! is_array( $link ) || empty( $link['url'] ) ) {
		return '';
	}

	$target = $link['target'] ?? '';
	$text   = trim( (string) ( $link['title'] ?? '' ) );

	if ( '' === $text ) {
		$text = $fallback_text;
	}

	if ( '' === $text ) {
		return '';
	}

	return sprintf(
		'<a class="%1$s" href="%2$s"%3$s%4$s>%5$s</a>',
		esc_attr( trim( $classes ) ),
		esc_url( $link['url'] ),
		$target ? ' target="' . esc_attr( $target ) . '"' : '',
		'_blank' === $target ? ' rel="noopener noreferrer"' : '',
		esc_html( $text )
	);
}

/**
 * Echo the result of mv_link().
 *
 * @param mixed  $link          ACF link array.
 * @param string $classes       Classes for the anchor.
 * @param string $fallback_text Fallback label.
 */
function mv_the_link( $link, string $classes = '', string $fallback_text = '' ): void {
	echo mv_link( $link, $classes, $fallback_text ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in mv_link().
}

/**
 * Inline an SVG icon from the theme's icon folder.
 *
 * Decorative by default (aria-hidden), so screen readers skip it.
 *
 * @param string $name  File name without extension.
 * @param string $class Extra classes for the wrapper.
 *
 * @return string
 */
function mv_icon( string $name, string $class = '' ): string {
	$name = sanitize_file_name( $name );
	$file = get_theme_file_path( "assets/images/icons/{$name}.svg" );

	if ( ! is_readable( $file ) ) {
		return '';
	}

	$svg = file_get_contents( $file ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local theme asset.

	if ( false === $svg ) {
		return '';
	}

	return sprintf(
		'<span class="mv-icon %s" aria-hidden="true">%s</span>',
		esc_attr( $class ),
		$svg
	);
}
