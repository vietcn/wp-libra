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
global $smof_data, $wp_libra_base;
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="bg-post-gallery-two<?php echo has_post_thumbnail() ? ' has-bg' : ' no-bg' ; ?>">
        <div class="bg-images">
            <?php wp_libra_images();?>
            <?php $wp_libra_base->getBreadCrumb(); ?>
        </div>
    </div>
	<div class="entry-blog entry-blog-post">
		<div class="entry-header clearfix">
			<h2 class="entry-title">
	    		<?php
		    		if(is_sticky()){
		                echo "<i class='fa fa-thumb-tack'></i>";
		            }
		    	?>
	    		<?php the_title(); ?>
		    	<span class="subtitle"><?php echo esc_attr(get_post_meta(get_the_ID(), 'post_subtitle', true)); ?></span>
		    </h2>
		    <div class="entry-meta">
		    	<?php wp_libra_archive_meta(); ?>
		    </div>
		</div>
		<!-- .entry-header -->
		
		<div class="entry-content">
			<div class="entry-content-inner">
				<?php
				/* Images are rendered above via Owl; strip duplicate [gallery] from content. */
				$content = preg_replace( '/\[gallery[^\]]*\]/', '', get_the_content() );
				echo apply_filters( 'the_content', $content ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				?>
			</div>
			<div class="blog-tags">
			    <?php the_tags( '<h5>TAGS</h5> ','' ); ?>
	    	</div>
			<div class="social-share-post">
				<div class="blog-social-shared" data-url="<?php the_permalink(); ?>">
					<div class="social-shared inline-bl">
						<ul><?php wp_libra_get_socials_share(); ?></ul>
					</div>
				</div>
			</div>
		</div>
		<!-- .entry-content -->
		<?php wp_libra_post_nav(); ?>
	</div><!-- .entry-blog -->
	
</article>
<!-- #post -->




