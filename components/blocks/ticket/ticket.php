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

<div <?php echo $anchor; ?>class=" block-ticket-container default-container" style="padding-top:0; padding-bottom:0; <?php echo $visibility_class; ?>">

     <div class="default-content block-ticket-wrapper">

          <h3><span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/icon_ticket_outline_.svg" width="60px" style="margin-top:-8px;"/></span> TICKET</h3>
          <h5><?php echo get_field("subtitle"); ?></h5>

          <div class="ticket-content">
               <?php echo get_field("content"); ?>
          </div>

          <?php if (get_field("price")) { ?>
               <div class="price-row">
                    <div class="price-tag"><h4><?php echo get_field("price")[
                        "pricetag"
                    ]; ?></h4></div>
                    <div class="price-value">
                         <h4><span class="currency"><?php echo get_field(
                             "price"
                         )[
                             "price"
                         ]; ?></span> <span class="currency"><?php echo get_field(
    "price"
)["currency"]; ?></span></h4>
                         <h6 class="fxxs" style="font-weight:200;"><?php echo get_field(
                             "price"
                         )["subtext"]; ?></h6>
                    </div>
               </div>
          <?php } ?>

          <div class="ticket-cta">
               <div class="ticket-cta-box">
                    <h6><?php echo get_field("register_interaction_1")[
                        "text"
                    ]; ?></h6>
                    <a href="<?php echo get_field("register_interaction_1")[
                        "button"
                    ]["url"]; ?>" target="<?php echo get_field(
    "register_interaction_1"
)["button"][
    "target"
]; ?>"><button class="btn-secondary fxs"><?php echo get_field(
    "register_interaction_1"
)["button"]["title"]; ?></button></a>
               </div>
               <div class="ticket-cta-box">
                    <h6><?php echo get_field("register_interaction_2")[
                        "text"
                    ]; ?></h6>
                    <a href="<?php echo get_field("register_interaction_2")[
                        "button"
                    ]["url"]; ?>" target="<?php echo get_field(
    "register_interaction_2"
)["button"][
    "target"
]; ?>"><button class="btn-secondary fxs"><?php echo get_field(
    "register_interaction_2"
)["button"]["title"]; ?></button></a>
               </div>
          </div>
     </div>

</div>
