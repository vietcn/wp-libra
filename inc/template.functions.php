<?php
/**
 * Page title template
 * @since 1.0.0
 * @author Fox
 */
function wp_libra_page_title(){
    global $smof_data, $wp_libra_meta, $wp_libra_base;
    
    if(is_page() && isset($wp_libra_meta->_cms_page_title) && $wp_libra_meta->_cms_page_title){
        if(isset($wp_libra_meta->_cms_page_title_type)){
            $smof_data['page_title_layout'] = $wp_libra_meta->_cms_page_title_type;
        }
    }

    if (is_page() && isset($wp_libra_meta->_cms_bg_image_page_title) && $wp_libra_meta->_cms_bg_image_page_title) {
        $smof_data['bg_image_page_title']['url'] = wp_get_attachment_url($wp_libra_meta->_cms_bg_image_page_title);
    }

    if($smof_data['page_title_layout']){
        ?>
        <div class="page-wrap">
            <div class="container">
                <div class="row">
                    <div id="page-title" class="page-title br-style col-xs-12 col-sm-12 col-md-12 col-lg-12 <?php if(empty($smof_data['bg_image_page_title']['url'])) { echo ' no-bg'; } ?>" style="background-image: url(<?php echo esc_url($smof_data['bg_image_page_title']['url']); ?>); background-size: cover; background-position: center; "></div>
                    <div class="row">
                    <?php switch ($smof_data['page_title_layout']){
                        case '1':
                            ?>
                                <div id="breadcrumb-text" class="line-white col-xs-12 col-sm-12 col-md-12 col-lg-12 text-center">
                                    <?php $wp_libra_base->getBreadCrumb(); ?>
                                </div>
                            <?php
                            break;
                    } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
/**
 * Get Header Layout.
 * 
 * @author Fox
 */
function wp_libra_header(){
    /* load template. */
    get_template_part('inc/header/header', 'header');
}

/**
 * Get menu location ID.
 * 
 * @param string $option
 * @return NULL
 */
function wp_libra_menu_location($option = '_cms_primary'){
    global $wp_libra_meta;
    /* get menu id from page setting */
    return (isset($wp_libra_meta->$option) && $wp_libra_meta->$option) ? $wp_libra_meta->$option : null ;
}

/**
 * Add main class
 * 
 * @author Fox
 * @since 1.0.0
 */
function wp_libra_main_class(){
    global $wp_libra_meta;
    
    $main_class = '';
    /* chect content full width */
    if(is_page() && isset($wp_libra_meta->_cms_full_width) && $wp_libra_meta->_cms_full_width){
        /* full width */
        $main_class = "no-container";
    } else {
        /* boxed */
        $main_class = "container";
    }
    
    echo apply_filters('wp_libra_main_class', $main_class);
}

/**
 * Archive detail
 * 
 * @author Fox
 * @since 1.0.0
 */
function wp_libra_archive_detail(){
    ?>
    <ul class="meta">
        <li class="detail-date"> <a href="#"><?php echo get_the_date();?></a></li>
        <?php if(has_category()): ?>
        <li class="detail-terms"><?php the_terms( get_the_ID(), 'category' ); ?></li>
        <?php endif; ?>
        <li><?php if(is_sticky()){ ?>
            <span class="sticky-post"><?php echo esc_html_e('Featured', 'wp-libra'); ?> </span>
        <?php } ?></li>
    </ul>
    <?php
}

function wp_libra_archive_meta() {
    ?>
    <ul class="meta">
        <li class="detail-date"> <a href="#"><?php echo get_the_date();?></a></li>
        <?php if(has_category()): ?>
        <li class="detail-terms"><?php the_terms( get_the_ID(), 'category' ); ?></li>
        <?php endif; ?>
        <li class="entry-author"><?php the_author_posts_link(); ?></li>
        <li><a class="ico-comment" href="<?php the_permalink(); ?>">Comments <?php echo comments_number('<span>0</span>','<span>1</span>','<span>%</span>'); ?></a></li>
        <li><?php if(is_sticky()){ ?>
            <span class="sticky-post"><?php echo esc_html_e('Featured', 'wp-libra'); ?> </span>
        <?php } ?></li>
    </ul>
    <?php
}
function wp_libra_detail_terms(){
    ?>
        <?php if(has_category()): ?>
        <span class="detail-terms"><?php the_terms( get_the_ID(), 'category','', ' | ' ); ?></span>
        <?php endif; ?>
    <?php
}

function wp_libra_detail_date(){
    ?>
        <a href="#" class="detail-date"> <?php echo get_the_date();?></a>
    <?php
}

/**
 * Archive readmore
 * 
 * @author Fox
 * @since 1.0.0
 */
function wp_libra_archive_readmore(){
    echo '<a href="'.esc_url(get_the_permalink()).'" title="'.get_the_title().'" >'.esc_html__('READ MORE', 'wp-libra').'</a>';
}

/**
 * Media Audio.
 * 
 * @param string $before
 * @param string $after
 */
function wp_libra_archive_audio() {
   global $wp_embed, $wp_libra_base;
    /* get shortcode audio. */
    $shortcode = $wp_libra_base->getShortcodeFromContent('audio', get_the_content());
    /* Get remote audio */
    $remote_audio = $wp_libra_base->getShortcodeFromContent('embed', get_the_content());

     /* Get soundcloud audio */
    $remote_soundcloud = $wp_libra_base->getShortcodeFromContent('soundcloud', get_the_content());

    if($remote_soundcloud != ''){
        echo '<div class="entry-media entry-audio entry-remote-soundcloud">'.do_shortcode($remote_soundcloud).'</div>';
        return true;
    } elseif ($remote_audio) {
        /* view remote audio. */
        echo '<div class="entry-media entry-audito entry-remote-audio">'.$wp_embed->run_shortcode($remote_audio).'</div>';
        return true;    
    } elseif($shortcode != ''){
        echo '<div class="entry-media entry-audio">'.do_shortcode($shortcode).'</div>';
        return true;
    }  elseif(has_post_thumbnail()){
        echo '<div class="entry-media entry-feature-image">';
        the_post_thumbnail('blog-grid');
        echo '</div>';
    } else {
        the_excerpt();
    }  
}
/**
 * Single Media Audio.
 * 
 * @param string $before
 * @param string $after
 */
function wp_libra_single_audio() {
    global $wp_embed, $wp_libra_base;
    /* get shortcode audio. */
    $shortcode = $wp_libra_base->getShortcodeFromContent('audio', get_the_content());
    /* Get remote audio */
    $remote_audio = $wp_libra_base->getShortcodeFromContent('embed', get_the_content());

     /* Get soundcloud audio */
    $remote_soundcloud = $wp_libra_base->getShortcodeFromContent('soundcloud', get_the_content());

    if($remote_soundcloud != ''){
        echo '<div class="entry-media entry-audio entry-remote-soundcloud">'.do_shortcode($remote_soundcloud).'</div>';
        return true;
    } elseif ($remote_audio) {
        /* view remote audio. */
        echo '<div class="entry-media entry-audito entry-remote-audio">'.$wp_embed->run_shortcode($remote_audio).'</div>';
        return true;    
    } elseif($shortcode != ''){
        echo '<div class="entry-media entry-audio">'.do_shortcode($shortcode).'</div>';
        return true;
    }  elseif(has_post_thumbnail()){
        echo '<div class="entry-media entry-feature-image">';
        the_post_thumbnail();
        echo '</div>';
    } else {
        the_excerpt();
    }  
}

/**
 * Media Video.
 *
 * @param string $before
 * @param string $after
 */
function wp_libra_archive_video() {
    
    global $wp_embed, $wp_libra_base;
    /* Get Local Video */
    $local_video = $wp_libra_base->getShortcodeFromContent('video', get_the_content());
    
    /* Get Youtobe or Vimeo */
    $remote_video = $wp_libra_base->getShortcodeFromContent('embed', get_the_content());
    
    if($local_video){
        /* view local. */
        echo do_shortcode($local_video);
        
        return true;
        
    } elseif ($remote_video) {
        /* view youtobe or vimeo. */
        echo ''.$wp_embed->run_shortcode($remote_video);
        
        return true;
        
    } elseif (has_post_thumbnail()) {
        /* view thumbnail. */
        the_post_thumbnail();
    } else {
        return false;
    }
    
}

/**
 * Gallerry Images
 * 
 * @author Fox
 * @since 1.0.0
 */
function wp_libra_archive_gallery(){
    global $wp_libra_base, $smof_data;
    /* get shortcode gallery. */
    $shortcode = $wp_libra_base->getShortcodeFromContent('gallery', get_the_content());
    
    if($shortcode != ''){
        preg_match('/\[gallery.*ids=.(.*).\]/', $shortcode, $ids);
        
        if(!empty($ids)){
        
            $array_id = explode(",", $ids[1]);
            $auto_play = ! empty( $smof_data['auto_play_slider'] ) ? $smof_data['auto_play_slider'] : '1';
            $speed     = ! empty( $smof_data['speed_slider'] ) ? $smof_data['speed_slider'] : '2000';
            $loop      = ! empty( $smof_data['loop_slider'] ) ? $smof_data['loop_slider'] : '1';
            ?>
            <div id="cms-gallery-carousel-<?php the_ID(); ?>" class="cms-theme-carousel cms-post-gallery-carousel cs-slider-wrapper nav-center clearfix" data-auto-play="<?php echo esc_attr( $auto_play ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-item="1" data-loop="<?php echo esc_attr( $loop ); ?>">
                <?php foreach ( $array_id as $image_id ) : ?>
                    <?php
                    $attachment_image = wp_get_attachment_image_src( $image_id, 'full', false );
                    if ( is_array( $attachment_image ) && ! empty( $attachment_image[0] ) ) :
                        $alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                        ?>
                        <div class="item-inner">
                            <img src="<?php echo esc_url( $attachment_image[0] ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php
            
            return true;
        
        } else {
            return false;
        }
    } else {
        if(has_post_thumbnail()){
            the_post_thumbnail();
        }
    }
}


/**
 * Gallerry Images
 * 
 * @author Fox
 * @since 1.0.0
 */
function wp_libra_archive_images(){
    global $wp_libra_base;
    /* get shortcode images. */
    $shortcode = $wp_libra_base->getShortcodeFromContent('gallery', get_the_content());
    
    if($shortcode != ''){
        preg_match('/\[gallery.*ids=.(.*).\]/', $shortcode, $ids);
        
        if(!empty($ids)){
        
            $array_id = explode(",", $ids[1]);
            ?>
            <div class="carousel-dot cms-post-image-carousel" data-item="1" data-loop="true" data-speed="2000">
                <?php $i = 0; ?>
                <?php foreach ($array_id as $image_id): ?>
                    <?php
                    $attachment_image = wp_get_attachment_image_src($image_id, 'full', false);
                    if($attachment_image[0] != ''):?>
                        <div class="item <?php if( $i == 0 ){ echo 'active'; } ?>">
                            <a href="<?php echo esc_url(get_the_permalink()); ?>"><img style="width:100%;" data-src="holder.js" src="<?php echo esc_url($attachment_image[0]);?>" alt="" /></a>
                            <div class="entry-terms"><?php wp_libra_detail_terms(); ?></div>
                        </div>
                    <?php $i++; endif; ?>
                <?php endforeach; ?>
            </div>
            <?php
        }
    } 
    else {
        if(has_post_thumbnail()){
            the_post_thumbnail();
        }
    }
}

function wp_libra_images(){
    global $wp_libra_base, $smof_data;
    /* get shortcode images. */
    $shortcode = $wp_libra_base->getShortcodeFromContent('gallery', get_the_content());
    
    if($shortcode != ''){
        preg_match('/\[gallery.*ids=.(.*).\]/', $shortcode, $ids);
        
        if(!empty($ids)){
        
            $array_id = explode(",", $ids[1]);
            $auto_play = ! empty( $smof_data['auto_play_slider'] ) ? $smof_data['auto_play_slider'] : '1';
            $speed     = ! empty( $smof_data['speed_slider'] ) ? $smof_data['speed_slider'] : '2000';
            $loop      = ! empty( $smof_data['loop_slider'] ) ? $smof_data['loop_slider'] : '1';
            ?>
            <div class="cms-theme-carousel cms-post-gallery-carousel cs-slider-wrapper nav-center clearfix" data-auto-play="<?php echo esc_attr( $auto_play ); ?>" data-speed="<?php echo esc_attr( $speed ); ?>" data-item="1" data-loop="<?php echo esc_attr( $loop ); ?>">
                <?php foreach ( $array_id as $image_id ) : ?>
                    <?php
                    $attachment_image = wp_get_attachment_image_src( $image_id, 'full', false );
                    if ( is_array( $attachment_image ) && ! empty( $attachment_image[0] ) ) :
                        $alt = get_post_meta( $image_id, '_wp_attachment_image_alt', true );
                        ?>
                        <div class="item-inner">
                            <img src="<?php echo esc_url( $attachment_image[0] ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <?php
        }
    } 
    else {
        if(has_post_thumbnail()){
            the_post_thumbnail();
        }
    }
}

/**
 * Quote Text.
 * 
 * @author Fox
 * @since 1.0.0
 */
function wp_libra_archive_quote() {
    /* get text. */
    preg_match('/\<blockquote\>(.*)\<\/blockquote\>/', get_the_content(), $blockquote);
    
    if(!empty($blockquote[0])){
        echo ''.$blockquote[0].'';
        return true;
    } else {
        if(has_post_thumbnail()){
            the_post_thumbnail();
        }
        return false;
    }
}

/**
 * Get icon from post format.
 * 
 * @return multitype:string Ambigous <string, mixed>
 * @author Fox
 * @since 1.0.0
 */
function wp_libra_archive_post_icon() {
    $post_icon = array('icon'=>'fa fa-file-text-o','text'=>__('STANDARD', 'wp-libra'));
    switch (get_post_format()) {
        case 'gallery':
            $post_icon['icon'] = 'fa fa-camera-retro';
            $post_icon['text'] = esc_html__('GALLERY', 'wp-libra');
            break;
        case 'link':
            $post_icon['icon'] = 'fa fa-external-link';
            $post_icon['text'] = esc_html__('LINK', 'wp-libra');
            break;
        case 'quote':
            $post_icon['icon'] = 'fa fa-quote-left';
            $post_icon['text'] = esc_html__('QUOTE', 'wp-libra');
            break;
        case 'video':
            $post_icon['icon'] = 'fa  fa-youtube-play';
            $post_icon['text'] = esc_html__('VIDEO', 'wp-libra');
            break;
        case 'audio':
            $post_icon['icon'] = 'fa fa-volume-up';
            $post_icon['text'] = esc_html__('AUDIO', 'wp-libra');
            break;
        default:
            $post_icon['icon'] = 'fa fa-image';
            $post_icon['text'] = esc_html__('STANDARD', 'wp-libra');
            break;
    }
    echo '<i class="'.$post_icon['icon'].'"></i>';
}

/* Slider New */
function wp_libra_slider_news(){
    global $smof_data, $wp_libra_meta;

    /* query. */
    $query = array(
        'posts_per_page'=> 4,
        'post_type' => 'post',
        'post_status' => 'publish'
    );

    if(!empty($wp_libra_meta->_cms_slider_categories)){
         $query['tax_query'] = array(array('taxonomy'=>'category', 'field'=>'slug', 'terms'=>explode(',', $wp_libra_meta->_cms_slider_categories)));
    }


    $cube_posts = new WP_Query( $query );

    if(!$cube_posts->have_posts()) return ;

    ?>
    <div class="cms-theme-carousel cs-slider-wrapper nav-center clearfix" data-auto-play="<?php echo esc_attr($smof_data['auto_play_slider']) ; ?>"  data-speed="<?php echo esc_attr($smof_data['speed_slider']) ; ?>" data-item="1" data-loop="<?php echo esc_attr($smof_data['loop_slider']) ; ?>">
        <?php
        while ($cube_posts->have_posts()) {
            
            $cube_posts->the_post();
            
            echo '<div class="item-inner">';
                wp_libra_slider_news_post();
            echo '</div>';
        }
        ?>
    </div>
    <?php
    
    wp_reset_postdata();
}

/* Slider Magazine */
function wp_libra_slider_magazine(){
    global $smof_data, $wp_libra_meta;

    /* query. */
    $query = array(
        'posts_per_page'=> 6,
        'post_type' => 'post',
        'post_status' => 'publish'
    );

    if(!empty($wp_libra_meta->_cms_slider_categories)){
         $query['tax_query'] = array(array('taxonomy'=>'category', 'field'=>'slug', 'terms'=>explode(',', $wp_libra_meta->_cms_slider_categories)));
    }


    $cube_posts = new WP_Query( $query );

    if(!$cube_posts->have_posts()) return ;

    ?>
    <div class="cs-slider-magazine-wrapper clearfix">
        <?php
        while ($cube_posts->have_posts()) {
            
            $cube_posts->the_post();
            
            echo '<div class="item-inner">';
                wp_libra_wp_libra_slider_magazine_post();
            echo '</div>';
        }
        ?>
    </div>
    <?php
    
    wp_reset_postdata();
}

/* Function Child wp_libra_slider_news */
function wp_libra_slider_news_post($limit = 25){
    global $post;
    ?>
    <article>
        <?php if(has_post_thumbnail($post->ID)): ?>
            <?php 
                $thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'wp_libra_lg-images') ); 
            ?>
        <?php else : ?>
            <?php 
                $thumbnail = '' .get_template_directory_uri(). '/assets/images/no-image.jpg';
            ?>
        <?php endif; ?>
        <div class="post-thumbnail" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
        </div>
        <span class="overlay-slider"></span>
        <div class="content" style="opacity: 0;">
            <div class="meta">
                <?php wp_libra_archive_detail(); ?>
            </div>
            <h1 class="title"><?php echo esc_attr($post->post_title); ?></h1>
            <span class="subtitle"><?php echo esc_attr(get_post_meta($post->ID , 'post_subtitle', true)); ?></span>
            <a class="readmore" href="<?php echo esc_url(get_the_permalink($post->ID)); ?>"><?php esc_html_e('Read this article', 'wp-libra'); ?></a>
        </div>
    </article>
    <?php
}

/* Function Child wp_libra_slider_magazine */
function wp_libra_wp_libra_slider_magazine_post($limit = 25){
    global $post;
    ?>
    <article>
        <div class="cs-magazine-item">
            <?php if(has_post_thumbnail($post->ID)): ?>
                <?php 
                    $thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID, 'wp_libra_lg-images') ); 
                ?>
            <?php else : ?>
                <?php 
                    $thumbnail = '' .get_template_directory_uri(). '/assets/images/no-image.jpg';
                ?>
            <?php endif; ?>
            <div class="post-thumbnail" style="background-image: url(<?php echo esc_url($thumbnail); ?>);">
            </div>
            <div class="first-content">
                <div class="meta">
                    <?php wp_libra_archive_detail(); ?>
                </div>
                <h3 class="title"><?php echo esc_attr($post->post_title); ?></h3>
            </div>
            <div class="last-content">
                <div class="meta">
                    <?php wp_libra_archive_detail(); ?>
                </div>
                <h3 class="title"><?php echo esc_attr($post->post_title); ?></h3>
                <a class="readmore" href="<?php echo esc_url(get_the_permalink($post->ID)); ?>"><?php esc_html_e('Read More', 'wp-libra'); ?></a>
            </div>
        </div>
    </article>
    <?php
}

/* Related Post */
function wp_libra_related_post() {
    global $post;

    $posttags = get_the_category($post->ID);
    
    if(empty($posttags)) return ;
    
    $tags = array();
    
    foreach ($posttags as $tag) {
        
        $tags[] = $tag->term_id;
    }
    
    $query = new WP_Query(array('posts_per_page'=> 3, 'post_type' => 'post', 'post_status'=> 'publish', 'category__in'=>$tags));
    
    if($query->have_posts()){
        ?> 
        <div class="cms-related-post">
            <h3 class="title-after"><?php esc_html_e('Related posts','wp-libra'); ?></h3>
            <div class="cms-related-post-content row clearfix"> 
                <?php
                while ($query->have_posts()): $query->the_post();
                ?>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <article>
                        <?php
                            $class = '';
                            $thumbnail = '';
                            if(has_post_thumbnail($post->ID)){
                                $thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID),'full' ); 
                            }
                            else{
                                $class = "no-image ";
                            }
                        ?>
                        <div class="item-inner <?php echo esc_attr($class); ?>">
                            <a class="item-image" href="<?php echo esc_url(get_the_permalink()); ?>" style="background-image: url(<?php echo esc_url($thumbnail); ?>); background-size: cover; background-position: center; "></a>
                            <p class="description"><a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo wp_libra_limit_words( strip_tags( get_the_excerpt() ), 7); ?></a></p>     
                        </div>
                    </article>
                </div>
        <?php
        endwhile;
        ?> </div> 
        </div> <?php
    }
    
    wp_reset_postdata();
}

/* Feature Box */
function wp_libra_feature_box() {
    ?>
        <div id="feature-wrapper" class="clearfix">
            <div class="container">
                <div class="row">
                    <?php if ( is_active_sidebar( 'wg-feature-1' ) ) { ?>
                        <div class="feature-box-item ">
                            <?php dynamic_sidebar('wg-feature-1'); ?>
                        </div>
                    <?php } ?>

                    <?php if ( is_active_sidebar( 'wg-feature-2' ) ) { ?>
                        <div class="feature-box-item ">
                            <?php dynamic_sidebar('wg-feature-2'); ?>
                        </div>
                     <?php } ?>

                    <?php if ( is_active_sidebar( 'wg-feature-3' ) ) { ?>
                        <div class="feature-box-item ">
                            <?php dynamic_sidebar('wg-feature-3'); ?>
                        </div>
                     <?php } ?>
                 </div>
             </div>
        </div>
    <?php
}

/* Lastest Post. */
function wp_libra_lastest_posts() {
    
    $query = new WP_Query(array('posts_per_page'=> 3, 'post_type' => 'post', 'post_status'=> 'publish'));
    
    if($query->have_posts()){
        ?> <div class="cms-lastest-post clearfix"><?php
            while ($query->have_posts()): $query->the_post();
            ?>
            <div class="item-inner">
                <div class="entry-blog">
                    <div class="entry-header clearfix">
                        <div class="entry-feature entry-feature-image">
                            <?php the_post_thumbnail('wp_libra_images-small'); ?>
                        </div>
                        <div class="entry-meta">
                            <?php wp_libra_archive_detail(); ?>
                        </div>
                        <h3 class="entry-title">
                            <a href="<?php the_permalink(); ?>">
                                <?php
                                    if(is_sticky()){
                                        echo "<i class='hide fa fa-thumb-tack'></i>";
                                    }
                                ?>
                                <?php the_title(); ?>
                            </a>
                            <span class="subtitle"><?php echo esc_attr(get_post_meta(get_the_ID(), 'post_subtitle', true)); ?></span>
                        </h3>
                    </div>
                    <div class="entry-content">
                        <div class="entry-content-inner"><?php echo substr(strip_tags(strip_shortcodes(get_the_content())), 0, 140); ?></div>
                    </div>
                    <div class="entry-readmore">
                        <?php the_author_posts_link(); ?>
                        <a class="readmore" href="<?php the_permalink(); ?>"><?php esc_html_e('Read More', 'wp-libra'); ?></a>
                    </div>
                </div>
            </div>
            <?php
            endwhile;
            ?> </div> <?php
        }
        
        wp_reset_postdata();
}

/* Body Class */

add_filter('body_class', 'wp_libra_body_class');   
function wp_libra_body_class($class) {

    $class[] = ' page-boxed';
    return $class;

}