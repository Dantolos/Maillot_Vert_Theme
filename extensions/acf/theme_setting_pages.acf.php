<?php
add_action( 'acf/init', function() {
	acf_add_options_page( array(
          'page_title' => 'Footer',
          'menu_slug' => 'footer',
          'parent_slug' => 'theme-settings',
          'position' => '',
          'redirect' => false,
     ) ); 
          acf_add_options_page( array(
          'page_title' => 'Theme Settings',
          'menu_slug' => 'theme-settings',
          'position' => '',
          'redirect' => false,
     ) );
} );

