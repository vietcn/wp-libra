<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-blog entry-blog-list">
		<div class="entry-list col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<a href="<?php echo esc_url(get_the_permalink()); ?>">
				<div class="entry-feature-image audio video <?php echo has_post_thumbnail() ? ' has-img' : ' no-img' ; ?>" style="background-image: url('<?php $url_feature_image = get_post(); $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID));echo esc_url($url);?>'); background-size: cover; background-position: center; ">
			    	<div class="overlay"></div>
		    	</div>
		    </a>
	    </div>
	    <div class="entry-header-list col-xs-12 col-sm-8 col-md-8 col-lg-8">
			<div class="entry-header clearfix">
				<h2 class="entry-title">
			    	<a href="<?php the_permalink(); ?>">
			    		<?php
				    		if(is_sticky()){
				                echo "<i class='fa fa-thumb-tack'></i>";
				            }
				    	?>
			    		<?php the_title(); ?>
			    	</a>
			    	<span class="subtitle"><?php echo esc_attr(get_post_meta(get_the_ID(), 'post_subtitle', true)); ?></span>
			    </h2>
				<p> <?php echo wp_libra_limit_words( strip_tags( get_the_excerpt() ), 15); ?></p>
				<div class="entry-meta">	
					<?php wp_libra_archive_detail(); ?>
					<span class="entry-author"><?php the_author_posts_link(); ?></span>
					<span class="blog-comment inline-bl">
						<a class="ico-comment" href="<?php the_permalink(); ?>">Comments <?php echo comments_number('<span>0</span>','<span>1</span>','<span>%</span>'); ?></a>
					</span>
				</div>
			</div>
			<?php
	    		wp_link_pages( array(
	        		'before'      => '<div class="pagination loop-pagination"><span class="page-links-title">' . esc_html__( 'Pages:','wp-libra') . '</span>',
	        		'after'       => '</div>',
	        		'link_before' => '<span class="page-numbers">',
	        		'link_after'  => '</span>',
	    		) );
			?>
			<div class="post-share">
				<div class="icon-share share-btn" role="button" tabindex="0" aria-label="<?php esc_attr_e( 'Share', 'wp-libra' ); ?>">
					<i class="fa fa-share-alt"></i>
				</div>
				<div class="social-shared">
					<ul><?php wp_libra_get_socials_share(); ?></ul>
				</div>
			</div>
		</div>
	</div>
	<!-- .entry-blog -->
</article>
<!-- #post -->
