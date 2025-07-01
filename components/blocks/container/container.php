<?php

// Support custom "anchor" values.
$anchor = "";
if (!empty($block["anchor"])) {
    $anchor = 'id="' . esc_attr($block["anchor"]) . '" ';
}

// hide block
$visibility = get_field("display") ?: true;
$visibility_class = $visibility
    ? "visibility: visible;"
    : "visibility: hidden;";

// show message in backend, if block is hidden
if (is_admin() && !$visibility) {
    echo '<div style="background-color:#e6e6e6; border-radius:25px; padding:8px 25px;">';
    echo '<p style="margin:0; color:#808080;">Hidden Block: <b>' .
        $block["title"] .
        "</b></p>";
    echo "</div>";
}

$width = get_field("width") ?: "default";
?>

<div <?php echo $anchor; ?>class=" block-container container-width-<?php echo $width; ?>" style="padding-top:0; padding-bottom:0; min-height: 50px; <?php echo $visibility_class; ?>">

     <InnerBlocks />

</div>
