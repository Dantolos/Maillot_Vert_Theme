<?php
/**
 * Register the ACF blocks.
 *
 * @package MaillotVert
 */

defined( 'ABSPATH' ) || exit;

/**
 * All block folders under components/blocks.
 *
 * @return string[]
 */
function mv_block_folders(): array {
	return [
		'hero',
		'container',
		'facts',
		'ticket',
		'program',
		'gallery-slider',
		'location-teaser',
		'supporter-strip',
		'supporter-list',
		'team-grid',
		'manifest-teaser',
		'manifest-wall',
	];
}

/**
 * Register every block plus its local field group.
 */
function mv_register_acf_blocks(): void {
	if ( ! function_exists( 'acf_register_block_type' ) && ! function_exists( 'get_field' ) ) {
		// ACF is not active – registering the blocks would be pointless.
		return;
	}

	require_once __DIR__ . '/global.acf.php';

	foreach ( mv_block_folders() as $slug ) {
		$dir = __DIR__ . '/' . $slug;

		if ( ! is_dir( $dir ) || ! file_exists( $dir . '/block.json' ) ) {
			continue;
		}

		register_block_type( $dir );

		$fields = $dir . '/' . $slug . '.acf.php';

		if ( file_exists( $fields ) ) {
			require_once $fields;
		}
	}
}
add_action( 'init', 'mv_register_acf_blocks' );
