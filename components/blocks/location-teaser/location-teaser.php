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
?>

<div <?php echo $anchor; ?>class=" block-location-teaser-container default-container" style="padding-top:0; padding-bottom:0; <?php echo $visibility_class; ?>">

     <div class="default-content block-location-teaser-wrapper">
          <!-- Location Teaser -->
          <div class="location-teaser-left">
               <img src="<?php echo get_field("image"); ?>" alt="">
          </div>

          <div class="location-teaser-right">
               <h3><?php echo get_field("title"); ?></h3>
               <div class="location-teaser-content">
                    <?php echo get_field("content"); ?>
               </div>
               <?php if (get_field("button")) { ?>
               <a href="<?php echo get_field("button")[
                   "url"
               ]; ?>" target="<?php echo get_field("button")["target"]; ?>" >
                    <button><?php echo get_field("button")["title"]; ?></button>
               </a>
               <?php } ?>
          </div>
     </div>
</div>
