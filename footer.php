
</div>

<?php $language = apply_filters( 'wpml_current_language', null ); ?>

<div id="footer-container">
   <div class="footer-content" style="">
      <div class="footer-left" style="width:30%;">

         <h5><?php echo get_field('name', 'option'); ?></h5>
         <p> <?php echo get_field('address', 'option') ?></p>
            <?php if(get_field('website', 'option')) { ?>
               <p><a href="<?php echo get_field('website', 'option')['url']; ?>" target="_blank"><?php echo get_field('website', 'option')['title']; ?></a></p>
            <?php } ?>
            <?php if(get_field('e_mail', 'option')) { ?>
               <p><a href="<?php echo get_field('e_mail', 'option')['url']; ?>" target="_blank"><?php echo get_field('e_mail', 'option')['title']; ?></a></p>
            <?php } ?>   
    
      </div>
     <!-- <div class="footer-center" style="width:40%;">
         <p style="text-align:right;">
            <a href="mailto:dis@livelearninglabs.ch">Dr. Dominik Isler </a><br />
            <a href="mailto:dis@livelearninglabs.ch">Cornelia Giger</a>
         </p>
      </div>  -->

      <div class="footer-right" style="width:40%;">
         <p style="text-align:right;">
            <a href="https://maillot-vert.ch/<?= $language; ?>/about">About</a><br />
            <a href="https://maillot-vert.ch/<?= $language; ?>/team">Team</a>
         </p>
      </div> 

   </div>

   <div class="copyright-section">
      <div class="linkedin-button">
         <a href="<?php echo get_field('linkedin_link', 'option'); ?>" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/icons/linkedin-icon.svg" alt="linkedin-icon" /></a>
      </div>
      <p style="text-align:right;">
         <?php 
            if(get_field('footer_copyright_bar_links', 'option')) {
               foreach(get_field('footer_copyright_bar_links', 'option') as $key => $fooerLink ){
                  if( $key != 0 ){ echo ' | '; }
                  echo '<a href="'.get_permalink($fooerLink).'">'.get_the_title($fooerLink).'</a>';
               }
            }
         ?>
  
      </p>
   </div>


</div>


<?php wp_footer(); ?>
</body>
</html> 