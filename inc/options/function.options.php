<?php
global $wp_libra_base;
/**
 * Home Options
 *
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Main Options', 'wp-libra'),
    'icon' => 'el-icon-dashboard',
    'fields' => array()
);

$this->sections[] = array(
    'icon' => 'el-icon-briefcase',
    'title' => esc_html__('Demo Content', 'wp-libra'),
    'subsection' => true,
    'fields' => array(
        array(
            'subtitle' => '<input type=\'button\' name=\'sample\' id=\'dummy-data\' value=\'Import Now\' /><div class=\'cms-dummy-process\'><div  class=\'cms-dummy-process-bar\'></div></div><div id=\'cms-msg\'><span class="cms-status"></span></div>',
            'id' => 'theme',
            'icon' => true,
            'default' => 'libra',
            'options' => array(
                'libra' => get_template_directory_uri() . '/assets/images/dummy/libra.png'
            ),
            'type' => 'image_select',
            'title' => 'Select Theme'
        )
    )
);

$this->sections[] = array(
    'title' => esc_html__('Favicon Icon', 'wp-libra'),
    'icon' => 'el-icon-star',
    'fields' => array(
        array(
            'title' => esc_html__('Icon', 'wp-libra'),
            'subtitle' => esc_html__('Select a favicon icon (.png, .jpg).', 'wp-libra'),
            'id' => 'favicon_icon',
            'type' => 'media',
            'url' => true,
            'default' => array(
                'url'=>get_template_directory_uri().'/assets/images/favicon.png'
            )
        ),
    )
);

/* End Dummy Data */
/**
 * Header Options
 *
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Header', 'wp-libra'),
    'icon' => 'el-icon-credit-card',
    'fields' => array(
        array(
            'subtitle' => esc_html__('enable sticky mode for menu.', 'wp-libra'),
            'id' => 'menu_sticky',
            'type' => 'switch',
            'title' => esc_html__('Sticky Header', 'wp-libra'),
            'default' => false
        ),
    )
);

/* Logo */
$this->sections[] = array(
    'title' => esc_html__('Logo', 'wp-libra'),
    'icon' => 'el-icon-picture',
    'subsection' => true,
    'fields' => array(
        array(
            'title' => esc_html__('Select Logo', 'wp-libra'),
            'subtitle' => esc_html__('Select an image file for your logo.', 'wp-libra'),
            'id' => 'main_logo',
            'type' => 'media',
            'url' => true,
            'default' => array(
                'url' => get_template_directory_uri() . '/assets/images/mainlogo.png'
            )
        ),
    )
);

/**
 * Page Title Options
 * 
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Page Title', 'wp-libra'),
    'icon' => 'el el-map-marker',
    'fields' => array(
        array(
            'id' => 'page_title_layout',
            'title' => esc_html__('Layouts', 'wp-libra'),
            'subtitle' => esc_html__('Select a layout for page title', 'wp-libra'),
            'default' => '1',
            'type' => 'image_select',
            'options' => array(
                '' => get_template_directory_uri().'/inc/options/images/pagetitle/p0.png',
                '1' => get_template_directory_uri().'/inc/options/images/pagetitle/p1.png',
            )
        ),
        array(
            'title' => esc_html__('Select Background Image', 'wp-libra'),
            'subtitle' => esc_html__('Select an image file for your background image page title.', 'wp-libra'),
            'id' => 'bg_image_page_title',
            'type' => 'media',
            'url' => true,
            'default' => array(
                'url' => get_template_directory_uri() . '/assets/images/bg-page-title.jpg'
            )
        ),
    )
);

/**
 * Body
 *
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Body', 'wp-libra'),
    'icon' => 'el-icon-website',
    'fields' => array(
        array(
            'title' => esc_html__('Boxed Background Image', 'wp-libra'),
            'subtitle' => esc_html__('Select an image file for your background image body.', 'wp-libra'),
            'id' => 'boxed_bg_image',
            'type' => 'media',
            'url' => true,
            'default' => array(
                'url' => get_template_directory_uri() . '/assets/images/bg-body.jpg'
            )
        ),
        array(
            'id' => 'bg_canvas',
            'type' => 'switch',
            'title' => esc_html__('Enable canvas', 'wp-libra'),
            'default' => false,
        )
    )
);

/**
 * Footer
 *
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Footer', 'wp-libra'),
    'icon' => 'el-icon-credit-card',
);

/* Footer top */
$this->sections[] = array(
    'title' => esc_html__('Footer Top', 'wp-libra'),
    'icon' => 'el-icon-fork',
    'subsection' => true,
    'fields' => array(
        array(
            'subtitle' => esc_html__('enable button back to top.', 'wp-libra'),
            'id' => 'footer_botton_back_to_top',
            'type' => 'switch',
            'title' => esc_html__('Back To Top', 'wp-libra'),
            'default' => true,
        )
    )
);

/**
 * Styling
 *
 * css color.
 * 
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Styling', 'wp-libra'),
    'icon' => 'el-icon-adjust',
    'fields' => array(
        array(
            'subtitle' => esc_html__('set color main color.', 'wp-libra'),
            'id' => 'primary_color',
            'type' => 'color',
            'title' => esc_html__('Primary Color', 'wp-libra'),
            'default' => '#e7cd3b'
        ),
    )
);

/**
 * Typography
 *
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Typography', 'wp-libra'),
    'icon' => 'el-icon-text-width',
    'fields' => array(
        array(
            'id' => 'font_body',
            'type' => 'typography',
            'title' => esc_html__('Body Font', 'wp-libra'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output' => array(
                'body'
            ),
            'units' => 'px',
            'default' => array(
                'color' => '#8a8a8a',
                'font-style' => 'normal',
                'font-weight' => '400',
                'font-family' => 'Raleway',
                'google' => true,
                'font-size' => '14px',
                'line-height' => '24px',
                'text-align' => ''
            ),
            'subtitle' => esc_html__('Typography option with each property can be called individually.', 'wp-libra')
        ),
        array(
            'id' => 'font_menu',
            'type' => 'typography',
            'title' => esc_html__('Menu Font', 'wp-libra'),
            'google' => true,
            'font-backup' => false,
            'font-style' => false,
            'color' => false,
            'text-align' => false,
            'line-height' => false,
            'font-size' => false,
            'subsets' => false,
            'all_styles' => true,
            'units' => 'px',
            'subtitle' => esc_html__('Typography option with each property can be called individually.', 'wp-libra'),
            'output' => array(
                '#cshero-header-navigation .main-navigation ul li a'
            ),
            'default' => array(
                'font-weight' => '600',
                'font-family' => 'Raleway',
                'google' => true,
            )
        ),
        array(
            'id' => 'font_h1',
            'type' => 'typography',
            'title' => esc_html__('H1', 'wp-libra'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output' => array(
                'body h1'
            ),
            'units' => 'px',
            'default' => array(
                'color' => '',
                'font-style' => 'normal',
                'font-weight' => '500',
                'font-family' => 'Raleway',
                'google' => true,
                'font-size' => '30px',
                'line-height' => '42px',
                'text-align' => ''
            )
        ),
        array(
            'id' => 'font_h2',
            'type' => 'typography',
            'title' => esc_html__('H2', 'wp-libra'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output' => array(
                'body h2'
            ),
            'units' => 'px',
            'default' => array(
                'color' => '#4a4a4a',
                'font-style' => 'normal',
                'font-weight' => '600',
                'font-family' => 'Raleway',
                'google' => true,
                'font-size' => '28px',
                'line-height' => '34px',
                'text-align' => ''
            )
        ),
        array(
            'id' => 'font_h3',
            'type' => 'typography',
            'title' => esc_html__('H3', 'wp-libra'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output' => array(
                'body h3'
            ),
            'units' => 'px',
            'default' => array(
                'color' => '',
                'font-style' => 'normal',
                'font-weight' =>'600',
                'font-family' => 'Raleway',
                'google' => true,
                'font-size' => '18px',
                'line-height' => '20px',
                'text-align' => ''
            )
        ),
        array(
            'id' => 'font_h4',
            'type' => 'typography',
            'title' => esc_html__('H4', 'wp-libra'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output' => array(
                'body h4'
            ),
            'units' => 'px',
            'default' => array(
                'color' => '#4a4a4a',
                'font-style' => 'normal',
                'font-weight' => '600',
                'font-family' => 'Raleway',
                'google' => true,
                'font-size' => '18px',
                'line-height' => '20px',
                'text-align' => ''
            )
        ),
        array(
            'id' => 'font_h5',
            'type' => 'typography',
            'title' => esc_html__('H5', 'wp-libra'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output' => array(
                'body h5'
            ),
            'units' => 'px',
            'default' => array(
                'color' => '#4a4a4a',
                'font-style' => 'normal',
                'font-weight' => '600',
                'font-family' => 'Raleway',
                'google' => true,
                'font-size' => '14px',
                'line-height' => '15px',
                'text-align' => ''
            )
        ),
        array(
            'id' => 'font_h6',
            'type' => 'typography',
            'title' => esc_html__('H6', 'wp-libra'),
            'google' => true,
            'font-backup' => true,
            'all_styles' => true,
            'output' => array(
                'body h6'
            ),
            'units' => 'px',
            'default' => array(
                'color' => '#4a4a4a',
                'font-style' => 'normal',
                'font-weight' => '700',
                'font-family' => 'Raleway',
                'google' => true,
                'font-size' => '12px',
                'line-height' => '13px',
                'text-align' => ''
            )
        )
    )
);

/**
 * Page Option
 *
 * css color.
 * 
 * @author CMS
 */
$this->sections[] = array(
    'title' => esc_html__('Page Option', 'wp-libra'),
    'icon' => 'el-icon-edit',
    'fields' => array(
        array(
            'id' => 'page_comment',
            'type' => 'switch',
            'title' => esc_html__('Show Comment', 'wp-libra'),
            'subtitle' => esc_html__('Show / Hide comment on page.', 'wp-libra'),
            'default' => true
        ),
    )
);

/**
 * Slider Option
 *
 * css color.
 * 
 * @author CMS
 */
$this->sections[] = array(
    'title' => esc_html__('Slider Option', 'wp-libra'),
    'icon' => 'el el-camera',
    'fields' => array(
        array(
            'id' => 'enable_feature_slider',
            'type' => 'switch',
            'title' => esc_html__('Show Feature Slider', 'wp-libra'),
            'subtitle' => esc_html__('Show / Hide feature slider.', 'wp-libra'),
            'default' => false
        ),
        array(
            'subtitle' => esc_html__('Set speed slider.', 'wp-libra'),
            'id' => 'speed_slider',
            'type' => 'text',
            'title' => 'Speed',
            'default' => '1100',
            'required' => array(
                0 => 'enable_feature_slider',
                1 => '=',
                2 => 1
            )
        ),
        array(
            'id' => 'loop_slider',
            'type' => 'switch',
            'title' => esc_html__('Loop', 'wp-libra'),
            'subtitle' => esc_html__('Set loop slider.', 'wp-libra'),
            'default' => false,
            'required' => array(
                0 => 'enable_feature_slider',
                1 => '=',
                2 => 1
            )
        ),
        array(
            'id' => 'auto_play_slider',
            'type' => 'switch',
            'title' => esc_html__('Auto Play', 'wp-libra'),
            'subtitle' => esc_html__('Set auto play slider.', 'wp-libra'),
            'default' => true,
            'required' => array(
                0 => 'enable_feature_slider',
                1 => '=',
                2 => 1
            )
        ),
    )
);

/**
 * Blog Option
 *
 * css color.
 * 
 * @author CMS
 */
$this->sections[] = array(
    'title' => esc_html__('Blog Option', 'wp-libra'),
    'icon' => 'el el-blogger',
    'fields' => array(
        array(
            'id' => 'post_full_width',
            'type' => 'switch',
            'title' => esc_html__('Post Full Width', 'wp-libra'),
            'subtitle' => esc_html__('Show single post full width no sidebar.', 'wp-libra'),
            'default' => false
        ),
        array(
            'id' => 'post_sidebar_left',
            'type' => 'switch',
            'title' => esc_html__('Enable Post Sidebar Left', 'wp-libra'),
            'subtitle' => esc_html__('Default post blog sidebar Right.', 'wp-libra'),
            'default' => false
        ),
    )
);

/* Admin Social */
$this->sections[] = array(
    'title' => esc_html__('Admin Social Link', 'wp-libra'),
    'icon' => 'el el-group-alt',
    'subsection' => true,
    'fields' => array(
        array(
            'subtitle' => '',
            'id' => 'admin_fb',
            'type' => 'text',
            'title' => 'Facebook',
            'default' => 'http://facebook.com/'
        ),
        array(
            'subtitle' => '',
            'id' => 'admin_tw',
            'type' => 'text',
            'title' => 'Twitter',
            'default' => 'https://twitter.com/'
        ),
        array(
            'subtitle' => '',
            'id' => 'admin_ins',
            'type' => 'text',
            'title' => 'Instagram',
            'default' => 'https://instagram.com/'
        ),
        array(
            'subtitle' => '',
            'id' => 'admin_gl',
            'type' => 'text',
            'title' => 'Google Plus',
            'default' => 'https://plus.google.com/'
        ),
        array(
            'subtitle' => '',
            'id' => 'admin_pin',
            'type' => 'text',
            'title' => 'Pinterest',
            'default' => 'https://www.pinterest.com/'
        ),
    )
);

/**
 * Custom CSS
 *
 * extra css for customer.
 * 
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Custom CSS', 'wp-libra'),
    'icon' => 'el-icon-bulb',
    'fields' => array(
        array(
            'id' => 'custom_css',
            'type' => 'ace_editor',
            'title' => esc_html__('CSS Code', 'wp-libra'),
            'subtitle' => esc_html__('create your css code here.', 'wp-libra'),
            'mode' => 'css',
            'theme' => 'monokai'
        )
    )
);

/**
 * Optimal Core
 *
 * Optimal options for theme. optimal speed
 * 
 * @author Fox
 */
$this->sections[] = array(
    'title' => esc_html__('Optimal Core', 'wp-libra'),
    'icon' => 'el-icon-idea',
    'fields' => array(
        array(
            'subtitle' => esc_html__('no minimize , generate css over time...', 'wp-libra'),
            'id' => 'dev_mode',
            'type' => 'switch',
            'title' => esc_html__('Dev Mode (not recommended)', 'wp-libra'),
            'default' => true
        )
    )
);
