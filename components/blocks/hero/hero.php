<?php

// $attributes = $block->get_attributes();

// Support custom "anchor" values.
$anchor = "";
if (!empty($block["anchor"])) {
    $anchor = 'id="' . esc_attr($block["anchor"]) . '" ';
}

// hide block
$visibility = get_field("display");
$visibility_class = "visibility: hidden; display:none;";

// show message in backend, if block is hidden
if (is_admin() && $visibility) {
    echo '<div style="border:6px solid #e6e6e6; border-radius:25px; padding:8px 25px; opacity:.3; position:relative;">';
    echo '<div style="position:absolute; top:0; right:0; padding:5px 20px; background-color:#e6e6e6;  border-radius: 0px 25px; ">Hidden</div>';
}
?>

<div <?php echo $anchor; ?> class=" block-hero-container default-container" style="padding-top:0; padding-bottom:0; <?php if (
     $visibility &&
     !is_admin()
 ) {
     echo $visibility_class;
 } ?>">

     <div class="default-content block-hero-wrapper">

          <div class="hero-left-container">
               <img class="mv-hero-image" src="<?php echo get_field(
                   "image",
               ); ?>" alt="Mailott Vert Hero Image" />
          </div>
          <div class="hero-right-container">
               <h1 class="fl"><?php echo get_field("title"); ?></h1>
               <h3 class="fs" style="margin: 10px 0;"><?php echo get_field(
                   "subtitle",
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
 <?php if (is_admin() && $visibility) {
     echo "</div>";
 }
