<?php
/**
 * 404 template.
 *
 * @package MaillotVert
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<div class="default-container">
	<div class="default-content page-content error-404">
		<h1 class="fl"><?php esc_html_e( 'Page not found', 'maillot-vert' ); ?></h1>
		<p><?php esc_html_e( 'The page you were looking for does not exist or has moved.', 'maillot-vert' ); ?></p>

		<?php get_search_form(); ?>

		<p>
			<a class="mv-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<?php esc_html_e( 'Back to the home page', 'maillot-vert' ); ?>
			</a>
		</p>
	</div>
</div>
<?php
get_footer();
