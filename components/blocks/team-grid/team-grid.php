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
if (is_admin() && $visibility) {
    echo '<div style="border:6px solid #e6e6e6; border-radius:25px; padding:8px 25px; opacity:.3; position:relative;">';
    echo '<div style="position:absolute; top:0; right:0; padding:5px 20px; background-color:#e6e6e6;  border-radius: 0px 25px; ">Hidden</div>';
}
?>

<div <?php echo $anchor; ?> class="team-grid-container default-container" style="padding-top:0; padding-bottom:0; <?php if (
     $visibility &&
     !is_admin()
 ) {
     echo $visibility_class;
 } ?>">

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
<?php if (is_admin() && $visibility) {
    echo "</div>";
}
