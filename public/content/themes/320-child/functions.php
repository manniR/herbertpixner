<?php
/**
 * Created by PhpStorm.
 * User: macbookpro
 * Date: 22.01.14
 * Time: 18:42
 */

add_filter('rewrite_rules_array','wp_insertMyRewriteRules');
add_filter('query_vars','wp_insertMyRewriteQueryVars');
//add_filter('init','flushRules');

// Remember to flush_rules() when adding rules
function flushRules(){
    global $wp_rewrite;
    $wp_rewrite->flush_rules();
}

// Adding a new rule
function wp_insertMyRewriteRules($rules)
{
    $newrules = array();
    $newrules['programm/(.+)'] = 'index.php?pagename=programm&monat=$matches[1]';
    $finalrules = $newrules + $rules;
    return $finalrules;
}

// Adding the var so that WP recognizes it
function wp_insertMyRewriteQueryVars($vars)
{
    array_push($vars, 'monat');
    return $vars;
}

//Stop wordpress from redirecting
remove_filter('template_redirect', 'redirect_canonical');




// get page parent id
function get_top_parent_page_id() {

    global $post;

    $ancestors = $post->ancestors;

    // Check if page is a child page (any level)
    if ($ancestors) {

        //  Grab the ID of top-level page from the tree
        return end($ancestors);

    } else {

        // Page is the top level, so use  it's own id
        return $post->ID;

    }
}

// add active class
add_filter('nav_menu_css_class', 'add_my_active_class', 10, 2 );
add_filter( 'page_css_class', 'add_my_active_class', 10, 5 );

function add_my_active_class($classes, $item) {

    if( in_array( 'current-menu-item', $classes ) ||
        in_array( 'current-menu-ancestor', $classes ) ||
        in_array( 'current-menu-parent', $classes ) ||
        in_array( 'current-page-parent', $classes ) ||
        in_array( 'current-page-item', $classes ) ||
        in_array( 'current-page-ancestor', $classes )
    ) {

        $classes[] = "active";
    }

    return $classes;

}


/*
/*
 *
 * custom walker menu for list pages
 *
 */

// page menu
register_nav_menus(
    array(
        // location => description
         'theme_location' => 'hp_side_menu'
    )
);

function hp_side_nav() {
    // display the wp3 menu if available
    wp_nav_menu(
        array(
            //'menu' => 'main_nav', /* menu name */
            //'menu_class' => 'nav navbar-nav',
            //'theme_location' => 'hp_side_menu', /* where in the theme it's assigned */
            'container' => 'false', /* container class */
            //'fallback_cb' => 'wp_bootstrap_main_nav_fallback', /* menu fallback */
            // 'depth' => '2',  suppress lower levels for now
            'walker' => new MR_Child_Only_Walker(),
            'depth' => 0
        )
    );
}




/**
 * Class child only walker menu
 * @see Walker
 *
 */

class MR_Child_Only_Walker extends Walker_Nav_Menu {


    // Don't start the top level
    function start_lvl(&$output, $depth=0, $args=array()) {

        //$output .='alsdkfj';
        if( 0 == $depth )
            return;
        parent::start_lvl($output, $depth, $args);
    }

    // Don't end the top level
    function end_lvl(&$output, $depth=0, $args=array()) {



        //$output .='aa';
        if( 0 == $depth )
            return;
        parent::end_lvl($output, $depth, $args);
    }

    // Don't print top-level elements
    function start_el(&$output, $object, $depth=0, $args=array(), $current_object_id=0) {

        //$output .='start el: title: '. $object->post_title .' ';


        if( 0 == $depth )
            return;

        parent::start_el($output, $object, $depth = 0, $args, $current_object_id);
    }

    function end_el(&$output, $object, $depth=0, $args=array()) {

        $output .=" end el <br/>";


        if( 0 == $depth )
            return;

        parent::end_el($output, $object, $depth, $args);
    }



    // Only follow down one branch
    function display_element( $object, &$children_elements, $max_depth, $depth=0, $args, &$output ) {
        // Check if element as a 'current element' class
        $current_element_markers = array( 'current-menu-item', 'current-menu-parent', 'current-menu-ancestor' );

       /* echo '<pre>';
        var_dump($object);
        echo '</pre>';*/


        //var_dump($output);
        //$current_class = array_intersect( $current_element_markers, $element->classes );

        // If element has a 'current' class, it is an ancestor of the current element
        $ancestor_of_current = !empty($current_class);

        // If this is a top-level link and not the current, or ancestor of the current menu item - stop here.
        if ( 0 == $depth)
            return;

         parent::display_element( $object, $children_elements, $max_depth, $depth, $args, $output );
    }
} // end Child only Walker






