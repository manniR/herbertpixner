<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 22.01.14
 * Time: 18:42
 */
// Get Bones and Core Up & Running!
require_once('library/bones.php');
require_once('library/admin.php');
require_once('library/menus.php');
require_once('library/extras.php');
require_once('library/helper.php');
require_once('library/Mr_Bootstrap_Walker.php');
require_once('library/wp_bootstrap_navwalker.php');




// Set content width
if ( ! isset( $content_width ) ) $content_width = 580;

// Set content width
if ( ! isset( $content_width ) ) $content_width = 580;

/************* THUMBNAIL SIZE OPTIONS *************/

/*// Thumbnail sizes
add_image_size( 'wpbs-featured', 780, 300, true );
add_image_size( 'wpbs-featured-home', 970, 311, true);
add_image_size( 'wpbs-featured-carousel', 970, 400, true);

/*add them to the media library dropdown*/
/*add_filter( 'image_size_names_choose', 'custom_image_sizes_choose' );
function custom_image_sizes_choose( $sizes ) {
  $custom_sizes = array(
    'wpbs-featured' => 'wpbs-featured',
    'wpbs-featured-home' => 'wpbs-featured-home',
    'wpbs-featured-carousel' => 'wpbs-featured-carousel',
  );
  return array_merge( $sizes, $custom_sizes );
}*/



/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

// ADD DEFAULT TWITTER BOOTSTRAP ACTIVE CLASS

add_filter('nav_menu_css_class', 'add_my_active_class', 10, 2);
add_filter('page_css_class', 'add_my_active_class', 10, 5);

function add_my_active_class($classes, $item)
{
  if (in_array('current-menu-item', $classes) ||
    in_array('current-menu-ancestor', $classes) ||
    in_array('current-menu-parent', $classes) ||
    in_array('current-page-parent', $classes) ||
    in_array('current-page-item', $classes) ||
    in_array('current_page_item', $classes) ||
    in_array('current-page-ancestor', $classes)
  ) {

    $classes[] = "active";
  }

  return $classes;

}

// CUSTOM HEADER IMAGE THEME SUPPORT
$args = array(
  //'flex-width'    => true,
  'width' => 940,
  //'flex-height'   => true,
  'height' => 360,
  'default-image' => get_template_directory_uri() . '/images/header.jpg',
);
add_theme_support('custom-header', $args);


//THEME STYLES
if (!function_exists("theme_styles")) {
  function theme_styles(){
    wp_register_style('bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css?', array(), null);
    wp_register_style('theme_style', get_stylesheet_directory_uri() . '/style.css?', array(), null);
    wp_register_style('jquery_lightbox', get_stylesheet_directory_uri() . '/css/jquery.lightbox.min.css', array(), null);
    wp_register_style('font-awesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css?', array(), null);

    wp_enqueue_style('bootstrap');
    wp_enqueue_style('theme_style');
    wp_enqueue_style('font-awesome');
    wp_enqueue_style('jquery_lightbox');
  }
}

add_action('wp_enqueue_scripts', 'theme_styles');

// enqueue javascript
if (!function_exists("theme_scripts")) {
  function theme_scripts()
  {
    wp_register_script('modernizer',get_stylesheet_directory_uri() . '/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js', array('jquery'), null, true);
    wp_register_script('bootstrap-js',get_stylesheet_directory_uri() . '/js/vendor/bootstrap.min.js', array('jquery'), null, true);
    wp_register_script('jquery-lightbox',get_stylesheet_directory_uri() . '/js/jquery.lightbox.min.js', array('jquery'), null, true);
    wp_register_script('main',get_stylesheet_directory_uri() . '/js/main.js', array('jquery', 'jquery-lightbox'), null, true);
    wp_register_script('fittext',get_stylesheet_directory_uri() . '/js/jquery.fittext.js', array('jquery'), null, true);

    wp_enqueue_script('modernizer');
    wp_enqueue_script('bootstrap-js');
    wp_enqueue_script('jquery-lightbox');
    wp_enqueue_script('fittext');
    wp_enqueue_script('main');
  }
}
add_action('wp_enqueue_scripts', 'theme_scripts');





// Disable jump in 'read more' link
function remove_more_jump_link( $link ) {
  $offset = strpos($link, '#more-');
  if ( $offset ) {
    $end = strpos( $link, '"',$offset );
  }
  if ( $end ) {
    $link = substr_replace( $link, '', $offset, $end-$offset );
  }
  return $link;
}
add_filter( 'the_content_more_link', 'remove_more_jump_link' );

// Remove height/width attributes on images so they can be responsive
add_filter( 'post_thumbnail_html', 'remove_thumbnail_dimensions', 10 );
add_filter( 'image_send_to_editor', 'remove_thumbnail_dimensions', 10 );

function remove_thumbnail_dimensions( $html ) {
  $html = preg_replace( '/(width|height)=\"\d*\"\s/', "", $html );
  return $html;
}



/*EDITOR STYLES*/
function my_theme_add_editor_styles() {
    add_editor_style( 'editor-style.css' );
}
add_action( 'init', 'my_theme_add_editor_styles' );


/*
 REMOVE IMAGE W / H
*/

/*
function remove_width_attribute( $html ) {
  $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );

  return $html;
}

add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 )*/;

//add_filter('the_content', 'add_responsive_class');

function add_responsive_class($content){

  $content = mb_convert_encoding($content, 'HTML-ENTITIES', "UTF-8");
  $document = new DOMDocument();
  libxml_use_internal_errors(true);
  $document->loadHTML(utf8_decode($content));
	$ps = $document->getElementsByTagName('p');
	echo '<pre>';
	var_dump($ps->item(1));
	echo '</pre>';

  /*$imgs = $document->getElementsByTagName('img');
  foreach ($imgs as $img) {
    $img->setAttribute('class','w100');
  }
		$a = $p->getElementsByTagName('a')->item(0);

		$pdf_symbol = $document->createElement( 'span', 'PDF' );
		$pdf_symbol->setAttribute('class', 'pdf-symbol');
		$p->insertBefore($pdf_symbol, $a);

		echo '<pre>';
		var_dump($p);
		echo '</pre>';*/


		foreach ($ps as $link) {

//			$a->item[]->insertBefore($pdf_symbol, $link);

			/*echo '<pre>';
			var_dump($link->textContent);
			echo '</pre>';*/

    //$link->nodeValue = '<span class= filtered>FILTER</span>'.$link->textContent;

  }

 /* $html = $document->saveHTML();
  return $html;*/
}


function manipulate_dom(){

$dom = new DOMDocument;
//$dom->loadHTMLFile("data.html");

foreach($dom->getElementsByTagName('img') as $img){
		$src = $img->getAttribute('src');

		$filename = substr(strrchr($src , '/') ,1);
		$filename = preg_replace('/^[.]*/', '', $filename);
		$filename = explode('.', $filename);
		$filename = $filename[0];

		$classes = explode(' ', $img->getAttribute('class'));

		if(!in_array('no-enlarge', $classes))
		{
				$fancyHref = $dom->createElement('a');
				$span = $dom->createElement('span');
				$span->setAttribute('class', 'magnifier');
				$fancyHref->setAttribute('class', 'enlarge');
				$fancyHref->setAttribute('rel', 'enlarge');
				$fancyHref->setAttribute('href', $img->getAttribute('src'));
				if($img->getAttribute('title') !== '')
				{
						$fancyHref->setAttribute('title', $img->getAttribute('title'));
						$fancyHref->setAttribute('alt', $img->getAttribute('title'));
				}
				$clone = $fancyHref->cloneNode();

				$img->parentNode->replaceChild($clone, $img);
				$clone->appendChild($img);
				$img->parentNode->insertBefore($span, $img);
		}

		$img->setAttribute('class', trim(str_replace('no-enlarge', '', $img->getAttribute('class'))));

		if($img->getAttribute('class') === ''){
				$img->removeAttribute('class');
		}
}

echo "<pre>" . htmlentities($dom->saveHTML()) . "</pre>";


/*With this (data.html) as source data:

<!doctype html>
<html>
    <head>
    </head>
    <body>
        <img src="http://lorempixel.com/g/400/200/" alt="alts" title="tits">
    </body>
</html>
And the result is this:

<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
        <a class="enlarge" rel="enlarge" href="http://lorempixel.com/g/400/200/" title="tits" alt="tits">
            <span class="magnifier">
            </span>
            <img src="http://lorempixel.com/g/400/200/" alt="alts" title="tits"></a>
    </body>
</html>*/

//  So.. Isn't that what you wanted? :D



}