
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
	<div class="bg-post-fullwidth<?php echo has_post_thumbnail() ? ' has-bg' : ' no-bg' ; ?>">
        <div class="bg-images">
            <div class="entry-feature entry-gallery"><?php wp_libra_archive_gallery(); ?></div>
            <?php $wp_libra_base->getBreadCrumb(); ?>
        </div>
    </div><!-- #fullwidthbg -->
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
			<div class="entry-content-inner"><?php the_content(); ?></div>
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
	<div class="entry-footer">
		<div class="blog-admin-post clearfix">
			<div class="admin-avt">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 120 ); ?>
			</div>
			<div class="admin-info">
				<h3>
					<?php the_author_meta( 'first_name' ); ?>
					<?php the_author_meta( 'last_name' ); ?>
				</h3>
				<div class="admin-des">
					<?php the_author_meta( 'description' ); ?>
				</div>
				<div class="admin-social">
					<ul>
						<li><a href="<?php echo esc_url($smof_data['admin_fb']); ?>"><i class="fa fa-facebook"></i></a></li>
						<li><a href="<?php echo esc_url($smof_data['admin_tw']); ?>"><i class="fa fa-twitter"></i></a></li>
						<li><a href="<?php echo esc_url($smof_data['admin_ins']); ?>"><i class="fa fa-instagram"></i></a></li>
						<li><a href="<?php echo esc_url($smof_data['admin_gl']); ?>"><i class="fa fa-google"></i></a></li>
						<li><a href="<?php echo esc_url($smof_data['admin_pin']); ?>"><i class="fa fa-pinterest"></i></a></li>
					</ul>
				</div>
			</div>
			<div class="overlay-admin"></div>
		</div>
	</div>
	<!-- .entry-footer -->
</article>
<!-- #post -->



