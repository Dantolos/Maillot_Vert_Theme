<?php


// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$supporters = get_field('supporters') ?: null;
 
?>

<div <?php echo $anchor; ?>class=" block-supporter-strip-container default-container" style="padding-top:0; padding-bottom:0;">

     <div class="default-content block-supporter-strip-wrapper">
          <h3 style="width:100%; text-align:center;"><?php echo get_field('title'); ?></h3>
  

          <?php 
          $catBefore = '';
          foreach($supporters as $supporter) { 
               $cat = get_the_terms($supporter, 'partner-category')[0];
               $maincat = $cat->slug === 'initialpartner' ? true : false;
               $maincatClass = $maincat ? 'main-cat' : ''; 
               if($cat != $catBefore ){
                    echo '<div class="supporter-categorie-title">';
                    echo '<h4>'.$cat->name.'</h4>';
                    echo '</div>';
                    $catBefore = $cat;
               }

               ?>
               <a href="<?php echo get_field('informationss', $supporter)['website']; ?>" class="<?php echo $maincatClass; ?>" target="_blank">
                    <div class="supporter-item">
                         <img src="<?php echo esc_url( get_field('logos', $supporter)['logo'] ); ?>" alt="<?php echo the_title($supporter); ?>" />
                    </div>
               </a> 
          <?php } ?>
          

     </div>

</div>