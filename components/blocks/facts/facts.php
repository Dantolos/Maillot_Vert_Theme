<?php

// Support custom "anchor" values.
$anchor = "";
if (!empty($block["anchor"])) {
    $anchor = 'id="' . esc_attr($block["anchor"]) . '" ';
}

$visibility = get_field("display");
$visibility_class = "visibility: hidden;  display:none;";

// show message in backend, if block is hidden
if (is_admin() && !$visibility) {
    echo '<div style="border:6px solid #e6e6e6; border-radius:25px; padding:8px 25px; opacity:.3; position:relative;">';
    echo '<div style="position:absolute; top:0; right:0; padding:5px 20px; background-color:#e6e6e6;  border-radius: 0px 25px; ">Hidden</div>';
}
?>

<div <?php echo $anchor; ?>class=" block-facts-container default-container" style="padding-top:0; padding-bottom:0; <?php if (
    !$visibility &&
    !is_admin()
) {
    echo $visibility_class;
} ?> "  >

     <div class="default-content block-facts-wrapper"  >

          <div class="facts-left-column">
               <img src="<?php echo get_field("image"); ?>" alt="">
          </div>

          <div class="facts-right-column">
               <div class="facts-right-content">
                    <h3><?php echo get_field("title"); ?></h3>
                    <?php if (get_field("facts")) {
                        echo '<div class="facts-item-wrapper">';

                        foreach (get_field("facts") as $key => $fact) { ?>
                              <div class="fact-item">
                                   <div class="fact-item-icon"><img src="<?php echo $fact[
                                       "icon"
                                   ]; ?>" alt="" /></div>
                                   <div class="fact-infos">
                                        <h5><?php echo $fact["information"][
                                            "title"
                                        ]; ?></h5>
                                        <p><?php echo $fact["information"][
                                            "text"
                                        ]; ?></p>
                                   </div>
                              </div>
                         <?php }

                        echo "</div>";
                    } ?>

                    <?php if (get_field("button")) { ?>
                         <a href="<?php echo get_field("button")[
                             "url"
                         ]; ?>" target="<?php echo get_field("button")[
    "target"
]; ?>" style="align-self: center;">
                              <button><?php echo get_field("button")[
                                  "title"
                              ]; ?></button>
                         </a>
                    <?php } ?>
               </div>
          </div>
     </div>
</div>
<?php if (is_admin() && !$visibility) {
    echo "</div>";
}
