<?php
// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

?>

<div <?php echo $anchor; ?> class=" block-hero-container default-container" style="padding-top:0; padding-bottom:0;">

     <div class="default-content block-hero-wrapper">

          <div class="hero-left-container">
               <img class="mv-hero-image" src="<?php echo get_field('image'); ?>" alt="Mailott Vert Hero Image" />
          </div>
          <div class="hero-right-container">
               <h1 class="fl"><?php echo get_field('title'); ?></h1>
               <h3 class="fs" style="margin: 10px 0;"><?php echo get_field('subtitle') ?></h3>
               <?php if(get_field('button')) { ?>
                    <a href="<?php echo get_field('button')['url']; ?>"><button><?php echo get_field('button')['title']; ?></button></a>
               <?php } ?>
          </div>
          
     </div>
 
</div>