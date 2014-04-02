<?php
/*
 Template Name: Für die Presse
*/
?>

<?php get_header(); //get_header_image()?>

<div class="container">
  <div id="content" class="clearfix row">
    <?php get_template_part('partials/template', 'sidebar') ?>

    <div id="main" class="col-sm-8 clearfix" role="main">

<?php

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
//$today = date('d-m-Y');
$args= array(
        'post_type' => 'presse', // Tell WordPress which post type we want
        'orderby' => 'menu_order', // We want to organize the events by date
        'category' => 'fuer-die-presse',
        'order' => 'ASC', // ASC is the other option
        'posts_per_page' => '-1' // Let's show them all.
            );



$presse_query = new WP_Query($args);
/** @var $wpdb wpdb */

global $wpdb;
/*echo '<pre>';
var_dump($wpdb->get_caller());
echo '</pre>';*/

/*echo '<pre>';
var_dump($presse_query);
echo '</pre>';*/


?>
<?php if($presse_query->have_posts()): ?>
<div class="row">




<!-- the loop -->
<?php while( $presse_query->have_posts() ) : $presse_query->the_post(); ?>
<div class="col-md-3">
<div class="thumbnail">
  <p><?php the_title() ?></p>
  <?php the_content() ?>
</div>
</div>
<?php endwhile ?>


<!-- end of the loop -->

<!-- pagination here -->

<?//php wp_reset_postdata(); ?>
</div>
<?php else: ?>
<p> <?php _e( 'Sorry, no press-data where found'); ?></p>
<?php endif; ?>

</div>
    </div> <!-- end #main -->

</div> <!-- end #content -->



<?php get_footer(); ?>



