<?php
/**
 * Supporter list block.
 *
 * @package MaillotVert
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True during backend preview render.
 */

defined( 'ABSPATH' ) || exit;

if ( ! mv_block_open( $block, 'block-supporter-list-container default-container', ! empty( $is_preview ) ) ) {
	return;
}

$mv_title      = (string) get_field( 'title' );
$mv_supporters = get_field( 'supporters' );
?>
<div class="default-content">

	<?php if ( '' !== $mv_title ) : ?>
		<h2 class="fl block-title--centered"><?php echo esc_html( $mv_title ); ?></h2>
	<?php endif; ?>

	<?php if ( $mv_supporters && is_array( $mv_supporters ) ) : ?>
		<ul class="block-supporter-list-wrapper">
			<?php
			foreach ( $mv_supporters as $mv_supporter ) :
				$mv_logos   = get_field( 'logos', $mv_supporter );
				$mv_infos   = get_field( 'informationss', $mv_supporter );
				$mv_name    = get_the_title( $mv_supporter );
				$mv_website = (string) ( $mv_infos['website'] ?? '' );
				?>
				<li class="supporter-list-item">
					<?php if ( ! empty( $mv_logos['logo_negativ'] ) ) : ?>
						<div class="supporter-logo-neg">
							<?php mv_the_image( $mv_logos['logo_negativ'], 'medium', [ 'alt' => $mv_name ] ); ?>
						</div>
					<?php endif; ?>

					<div class="supporter-description">
						<?php if ( ! empty( $mv_infos['description'] ) ) : ?>
							<p><?php echo esc_html( $mv_infos['description'] ); ?></p>
						<?php endif; ?>

						<?php if ( '' !== $mv_website ) : ?>
							<a class="mv-button supporter-list-item-link" href="<?php echo esc_url( $mv_website ); ?>"
								target="_blank" rel="noopener noreferrer">
								<?php esc_html_e( 'Website', 'maillot-vert' ); ?>
								<span class="screen-reader-text"><?php echo esc_html( $mv_name ); ?></span>
							</a>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
<?php
mv_block_close();
