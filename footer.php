
</div>

<div id="footer-container">
   <div class="footer-content" style="">
      <div class="footer-left" style="width:30%;">

         <h5>LINDEN 3L AG</h5>
         <p>Weyermannsstrasse 36<br />
            3008 Bern Schweiz<br />
            <a href="www.livelearninglabs.ch" target="_blank">www.livelearninglabs.ch</a>
            </p>
      </div>
      <div class="footer-center" style="width:40%;">
         <p style="text-align:right;">
            <a href="mailto:dis@livelearninglabs.ch">Dr. Dominik Isler </a><br />
            <a href="mailto:dis@livelearninglabs.ch">Cornelia Giger</a>
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
                  if( $key != 0 ){ echo ' [ '; }
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