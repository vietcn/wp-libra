<?php
/**
 * The Header template for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 */
global $smof_data, $wp_libra_meta; ?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="initial-scale=1, width=device-width" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php if ( ! function_exists( 'wp_site_icon' )) : ?>
<link rel="icon" type="image/png" href="<?php echo esc_url($smof_data['favicon_icon']['url']); ?>"/>
<?php endif; ?>
<?php wp_head(); ?>
</head>
<?php
    if(is_page() && isset($wp_libra_meta->_cms_boxed_bg_image) && $wp_libra_meta->_cms_boxed_bg_image) {
        $smof_data['boxed_bg_image']['url'] = wp_get_attachment_url( $wp_libra_meta->_cms_boxed_bg_image) ;
    }
?>
<body <?php body_class(); ?><?php echo !empty($smof_data['boxed_bg_image']['url']) ? ' style="background-image: url( ' . esc_url($smof_data['boxed_bg_image']['url']) . ' );"' : '' ; ?>>
<div class="overlay"></div>
<?php if($smof_data['bg_canvas']=='1'):?>
    <div id="particles"><canvas class="pg-canvas" width="1916" height="580"></canvas><canvas class="pg-canvas"></canvas></div>
<?php endif; ?>
<div id="page">
	<header id="masthead" class="site-header">
		<?php wp_libra_header(); ?>
	</header><!-- #masthead -->
	 <?php wp_libra_page_title(); ?>
	<main id="main">