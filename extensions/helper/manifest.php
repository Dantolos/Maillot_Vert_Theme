<?php
/**
 * Manifest helpers – shared by the teaser block and the wall block.
 *
 * @package MaillotVert
 */

defined( 'ABSPATH' ) || exit;

/**
 * Characters after which a statement is shortened on a card.
 *
 * The teaser shows one large card at a time and can carry more text than a
 * tile on the wall.
 */
const MV_MANIFEST_LIMIT_TEASER = 420;
const MV_MANIFEST_LIMIT_WALL   = 320;

/**
 * Whether attribution is switched on site-wide.
 *
 * The cards are anonymous for now; the name fields already exist on every
 * manifest so the switch is the only thing that has to change later.
 *
 * @return bool
 */
function mv_manifest_shows_authors(): bool {
	if ( ! function_exists( 'get_field' ) ) {
		return false;
	}

	return (bool) get_field( 'manifest_show_authors', 'option' );
}

/**
 * The year a manifest belongs to.
 *
 * @param int $post_id Manifest post ID.
 *
 * @return string Empty string when no year is assigned.
 */
function mv_manifest_year( int $post_id ): string {
	$terms = get_the_terms( $post_id, 'manifest-year' );

	if ( ! is_array( $terms ) || empty( $terms ) ) {
		return '';
	}

	return (string) $terms[0]->name;
}

/**
 * Split a statement into paragraphs.
 *
 * @param string $statement Raw field value.
 *
 * @return string[]
 */
function mv_manifest_paragraphs( string $statement ): array {
	$parts = preg_split( '/\R{2,}|\R/', trim( $statement ) );

	if ( ! is_array( $parts ) ) {
		return [];
	}

	return array_values( array_filter( array_map( 'trim', $parts ), 'strlen' ) );
}

/**
 * Shorten a statement at a word boundary.
 *
 * @param string $text  Full statement.
 * @param int    $limit Character budget.
 *
 * @return array{0:string,1:bool} The shortened text and whether it was cut.
 */
function mv_manifest_shorten( string $text, int $limit ): array {
	$text = trim( $text );

	if ( mb_strlen( $text ) <= $limit ) {
		return [ $text, false ];
	}

	$cut   = mb_substr( $text, 0, $limit );
	$space = mb_strrpos( $cut, ' ' );

	if ( false !== $space && $space > (int) ( $limit * 0.6 ) ) {
		$cut = mb_substr( $cut, 0, $space );
	}

	return [ rtrim( $cut, " \t\n\r\0\x0B,;:.–—-" ) . '…', true ];
}

/**
 * Render one manifest card.
 *
 * @param int|WP_Post $manifest The manifest.
 * @param array       $args     tone: '' | 'dark' | 'green'. limit: character budget.
 *                              context: 'teaser' | 'wall'.
 *
 * @return string HTML, or an empty string when there is no statement.
 */
function mv_manifest_card( $manifest, array $args = [] ): string {
	$post_id = $manifest instanceof WP_Post ? $manifest->ID : (int) $manifest;

	if ( ! $post_id || ! function_exists( 'get_field' ) ) {
		return '';
	}

	$args = wp_parse_args(
		$args,
		[
			'tone'    => '',
			'limit'   => MV_MANIFEST_LIMIT_WALL,
			'context' => 'wall',
		]
	);

	$statement = (string) get_field( 'statement', $post_id );

	if ( '' === trim( $statement ) ) {
		return '';
	}

	list( $short, $is_cut ) = mv_manifest_shorten( $statement, (int) $args['limit'] );

	$year  = mv_manifest_year( $post_id );
	$tone  = $args['tone'] ? ' mv-manifest-card--' . sanitize_html_class( $args['tone'] ) : '';
	$dlgid = 'mv-manifest-' . $post_id;

	$name = '';
	$role = '';

	if ( mv_manifest_shows_authors() ) {
		$name = (string) get_field( 'author_name', $post_id );
		$role = (string) get_field( 'author_role', $post_id );
	}

	ob_start();
	?>
	<article class="mv-manifest-card<?php echo esc_attr( $tone ); ?>">
		<span class="mv-manifest-card__mark" aria-hidden="true">&bdquo;</span>

		<div class="mv-manifest-card__text">
			<?php foreach ( mv_manifest_paragraphs( $short ) as $mv_paragraph ) : ?>
				<p><?php echo esc_html( $mv_paragraph ); ?></p>
			<?php endforeach; ?>
		</div>

		<footer class="mv-manifest-card__foot">
			<?php if ( '' !== $year ) : ?>
				<span class="mv-manifest-card__year"><?php echo esc_html( $year ); ?></span>
			<?php endif; ?>

			<?php if ( '' !== $name ) : ?>
				<span class="mv-manifest-card__author">
					<span class="mv-manifest-card__name"><?php echo esc_html( $name ); ?></span>
					<?php if ( '' !== $role ) : ?>
						<span class="mv-manifest-card__role"><?php echo esc_html( $role ); ?></span>
					<?php endif; ?>
				</span>
			<?php endif; ?>

			<?php if ( $is_cut ) : ?>
				<button type="button" class="mv-manifest-card__more" data-mv-manifest-open="<?php echo esc_attr( $dlgid ); ?>">
					<?php esc_html_e( 'Read on', 'maillot-vert' ); ?>
					<span aria-hidden="true">&rarr;</span>
				</button>
			<?php endif; ?>
		</footer>

		<?php if ( $is_cut ) : ?>
			<template id="<?php echo esc_attr( $dlgid ); ?>">
				<?php foreach ( mv_manifest_paragraphs( $statement ) as $mv_paragraph ) : ?>
					<p><?php echo esc_html( $mv_paragraph ); ?></p>
				<?php endforeach; ?>
			</template>
		<?php endif; ?>
	</article>
	<?php

	return (string) ob_get_clean();
}

/**
 * Echo mv_manifest_card().
 *
 * @param int|WP_Post $manifest The manifest.
 * @param array       $args     See mv_manifest_card().
 */
function mv_the_manifest_card( $manifest, array $args = [] ): void {
	echo mv_manifest_card( $manifest, $args ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped while building.
}

/**
 * All published manifests, newest first.
 *
 * @param int $limit -1 for all.
 *
 * @return WP_Post[]
 */
function mv_get_manifests( int $limit = -1 ): array {
	$query = new WP_Query(
		[
			'post_type'              => 'manifest',
			'post_status'            => 'publish',
			'posts_per_page'         => $limit,
			'orderby'                => 'date',
			'order'                  => 'DESC',
			'no_found_rows'          => true,
			'update_post_meta_cache' => true,
			'update_post_term_cache' => true,
		]
	);

	return $query->posts;
}

/**
 * The years that actually have published manifests, newest first.
 *
 * @return WP_Term[]
 */
function mv_manifest_years(): array {
	$terms = get_terms(
		[
			'taxonomy'   => 'manifest-year',
			'hide_empty' => true,
		]
	);

	if ( is_wp_error( $terms ) || ! is_array( $terms ) ) {
		return [];
	}

	usort(
		$terms,
		static function ( $a, $b ) {
			return strnatcmp( $b->name, $a->name );
		}
	);

	return $terms;
}
