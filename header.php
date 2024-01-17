<!DOCTYPE html>
<html <?php language_attributes(); ?>>
     <head>
          <meta charset="<?php bloginfo('charset'); ?>">
          <meta name="viewport" content="width=device-width, initial-scale=1">

          <!-- FAVICON -->
          <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/apple-touch-icon.png">
          <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/favicon-32x32.png">
          <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/favicon-16x16.png">
          <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/site.webmanifest">
          <link rel="mask-icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/safari-pinned-tab.svg" color="#a6c83c">
          <meta name="msapplication-TileColor" content="#a6c83c">
          <meta name="theme-color" content="#ffffff">

          <link rel="shortcut icon" type="image/png" href=""/> 
          
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

          <?php wp_head();
               
          ?>
          
     </head>

     <body  lang="<?php echo ICL_LANGUAGE_CODE; ?>">

          <?php
               //add header
               $header = new mv\components\header\Header;
               echo $header->html;
          ?>  

          <!-- Background-Element -->
          <!--  <div id="mv-background-image" style="background-image:url(<?php echo get_template_directory_uri(); ?>/assets/images/mv-background-element.svg);"></div>-->
          <!-- end Background-Element -->


          <div id="main-container">

     