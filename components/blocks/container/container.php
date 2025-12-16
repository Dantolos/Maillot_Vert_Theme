<?php

// Support custom "anchor" values.
$anchor = "";
if (!empty($block["anchor"])) {
    $anchor = 'id="' . esc_attr($block["anchor"]) . '" ';
}

// hide block
$visibility = get_field("display");
$visibility_class = "visibility: hidden;  display:none;";

// show message in backend, if block is hidden
if (is_admin() && !$visibility) {
    echo '<div style="border:6px solid #e6e6e6; border-radius:25px; padding:8px 25px; opacity:.3; position:relative;">';
    echo '<div style="position:absolute; top:0; right:0; padding:5px 20px; background-color:#e6e6e6;  border-radius: 0px 25px;">Hidden</div>';
}

$width = get_field("width") ?: "default";
?>

<div <?php echo $anchor; ?>class=" block-container container-width-<?php echo $width; ?>" style="padding-top:0; padding-bottom:0; min-height: 50px; <?php if (
    !$visibility &&
    !is_admin()
) {
    echo $visibility_class;
} ?> ">

     <InnerBlocks />

</div>
<?php if (is_admin() && !$visibility) {
    echo "</div>";
}
