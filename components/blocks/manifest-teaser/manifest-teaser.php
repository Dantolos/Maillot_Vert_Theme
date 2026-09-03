<?php
/**
 * Manifest teaser block – question and links on the left, one manifest at a
 * time on the right.
 *
 * @package MaillotVert
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True during backend preview render.
 */

defined( 'ABSPATH' ) || exit;

if ( ! mv_block_open( $block, 'block-manifest-teaser-container default-container', ! empty( $is_preview ) ) ) {
	return;
}

$mv_eyebrow   = (string) get_field( 'eyebrow' );
$mv_title     = (string) get_field( 'title' );
$mv_question  = (string) get_field( 'question' );
$mv_intro     = (string) get_field( 'intro' );
$mv_page_link = get_field( 'page_link' );
$mv_pdf       = get_field( 'pdf' );
$mv_manifests = get_field( 'manifests' );

// Drop entries whose statement is empty, so the slider never shows a blank card.
$mv_cards = [];

if ( is_array( $mv_manifests ) ) {
	foreach ( array_slice( $mv_manifests, 0, 5 ) as $mv_manifest ) {
		$mv_card = mv_manifest_card(
			$mv_manifest,
			[
				'limit'   => MV_MANIFEST_LIMIT_TEASER,
				'context' => 'teaser',
			]
		);

		if ( '' !== $mv_card ) {
			$mv_cards[] = $mv_card;
		}
	}
}

$mv_slider_id = ! empty( $block['id'] )
	? 'manifest-slide-' . sanitize_html_class( (string) $block['id'] )
	: wp_unique_id( 'manifest-slide-' );
?>
<div class="default-content block-manifest-teaser-wrapper">

	<div class="manifest-teaser-intro">
		<?php if ( '' !== $mv_eyebrow ) : ?>
			<p class="mv-eyebrow"><?php echo esc_html( $mv_eyebrow ); ?></p>
		<?php endif; ?>

		<?php if ( '' !== $mv_title ) : ?>
			<h2 class="fl"><?php echo esc_html( $mv_title ); ?></h2>
		<?php endif; ?>

		<?php if ( '' !== $mv_question ) : ?>
			<p class="manifest-teaser-question">
				<?php echo esc_html( $mv_question ); ?>
			</p>
		<?php endif; ?>

		<?php if ( '' !== $mv_intro ) : ?>
			<p class="manifest-teaser-lead"><?php echo esc_html( $mv_intro ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $mv_page_link['url'] ) || ! empty( $mv_pdf ) ) : ?>
			<div class="manifest-teaser-actions">
				<?php mv_the_link( $mv_page_link, 'mv-button' ); ?>

				<?php if ( ! empty( $mv_pdf['url'] ) ) : ?>
					<a class="mv-download" href="<?php echo esc_url( $mv_pdf['url'] ); ?>" download>
						<span class="mv-download__icon" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" focusable="false"><path d="M12 3v12"/><path d="m7 12 5 5 5-5"/><path d="M5 21h14"/></svg>
						</span>
						<span class="mv-download__label">
							<?php echo esc_html( $mv_pdf['title'] ? $mv_pdf['title'] : __( 'Download PDF', 'maillot-vert' ) ); ?>
							<small>
								<?php
								printf(
									'(%1$s, %2$s)',
									esc_html( strtoupper( (string) pathinfo( (string) $mv_pdf['filename'], PATHINFO_EXTENSION ) ) ),
									esc_html( size_format( (int) $mv_pdf['filesize'] ) )
								);
								?>
							</small>
						</span>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

	<div class="manifest-teaser-slider">
		<?php if ( $mv_cards ) : ?>
			<div id="<?php echo esc_attr( $mv_slider_id ); ?>" class="splide js-mv-manifest-slider"
				role="group" aria-label="<?php esc_attr_e( 'Voices of participants', 'maillot-vert' ); ?>">
				<div class="splide__track">
					<ul class="splide__list">
						<?php foreach ( $mv_cards as $mv_card ) : ?>
							<li class="splide__slide">
								<?php echo $mv_card; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in mv_manifest_card(). ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		<?php elseif ( ! empty( $is_preview ) ) : ?>
			<p class="manifest-teaser-empty">
				<?php esc_html_e( 'No manifests selected yet – pick up to five in the block settings.', 'maillot-vert' ); ?>
			</p>
		<?php endif; ?>
	</div>

</div>
<?php
mv_block_close();
