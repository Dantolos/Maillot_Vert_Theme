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

<div <?php echo $anchor; ?> class="team-grid-container default-container" style="padding-top:0; padding-bottom:0; <?php echo $visibility_class; ?>">

     <div class="default-content team-grid-wrapper">
     <h3><?php echo get_field("title"); ?></h3>

     <?php if (get_field("team_members")) {
         echo '<div class="team-grid-members">';
         foreach (get_field("team_members") as $member) { ?>
               <div class="team-grid-member-item">
                    <img src="<?php echo $member[
                        "portrait"
                    ]; ?>" alt="<?php echo $member["informationen"][
    "name"
]; ?>"/>
                    <h5 class="primary-color"><?php echo $member[
                        "informationen"
                    ]["name"]; ?></h5>
                    <p><?php echo $member["informationen"]["function"]; ?></p>
                    <a href="mailto:<?php echo $member["informationen"][
                        "e-mail"
                    ]; ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/mail-icon.svg" alt="email icon" /></a>
               </div>
               <?php }
         echo "</div>";
     } ?>

     </div>

</div>
