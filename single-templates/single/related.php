 <?php
/**
 * Shows related posts by tag if available and category if not
 *
 * @author Justin Tallant
 * @param string $title h4 above list of related posts
 * @param int $count max number of posts to show
 * @return mixed related posts wrapped in div or null if none found
 */
function jt_related_posts($title = 'Related Posts', $count = 5) {
	global $post;
	$tag_ids = array();
	$current_cat = get_the_category($post->ID);
	$current_cat = $current_cat[0]->cat_ID;
	$this_cat = '';
	$tags = get_the_tags($post->ID);
	if ( $tags ) {
		foreach($tags as $tag) {
			$tag_ids[] = $tag->term_id;
		}
	} else {
		$this_cat = $current_cat;
	}
	$args = array(
		'post_type'   => get_post_type(),
		'numberposts' => $count,
		'orderby'     => 'rand',
		'tag__in'     => $tag_ids,
		'cat'         => $this_cat,
		'exclude'     => $post->ID
	);
	$related_posts = get_posts($args);
	/**
	 * If the tags are only assigned to this post try getting
	 * the posts again without the tag__in arg and set the cat
	 * arg to this category.
	 */
	if ( empty($related_posts) ) {
		$args['tag__in'] = '';
		$args['cat'] = $current_cat;
		$related_posts = get_posts($args);
	}
	if ( empty($related_posts) ) {
		return;
	}
	$post_list = '';
	foreach($related_posts as $related) {
		$post_list .= '<li><a href="' . get_permalink($related->ID) . '">' . $related->post_title . '</a></li>';
	}
	return sprintf('
		<div class="related-posts">
			<h4>%s</h4>
			<ul>%s</ul>
		</div> <!-- .related-posts -->
	', $title, $post_list );
}
/**
 * Customize the title and where the related posts are displayed
 */
add_action('genesis_after_post_content', 'do_jt_related_posts');
function do_jt_related_posts() {
	$title = 'Related Posts';
	if ( !is_single() ) {
		return;
	}
	if ( get_post_type() == 'gallery' || get_post_type() == 'case-studies' ) {
		$title = 'See more client sites';
	}
	/**
	 * Array of post types to be excluded
	 */
	$exclude = array('aeprofiles', 'bizdir', 'palettes');
	foreach($exclude as $type) {
		if ( get_post_type() == $type ) {
			return;
		}
	}
	echo jt_related_posts($title);
}