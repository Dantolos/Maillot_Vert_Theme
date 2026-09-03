<?php
/**
 * Supporter strip block – logos grouped by partner category.
 *
 * @package MaillotVert
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True during backend preview render.
 */

defined( 'ABSPATH' ) || exit;

if ( ! mv_block_open( $block, 'block-supporter-strip-container default-container', ! empty( $is_preview ) ) ) {
	return;
}

$mv_title      = (string) get_field( 'title' );
$mv_supporters = get_field( 'supporters' );

/*
 * Group by partner category up front. The old code compared the previous term
 * inside the loop and fataled as soon as a supporter had no category at all.
 */
$mv_groups = [];

if ( $mv_supporters && is_array( $mv_supporters ) ) {
	foreach ( $mv_supporters as $mv_supporter ) {
		$mv_terms = get_the_terms( $mv_supporter, 'partner-category' );
		$mv_term  = ( is_array( $mv_terms ) && ! empty( $mv_terms ) ) ? $mv_terms[0] : null;
		$mv_key   = $mv_term ? $mv_term->term_id : 0;

		if ( ! isset( $mv_groups[ $mv_key ] ) ) {
			$mv_groups[ $mv_key ] = [
				'name'       => $mv_term ? $mv_term->name : '',
				'is_initial' => $mv_term && false !== strpos( $mv_term->slug, 'initialpartner' ),
				'items'      => [],
			];
		}

		$mv_groups[ $mv_key ]['items'][] = $mv_supporter;
	}
}
?>
<div class="default-content block-supporter-strip-wrapper">

	<?php if ( '' !== $mv_title ) : ?>
		<h2 class="fl block-title--centered"><?php echo esc_html( $mv_title ); ?></h2>
	<?php endif; ?>

	<?php foreach ( $mv_groups as $mv_group ) : ?>

		<?php if ( '' !== $mv_group['name'] ) : ?>
			<div class="supporter-categorie-title">
				<h3 class="fm"><?php echo esc_html( $mv_group['name'] ); ?></h3>
			</div>
		<?php endif; ?>

		<?php
		foreach ( $mv_group['items'] as $mv_supporter ) :
			$mv_logos   = get_field( 'logos', $mv_supporter );
			$mv_infos   = get_field( 'informationss', $mv_supporter );
			$mv_name    = get_the_title( $mv_supporter );
			$mv_website = (string) ( $mv_infos['website'] ?? '' );
			$mv_logo    = $mv_logos['logo'] ?? null;

			if ( ! $mv_logo ) {
				continue;
			}

			$mv_classes = 'supporter-link' . ( $mv_group['is_initial'] ? ' main-cat' : '' );
			?>
			<?php if ( '' !== $mv_website ) : ?>
				<a class="<?php echo esc_attr( $mv_classes ); ?>" href="<?php echo esc_url( $mv_website ); ?>"
					target="_blank" rel="noopener noreferrer">
					<div class="supporter-item">
						<?php mv_the_image( $mv_logo, 'medium', [ 'alt' => $mv_name ] ); ?>
					</div>
				</a>
			<?php else : ?>
				<div class="<?php echo esc_attr( $mv_classes ); ?>">
					<div class="supporter-item">
						<?php mv_the_image( $mv_logo, 'medium', [ 'alt' => $mv_name ] ); ?>
					</div>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>

	<?php endforeach; ?>

</div>
<?php
mv_block_close();
