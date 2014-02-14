<?php
/*
 Template Name: Tourdates Listing
*/

?>

<?php get_header(); ?>

<?php
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$today = date('Y-m-d');
query_posts(array(
    'post_type' => 'performance',
    'posts_per_page' => 5,
    'caller_get_posts' => 5,
    'paged' => $paged,
    'meta_key' => 'order-date',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'order-date',
            'meta-value' => $value,
            'value' => $today,
            'compare' => '>=',
            'type' => 'CHAR'
        )
    )
));

/* WP LOOP */


?>


