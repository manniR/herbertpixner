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

function add_my_active_class($classes, $item) {

    if( in_array( 'current-menu-item', $classes ) ||
        in_array( 'current-menu-ancestor', $classes ) ||
        in_array( 'current-menu-parent', $classes ) ||
        in_array( 'current_page_parent', $classes ) ||
        in_array( 'current_page_item', $classes ) ||
        in_array( 'current_page_ancestor', $classes )
    ) {

        $classes[] = "active2";
    }

    return $classes;

        /*if( $item->menu_item_parent == 0 && in_array('current-menu-item', $classes) ) {
            $classes[] = "active2";
        }
        return $classes;*/

}


/*
/*
 *
 * custom walker menu for list pages
 *
 */

register_nav_menus(                      // wp3+ menus
    array(
//        'main_nav' => 'The Main Menu',    main nav in header
//        'footer_links' => 'Footer Links'  secondary nav in footer

          'sub_nav' => 'The Sub Menu'
    )
);
class My_Custom_Walker extends Walker_page {

}  //End Walker Class