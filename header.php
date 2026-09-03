<?php
/**
 * Site header.
 *
 * @package MaillotVert
 */

defined( 'ABSPATH' ) || exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php // Favicons live in assets/favicon – the old paths pointed at assets/images/favicon and 404'd. ?>
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( get_theme_file_uri( 'assets/favicon/apple-touch-icon.png' ) ); ?>">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo esc_url( get_theme_file_uri( 'assets/favicon/favicon-32x32.png' ) ); ?>">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo esc_url( get_theme_file_uri( 'assets/favicon/favicon-16x16.png' ) ); ?>">
	<link rel="icon" href="<?php echo esc_url( get_theme_file_uri( 'assets/favicon/favicon.ico' ) ); ?>" sizes="any">
	<link rel="manifest" href="<?php echo esc_url( get_theme_file_uri( 'assets/favicon/site.webmanifest' ) ); ?>">
	<link rel="mask-icon" href="<?php echo esc_url( get_theme_file_uri( 'assets/favicon/safari-pinned-tab.svg' ) ); ?>" color="#a6c83c">
	<meta name="msapplication-TileColor" content="#a6c83c">
	<meta name="theme-color" content="#ffffff">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-container"><?php esc_html_e( 'Skip to content', 'maillot-vert' ); ?></a>

<?php mv_site_header(); ?>

<main id="main-container" class="main-container">
