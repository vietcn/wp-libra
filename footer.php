<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 */
global $smof_data, $post, $wp_libra_meta;
$hide_footer = (isset($wp_libra_meta->_cms_hide_footer) && !is_search()) ? $wp_libra_meta->_cms_hide_footer : '';
$id_contact_form = '';
if (!empty($smof_data['get_id_contact_form'])) {
    $id_contact_form = $smof_data['get_id_contact_form'];
}
?>
        </main><!-- #main -->
        <div class="layout-divider"></div>
		<footer>
                <div id="cshero-footer-top">
                    <div class="no-container">
                        <?php dynamic_sidebar('wg-footer-top'); ?>
                    </div>
                </div>
                <?php if ( is_active_sidebar( 'wg-footer-middle-1' ) && is_active_sidebar( 'wg-footer-middle-2' ) && is_active_sidebar( 'wg-footer-middle-3' )) { ?>
                    <div id="cshero-footer-middle">
                        <div class="row">
                            <div class="wg-logo col-xs-12 col-sm-4 col-md-4 col-lg-4"><?php dynamic_sidebar('wg-footer-middle-1'); ?></div>
                            <div class="popular-tags col-xs-12 col-sm-4 col-md-4 col-lg-4"><?php dynamic_sidebar('wg-footer-middle-2'); ?></div>
                            <div class="subscribe col-xs-12 col-sm-4 col-md-4 col-lg-4"><?php dynamic_sidebar('wg-footer-middle-3'); ?></div>
                        </div>
                    </div>   
                <?php } ?>

                <?php if ( is_active_sidebar( 'wg-footer-bottom-left' ) && is_active_sidebar( 'wg-footer-bottom-right' ) && is_active_sidebar( 'wg-footer-middle-3' )) { ?>
                    <div id="cshero-footer-bottom">
                         <div class="row">
                             <div class=" copyright col-xs-12 col-sm-6 col-md-6 col-lg-6"><?php dynamic_sidebar('wg-footer-bottom-left'); ?></div>
                             <div class="bottom-text-right col-xs-12 col-sm-6 col-md-6 col-lg-6"><?php dynamic_sidebar('wg-footer-bottom-right'); ?></div>
                         </div>
                    </div>
                <?php } ?>
		</footer><!-- #site-footer -->
        <div class="page-search-popup">
            <div class="container">
                <div class="row">
                    <div class="close"></div>
                    <div class="page-search-header">
                        <?php get_search_form (); ?>
                    </div>
                </div>
            </div>
        </div>
	</div><!-- #page -->
	<?php wp_footer(); ?>
</body>
</html>