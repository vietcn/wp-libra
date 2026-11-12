<?php
/**
 * Template Name: Blog Standard
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 * @author Fox
 */
get_header(); 
global $smof_data, $wp_query, $post, $wp_libra_meta, $paged;
if(is_page() && isset($wp_libra_meta->_cms_enable_feature_slider) && $wp_libra_meta->_cms_enable_feature_slider){
    $smof_data['enable_feature_slider'] = $wp_libra_meta->_cms_enable_feature_slider;
}
?>
<?php if (($smof_data['enable_feature_slider']) && $paged < 2 ) { ?>
    <div id="slider-wrapper">
        <div class="container">
            <div class="row">
            <?php 
                wp_libra_slider_news();
            ?>
            </div>
        </div>
    </div>
    <div class="layout-divider"></div>

    <?php if ( is_active_sidebar( 'featured-box-1' ) ) { ?>
        <div class="home-carousel-slide">
            <div class="row">
                <?php dynamic_sidebar('featured-box-1'); ?>
            </div>
        </div>
    <?php } ?>
    <div class="layout-divider"></div>
<?php } ?>


<?php
    if(isset($wp_libra_meta->_cms_show_feature_box) && $paged < 2 && $wp_libra_meta->_cms_show_feature_box == '1') {
        wp_libra_feature_box();
    }
?>
<div id="page-front-page" class="home-slider full custom-page-template <?php if($paged > 1) { echo 'paged-active'; } ?>">
    <div class="no-container">
        <div class="row">
            <section id="primary" class="<?php if($wp_libra_meta->_cms_show_sidebar == '1') { echo 'col-xs-12 col-sm-8 col-md-8 col-lg-8'; }else  { echo 'col-xs-12 col-sm-12 col-md-12 col-lg-12 page-full-width'; } ?>">
                <div id="content" role="main">
                    
                    <?php query_posts('post_type=post&showposts='.get_option('posts_per_page').'&paged='.$paged); ?>
                    
                    <?php if ( have_posts() ) : ?>
                        <?php while ( have_posts() ) : the_post();
                            /* Include the post format-specific template for the content. If you want to
                             * this in a child theme then include a file called called content-___.php
                             * (where ___ is the post format) and that will be used instead.
                             */
                             get_template_part( 'single-templates/content/content', get_post_format() );
                        endwhile; // end of the loop.?>
                        
                    <?php else : ?>
                    
                        <?php get_template_part( 'single-templates/content', 'none' ); ?>
                    <?php endif; ?>
                
                </div><!-- #content -->
            </section><!-- #primary -->
            <?php if($wp_libra_meta->_cms_show_sidebar == '1') { ?>
                <div id="sidebar" class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <?php get_sidebar(); ?>
                </div>
            <?php } ?>
        </div>
         <?php wp_libra_paging_nav(); ?>
    </div>
</div>

<?php get_footer(); ?>