<?php
/**
 * Hero block.
 *
 * @package MaillotVert
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True during backend preview render.
 */

defined( 'ABSPATH' ) || exit;

if ( ! mv_block_open( $block, 'block-hero-container default-container', ! empty( $is_preview ) ) ) {
	return;
}

$mv_title    = (string) get_field( 'title' );
$mv_subtitle = (string) get_field( 'subtitle' );
$mv_image    = get_field( 'image' );
$mv_button   = get_field( 'button' );
?>
<div class="default-content block-hero-wrapper">

	<?php if ( $mv_image ) : ?>
		<div class="hero-left-container">
			<?php
			// The hero is above the fold: load it eagerly and with high priority.
			mv_the_image(
				$mv_image,
				'large',
				[
					'class'         => 'mv-hero-image',
					'loading'       => 'eager',
					'fetchpriority' => 'high',
				]
			);
			?>
		</div>
	<?php endif; ?>

	<div class="hero-right-container">
		<?php if ( '' !== $mv_title ) : ?>
			<h1 class="fl"><?php echo esc_html( $mv_title ); ?></h1>
		<?php endif; ?>

		<?php if ( '' !== $mv_subtitle ) : ?>
			<p class="hero-subtitle fs"><?php echo esc_html( $mv_subtitle ); ?></p>
		<?php endif; ?>

		<?php mv_the_link( $mv_button, 'mv-button' ); ?>
	</div>

</div>
<?php
mv_block_close();
