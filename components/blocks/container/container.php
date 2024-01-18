<?php


// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$width = get_field('width') ?: 'default';

?>

<div <?php echo $anchor; ?>class=" block-container container-width-<?php echo $width; ?>" style="padding-top:0; padding-bottom:0; min-height: 50px; ">

     <InnerBlocks />
 
</div>