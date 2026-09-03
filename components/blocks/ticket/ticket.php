<?php
/**
 * Ticket block.
 *
 * @package MaillotVert
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True during backend preview render.
 */

defined( 'ABSPATH' ) || exit;

if ( ! mv_block_open( $block, 'block-ticket-container default-container', ! empty( $is_preview ) ) ) {
	return;
}

$mv_subtitle = (string) get_field( 'subtitle' );
$mv_content  = (string) get_field( 'content' );
$mv_price    = get_field( 'price' );
$mv_ctas     = array_filter(
	[
		get_field( 'register_interaction_1' ),
		get_field( 'register_interaction_2' ),
	]
);
?>
<div class="default-content block-ticket-wrapper">

	<h2 class="ticket-heading fl">
		<?php echo mv_icon( 'icon_ticket_outline_', 'ticket-heading__icon' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Local SVG asset. ?>
		<?php esc_html_e( 'Ticket', 'maillot-vert' ); ?>
	</h2>

	<?php if ( '' !== $mv_subtitle ) : ?>
		<p class="ticket-subtitle fs"><?php echo esc_html( $mv_subtitle ); ?></p>
	<?php endif; ?>

	<?php if ( '' !== $mv_content ) : ?>
		<div class="ticket-content"><?php echo wp_kses_post( $mv_content ); ?></div>
	<?php endif; ?>

	<?php if ( $mv_price && is_array( $mv_price ) ) : ?>
		<div class="price-row">
			<?php if ( ! empty( $mv_price['pricetag'] ) ) : ?>
				<div class="price-tag"><p class="fm"><?php echo esc_html( $mv_price['pricetag'] ); ?></p></div>
			<?php endif; ?>
			<div class="price-value">
				<p class="fm">
					<span class="currency"><?php echo esc_html( (string) ( $mv_price['price'] ?? '' ) ); ?></span>
					<span class="currency"><?php echo esc_html( (string) ( $mv_price['currency'] ?? '' ) ); ?></span>
				</p>
				<?php if ( ! empty( $mv_price['subtext'] ) ) : ?>
					<p class="fxxs price-subtext"><?php echo esc_html( $mv_price['subtext'] ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( $mv_ctas ) : ?>
		<div class="ticket-cta">
			<?php foreach ( $mv_ctas as $mv_cta ) : ?>
				<?php if ( empty( $mv_cta['button']['url'] ) && empty( $mv_cta['text'] ) ) { continue; } ?>
				<div class="ticket-cta-box">
					<?php if ( ! empty( $mv_cta['text'] ) ) : ?>
						<p class="ticket-cta-box__text fxs"><?php echo esc_html( $mv_cta['text'] ); ?></p>
					<?php endif; ?>
					<?php mv_the_link( $mv_cta['button'] ?? null, 'mv-button mv-button--secondary fxs' ); ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
<?php
mv_block_close();
