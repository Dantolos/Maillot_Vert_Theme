<?php

add_action( 'init', 'register_acf_blocks' );
function register_acf_blocks() {

    register_block_type( __DIR__ . '/hero' );
    require_once( __DIR__ . '/hero/hero.acf.php' );

    register_block_type( __DIR__ . '/container' );
    require_once( __DIR__ . '/container/container.acf.php' );
    
    register_block_type( __DIR__ . '/facts' );
    require_once( __DIR__ . '/facts/facts.acf.php' );
    
    register_block_type( __DIR__ . '/ticket' );
    require_once( __DIR__ . '/ticket/ticket.acf.php' );

    register_block_type( __DIR__ . '/program' );
    require_once( __DIR__ . '/program/program.acf.php' );
    
    register_block_type( __DIR__ . '/gallery-slider' );
    require_once( __DIR__ . '/gallery-slider/gallery-slider.acf.php' );

    register_block_type( __DIR__ . '/location-teaser' );
    require_once( __DIR__ . '/location-teaser/location-teaser.acf.php' );
}

//Register block script
add_action( 'init', 'mv_register_block_script' );
function mv_register_block_script() {
    $theme_version = wp_get_theme()->get( 'Version' );
    wp_register_script( 'block-gallery-slider', get_template_directory_uri() . '/components/blocks/gallery-slider/gallery-slider.js', [ 'splide' ], $theme_version );
  
}