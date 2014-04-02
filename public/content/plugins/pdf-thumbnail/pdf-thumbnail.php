<?php
/*
Plugin Name: PDF Thumbnail
Plugin URI: http://andref.it/blog
Description: With this simple plugin you can add a PDF thumbnail image to your posts and pages.
Author: Andrea Ferrato
Version: 0.1
Author URI: http://andref.it/blog
*/
function tcustom_addbuttons() {
	if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
		return;

	if ( get_user_option('rich_editing') == 'true') {
		add_filter("mce_external_plugins", "add_tcustom_tinymce_plugin");
		add_filter('mce_buttons', 'register_tcustom_button');
	}
}
function register_tcustom_button($buttons) {
	array_push($buttons, "|", "PDF Thumbnail");
	return $buttons;
}
function add_tcustom_tinymce_plugin($plugin_array) {
	$plugin_array['PDF Thumbnail'] = plugins_url('/pdf-thumbnail/editor_plugin.js');
	return $plugin_array;
}
// init process for button control
add_action('init', 'tcustom_addbuttons');

function locandina_funct($atts, $content = null) {
 extract( shortcode_atts( array(
          'url_pdf' => '', 'width' => '', 'page_number'  => '', 'add_link'  => '', 'link_title'  => '', 'image_class'  => '', 'link_class'  => '',

	), $atts));
	if ($add_link == "YES") {
		return '<a href="'.$url_pdf.'" title="'.$link_title.'" class="pdf_thumb_link '.$link_class.'" ><img src="http://docs.google.com/viewer?url='.$url_pdf.'&a=bi&pagenumber='.$page_number.'&w='.$width.'" alt=""  class="pdf_thumb_img '.$image_class.'" /></a>';
	}
	else {
		return '<img src="http://docs.google.com/viewer?url='.$url_pdf.'&a=bi&pagenumber='.$page_number.'&w='.$width.'" alt=""  class="pdf_thumb_img '.$image_class.'" />';
	}
}
add_shortcode('locandina', 'locandina_funct');

?>