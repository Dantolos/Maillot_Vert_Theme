<?php
/**
 * Search form.
 *
 * @package MaillotVert
 */

defined( 'ABSPATH' ) || exit;

$mv_search_id = wp_unique_id( 'search-field-' );
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $mv_search_id ); ?>">
		<?php esc_html_e( 'Search for:', 'maillot-vert' ); ?>
	</label>
	<input type="search" id="<?php echo esc_attr( $mv_search_id ); ?>" class="search-field"
		name="s" value="<?php echo esc_attr( get_search_query() ); ?>"
		placeholder="<?php esc_attr_e( 'Search …', 'maillot-vert' ); ?>" />
	<button type="submit" class="mv-button search-submit"><?php esc_html_e( 'Search', 'maillot-vert' ); ?></button>
</form>
