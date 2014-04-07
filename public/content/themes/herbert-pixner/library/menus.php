<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 06.03.14
 * Time: 10:35
 */




function wp_bootstrap_main_nav() {
  // display the wp3 menu if available
  wp_nav_menu(
    array(
      'menu' => 'main_nav', /* menu name */
      'menu_class' => 'nav navbar-nav pull-left',
      'theme_location' => 'main_nav', /* where in the theme it's assigned defined in bones.php add theme support*/
      'container' => 'false', /* container class */
      'fallback_cb' => 'wp_bootstrap_main_nav_fallback', /* menu fallback */
      'depth' => '2', // suppress lower levels for now
      'walker' => new Bootstrap_walker()
    )
  );
}
function test_nav() {
  // display the wp3 menu if available
  wp_nav_menu(
    array(
      'menu' => 'main_nav', /* menu name */
      'menu_class' => 'nav navbar-nav center-block',
      'theme_location' => 'main_nav', /* where in the theme it's assigned defined in bones.php add theme support*/
      'container' => 'false', /* container class */
      'fallback_cb' => 'wp_bootstrap_main_nav_fallback', /* menu fallback */
      'depth' => '2', // suppress lower levels for now
      'walker' => new Mr_Bootstrap_Walker()//new wp_bootstrap_navwalker()
    )
  );
}

function mr_footer_menu()
{
		// display the wp3 menu if available
		wp_nav_menu(
				array(
						'menu' => 'footer_links', /* menu name */
						'menu_class' => 'nav nav-stacked nav-pills', /*menu class*/
						'menu_id' => 'footer-main-menu',
						'theme_location' => 'footer_links', /* where in the theme it's assigned */
						'container_class' => 'footer-links clearfix', /* container class */
						'depth' => 1,
						'fallback_cb' => 'wp_bootstrap_footer_links_fallback' /* menu fallback */

				)
		);
}


function wp_bootstrap_footer_links() {
  // display the wp3 menu if available
  wp_nav_menu(
    array(
      'menu' => 'footer_links', /* menu name */
      'theme_location' => 'footer_links', /* where in the theme it's assigned */
      'container_class' => 'footer-links clearfix', /* container class */
		    'depth' => 1,
      'fallback_cb' => 'wp_bootstrap_footer_links_fallback' /* menu fallback */
    )
  );
}

// this is the fallback for header menu
function wp_bootstrap_main_nav_fallback() {
  // Figure out how to make this output bootstrap-friendly html
  //wp_page_menu( 'show_home=Home&menu_class=nav' );
}

// this is the fallback for footer menu
function wp_bootstrap_footer_links_fallback() {
  /* you can put a default here if you like */
}

/**
 * CUSTOM MENU / SUB MENU
 * http://christianvarga.com/how-to-get-submenu-items-from-a-wordpress-menu-based-on-parent-or-sibling/
 * DEMO:
 * http://wp-sub-menu-demo.christianvarga.com/
 *
 */

/*
wp_nav_menu( array(
		'theme_location' => 'sidebar',
		'sub_menu' => true,
		'direct_parent' => true
));
*/

function custom_sub_nav(){

		wp_nav_menu( array(
//				'theme_location' => 'sidebar',
				'container_class' => 'navbar',
				'menu_class' => 'nav nav-pills nav-stacked span2',
				'sub_menu' => true,
				'direct_parent' => true

		));
}

// add hook
add_filter( 'wp_nav_menu_objects', 'my_wp_nav_menu_objects_sub_menu', 10, 2 );

// filter_hook function to react on sub_menu flag
function my_wp_nav_menu_objects_sub_menu( $sorted_menu_items, $args ) {

		if ( isset( $args->sub_menu ) ) {
				$root_id = 0;

				// find the current menu item
				foreach ( $sorted_menu_items as $menu_item ) {
						if ( $menu_item->current ) {
								// set the root id based on whether the current menu item has a parent or not
								$root_id = ( $menu_item->menu_item_parent ) ? $menu_item->menu_item_parent : $menu_item->ID;
								break;
						}
				}

				// find the top level parent
				if ( ! isset( $args->direct_parent ) ) {
						$prev_root_id = $root_id;
						while ( $prev_root_id != 0 ) {
								foreach ( $sorted_menu_items as $menu_item ) {
										if ( $menu_item->ID == $prev_root_id ) {
												$prev_root_id = $menu_item->menu_item_parent;
												// don't set the root_id to 0 if we've reached the top of the menu
												if ( $prev_root_id != 0 ) $root_id = $menu_item->menu_item_parent;
												break;
										}
								}
						}
				}

				$menu_item_parents = array();
				foreach ( $sorted_menu_items as $key => $item ) {
						// init menu_item_parents
						if ( $item->ID == $root_id ) $menu_item_parents[] = $item->ID;

						if ( in_array( $item->menu_item_parent, $menu_item_parents ) ) {
								// part of sub-tree: keep!
								$menu_item_parents[] = $item->ID;
						} else if ( ! ( isset( $args->show_parent ) && in_array( $item->ID, $menu_item_parents ) ) ) {
								// not part of sub-tree: away with it!
								unset( $sorted_menu_items[$key] );
						}
				}

				return $sorted_menu_items;
		} else {
				return $sorted_menu_items;
		}
}

  /**
   * Class Bootstrap_walker
   *
   * Menu output mods
   *
   * @param string $output
   * @param object $object
   * @param int $depth
   * @param array $args
   * @param int $current_object_id
   */
class Bootstrap_walker extends Walker_Nav_Menu{
  function start_el(&$output, $object, $depth = 0, $args = Array(), $current_object_id = 0){

    global $wp_query;
    $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

    $class_names = $value = '';

    // If the item has children, add the dropdown class for bootstrap
    if ( $args->has_children ) {
      $class_names = "dropdown ";
    }

    $classes = empty( $object->classes ) ? array() : (array) $object->classes;

    $class_names .= join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $object ) );
    $class_names = ' class="'. esc_attr( $class_names ) . '"';

    $output .= $indent . '<li id="menu-item-'. $object->ID . '"' . $value . $class_names .'>';

    $attributes  = ! empty( $object->attr_title ) ? ' title="'  . esc_attr( $object->attr_title ) .'"' : '';
    $attributes .= ! empty( $object->target )     ? ' target="' . esc_attr( $object->target     ) .'"' : '';
    $attributes .= ! empty( $object->xfn )        ? ' rel="'    . esc_attr( $object->xfn        ) .'"' : '';
    $attributes .= ! empty( $object->url )        ? ' href="'   . esc_attr( $object->url        ) .'"' : '';

    // if the item has children add these two attributes to the anchor tag
    // if ( $args->has_children ) {
    // $attributes .= ' class="dropdown-toggle" data-toggle="dropdown"';
    // }

    $item_output = $args->before;
    $item_output .= '<a'. $attributes .'>';
    $item_output .= $args->link_before .apply_filters( 'the_title', $object->title, $object->ID );
    $item_output .= $args->link_after;

    // if the item has children add the caret just before closing the anchor tag
    if ( $args->has_children ) {
      //$item_output .= '<b class="caret"></b></a>'; // uncomment if submenu
    }
    else {
      $item_output .= '</a>';
    }

    $item_output .= $args->after;

    $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $object, $depth, $args );
  } // end start_el function

  function start_lvl(&$output, $depth = 0, $args = Array()) {
    $indent = str_repeat("\t", $depth);
    $output .= "\n$indent<ul class=\"dropdown-menu\">\n";
  }

  function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ){
    $id_field = $this->db_fields['id'];
    if ( is_object( $args[0] ) ) {
      $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
    }
    return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
  }
}
