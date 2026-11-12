<?php
// Filter Functions with Hooks
add_action('admin_head', 'cshero_tinymce_button');
function cshero_tinymce_button() {
    global $typenow;
  // Check if user have permission
  if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
    return;
  }
  // Check if WYSIWYG is enabled
  if ( get_user_option('rich_editing') == 'true') {
    add_filter( 'mce_external_plugins', 'cms_custom_tinymce_button' );
    add_filter( 'mce_buttons', 'cms_register_mce_button' );
  }
}

// Function for new button
function cms_custom_tinymce_button( $plugin_array ) {
  $plugin_array['cshero_tinymce_button'] = get_template_directory_uri() .'/inc/tinymce/editor_plugin.js';
  return $plugin_array;
}
// Register new button in the editor
function cms_register_mce_button( $button ) {
  array_push( $button, 'cshero_tinymce_button' );
  return $button;
}

?>