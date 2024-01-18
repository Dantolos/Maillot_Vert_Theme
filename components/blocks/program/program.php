<?php


// Support custom "anchor" values.
$anchor = '';
if ( ! empty( $block['anchor'] ) ) {
    $anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

$dateFormat = new \mv\helper\date\Date_Format;

?>

<div <?php echo $anchor; ?>class=" block-program-container default-container" style="padding-top:0; padding-bottom:0;">
     <div class="default-content block-program-wrapper">
          <div class="program-image">
               <img src="<?php echo get_field('image'); ?>" alt="">
          </div>

          <div class="program-content">
               <h3><?php echo get_field('title'); ?></h3>
               
               <?php if(get_field('program_rows')) { ?>
                    <div class="program-rows-wrapper">
                         <?php foreach(get_field('program_rows') as $key => $program_row) { ?>
                              <div class="program-row"> 
                                   <h4><?php echo $dateFormat->formating_Date_Language($program_row['time'], 'time'); ?></h4>
                                   <p><?php echo $program_row['program_title']; ?></p>
                              </div>
                         <?php } ?>
                    </div>
               <?php } ?>
          </div>
     </div>
</div>