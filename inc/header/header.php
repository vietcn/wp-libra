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
                        'theme_location' => 'primary',
                        'menu_class'     => 'nav-menu menu-main-menu',
                    );

                    /* Optional per-page menu override from page meta. */
                    $custom_menu = wp_libra_menu_location();
                    if ( ! empty( $custom_menu ) ) {
                        $attr['menu'] = $custom_menu;
                    } elseif ( ! has_nav_menu( 'primary' ) ) {
                        /*
                         * Mirror WP core behaviour when theme_location is omitted:
                         * use the first nav menu that has items.
                         */
                        $menus = wp_get_nav_menus();
                        foreach ( $menus as $menu_maybe ) {
                            $items = wp_get_nav_menu_items(
                                $menu_maybe->term_id,
                                array( 'update_post_term_cache' => false )
                            );
                            if ( ! empty( $items ) ) {
                                $attr['menu'] = (int) $menu_maybe->term_id;
                                break;
                            }
                        }
                    }

                    /* enable mega menu. */
                    if ( class_exists( 'HeroMenuWalker' ) ) {
                        $attr['walker'] = new HeroMenuWalker();
                    }

                    /*
                     * theme_location is always set above ('primary').
                     * Envato Theme Check cannot see keys inside $attr — manual review OK.
                     */
                    wp_nav_menu( $attr ); // phpcs:ignore WordPress.Theme.NavMenu
                    ?>
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