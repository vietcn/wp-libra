<?php

/**
 * Auto create css from Meta Options.
 * 
 * @author Fox
 * @version 1.0.0
 */
class CMSSuperHeroes_DynamicCss
{

    function __construct()
    {
        add_action('wp_head', array($this, 'generate_css'));
    }

    /**
     * generate css inline.
     *
     * @since 1.0.0
     */
    public function generate_css()
    {
        global $smof_data, $wp_libra_base;
        $css = $this->css_render();
        if (! $smof_data['dev_mode']) {
            $css = $wp_libra_base->compressCss($css);
        }
        echo '<style type="text/css" data-type="cms_shortcodes-custom-css">'.$css.'</style>';
    }

    /**
     * header css
     *
     * @since 1.0.0
     * @return string
     */
    public function css_render()
    {
        global $smof_data, $wp_libra_meta;
        ob_start();
        
        /* ==========================================================================
           Start Body
        ========================================================================== */
       if (is_page() && !empty($wp_libra_meta->_cms_color_widget)) {
            echo "body #sidebar #secondary .about-me .content {
                background-color: ".esc_attr($wp_libra_meta->_cms_color_widget).";
            }";
            echo "body #sidebar #secondary .widget_categories ul {
                background-color: ".esc_attr($wp_libra_meta->_cms_color_widget).";
            }";
            echo "body #sidebar #secondary .widget_newsletterwidget .sb-content {
                background-color: ".esc_attr($wp_libra_meta->_cms_color_widget).";
            }";
            echo "body #sidebar #secondary .widget_newsletterwidget form {
                background-color: ".esc_attr($wp_libra_meta->_cms_color_widget).";
            }";
        }

        if(is_page() && !empty($wp_libra_meta->_cms_color_link_text)) {
            echo "body #sidebar #secondary .about-me .content p {
                color: ".esc_attr($wp_libra_meta->_cms_color_link_text).";
            }";
            echo "body #sidebar #secondary .about-me .content a {
                color: ".esc_attr($wp_libra_meta->_cms_color_link_text).";
            }";

            echo "body #sidebar #secondary .widget_categories ul a {
                color: ".esc_attr($wp_libra_meta->_cms_color_link_text).";
            }";
            echo "body #sidebar #secondary .widget_categories ul a:before {
                border-color: ".esc_attr($wp_libra_meta->_cms_color_link_text).";
            }";
            echo "body #sidebar #secondary .widget_categories ul li {
                border-bottom-color: ".esc_attr($wp_libra_meta->_cms_color_link_text).";
            }";
            echo "body #sidebar #secondary .widget_categories ul ul.children {
                border-top-color: ".esc_attr($wp_libra_meta->_cms_color_link_text).";
            }";
            echo "body #sidebar #secondary .widget_categories ul ul.children li {
                border-bottom-color: ".esc_attr($wp_libra_meta->_cms_color_link_text).";
            }";

            echo "body #sidebar #secondary .widget_newsletterwidget .sb-content p {
                color: ".esc_attr($wp_libra_meta->_cms_color_link_text).";
            }";
            echo "body #sidebar #secondary .widget_newsletterwidget .newsletter-widget .newsletter-email {
                color: ".esc_attr($wp_libra_meta->_cms_color_link_text).";
            }";
            echo "body #sidebar #secondary .widget_newsletterwidget .newsletter-widget form input::-moz-placeholder {
                color: ".esc_attr($wp_libra_meta->_cms_color_link_text).";
            }";
            echo "body #sidebar #secondary .widget_newsletterwidget .newsletter-widget form input::-webkit-input-placeholder {
                color: ".esc_attr($wp_libra_meta->_cms_color_link_text).";
            }";
            echo "body #sidebar #secondary .widget_newsletterwidget .newsletter-widget form input:-ms-input-placeholder {
                color: ".esc_attr($wp_libra_meta->_cms_color_link_text).";
            }";
            echo "body #sidebar #secondary .widget_newsletterwidget .sb-content .sb-social {
                border-bottom-color: ".esc_attr($wp_libra_meta->_cms_color_link_text).";
            }";

            echo "body #sidebar #secondary .widget_newsletterwidget .sb-content .sb-social a {
                color: ".esc_attr($wp_libra_meta->_cms_color_link_text).";
            }";
        }

        if(is_page() && !empty($wp_libra_meta->_cms_color_line_buttom)) {
            echo "body #sidebar #secondary .about-me:after {
                background-color: ".esc_attr($wp_libra_meta->_cms_color_line_buttom).";
            }";
            echo "body #sidebar #secondary .widget_categories ul:after {
                background-color: ".esc_attr($wp_libra_meta->_cms_color_line_buttom).";
            }";
            echo "body #sidebar #secondary .about-me .content a:hover {
                color: ".esc_attr($wp_libra_meta->_cms_color_line_buttom).";
            }";
            echo "body #sidebar #secondary .widget_newsletterwidget .sb-content .sb-social a:hover {
                color: ".esc_attr($wp_libra_meta->_cms_color_line_buttom).";
            }";
            echo "body #sidebar #secondary .widget_newsletterwidget .newsletter-widget .newsletter-submit {
                background-color: ".esc_attr($wp_libra_meta->_cms_color_line_buttom).";
            }";
        }

        if(is_page() && !empty($wp_libra_meta->_cms_bg_color_input)) {
            echo "body #sidebar #secondary .widget_newsletterwidget .newsletter-widget .newsletter-email {
                background-color: ".esc_attr($wp_libra_meta->_cms_bg_color_input).";
            }";
        }
        /* ==========================================================================
           End Body
        ========================================================================== */
        return ob_get_clean();
    }
}

new CMSSuperHeroes_DynamicCss();