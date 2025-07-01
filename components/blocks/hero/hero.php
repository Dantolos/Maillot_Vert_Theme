<?php

// $attributes = $block->get_attributes();

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

<div <?php echo $anchor; ?> class=" block-hero-container default-container" style="padding-top:0; padding-bottom:0; <?php echo $visibility_class; ?>">

     <div class="default-content block-hero-wrapper">

          <div class="hero-left-container">
               <img class="mv-hero-image" src="<?php echo get_field(
                   "image"
               ); ?>" alt="Mailott Vert Hero Image" />
          </div>
          <div class="hero-right-container">
               <h1 class="fl"><?php echo get_field("title"); ?></h1>
               <h3 class="fs" style="margin: 10px 0;"><?php echo get_field(
                   "subtitle"
               ); ?></h3>
               <?php if (get_field("button")) { ?>
                    <a href="<?php echo get_field("button")[
                        "url"
                    ]; ?>"><button><?php echo get_field("button")[
    "title"
]; ?></button></a>
               <?php } ?>
          </div>

     </div>

</div>
