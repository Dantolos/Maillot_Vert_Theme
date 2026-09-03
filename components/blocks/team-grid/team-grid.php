<?php
/**
 * Team grid block.
 *
 * @package MaillotVert
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True during backend preview render.
 */

defined( 'ABSPATH' ) || exit;

if ( ! mv_block_open( $block, 'team-grid-container default-container', ! empty( $is_preview ) ) ) {
	return;
}

$mv_title   = (string) get_field( 'title' );
$mv_members = get_field( 'team_members' );
?>
<div class="default-content team-grid-wrapper">

	<?php if ( '' !== $mv_title ) : ?>
		<h2 class="fl"><?php echo esc_html( $mv_title ); ?></h2>
	<?php endif; ?>

	<?php if ( $mv_members && is_array( $mv_members ) ) : ?>
		<ul class="team-grid-members">
			<?php
			foreach ( $mv_members as $mv_member ) :
				$mv_info     = $mv_member['informationen'] ?? [];
				$mv_name     = (string) ( $mv_info['name'] ?? '' );
				$mv_function = (string) ( $mv_info['function'] ?? '' );
				$mv_email    = (string) ( $mv_info['e-mail'] ?? '' );
				?>
				<li class="team-grid-member-item">
					<?php if ( ! empty( $mv_member['portrait'] ) ) : ?>
						<?php mv_the_image( $mv_member['portrait'], 'medium_large', [ 'alt' => $mv_name ] ); ?>
					<?php endif; ?>

					<?php if ( '' !== $mv_name ) : ?>
						<h3 class="primary-color fs"><?php echo esc_html( $mv_name ); ?></h3>
					<?php endif; ?>

					<?php if ( '' !== $mv_function ) : ?>
						<p><?php echo esc_html( $mv_function ); ?></p>
					<?php endif; ?>

					<?php if ( is_email( $mv_email ) ) : ?>
						<a class="team-grid-member-item__mail" href="<?php echo esc_url( 'mailto:' . antispambot( $mv_email ) ); ?>">
							<span class="screen-reader-text">
								<?php
								/* translators: %s: team member name. */
								printf( esc_html__( 'Email %s', 'maillot-vert' ), esc_html( $mv_name ) );
								?>
							</span>
							<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/icons/mail-icon.svg' ) ); ?>"
								alt="" width="24" height="24" loading="lazy" aria-hidden="true" />
						</a>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>

</div>
<?php
mv_block_close();
