<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
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
    <div class="sidebar-active <?php if($paged > 1) { echo 'paged-active'; } ?>">
        <div class="row">
            <div id="primary" class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                <div id="content" role="main">
                    <?php if ( have_posts() ) : ?>

                        <?php /* Start the Loop */ ?>
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php get_template_part( 'single-templates/content/content', get_post_format() ); ?>
                        <?php endwhile; ?>

                    <?php else : ?>

                        <article id="post-0" class="post no-results not-found">

                            <?php if ( current_user_can( 'edit_posts' ) ) :
                                // Show a different message to a logged-in user who can add posts.
                                ?>
                                <header class="entry-header">
                                    <h1 class="entry-title"><?php esc_html_e( 'No posts to display', 'wp-libra' ); ?></h1>
                                </header>

                                <div class="entry-content">
                                    <p><?php printf( esc_html__( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'wp-libra' ), admin_url( 'post-new.php' ) ); ?></p>
                                </div><!-- .entry-content -->

                            <?php else :
                                // Show the default message to everyone else.
                                ?>
                                <header class="entry-header">
                                    <h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'wp-libra' ); ?></h1>
                                </header>

                                <div class="entry-content">
                                    <p><?php esc_html_e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'wp-libra' ); ?></p>
                                    <?php get_search_form(); ?>
                                </div><!-- .entry-content -->
                            <?php endif; // end current_user_can() check ?>

                        </article><!-- #post-0 -->

                    <?php endif; // end have_posts() check ?>

                </div><!-- #content -->

            </div><!-- #primary -->

            <div id="sidebar" class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <?php get_sidebar(); ?>
            </div>
            
        </div>
        <?php wp_libra_paging_nav(); ?>
    </div>
<?php get_footer(); ?>