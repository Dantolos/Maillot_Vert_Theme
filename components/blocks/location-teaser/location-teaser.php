<?php
/**
 * Location teaser block.
 *
 * @package MaillotVert
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True during backend preview render.
 */

defined( 'ABSPATH' ) || exit;

if ( ! mv_block_open( $block, 'block-location-teaser-container default-container', ! empty( $is_preview ) ) ) {
	return;
}

$mv_title   = (string) get_field( 'title' );
$mv_image   = get_field( 'image' );
$mv_content = (string) get_field( 'content' );
$mv_button  = get_field( 'button' );
?>
<div class="default-content block-location-teaser-wrapper">

	<?php if ( $mv_image ) : ?>
		<div class="location-teaser-left">
			<?php mv_the_image( $mv_image, 'large' ); ?>
		</div>
	<?php endif; ?>

	<div class="location-teaser-right">
		<?php if ( '' !== $mv_title ) : ?>
			<h2 class="fl"><?php echo esc_html( $mv_title ); ?></h2>
		<?php endif; ?>

		<?php if ( '' !== $mv_content ) : ?>
			<div class="location-teaser-content"><?php echo wp_kses_post( $mv_content ); ?></div>
		<?php endif; ?>

		<?php mv_the_link( $mv_button, 'mv-button' ); ?>
	</div>
</div>
<?php
mv_block_close();
