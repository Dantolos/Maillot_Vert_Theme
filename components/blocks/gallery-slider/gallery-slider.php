<?php


// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$photos = get_field('images') ?: null;

?>

<div <?php echo $anchor; ?>class=" block-gallery-slider-container default-container" style="padding-top:0; padding-bottom:0;">

<div class="gallery-slider-background"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/mv-bacground-element-02.png" alt=""></div>

     <div class="default-content block-gallery-slider-wrapper">
     
          <div <?php echo $anchor; ?>class="photo-slide-wrapper" >
               <?php if($photos){ ?>
                    <div id="photo-slide" class="splide">
                         <div class="splide__track" style="overflow:visible;">
                              <ul class="splide__list" style="overflow-y:visible;">
                                   <?php
                                   foreach($photos as $key => $photo){
                                        //$alt = $photo['alt'] ?: $photo['name'].$key;
                                        echo '<li class="splide__slide photo-slide-li-element">';
                                        echo '<div class="photo-slide-box " >';
                                             echo '<div class="photo-slide-image ">';
                                             echo '<img src="'.$photo.'" alt="MV Gallery Image '.$key.'" />';
                                             echo '</div>';
                                        echo '</div>';
                                        echo '</li>';
                                   }
                                   ?>
                              </ul>
                         </div>
                    </div>
               <?php } ?>
          </div>
     </div>

</div>