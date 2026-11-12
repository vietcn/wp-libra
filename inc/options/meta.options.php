<?php
/**
 * Meta options
 * 
 * @author Fox
 * @since 1.0.0
 */
class CMSMetaOptions
{
    public function __construct()
    {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('admin_enqueue_scripts', array($this, 'admin_script_loader'));
    }
    /* add script */
    function admin_script_loader()
    {
        global $pagenow;
        if (is_admin() && ($pagenow == 'post-new.php' || $pagenow == 'post.php')) {
            wp_enqueue_style('metabox', get_template_directory_uri() . '/inc/options/css/metabox.css');
            
            wp_enqueue_script('easytabs', get_template_directory_uri() . '/inc/options/js/jquery.easytabs.min.js');
            wp_enqueue_script('metabox', get_template_directory_uri() . '/inc/options/js/metabox.js');
        }
    }
    /* add meta boxs */
    public function add_meta_boxes()
    {
        $this->add_meta_box('template_page_options', esc_html__('Setting', 'wp-libra'), 'page');
        $this->add_meta_box('post_options', esc_html__('Post Setting', 'wp-libra'), 'post');
    }
    
    public function add_meta_box($id, $label, $post_type, $context = 'advanced', $priority = 'default')
    {
        add_meta_box('_cms_' . $id, $label, array($this, $id), $post_type, $context, $priority);
    }
    /* --------------------- PAGE ---------------------- */
    function template_page_options() {
        ?>
        <div class="tab-container clearfix">
            <ul class='etabs clearfix'>
               <li class="tab"><a href="#tabs-general"><?php esc_html_e('general', 'wp-libra'); ?></a></li>
               <li class="tab"><a href="#tabs-page-title"><?php esc_html_e('Page Title', 'wp-libra'); ?></a></li>
               <li class="tab tabs-slider"><a href="#tabs-slider"><?php esc_html_e('Slider', 'wp-libra'); ?></a></li>
               <li class="tab tabs-sidebar"><a href="#tabs-sidebar"><?php esc_html_e('Sidebar', 'wp-libra'); ?></a></li>
            </ul>
            <div class='panel-container'>
                <div id="tabs-general">
                <?php
                    cms_options(array(
                        'id' => 'boxed_bg_image',
                        'label' => esc_html__('Background Image','wp-libra'),
                        'type' => 'image',
                        'default' => ''
                    ));
                ?>
                </div>
                <div id="tabs-slider">
                <?php
                    $slider_cat_options = array(''=>'All');
                    $slider_categories = get_terms('category');
                    
                    if(!isset($slider_categories->errors)){
                    
                        foreach($slider_categories as $category){
                            $slider_cat_options[$category->slug] = $category->name;
                        }
                    
                        cms_options(array(
                            'id' => 'slider_categories',
                            'label' => esc_html__('Select Categories','wp-libra'),
                            'type' => 'multiple',
                            'options' => $slider_cat_options,
                            'desc' => 'Apply only Page Template Blog',
                        ));
                    }
                    cms_options(array(
                        'id' => 'enable_feature_slider',
                        'label' => esc_html__('Slider & Feature Box - Blog','wp-libra'),
                        'type' => 'switch',
                        'desc' => 'Apply only Page Template Blog',
                        'options' => array('on'=>'1','off'=>''),
                    ));
                ?>
                </div>
                <div id="tabs-page-title">
                <?php
                /* page title. */
                cms_options(array(
                    'id' => 'page_title',
                    'label' => esc_html__('Custom Page Title','wp-libra'),
                    'type' => 'switch',
                    'desc' => 'Custom page title only page',
                    'options' => array('on'=>'1','off'=>''),
                    'follow' => array('1'=>array('#page_title_enable'))
                ));
                ?>  <div id="page_title_enable"><?php
                    cms_options(array(
                        'id' => 'page_title_type',
                        'label' => esc_html__('Layout','wp-libra'),
                        'type' => 'imegesselect',
                        'options' => array(
                            '' => get_template_directory_uri().'/inc/options/images/pagetitle/p0.png',
                            '1' => get_template_directory_uri().'/inc/options/images/pagetitle/p1.png',
                        )
                    ));
                    cms_options(array(
                        'id' => 'bg_image_page_title',
                        'label' => esc_html__('Background Image','wp-libra'),
                        'type' => 'image',
                        'default' => ''
                    ));
                    cms_options(array(
                        'id' => 'page_title_text',
                        'label' => esc_html__('Title','wp-libra'),
                        'desc' => 'Change text page title',
                        'type' => 'text',
                    ));
                    ?>
                    </div>
                </div>
                <div id="tabs-sidebar">
                <?php
                    cms_options(array(
                        'id' => 'show_sidebar',
                        'label' => esc_html__('Show Sidebar','wp-libra'),
                        'type' => 'switch',
                        'desc' => 'Page default full width',
                        'options' => array('on'=>'1','off'=>''),
                        'follow' => array('1'=>array('#show_sidebar_page_left'))
                    ));
                    ?>
                        <div id="show_sidebar_page_left">
                            <?php
                                cms_options(array(
                                    'id' => 'show_sidebar_page_left',
                                    'label' => esc_html__('Show Sidebar Left - Default Sidebar Right','wp-libra'),
                                    'type' => 'switch',
                                    'options' => array('on'=>'1','off'=>''),
                                ));   
                                cms_options(array(
                                    'id' => 'color_widget',
                                    'label' => esc_html__('Select Color Widget','wp-libra'),
                                    'type' => 'color',
                                    'options' => array('on'=>'1','off'=>''),
                                    'rgba' =>true
                                ));
                                cms_options(array(
                                    'id' => 'color_link_text',
                                    'label' => esc_html__('Select Color Text','wp-libra'),
                                    'type' => 'color',
                                    'options' => array('on'=>'1','off'=>''),
                                    'rgba' =>true
                                ));
                                cms_options(array(
                                    'id' => 'color_line_buttom',
                                    'label' => esc_html__('Select Color Line Bottom','wp-libra'),
                                    'type' => 'color',
                                    'options' => array('on'=>'1','off'=>''),
                                    'rgba' =>true
                                ));
                                cms_options(array(
                                    'id' => 'bg_color_input',
                                    'label' => esc_html__('Select Background Color Input','wp-libra'),
                                    'type' => 'color',
                                    'options' => array('on'=>'1','off'=>''),
                                    'rgba' =>true
                                ));
                            ?>  
                        </div>
                </div>
            </div>
        </div>
        <?php
    }
    /* --------------------- POST FULL WIDTH ---------------------- */
    function post_options(){
        ?>
        <div class="post-full">
            <?php
                cms_options(array(
                    'id' => 'post_full_width',
                    'label' => esc_html__('Post Full Width','wp-libra'),
                    'type' => 'switch',
                    'options' => array('on'=>'1','off'=>'0'),
                ));
                cms_options(array(
                    'id' => 'post_sidebar_left',
                    'label' => esc_html__('Enable Post Sidebar Left','wp-libra'),
                    'type' => 'switch',
                    'options' => array('on'=>'1','off'=>'0'),
                ));
            ?>
        </div>
        <?php
    }
    /* --------------------- Look Block ---------------------- */
}

new CMSMetaOptions();