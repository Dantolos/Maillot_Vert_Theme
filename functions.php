<?php
$theme = wp_get_theme();
define('THEME_VERSION', $theme->Version); 



// ENQUEUES
function mv_register_style() {
     $theme_version = wp_get_theme()->get( 'Version' );

     wp_enqueue_script( 'splide', get_template_directory_uri() . '/assets/js/plugins/splide/splide.min.js', array(), '1.0', true );


     wp_enqueue_style('splide-style', get_template_directory_uri() . '/assets/js/plugins/splide/splide-core.min.css', array(), $theme_version, 'all');
     wp_enqueue_style('mv-fonts', 'https://use.typekit.net/doe6ray.css', array(), $theme_version, 'all');
     wp_enqueue_style('mv-style', get_template_directory_uri() . '/assets/css/main.css', array(), $theme_version, 'all');
}
add_action('wp_enqueue_scripts', 'mv_register_style');


/*-------------------------------------------------------------*/
/*--------------------- LOAD COMPONENTS -----------------------*/
/*-------------------------------------------------------------*/

$componentsFolder = opendir(dirname(__FILE__).'/components/elements');
if ( $componentsFolder ) {
    while (($entry = readdir($componentsFolder)) !== FALSE  ) {
      if($entry[0] !== '.'){
        require_once( dirname(__FILE__).'/components/elements/'.$entry );
      }
    }
}
closedir($componentsFolder);

/*-------------------------------------------------------------*/
/*--------------------------- ACF -----------------------------*/
/*-------------------------------------------------------------*/

//check directory extensions/acf for files

$acfFolder = opendir(dirname(__FILE__).'/extensions/acf');
if ( $acfFolder ) {
    while (($entry = readdir($acfFolder)) !== FALSE  ) {
      if($entry[0] !== '.'){
        require_once( dirname(__FILE__).'/extensions/acf/'.$entry );
      }
    }
}
closedir($acfFolder);


/*-------------------------------------------------------------*/
/*------------------------ Blocks -----------------------------*/
/*-------------------------------------------------------------*/

require_once(dirname(__FILE__).'/components/blocks/blocks-register.php');


/*-------------------------------------------------------------*/
/*-------------------- Filetypes Enable -----------------------*/
/*-------------------------------------------------------------*/
add_filter( 'wp_check_filetype_and_ext', 'my_svgs_disable_real_mime_check', 10, 4 );
function my_svgs_disable_real_mime_check( $data, $file, $filename, $mimes ) {
  $wp_filetype = wp_check_filetype( $filename, $mimes );	
  $ext = $wp_filetype['ext'];
  $type = $wp_filetype['type'];
  $proper_filename = $data['proper_filename'];
  return compact( 'ext', 'type', 'proper_filename' );
}
add_filter( 'upload_mimes', function ( $mime_types ) {
    $mime_types['svg'] = 'image/svg+xml';
    $mime_types[ 'eps' ] = 'application/postscript';
    $mime_types['json'] = 'application/json'; 
    $mime_types['obj'] = 'model/obj'; 
    $mime_types['fbx'] = 'model/fbx'; 
    return $mime_types;
} );


/*-------------------------------------------------------------*/
/*---------------------DISABLE COMMENTS------------------------*/
/*-------------------------------------------------------------*/
add_action('admin_init', function () {
  // Redirect any user trying to access comments page
  global $pagenow;
   
  if ($pagenow === 'edit-comments.php') {
      wp_safe_redirect(admin_url());
      exit;
  }

  // Remove comments metabox from dashboard
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

  // Disable support for comments and trackbacks in post types
  foreach (get_post_types() as $post_type) {
      if (post_type_supports($post_type, 'comments')) {
          remove_post_type_support($post_type, 'comments');
          remove_post_type_support($post_type, 'trackbacks');
      }
  }
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
  remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
  if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
  }
});