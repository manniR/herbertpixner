<?php
/*
 Template Name: Tourdates Listing
*/
?>

<?php get_header(); ?>


<?php

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$today = date('Y-m-d');
$args= array(
    'post_type' => 'tourdate',
    'posts_per_page' => 5,
    'ignore_sticky_posts' => true,
    'paged' => $paged,
    'meta_key' => 'datum',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_query' => array(
        array(
            'key' => 'datum',
            'meta-value' => $today,
            'value' => $today,
            'compare' => '>=',
            'type' => 'CHAR'
        )
    )

);

$tourdates_query = new WP_Query($args);
?>
<?php if($tourdates_query->have_posts()): ?>
<!-- the loop -->
<?php while( $tourdates_query->have_posts() ) : $tourdates_query->the_post(); ?>

<!--TOURDATES LISTING-->
<h2><?php the_title() ?></h2>


<?php endwhile ?>
<!-- end of the loop -->

<!-- pagination here -->

<?php wp_reset_postdata(); ?>

<?php else: ?>
<p> <?php _e( 'Sorry, no tourdates where found'); ?></p>
<?php endif; ?>


