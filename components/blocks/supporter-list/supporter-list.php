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

<div <?php echo $anchor; ?>class=" block-supporter-list-container default-container" style="padding-top:0; padding-bottom:0; <?php echo $visibility_class; ?>">

     <div class="default-content">
          <h3 style="width:100%; text-align:center;"><?php echo get_field(
              "title"
          ); ?></h3>

          <div class="block-supporter-list-wrapper">
               <?php if ($supporters) {
                   foreach ($supporters as $supporter) { ?>
                         <div class="supporter-list-item">
                              <div class="supporter-logo-neg">
                                   <img src="<?php echo esc_url(
                                       get_field("logos", $supporter)[
                                           "logo_negativ"
                                       ]
                                   ); ?>" alt="<?php echo the_title(
    $supporter
); ?>" />
                              </div>
                              <div class="supporter-description">
                                   <p> <?php echo get_field(
                                       "informationss",
                                       $supporter
                                   )["description"]; ?></p>
                                   <a class="supporter-list-item-link" href="<?php echo get_field(
                                       "informationss",
                                       $supporter
                                   )["website"]; ?>" target="_blank">
                                        <button><?php echo __(
                                            "WEBSEITE",
                                            "MV"
                                        ); ?></button>
                                   </a>
                              </div>
                         </div>
               <?php }
               } ?>
          </div>
     </div>

</div>
