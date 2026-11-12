<?php
global $masonry_filter,$wp_libra_meta;
$page_category = isset($wp_libra_meta->_cms_post_categories)?$wp_libra_meta->_cms_post_categories:'';

if(is_category()){
    $page_category = get_query_var( 'cat' );
}
if ($page_category == "" && !is_category()) {
    $args = array(
        'parent' => 0
    );
    $categories = get_categories( $args );
} else {
    if(!is_array($page_category)){
        $page_category = explode(',', $page_category);
    }
    $cats = $page_category;
    $categories = array();
    foreach ($cats as $key => $value) {
        $cat = get_category($value);
        $categories[$key] = new stdClass();
        $categories[$key]->slug = $cat->slug; 
        $categories[$key]->name = $cat->name; 
    }
    
}

if ($masonry_filter && count($categories) > 0) {	?>
	<div class="cms-grid-filter playfairdisplay clearfix">
        <ul class="list-unstyled list-inline cms-filter-category">
            <?php foreach($categories as $category):?>
                <li><a href="#" data-filter=".<?php echo esc_attr('category-'.$category->slug);?>">
                        <?php echo esc_html($category->name);?>
                    </a>
                </li>
            <?php endforeach;?>
        </ul>
    </div>
<?php  
}
?>
