<?php
/**
 * Gallery slider block.
 *
 * @package MaillotVert
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True during backend preview render.
 */

defined( 'ABSPATH' ) || exit;

if ( ! mv_block_open( $block, 'block-gallery-slider-container default-container', ! empty( $is_preview ) ) ) {
	return;
}

$mv_title       = (string) get_field( 'title' );
$mv_description = (string) get_field( 'description' );
$mv_photos      = get_field( 'images' );
$mv_flickr      = get_field( 'flickr_link' );

// A unique id per instance – the old markup reused #photo-slide for every block.
$mv_slider_id = ! empty( $block['id'] ) ? 'photo-slide-' . sanitize_html_class( (string) $block['id'] ) : wp_unique_id( 'photo-slide-' );
?>
<div class="default-content block-gallery-slider-wrapper">

	<?php if ( '' !== $mv_title ) : ?>
		<h2 class="fl"><?php echo esc_html( $mv_title ); ?></h2>
	<?php endif; ?>

	<?php if ( '' !== $mv_description ) : ?>
		<p class="gallery-slider-description"><?php echo esc_html( $mv_description ); ?></p>
	<?php endif; ?>

	<?php if ( $mv_photos && is_array( $mv_photos ) ) : ?>
		<div class="photo-slide-wrapper">
			<div id="<?php echo esc_attr( $mv_slider_id ); ?>" class="splide js-mv-gallery"
				role="group" aria-label="<?php echo esc_attr( '' !== $mv_title ? $mv_title : __( 'Image gallery', 'maillot-vert' ) ); ?>">
				<div class="splide__track">
					<ul class="splide__list">
						<?php foreach ( $mv_photos as $mv_photo ) : ?>
							<li class="splide__slide photo-slide-li-element">
								<div class="photo-slide-image">
									<?php mv_the_image( $mv_photo, 'large' ); ?>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php mv_the_link( $mv_flickr, 'mv-button' ); ?>
</div>
<?php
mv_block_close();
