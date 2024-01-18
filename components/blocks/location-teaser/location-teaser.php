<?php


// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

?> 

<div <?php echo $anchor; ?>class=" block-location-teaser-container default-container" style="padding-top:0; padding-bottom:0;">

     <div class="default-content block-location-teaser-wrapper">
          <!-- Location Teaser -->
          <div class="location-teaser-left">
               <img src="<?php echo get_field('image'); ?>" alt="">
          </div>

          <div class="location-teaser-right">
               <h3><?php echo get_field('title') ?></h3>
               <div class="location-teaser-content">
                    <?php echo get_field('content'); ?>
               </div>
               <?php if(get_field('button')) { ?>
               <a href="<?php echo get_field('button')['url']; ?>" target="<?php echo get_field('button')['target']; ?>" >
                    <button><?php echo get_field('button')['title']; ?></button>
               </a>
               <?php } ?>
          </div>
     </div>
</div>
