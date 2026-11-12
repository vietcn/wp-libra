<?php
add_action('widgets_init', 'cs_featured_post_widgets');

function cs_featured_post_widgets() {
    register_widget('CS_Featured_Post_Widget');
}

class CS_Featured_Post_Widget extends WP_Widget {

    function CS_Featured_Post_Widget() {
        parent::__construct(
                'cs_featured_post', esc_html__('CS Feature Posts','wp-libra'), array('description' => esc_html__('Feature Posts Widget.', 'wp-libra'),)
        );
    }

    function widget($args, $instance) {
        extract($args);
        $show_date = (int) $instance['show_date'];
        $show_decs = (int) $instance['show_decs'];
        $number = (int) $instance['number'];
        $cat_name = $instance['cat_name'];

        //echo balanceTags($before_widget);
        echo '<aside id="cms-featured-post-'.get_the_ID().'">';
            if($title) {
                echo balanceTags($before_title.$title.$after_title);
            }

            $sticky = get_option('sticky_posts');
            $args = array(
                'posts_per_page' => $number,
                'post_type' => 'post',
                'post_status' => 'publish',
                'category_name'    => $cat_name,
                'post__not_in'  => $sticky,
                'orderby' => 'date',
                'order' => 'DESC',
                'paged' => 1
            );

            $wp_query = new WP_Query($args);
            $extra_class = !empty($instance['extra_class']) ? $instance['extra_class'] : "";

            // no 'class' attribute - add one with the value of width
            if( strpos($before_widget, 'class') === false ) {
                $before_widget = str_replace('>', 'class="'. $extra_class . '"', $before_widget);
            }
            // there is 'class' attribute - append width value to it
            else {
                $before_widget = str_replace('class="', 'class="'. $extra_class . ' ', $before_widget);
            }
            ?>
            <?php if ($wp_query->have_posts()){ ?>
                <div class="cms-featured-post">
                    <ul class="cms-featured-post-wrapper wg-menu-item">
                        <?php while ($wp_query->have_posts()): $wp_query->the_post(); ?>
                            <li>

                                <div class="cms-featured-media">  
                                   <div class="image">
                                       <a class="post-featured-img" href="<?php the_permalink(); ?>">
                                            <?php 
                                                if(has_post_thumbnail() && !post_password_required() && !is_attachment() &&  wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'full', false)):
                                                    $class = ' has-thumbnail';
                                                    $thumbnail = get_the_post_thumbnail(get_the_ID(),'full');
                                                else:
                                                    $class = ' no-image';
                                                    $thumbnail = '<img src="' .esc_url(get_template_directory_uri()). '/assets/images/no-image.jpg" alt="'.get_the_title().'" />';
                                                endif;
                                                echo ''. $thumbnail .'';
                                            ?>
                                       </a>
                                    </div>     
                                </div>
                                <div class="cms-featured-details <?php if(has_post_thumbnail() == '') {echo 'no-image';} ?>">
                                    <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3> 
                                </div>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            <?php } else { ?>
                <span class="notfound">No post found!</span>
            <?php
            }
        echo '</aside>';
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;

        $instance['title'] = $new_instance['title'];
        $instance['show_date'] = $new_instance['show_date'];
        $instance['show_decs'] = $new_instance['show_decs'];
        $instance['cat_name'] = $new_instance['cat_name'];
        $instance['number'] = (int) $new_instance['number'];
        $instance['extra_class'] = $new_instance['extra_class'];

        return $instance;
    }

    function form($instance) {
        $title = isset($instance['title']) ? esc_attr($instance['title']) : '';
        $cat_name = isset($instance['cat_name']) ? esc_attr($instance['cat_name']) : '';
        $show_date = isset($instance['show_date']) ? esc_attr($instance['show_date']) : '';
        $show_decs = isset($instance['show_decs']) ? esc_attr($instance['show_decs']) : '';
        if ( !isset($instance['number']) || !$number = (int) $instance['number'] )
                     $number = 5;
        ?>
        <p>
            <label for="<?php echo ''.$this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:', 'wp-libra' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <p>
            <label for="<?php echo ''.$this->get_field_id('show_date'); ?>"><?php esc_html_e( 'Show date:', 'wp-libra' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('show_date') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_date') ); ?>" <?php if($show_date!='') echo 'checked="checked";' ?> type="checkbox" value="1"  />
        </p>
        <p>
            <label for="<?php echo ''.$this->get_field_id('show_decs'); ?>"><?php esc_html_e( 'Show Description:', 'wp-libra' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id('show_decs') ); ?>" name="<?php echo esc_attr( $this->get_field_name('show_decs') ); ?>" <?php if($show_decs!='') echo 'checked="checked";' ?> type="checkbox" value="1" />
        </p>
        <p>
            <label for="<?php echo ''.$this->get_field_id('number'); ?>"><?php esc_html_e( 'Number of post to show:', 'wp-libra' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id('number') ); ?>" name="<?php echo esc_attr( $this->get_field_name('number') ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" />
        </p>
        <p>
            <label for="<?php echo ''.$this->get_field_id('cat_name'); ?>"><?php esc_html_e( 'Categories name:', 'wp-libra' ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id('cat_name') ); ?>" name="<?php echo esc_attr( $this->get_field_name('cat_name') ); ?>" type="text" value="<?php echo esc_attr( $cat_name ); ?>"/>
        </p>
        <p>
            <label for="<?php echo ''.$this->get_field_id('extra_class'); ?>">Extra Class:</label>
            <input class="widefat" id="<?php echo ''.$this->get_field_id('extra_class'); ?>" name="<?php echo esc_attr($this->get_field_name('extra_class')); ?>" value="<?php if(isset($instance['extra_class'])){echo esc_attr($instance['extra_class']);} ?>" />
        </p>
        <?php
    }
}
?>