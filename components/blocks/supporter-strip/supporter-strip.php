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

$supporters = get_field("supporters") ?: null;
?>

<div <?php echo $anchor; ?>class=" block-supporter-strip-container default-container" style="padding-top:0; padding-bottom:0; <?php echo $visibility_class; ?>">

     <div class="default-content block-supporter-strip-wrapper">
          <h3 style="width:100%; text-align:center;"><?php echo get_field(
              "title"
          ); ?></h3>


          <?php
          $catBefore = "";
          foreach ($supporters as $supporter) {

              $cat = get_the_terms($supporter, "partner-category")[0];
              $maincat = str_contains($cat->slug, "initialpartner")
                  ? true
                  : false;
              $maincatClass = $maincat ? "main-cat" : "";
              if ($cat != $catBefore) {
                  echo '<div class="supporter-categorie-title">';
                  echo "<h4>" . $cat->name . "</h4>";
                  echo "</div>";
                  $catBefore = $cat;
              }
              ?>
               <a href="<?php echo get_field("informationss", $supporter)[
                   "website"
               ]; ?>" class="<?php echo $maincatClass; ?>" target="_blank">
                    <div class="supporter-item">
                         <img src="<?php echo esc_url(
                             get_field("logos", $supporter)["logo"]
                         ); ?>" alt="<?php echo the_title($supporter); ?>" />
                    </div>
               </a>
          <?php
          }
          ?>


     </div>

</div>
