<?php
add_action('widgets_init', 'cms_register_widget_fan_page');

/**
 * register widget.
 */
function cms_register_widget_fan_page()
{
    register_widget('CMS_Widget_Fan_Page');
}

class CMS_Widget_Fan_Page extends WP_Widget
{

    function CMS_Widget_Fan_Page()
    {
        parent::__construct('cms_widget_fan_page', esc_html__('CS Facebook', 'wp-libra'), array(
            'description' => esc_html__('Facebook Fan Page.', 'wp-libra')
        ));
    }

    function widget($args, $instance)
    {
        
        echo ''.$args['before_widget'];
        
        /* widget title. */
        if($instance['title']){
            
            echo ''.$args['before_title'] . apply_filters( 'widget_title', $instance['title'] ). $args['after_title'];
        }
        
        /* check app id. */
        if (! empty($instance['app_id'])) {
            
            $app_id = $instance['app_id'];
        } else {
            
            echo '<div class="cms-fan-page">' . esc_html__('App ID Not Found !', 'wp-libra') . '</div>';
            return ;
        }
        
        /* add script. */
        wp_register_script('fan-page', get_template_directory_uri() . '/inc/widgets/fanpage.js');
        wp_localize_script('fan-page', 'fanpage', array(
            'appid' => $app_id,
        	'language' => !empty($instance['language_id']) ? $instance['language_id'] : 'en_GB'
        ));
        wp_enqueue_script('fan-page');
        
        $page_id = ! empty($instance['page_id']) ? $instance['page_id'] : 'facebook';
        
        /* html. */
        echo '<div class="cms-fan-page"><div class="fb-page" data-href="https://www.facebook.com/' . $page_id . '" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"></div></div>';
    
        echo ''.$args['after_widget'];
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['app_id'] = strip_tags($new_instance['app_id']);
        $instance['page_id'] = strip_tags($new_instance['page_id']);
        $instance['language_id'] = strip_tags($new_instance['language_id']);
        
        return $instance;
    }

    function form($instance)
    {
        ?>
        <p>
        	<label for=""><?php esc_html_e('TITLE', 'wp-libra'); ?></label> <input
        		id="<?php echo esc_attr($this->get_field_id('title')); ?>"
        		name="<?php echo esc_attr( $this->get_field_name('title') ); ?>"
        		class="widefat" type="text"
        		value="<?php echo isset($instance['title']) ? $instance['title'] : ''; ?>"
        		placeholder="Facebook">
        </p>
        <p>
        	<label for=""><?php esc_html_e('APP ID', 'wp-libra'); ?></label> <input
        		id="<?php echo esc_attr($this->get_field_id('app_id')); ?>"
        		name="<?php echo esc_attr( $this->get_field_name('app_id') ); ?>"
        		class="widefat" type="text"
        		value="<?php echo isset($instance['app_id']) ? $instance['app_id'] : ''; ?>"
        		placeholder="168238290437780">
        </p>
        <p>
        	<label for=""><?php esc_html_e('PAGE ID', 'wp-libra'); ?></label> <input
        		id="<?php echo esc_attr($this->get_field_id('page_id')); ?>"
        		name="<?php echo esc_attr( $this->get_field_name('page_id') ); ?>"
        		class="widefat" type="text"
        		value="<?php echo isset($instance['page_id']) ? $instance['page_id'] : ''; ?>"
        		placeholder="facebook">
        </p>
        <p>
        	<label for=""><?php esc_html_e('Language ID (nl_NL, fr_FR, de_DE, ...)', 'wp-libra'); ?></label> <input
        		id="<?php echo esc_attr($this->get_field_id('language_id')); ?>"
        		name="<?php echo esc_attr( $this->get_field_name('language_id') ); ?>"
        		class="widefat" type="text"
        		value="<?php echo isset($instance['language_id']) ? $instance['language_id'] : ''; ?>"
        		placeholder="en_GB">
        </p>
        <?php
    }
}