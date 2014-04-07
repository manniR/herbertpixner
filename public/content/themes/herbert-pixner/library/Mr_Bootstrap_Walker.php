<?php
/**
 * Created by PhpStorm.
 * User: manni
 * Date: 03.04.14
 * Time: 19:04
 */


/**
 * Create HTML list of nav menu items.
 *
 * @package WordPress
 * @since 3.0.0
 * @uses Walker
 */
class Mr_Bootstrap_Walker extends Walker_Nav_Menu {
		/**
		 * What the class handles.
		 *
		 * @see Walker::$tree_type
		 * @since 3.0.0
		 * @var string
		 */
		var $tree_type = array( 'post_type', 'taxonomy', 'custom' );

		/**
		 * Database fields to use.
		 *
		 * @see Walker::$db_fields
		 * @since 3.0.0
		 * @todo Decouple this.
		 * @var array
		 */
		var $db_fields = array( 'parent' => 'menu_item_parent', 'id' => 'db_id' );

		/**
		 * Starts the list before the elements are added.
		 *
		 * START_LVL
		 * Starts the list before the CHILD elements are added.
		 *
		 *
		 * @see Walker::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */

		function start_lvl( &$output, $depth = 0, $args = array() ) {
				$indent = str_repeat("\t", $depth);
				$output .= "\n<ul role=\"menu\" class=\"dropdown-menu\">\n"; //child elements beginnn
		}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @see Walker::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param int    $depth  Depth of menu item. Used for padding.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		function end_lvl( &$output, $depth = 0, $args = array() ) {
				$indent = str_repeat("\t", $depth);
				$output .= "$indent</ul>\n";
		}

		/**
		 * Start the element output.
		 *
		 * @see Walker::start_el()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param array|object $args An array of arguments. @see wp_nav_menu()
		 * @param int $id Current item ID.
		 */
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
				$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

				$class_names = $value = '';

				$classes = empty( $item->classes ) ? array() : (array) $item->classes;
				$classes[] = 'menu-item-' . $item->ID;
				/**
				 * Filter the CSS class(es) applied to a menu item's <li>.
				 *
				 * @since 3.0.0
				 *
				 * @param array  $classes The CSS classes that are applied to the menu item's <li>.
				 * @param object $item    The current menu item.
				 * @param array  $args    An array of arguments. @see wp_nav_menu()
				 */
				$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );

				if ( $args->has_children )
						$class_names .= ' dropdown';

				if ( in_array( 'current-menu-item', $classes ) )
						$class_names .= ' active';

				$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';



				/**
				 * Filter the ID applied to a menu item's <li>.
				 *
				 * @since 3.0.1
				 *
				 * @param string The ID that is applied to the menu item's <li>.
				 * @param object $item The current menu item.
				 * @param array $args An array of arguments. @see wp_nav_menu()
				 */
				$id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
				$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

				$output .= $indent . '<li' . $id . $value . $class_names .'>';

				$atts = array();
				$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
				$atts['target'] = ! empty( $item->target )     ? $item->target     : '';
				$atts['rel']    = ! empty( $item->xfn )        ? $item->xfn        : '';



				/*
				*		If item has children set '#' anchor-tag and bootstrap classes.
				*/

				if($args->has_children && $depth === 0){
						// Bootstrap custom classes
						$atts['href'] ='#';
						$atts['data-toggle'] ='dropdown';
						$atts['class'] ='dropdown-toggle';
						$atts['class'] ='dropdown-toggle';
						$atts['aria-has-popup'] ='true';

				}else{
						// if not = normal link
						$atts['href'] = ! empty( $item->url ) ? $item->url : '';
				}

				/**
				 * Filter the HTML attributes applied to a menu item's <a>.
				 *
				 * @since 3.6.0
				 *
				 * @param array $atts {
				 *     The HTML attributes applied to the menu item's <a>, empty strings are ignored.
				 *
				 *     @type string $title  The title attribute.
				 *     @type string $target The target attribute.
				 *     @type string $rel    The rel attribute.
				 *     @type string $href   The href attribute.
				 * }
				 * @param object $item The current menu item.
				 * @param array  $args An array of arguments. @see wp_nav_menu()
				 */
				$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args );

				$attributes = '';
				foreach ( $atts as $attr => $value ) {
						if ( ! empty( $value ) ) {
								$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
								$attributes .= ' ' . $attr . '="' . $value . '"';
						}
				}



				$item_output = $args->before;

				/*
						 * Glyphicons
						 * ===========
						 * Since the the menu item is NOT a Divider or Header we check the see
						 * if there is a value in the attr_title property. If the attr_title
						 * property is NOT null we apply it as the class name for the glyphicon.
						 */




				if ( ! empty( $item->attr_title ) )
						$item_output .= '<a'. $attributes .'><span class="glyphicon ' . esc_attr( $item->attr_title ) . '"></span>&nbsp;';
				else
						$item_output .= '<a'. $attributes .'>';



				//$item_output .= '<a'. $attributes .'>';
				/** This filter is documented in wp-includes/post-template.php */
				$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
				$item_output .= ( $args->has_children && 0 === $depth ) ? ' <span class="caret"></span></a>' : '</a>';
				$item_output .= '</a>';
				$item_output .= $args->after;



				/**
				 * Filter a menu item's starting output.
				 *
				 * The menu item's starting output only includes $args->before, the opening <a>,
				 * the menu item's title, the closing </a>, and $args->after. Currently, there is
				 * no filter for modifying the opening and closing <li> for a menu item.
				 *
				 * @since 3.0.0
				 *
				 * @param string $item_output The menu item's starting HTML output.
				 * @param object $item        Menu item data object.
				 * @param int    $depth       Depth of menu item. Used for padding.
				 * @param array  $args        An array of arguments. @see wp_nav_menu()
				 */
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

		/**
		 * Ends the element output, if needed.
		 *
		 * @see Walker::end_el()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item   Page data object. Not used.
		 * @param int    $depth  Depth of page. Not Used.
		 * @param array  $args   An array of arguments. @see wp_nav_menu()
		 */
		function end_el( &$output, $item, $depth = 0, $args = array() ) {
				$output .= "</li>\n";
		}

		/**
		 * Traverse elements to create list from elements.
		 *
		 * Display one element if the element doesn't have any children otherwise,
		 * display the element and its children. Will only traverse up to the max
		 * depth and no ignore elements under that depth. It is possible to set the
		 * max depth to include all depths, see walk() method.
		 *
		 * This method should not be called directly, use the walk() method instead.
		 *
		 * @since 2.5.0
		 *
		 * @param object $element           Data object.
		 * @param array  $children_elements List of elements to continue traversing.
		 * @param int    $max_depth         Max depth to traverse.
		 * @param int    $depth             Depth of current element.
		 * @param array  $args              An array of arguments.
		 * @param string $output            Passed by reference. Used to append additional content.
		 * @return null Null on failure with no changes to parameters.
		 */
		function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {

				if ( ! $element )
						return;

				$id_field = $this->db_fields['id'];


				// Display this element.
				if ( is_object( $args[0] ) )
						$args[0]->has_children = ! empty( $children_elements[ $element->$id_field ] );

				parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );

		}

} // Walker_Nav_Menu