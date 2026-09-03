<?php
/**
 * Container block – wraps inner blocks and controls their width.
 *
 * @package MaillotVert
 *
 * @var array $block      The block settings and attributes.
 * @var bool  $is_preview True during backend preview render.
 */

defined( 'ABSPATH' ) || exit;

$mv_width = get_field( 'width' ) ?: 'default';

if ( ! mv_block_open( $block, 'block-container container-width-' . sanitize_html_class( (string) $mv_width ), ! empty( $is_preview ) ) ) {
	return;
}
?>
<InnerBlocks />
<?php
mv_block_close();
