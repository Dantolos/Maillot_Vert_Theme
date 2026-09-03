<?php
/**
 * Site footer.
 *
 * @package MaillotVert
 */

defined( 'ABSPATH' ) || exit;

$mv_has_acf = function_exists( 'get_field' );
$mv_name    = $mv_has_acf ? (string) get_field( 'name', 'option' ) : '';
$mv_address = $mv_has_acf ? (string) get_field( 'address', 'option' ) : '';
$mv_website = $mv_has_acf ? get_field( 'website', 'option' ) : null;
$mv_email   = $mv_has_acf ? get_field( 'e_mail', 'option' ) : null;
$mv_li      = $mv_has_acf ? (string) get_field( 'linkedin_link', 'option' ) : '';
$mv_legal   = $mv_has_acf ? get_field( 'footer_copyright_bar_links', 'option' ) : [];
?>
</main><!-- #main-container -->

<footer id="footer-container" class="footer-container">
	<div class="footer-content">

		<div class="footer-address">
			<?php if ( '' !== $mv_name ) : ?>
				<h2 class="fs"><?php echo esc_html( $mv_name ); ?></h2>
			<?php endif; ?>

			<?php if ( '' !== $mv_address ) : ?>
				<p><?php echo nl2br( esc_html( $mv_address ) ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $mv_website['url'] ) ) : ?>
				<p><?php mv_the_link( $mv_website, '', $mv_website['url'] ); ?></p>
			<?php endif; ?>

			<?php if ( ! empty( $mv_email['url'] ) ) : ?>
				<p><?php mv_the_link( $mv_email, '', $mv_email['url'] ); ?></p>
			<?php endif; ?>
		</div>

		<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer', 'maillot-vert' ); ?>">
			<?php
			if ( has_nav_menu( 'footer' ) ) {
				wp_nav_menu(
					[
						'theme_location' => 'footer',
						'container'      => false,
						'menu_class'     => 'footer-menu',
						'depth'          => 1,
					]
				);
			} else {
				/*
				 * Fallback while no menu is assigned. Built from home_url() so it
				 * keeps working on local and staging – the old markup hard-coded
				 * https://maillot-vert.ch.
				 */
				$mv_fallback = [
					'about' => __( 'About', 'maillot-vert' ),
					'team'  => __( 'Team', 'maillot-vert' ),
				];
				echo '<ul class="footer-menu">';
				foreach ( $mv_fallback as $mv_slug => $mv_label ) {
					printf(
						'<li><a href="%1$s">%2$s</a></li>',
						esc_url( home_url( '/' . $mv_slug . '/' ) ),
						esc_html( $mv_label )
					);
				}
				echo '</ul>';
			}
			?>
		</nav>

	</div>

	<div class="copyright-section">
		<?php if ( '' !== $mv_li ) : ?>
			<div class="linkedin-button">
				<a href="<?php echo esc_url( $mv_li ); ?>" target="_blank" rel="noopener noreferrer">
					<img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/icons/linkedin-icon.svg' ) ); ?>"
						alt="<?php esc_attr_e( 'Maillot Vert on LinkedIn', 'maillot-vert' ); ?>" width="24" height="24" loading="lazy" />
				</a>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $mv_legal ) && is_array( $mv_legal ) ) : ?>
			<nav class="legal-links" aria-label="<?php esc_attr_e( 'Legal', 'maillot-vert' ); ?>">
				<ul>
					<?php foreach ( $mv_legal as $mv_page_id ) : ?>
						<li>
							<a href="<?php echo esc_url( (string) get_permalink( $mv_page_id ) ); ?>">
								<?php echo esc_html( get_the_title( $mv_page_id ) ); ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</nav>
		<?php endif; ?>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
