<?php
/**
 * Program block.
 *
 * @package MaillotVert
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True during backend preview render.
 */

defined( 'ABSPATH' ) || exit;

if ( ! mv_block_open( $block, 'block-program-container default-container', ! empty( $is_preview ) ) ) {
	return;
}

$mv_title  = (string) get_field( 'title' );
$mv_image  = get_field( 'image' );
$mv_rows   = get_field( 'program_rows' );
$mv_format = new \mv\helper\date\Date_Format();
?>
<div class="default-content block-program-wrapper">

	<?php if ( $mv_image ) : ?>
		<div class="program-image">
			<?php mv_the_image( $mv_image, 'large' ); ?>
		</div>
	<?php endif; ?>

	<div class="program-content">
		<?php if ( '' !== $mv_title ) : ?>
			<h2 class="fl"><?php echo esc_html( $mv_title ); ?></h2>
		<?php endif; ?>

		<?php if ( $mv_rows && is_array( $mv_rows ) ) : ?>
			<dl class="program-rows-wrapper">
				<?php foreach ( $mv_rows as $mv_row ) : ?>
					<div class="program-row">
						<dt class="program-row__time fm">
							<?php echo esc_html( (string) $mv_format->formating_Date_Language( $mv_row['time'] ?? '', 'time' ) ); ?>
						</dt>
						<dd class="program-row__title">
							<?php echo esc_html( (string) ( $mv_row['program_title'] ?? '' ) ); ?>
						</dd>
					</div>
				<?php endforeach; ?>
			</dl>
		<?php endif; ?>
	</div>
</div>
<?php
mv_block_close();
