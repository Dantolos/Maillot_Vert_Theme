<?php

// Support custom "anchor" values.
$anchor = "";
if (!empty($block["anchor"])) {
    $anchor = 'id="' . esc_attr($block["anchor"]) . '" ';
}

// hide block
$visibility = get_field("display");
$visibility_class = "visibility: hidden; display:none;";

// show message in backend, if block is hidden
if (is_admin() && !$visibility) {
    echo '<div style="border:6px solid #e6e6e6; border-radius:25px; padding:8px 25px; opacity:.3; position:relative;">';
    echo '<div style="position:absolute; top:0; right:0; padding:5px 20px; background-color:#e6e6e6;  border-radius: 0px 25px; ">Hidden</div>';
}

$photos = get_field("images") ?: null;
?>

<div <?php echo $anchor; ?>class=" block-gallery-slider-container default-container" style="padding-top:0; padding-bottom:0; <?php if (
    !$visibility &&
    !is_admin()
) {
    echo $visibility_class;
} ?>">

 <!--<div class="gallery-slider-background">
    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mv-bacground-element-02.png" alt="">
    </div>-->

    <div class="default-content block-gallery-slider-wrapper">

        <?php if (get_field("title")) {
            echo "<h3>" . get_field("title") . "</h3>";
        } ?>
        <?php if (get_field("description")) {
            echo '<p style="text-align:center;">' .
                get_field("description") .
                "</p>";
        } ?>

        <div <?php echo $anchor; ?> class="photo-slide-wrapper" >
            <?php if ($photos) { ?>
                <div id="photo-slide" class="splide" >
                        <div class="splide__track" style="overflow:hidden;">
                            <ul class="splide__list" style="overflow-y:visible;">
                                <?php foreach ($photos as $key => $photo) {
                                    //$alt = $photo['alt'] ?: $photo['name'].$key;
                                    echo '<li class="splide__slide photo-slide-li-element">';

                                    echo '<div class="photo-slide-image ">';
                                    echo '<img src="' .
                                        $photo .
                                        '" alt="MV Gallery Image ' .
                                        $key .
                                        '" />';
                                    echo "</div>";

                                    echo "</li>";
                                } ?>
                            </ul>
                        </div>
                </div>
            <?php } ?>
        </div>

        <?php if (get_field("flickr_link")) {
            echo '<a href="' .
                get_field("flickr_link")["url"] .
                '" target="' .
                get_field("flickr_link")["target"] .
                '"><button>' .
                get_field("flickr_link")["title"] .
                "</button></a>";
        } ?>

    </div>

</div>
<?php if (is_admin() && !$visibility) {
    echo "</div>";
}
