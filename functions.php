<?php
/**
 * WP Libra theme functions and definitions.
 *
 * @package CMSSuperHeroes
 * @subpackage WP Libra
 * @since 1.0.0
 */

/**
 * Add global values.
 */
global $smof_data, $wp_libra_meta, $wp_libra_base;

/* Add base functions */
require( get_template_directory() . '/inc/base.class.php' );

if(class_exists("WPEnvogueBase")){
    $wp_libra_base = new WPEnvogueBase();
}

/* Add ReduxFramework. */
if(!class_exists('ReduxFramework')){
    require( get_template_directory() . '/inc/ReduxCore/framework.php' );
}

/* Add theme options. */
require( get_template_directory() . '/inc/options/functions.php' );

/* Add SCSS */
if(!class_exists('scssc')){
    require( get_template_directory() . '/inc/libs/scss.inc.php' );
}

/* Add Meta Core Options */
if(is_admin()){
    
    if(!class_exists('CsCoreControl')){
        /* add mete core */
        require( get_template_directory() . '/inc/metacore/core.options.php' );
        /* add meta options */
        require( get_template_directory() . '/inc/options/meta.options.php' );
    }
    
    /* tmp plugins. */
    require( get_template_directory() . '/inc/options/require.plugins.php' );
}

/* Add Template functions */
require( get_template_directory() . '/inc/template.functions.php' );

/* Static css. */
require( get_template_directory() . '/inc/dynamic/static.css.php' );

/* Dynamic css*/
require( get_template_directory() . '/inc/dynamic/dynamic.css.php' );


/* Add widgets */
require( get_template_directory() . '/inc/widgets/social.php' );
require( get_template_directory() . '/inc/widgets/recent_post_v2.php' );
require( get_template_directory() . '/inc/widgets/popular-posts-carousel.php' );
require( get_template_directory() . '/inc/widgets/fanpage.php' );
// Set up the content width value based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 625;
/*
 * Limit Words
 */
if (!function_exists('wp_libra_limit_words')) {
	function wp_libra_limit_words($string, $word_limit) {
		$string = (string) $string;
		if ( '' === $string ) {
			return '';
		}
		$words = explode( ' ', $string );
		return implode( ' ', array_splice( $words, 0, (int) $word_limit ) );
	}
}
/**
 * Theme setup.
 *
 * @since 1.0.0
 */
function wp_libra_setup() {
	load_theme_textdomain( 'wp-libra' , get_template_directory() . '/languages' );

	// Adds title tag
	add_theme_support( "title-tag" );
	
	// Add woocommerce
	add_theme_support('woocommerce');
	
	// Adds custom header
	add_theme_support( 'custom-header' );
	
	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme supports a variety of post formats.
	add_theme_support( 'post-formats', array( 'video', 'audio' , 'gallery', 'image') );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', esc_html__( 'Primary Menu', 'wp-libra' ) );

	/*
	 * This theme supports custom background color and image,
	 * and here we also set up the default background color.
	 */
	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'wp_libra_images-small', 500, 500, true );
	set_post_thumbnail_size( 624, 9999 ); // Unlimited height, soft crop

	// Modern WP theme supports (ThemeForest / Theme Check recommendations).
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	) );
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 400,
		'flex-height' => true,
		'flex-width'  => true,
	) );
	add_theme_support( 'align-wide' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_editor_style( 'assets/css/editor-style.css' );
}
add_action( 'after_setup_theme', 'wp_libra_setup' );

/**
 * Get meta data.
 * @author Fox
 * @return mixed|NULL
 */
function wp_libra_meta_data(){
    global $post, $wp_libra_meta;
    
    if(!isset($post->ID)) return ;
    
    $wp_libra_meta = json_decode(get_post_meta($post->ID, '_cms_meta_data', true));
    
    if(empty($wp_libra_meta)) return ;
    
    foreach ($wp_libra_meta as $key => $meta){
        $wp_libra_meta->$key = rawurldecode($meta);
    }
}
add_action('wp', 'wp_libra_meta_data');

/**
 * Admin enqueue script, which is add js and css to admin dashboard 
 * for import sample data
 */
add_action('admin_enqueue_scripts', 'wp_libra_admin_script');
function wp_libra_admin_script(){
	//script apply for sample data
	wp_register_script('cms-dummy-data', get_template_directory_uri(). '/assets/js/dummy.cms.js', array(),'1.0.0',true);
	wp_enqueue_style('cms-dummy-data-css', get_template_directory_uri(). '/assets/css/dummy.cms.css', '','1.0.0','all');
	wp_enqueue_script('cms-dummy-data');

}

/**
 * Enqueue scripts and styles for front-end.
 * @author Fox
 * @since CMS SuperHeroes 1.0
 */
function wp_libra_scripts_styles() {
    
	global $smof_data, $post;
	
	/** theme options. */
	$script_options = array(
	    'menu_sticky'=> $smof_data['menu_sticky'],
	    'back_to_top'=> $smof_data['footer_botton_back_to_top']
	);

	/*------------------------------------- JavaScript ---------------------------------------*/

	/* Owl Carousel - must load before theme main.js */
	wp_enqueue_script( 'olw-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), '2.0.0', true );

	/* Add main.js */
	wp_register_script( 'cmssuperheroes-main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery', 'olw-carousel' ), '1.0.8', true );
	wp_localize_script( 'cmssuperheroes-main', 'CMSOptions', $script_options );
	wp_enqueue_script( 'cmssuperheroes-main' );
	/* Add menu.js */
	wp_enqueue_script( 'cmssuperheroes-menu', get_template_directory_uri() . '/assets/js/menu.js', array( 'jquery' ), '1.0.0', true );
	/* Particles */
   	wp_enqueue_script('particles-min', get_template_directory_uri() . '/assets/js/particles.min.js', array( 'jquery' ), '1.0.0', true);
    wp_enqueue_script('particles-cms', get_template_directory_uri() . '/assets/js/particles.cms.js', array( 'jquery' ), '1.0.0', true);
    
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

    /*------------------------------------- Stylesheet ---------------------------------------*/
	
	/** --------------------------libs--------------------------------- */
	
	/* Loads Bootstrap stylesheet. */
	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '3.3.2');
	
	/* Loads Font Awesome. */
	wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.3.0');

	/* Olw Carousel */
	wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css', array(), '1.0.1');
	wp_enqueue_style('owl-theme', get_template_directory_uri() . '/assets/css/owl.theme.css', array(), '1.0.1');

	/** --------------------------custom------------------------------- */
	
	/* Loads our main stylesheet. */
	wp_enqueue_style( 'cmssuperheroes-style', get_stylesheet_uri(), array( 'bootstrap' ));

	/* Load static css*/
	wp_enqueue_style('cmssuperheroes-static', get_template_directory_uri() . '/assets/css/static.css', array( 'cmssuperheroes-style' ), '1.0.8');
}
add_action( 'wp_enqueue_scripts', 'wp_libra_scripts_styles' );

/**
 * Register sidebars.
 *
 * Registers our main widget area and the front page widget areas.
 *
 * @since Fox
 */
function wp_libra_widgets_init() {
	register_sidebar( array(
		'name' => esc_html__( 'Main Sidebar', 'wp-libra' ),
		'id' => 'main-sidebar',
		'description' => esc_html__( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'wp-libra' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="wg-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Featured Box 1', 'wp-libra' ),
		'id' => 'featured-box-1',
		'description' => esc_html__( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'wp-libra' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="wg-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Feature Box 1', 'wp-libra' ),
		'id' => 'wg-feature-1',
		'description' => esc_html__( 'Feature box column 1 on blog page templates.', 'wp-libra' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="wg-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Feature Box 2', 'wp-libra' ),
		'id' => 'wg-feature-2',
		'description' => esc_html__( 'Feature box column 2 on blog page templates.', 'wp-libra' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="wg-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Feature Box 3', 'wp-libra' ),
		'id' => 'wg-feature-3',
		'description' => esc_html__( 'Feature box column 3 on blog page templates.', 'wp-libra' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3 class="wg-title">',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
    	'name' => esc_html__( 'Footer Middle 1', 'wp-libra' ),
    	'id' => 'wg-footer-middle-1',
    	'description' => esc_html__( 'It will be used below the slider', 'wp-libra' ),
    	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    	'after_widget' => '</aside>',
    	'before_title' => '<h3 class="wg-title">',
    	'after_title' => '</h3>',
	) );
	register_sidebar( array(
    	'name' => esc_html__( 'Footer Middle 2', 'wp-libra' ),
    	'id' => 'wg-footer-middle-2',
    	'description' => esc_html__( 'It will be used below the slider', 'wp-libra' ),
    	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    	'after_widget' => '</aside>',
    	'before_title' => '<h3 class="wg-title">',
    	'after_title' => '</h3>',
	) );
	register_sidebar( array(
    	'name' => esc_html__( 'Footer Middle 3', 'wp-libra' ),
    	'id' => 'wg-footer-middle-3',
    	'description' => esc_html__( 'It will be used below the slider', 'wp-libra' ),
    	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    	'after_widget' => '</aside>',
    	'before_title' => '<h3 class="wg-title">',
    	'after_title' => '</h3>',
	) );
	register_sidebar( array(
    	'name' => esc_html__( 'Footer Top', 'wp-libra' ),
    	'id' => 'wg-footer-top',
    	'description' => esc_html__( 'Appears when using the optional Footer with a page set as Footer Top 1', 'wp-libra' ),
    	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    	'after_widget' => '</aside>',
    	'before_title' => '<h3 class="wg-title">',
    	'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
    	'name' => esc_html__( 'Footer Bottom Left', 'wp-libra' ),
    	'id' => 'wg-footer-bottom-left',
    	'description' => esc_html__( 'Appears when using the optional Footer with a page set as Footer Top 2', 'wp-libra' ),
    	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    	'after_widget' => '</aside>',
    	'before_title' => '<h3 class="wg-title">',
    	'after_title' => '</h3>',
	) );

	register_sidebar( array(
    	'name' => esc_html__( 'Footer Bottom Right', 'wp-libra' ),
    	'id' => 'wg-footer-bottom-right',
    	'description' => esc_html__( 'Appears when using the optional Footer with a page set as main menu', 'wp-libra' ),
    	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    	'after_widget' => '</aside>',
    	'before_title' => '<h3 class="wg-title">',
    	'after_title' => '</h3>',
	) );

}
add_action( 'widgets_init', 'wp_libra_widgets_init' );

/**
 * Filter the page menu arguments.
 *
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since 1.0.0
 */
function wp_libra_page_menu_args( $args ) {
    if ( ! isset( $args['show_home'] ) )
        $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'wp_libra_page_menu_args' );

/**
 * Add field subtitle to post.
 * 
 * @since 1.0.0
 */
function wp_libra_add_subtitle_field(){
    global $post, $wp_libra_meta;
    
    /* get current_screen. */
    $screen = get_current_screen();
    
    /* show field in post. */
    if(in_array($screen->id, array('post'))){
        
        /* get value. */
        $value = get_post_meta($post->ID, 'post_subtitle', true);
        
        /* html. */
        echo '<div class="subtitle"><input type="text" name="post_subtitle" value="'.esc_attr($value).'" id="subtitle" placeholder = "'.esc_html__('Subtitle', 'wp-libra').'" style="width: 100%;margin-top: 4px;"></div>';
    }
}

add_action( 'edit_form_after_title', 'wp_libra_add_subtitle_field' );

/**
 * Save custom theme meta. 
 * 
 * @since 1.0.0
 */
function wp_libra_save_meta_boxes($post_id) {
    
    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    /* update field subtitle */
    if ( isset( $_POST['post_subtitle'] ) ) {
        update_post_meta( $post_id, 'post_subtitle', sanitize_text_field( wp_unslash( $_POST['post_subtitle'] ) ) );
    }
}

add_action('save_post', 'wp_libra_save_meta_boxes');
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since 1.0.0
 */
function wp_libra_paging_nav() {
    // Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
			'base'     => $pagenum_link,
			'format'   => $format,
			'total'    => $GLOBALS['wp_query']->max_num_pages,
			'current'  => $paged,
			'mid_size' => 1,
			'add_args' => array_map( 'urlencode', $query_args ),
			'prev_text' => '<i class="fa fa-chevron-left"></i>',
			'next_text' => '<i class="fa fa-chevron-right"></i>',
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation clearfix">
			<div class="pagination loop-pagination">
				<?php echo ''.$links; ?>
			</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}

/**
* Display navigation to next/previous post when applicable.
*
* @since 1.0.0
*/
function wp_libra_post_nav() {
    global $post;

    // Don't print empty markup if there's nowhere to navigate.
    $previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );

    if ( ! $next && ! $previous )
        return;
    ?>
	<nav class="navigation post-navigation" role="navigation">
		<div class="nav-links clearfix">
			<?php
			$prev_post = get_previous_post();
			if (!empty( $prev_post )): ?>
			  <a class="post-prev left" href="<?php echo esc_url(get_permalink( $prev_post->ID )); ?>">
			  	<span><?php esc_html_e('PREVIOUS POST', 'wp-libra'); ?></span>
			  	<h4> <?php esc_html_e('Eenean et tortor vitae diam','wp-libra'); ?></h4>
			  </a>
			<?php endif; ?>
			<?php
			$next_post = get_next_post();
			if ( is_a( $next_post , 'WP_Post' ) ) { ?>
			  <a class="post-next right" href="<?php echo esc_url(get_permalink( $next_post->ID )); ?>">
			  	<span><?php esc_html_e('NEXT POST', 'wp-libra');?></span>
			  	<h4> <?php esc_html_e('Quiseue nec lobortis arcu','wp-libra'); ?></h4>
			  </a>
			<?php } ?>

			</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
/* End Post nav */

/**
 * Display navigation to next/previous comments when applicable.
 *
 * @since 1.0.0
 */
function wp_libra_comment_nav() {
    // Are there comments to navigate through?
    if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
    ?>
	<nav class="navigation comment-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'wp-libra' ); ?></h2>
		<div class="nav-links">
			<?php
				if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments', 'wp-libra' ) ) ) :
					printf( '<div class="nav-previous">%s</div>', $prev_link );
				endif;

				if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments', 'wp-libra' ) ) ) :
					printf( '<div class="nav-next">%s</div>', $next_link );
				endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .comment-navigation -->
	<?php
	endif;
}

/**
 * List socials share for post.
 * 
 * @since 1.0.0
 */
function wp_libra_get_socials_share(){
    ?>
    <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink();?>"><span class="share-box"><i class="fa fa-facebook"></i></span></a></li>
    <li><a target="_blank" href="https://twitter.com/home?status=<?php the_permalink();?>"><span class="share-box"><i class="fa fa-twitter"></i></span></a></li>
    <li><a target="_blank" href="https://google.com/share?url=<?php the_permalink();?>"><span class="share-box"><i class="fa fa-google"></i></span></a></li>
    <li class="social-pinterest"><a target="_blank" href="https://pinterest.com/pin/create/button/?url=<?php the_permalink();?>"><span class="share-box"><i class="fa fa-pinterest-p"></i></span></a></li>
    <li class="social-linkedin"><a target="_blank" href="https://linkedin.com/pin/create/button/?url=<?php the_permalink();?>"><span class="share-box"><i class="fa fa-linkedin"></i></span></a></li>
    <?php
}

/* Add Custom Comment */
function wp_libra_cms_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);

	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
<<?php echo esc_attr($tag) ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
<?php if ( 'div' != $args['style'] ) : ?>
<div id="div-comment-<?php comment_ID() ?>" class="comment-body clearfix">
<?php endif; ?>
	<div class="comment-author-image vcard">
		<?php echo get_avatar( $comment, 109 ); ?>
	</div>
<?php if ( $comment->comment_approved == '0' ) : ?>
	<em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.' , 'wp-libra'); ?></em>
<?php endif; ?>
	<div class="comment-main">
		<div class="comment-meta commentmetadata">
			<span class="comment-author"><a href="#"><?php echo get_comment_author_link(); ?></a></span>
			<span class="comment-date">
			<?php
				echo get_the_date(get_option('date_format', 'Y/m/d'));
			?>
			</span>
		</div>
		<div class="comment-content">
			<?php comment_text(); ?>
		</div>
		<div class="reply"><?php comment_reply_link( array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div>
	</div>
<?php if ( 'div' != $args['style'] ) : ?>
</div>
<?php endif; ?>
<?php
}
/* End Custom Comment */

// Replaces the excerpt "more" text by a link
function wp_libra_excerpt_more() {
	return '';
}
add_filter('excerpt_more', 'wp_libra_excerpt_more');

/**
 * Load ajax url.
 */
function wp_libra_ajax_url_head() {
    echo '<script type="text/javascript"> var ajaxurl = "'.admin_url('admin-ajax.php').'"; </script>';
}
add_action( 'wp_head', 'wp_libra_ajax_url_head');

// ajax search form.

add_action( 'wp_ajax_ajax_search', 'wp_libra_ajax_search' );
add_action( 'wp_ajax_nopriv_ajax_search', 'wp_libra_ajax_search' );

function wp_libra_ajax_search(){
    global $wpdb;
    
    if(empty($_REQUEST['data'])){
        
        echo '<span class="nothing-item">' . esc_html__('nothing found !', 'wp-libra') . '</span>';
        exit();
    }
    
    $keyword = sanitize_text_field( $_REQUEST['data'] );
    
    $keyword = "%{$keyword}%";
    
    // Search in post_title and post_content
    $post_ids_post = $wpdb->get_col( $wpdb->prepare( "SELECT DISTINCT ID FROM {$wpdb->posts} WHERE post_type = 'post' AND post_title LIKE '%s' OR post_content LIKE '%s' LIMIT 10", $keyword, $keyword ) );
    
    if(empty($post_ids_post)){
    
        echo '<span class="nothing-item">' . esc_html__('nothing found !', 'wp-libra') . '</span>';
        exit();
    }
    
    $query = array(
                'posts_per_page'=> 4,
                'post__in' => $post_ids_post,
                'post_status' => 'publish',
            );
    
    $search = new WP_Query( $query );
    
    if ($search->have_posts()){
        ?> <div class="search-wrapper"> <?php
        while ($search->have_posts()): $search->the_post();
            ?>
            <div class="search-item">
	            <div class="search-thumbnail">
	            	<?php 
	                    if(has_post_thumbnail() && !post_password_required() && !is_attachment() &&  wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'wp_libra_images-small', false)):
	                        $class = ' has-thumbnail';
	                        $thumbnail = get_the_post_thumbnail(get_the_ID(),'wp_libra_images-small');
	                    else:
	                        $class = ' no-image';
	                        $thumbnail = '<img src="' .esc_url(get_template_directory_uri(). '/assets/images/no-image.jpg').'" alt="'.get_the_title().'" />';
	                    endif;
	                    echo '<div class="">'. $thumbnail .'</div>';
	                ?>
	            </div>
	            <div class="search-content clearfix">
	            	<div class="search-meta"><?php wp_libra_archive_detail(); ?></div>
	                <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	                <span class="subtitle"><?php echo esc_html(get_post_meta(get_the_ID() , 'post_subtitle', true)); ?></span>
	                <div class="description"><?php echo wp_libra_limit_words( strip_tags( get_the_excerpt() ), 25)."..."; ?></div>
	                <a class="loadmore" href="<?php the_permalink(); ?>"><?php esc_html_e('READ MORE', 'wp-libra'); ?></a>
	            </div>
	        </div>
            <?php
        endwhile;
        ?> </div> <?php
    }
    die;
}
/**
 * Ajax Dummy Data
 */
add_action( 'wp_ajax_ajax_cmsdummy', 'wp_libra_ajax_cmsdummy');

/**
 * Ajax Function Dummy Data
 */

function wp_libra_ajax_cmsdummy(){
	if (!function_exists('cmsDummyData')) return ;
	
	cmsDummyData();
}

/* Add span wrap in count number categories */
add_filter('wp_list_categories', 'cat_count_span');
function cat_count_span($links) {
  $links = str_replace('</a> (', ' <span>(', $links);
  $links = str_replace(')', ')</span></a>', $links);
  return $links;
}

add_action('wp_head', 'wp_libra_custom_css');
function wp_libra_custom_css(){
    
    global $smof_data;
    
    /* custom css.  */
    if(!empty($smof_data['custom_css'])){
        echo '<style>';
        echo esc_attr($smof_data['custom_css']);
        echo '</style>';
    }
}