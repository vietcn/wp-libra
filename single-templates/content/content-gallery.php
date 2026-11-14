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
	<div class="entry-blog">
		<div class="entry-feature entry-gallery entry-feature-image">
			<?php wp_libra_archive_gallery(); ?>
	    	<div class="entry-terms"><?php wp_libra_detail_terms(); ?></div>
	    </div>
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
			<p> <?php echo wp_libra_limit_words( strip_tags( get_the_excerpt() ), 100); ?></p>
			<div class="entry-meta">	
				<?php wp_libra_detail_date(); ?>
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
			<div class="readmore">
				<?php wp_libra_archive_readmore(); ?> 
			</div>
			<div class="share-btn">Share</div>
			<div class="social-shared inline-bl">
				<ul><?php wp_libra_get_socials_share(); ?></ul>
			</div>
		</div>
	</div>
	<!-- .entry-blog -->
</article>
<!-- #post -->