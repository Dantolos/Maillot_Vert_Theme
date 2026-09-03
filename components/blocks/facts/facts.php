<?php
/**
 * Facts & figures block.
 *
 * @package MaillotVert
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True during backend preview render.
 */

defined( 'ABSPATH' ) || exit;

if ( ! mv_block_open( $block, 'block-facts-container default-container', ! empty( $is_preview ) ) ) {
	return;
}

$mv_title  = (string) get_field( 'title' );
$mv_image  = get_field( 'image' );
$mv_facts  = get_field( 'facts' );
$mv_button = get_field( 'button' );
?>
<div class="default-content block-facts-wrapper">

	<?php if ( $mv_image ) : ?>
		<div class="facts-left-column">
			<?php mv_the_image( $mv_image, 'large' ); ?>
		</div>
	<?php endif; ?>

	<div class="facts-right-column">
		<div class="facts-right-content">

			<?php if ( '' !== $mv_title ) : ?>
				<h2 class="fl"><?php echo esc_html( $mv_title ); ?></h2>
			<?php endif; ?>

			<?php if ( $mv_facts && is_array( $mv_facts ) ) : ?>
				<ul class="facts-item-wrapper">
					<?php foreach ( $mv_facts as $mv_fact ) : ?>
						<li class="fact-item">
							<?php if ( ! empty( $mv_fact['icon'] ) ) : ?>
								<div class="fact-item-icon">
									<?php mv_the_image( $mv_fact['icon'], 'thumbnail', [ 'alt' => '' ] ); ?>
								</div>
							<?php endif; ?>
							<div class="fact-infos">
								<?php if ( ! empty( $mv_fact['information']['title'] ) ) : ?>
									<h3 class="fs"><?php echo esc_html( $mv_fact['information']['title'] ); ?></h3>
								<?php endif; ?>
								<?php if ( ! empty( $mv_fact['information']['text'] ) ) : ?>
									<p><?php echo esc_html( $mv_fact['information']['text'] ); ?></p>
								<?php endif; ?>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<?php mv_the_link( $mv_button, 'mv-button facts-button' ); ?>
		</div>
	</div>
</div>
<?php
mv_block_close();
