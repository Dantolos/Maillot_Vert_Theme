<?php
/**
 * Manifest wall block – every manifest, staggered, optionally filtered by year.
 *
 * @package MaillotVert
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True during backend preview render.
 */

defined( 'ABSPATH' ) || exit;

if ( ! mv_block_open( $block, 'block-manifest-wall-container default-container', ! empty( $is_preview ) ) ) {
	return;
}

$mv_eyebrow  = (string) get_field( 'eyebrow' );
$mv_title    = (string) get_field( 'title' );
$mv_question = (string) get_field( 'question' );
$mv_intro    = (string) get_field( 'intro' );
$mv_filter   = (bool) get_field( 'show_filter' );

$mv_manifests = mv_get_manifests();
$mv_years     = $mv_filter ? mv_manifest_years() : [];

/*
 * Tones repeat in a fixed pattern rather than at random, so the wall looks the
 * same on every load and after every filter change.
 */
$mv_tones = [ '', '', 'dark', '', 'green', '', 'dark', '', '', 'green' ];
?>
<div class="default-content block-manifest-wall-wrapper">

	<div class="manifest-wall-head">
		<?php if ( '' !== $mv_eyebrow ) : ?>
			<p class="mv-eyebrow"><?php echo esc_html( $mv_eyebrow ); ?></p>
		<?php endif; ?>

		<?php if ( '' !== $mv_title ) : ?>
			<h2 class="fl"><?php echo esc_html( $mv_title ); ?></h2>
		<?php endif; ?>

		<?php if ( '' !== $mv_question ) : ?>
			<p class="manifest-wall-question"><?php echo esc_html( $mv_question ); ?></p>
		<?php endif; ?>

		<?php if ( '' !== $mv_intro ) : ?>
			<p class="manifest-wall-lead"><?php echo esc_html( $mv_intro ); ?></p>
		<?php endif; ?>
	</div>

	<?php if ( $mv_years ) : ?>
		<div class="manifest-wall-filter" role="group" aria-label="<?php esc_attr_e( 'Filter by year', 'maillot-vert' ); ?>"
			data-mv-manifest-filter>
			<button type="button" class="manifest-chip" data-year="all" aria-pressed="true">
				<?php esc_html_e( 'All', 'maillot-vert' ); ?>
			</button>
			<?php foreach ( $mv_years as $mv_year ) : ?>
				<button type="button" class="manifest-chip" data-year="<?php echo esc_attr( $mv_year->slug ); ?>" aria-pressed="false">
					<?php echo esc_html( $mv_year->name ); ?>
				</button>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ( $mv_manifests ) : ?>
		<div class="manifest-wall-grid" data-mv-manifest-grid>
			<?php
			foreach ( $mv_manifests as $mv_index => $mv_manifest ) :
				$mv_card = mv_manifest_card(
					$mv_manifest,
					[
						'tone'    => $mv_tones[ $mv_index % count( $mv_tones ) ],
						'limit'   => MV_MANIFEST_LIMIT_WALL,
						'context' => 'wall',
					]
				);

				if ( '' === $mv_card ) {
					continue;
				}

				$mv_terms = get_the_terms( $mv_manifest, 'manifest-year' );
				$mv_slug  = ( is_array( $mv_terms ) && ! empty( $mv_terms ) ) ? $mv_terms[0]->slug : '';
				?>
				<div class="manifest-wall-item" data-year="<?php echo esc_attr( $mv_slug ); ?>">
					<?php echo $mv_card; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in mv_manifest_card(). ?>
				</div>
			<?php endforeach; ?>
		</div>

		<p class="manifest-wall-empty" data-mv-manifest-empty hidden>
			<?php esc_html_e( 'No manifests for this year yet.', 'maillot-vert' ); ?>
		</p>
	<?php else : ?>
		<p class="manifest-wall-empty">
			<?php esc_html_e( 'No manifests published yet.', 'maillot-vert' ); ?>
		</p>
	<?php endif; ?>

</div>
<?php
mv_block_close();
