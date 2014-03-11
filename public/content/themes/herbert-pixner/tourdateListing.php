<?php get_header(); //get_header_image()?>

<div class="container">
    <div id="content" class="clearfix row">

        <div id="sidebar1" class="col-sm-3" role="complementary">
            <?php require_once('sidebar1.php'); ?>
        </div>
        <!--END SIDEBAR-->
        <div class="col-sm-9 col-xs-12">
        <div id="main" class="clearfix" role="main">
<?php

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
$args= array(
        'post_type' => 'tourdate', // Tell WordPress which post type we want
        'orderby' => 'meta_value', // We want to organize the events by date
        'meta_key' => 'datum', // Grab the "date" field created via "More Fields" plugin (stored in YYYY-MM-DD format)
        'order' => 'ASC', // ASC is the other option
        'posts_per_page' => '-1', // Let's show them all.
        'meta_query' => array( // WordPress has all the results, now, return only the events after today's date
            array(
                'key' => 'datum', // Check the start date field
                'value' => date("y-m-d"), // Set today's date (note the similar format)
                'compare' => '>=', // Return the ones greater than today's date
                'type' => 'DATE' // Let WordPress know we're working with numbers
            )
        )
);
$m=array("","");
$tourdates_query = new WP_Query($args);
/** @var $wpdb wpdb */
global $wpdb;
?>
<?php if($tourdates_query->have_posts()): ?>

<!--start accordion-->
<div class="panel-group" id="accordion">
<!-- the loop -->
<?php while( $tourdates_query->have_posts() ) : $tourdates_query->the_post(); ?>

<?php
        setlocale(LC_ALL, 'de_DE.utf-8');//  deutsche Monatsnamen
        $datum = strftime('%d. %B %Y',strtotime(get_field('datum',$post->ID)));
        $m[0] = explode(' ',$datum)[1];

        if ($m[0] != $m[1]){
            //neues MONAT
            echo '<h3>' . $m[0]. ' ' . explode(' ',$datum)[2] . '</h3>';
            $m[1] = $m[0];
        }
?>

  <!--START PANELS-->
<div class="panel">
    <div class="">
            <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#<?php the_ID() ?>">
        <h4 class="panel-title">
                <span><?php echo date('d-m-Y',strtotime(get_field('datum', $post->ID)))?></span>
                      <?php the_title() ?><span class="glyphicon glyphicon-plus pull-right"></span>
            <?php echo (get_field('ausverkauft')? '<span class="ausverkauft pull-right">AUSVERKAUFT</span>' : '') ?>
        </h4>
            </a>
    </div>
    <div id="<?php the_ID(); ?>" class="panel-collapse collapse">
        <div class="panel-body">

            <dl class="dl-horizontal">
                <dt>Ort: </dt>
                <dd><?php echo get_field('location', $post->ID)?></dd>
                <dt>Einlass: </dt>
                <dd><?php echo get_field('einlass', $post->ID)?></dd>
                <dt>Beginn: </dt>
                <dd><?php echo get_field('beginn', $post->ID)?></dd>
                <?php $href = get_field('ticket_link', $post->ID); ?>
             </dl>
                <?php if ($href): ?>
             <dl class="dl-horizontal">
                <dt>Tickets: </dt>
                <dd><a href="<?php echo $href ?>">
                        <?php echo _('Hier online reservieren') ?></a></dd>
              </dl>
                <?php endif  ?>

        </div>
    </div>
</div>

<?php endwhile ?>

    </div><!--end accordion-->
<!-- end of the loop -->

<!-- pagination here -->

<?//php wp_reset_postdata(); ?>

<?php else: ?>
<p> <?php _e( 'Sorry, no tourdates where found'); ?></p>
<?php endif; ?>

    </div>
    </div>
    </div> <!-- end #main -->

</div> <!-- end #content -->

<?php get_footer(); ?>



