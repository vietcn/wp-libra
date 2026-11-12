<?php
/**
 * @name : Default
 * @package : CMSSuperHeroes
 * @author : Fox
 */
global $smof_data, $wp_libra_meta; 

$logo_url = '';
if(!empty($smof_data['main_logo']['url'])) {
    $logo_url = $smof_data['main_logo']['url'];
} else {
    $logo_url = get_template_directory_uri().'/assets/images/mainlogo.png';
}

?>
<div id="cshero-header" class="cshero-main-header <?php if (!$smof_data['menu_sticky']) {echo 'no-sticky';} ?> <?php if (is_page() && !empty($wp_libra_meta->_cms_enable_header_fixed)) {echo 'header-fixed-page';} ?>">
    <div class="container">
        <div class="row">
            <div id="cshero-header-logo">
                <a href="<?php echo esc_url(home_url('/')); ?>"><img alt="" src="<?php echo esc_url($logo_url); ?>"></a>
            </div>
            <div id="cshero-header-navigation" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <nav id="site-navigation" class="main-navigation">
                    <?php
                    
                    $attr = array(
                        'menu' =>wp_libra_menu_location(),
                        'menu_class' => 'nav-menu menu-main-menu',
                    );
                    
                    $menu_locations = get_nav_menu_locations();
                    
                    if(!empty($menu_locations['primary'])){
                        $attr['theme_location'] = 'primary';
                    }
                    
                    /* enable mega menu. */
                    if(class_exists('HeroMenuWalker')){ $attr['walker'] = new HeroMenuWalker(); }
                    
                    /* main nav. */
                    wp_nav_menu( $attr ); ?>
                </nav>
                <div class="page-popup-wrapper hidden-xs hidden-sm inner">
                    <div class="search-page">
                        <i class="fa fa-search"></i>
                    </div>
                </div>
            </div>
            <div id="cshero-menu-mobile" class="collapse navbar-collapse">
                <i class="icon-menu fa fa-bars"></i>
                <div class="page-popup-wrapper hidden-md hidden-lg">
                    <div class="search-page">
                        <i class="fa fa-search"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- #site-navigation -->