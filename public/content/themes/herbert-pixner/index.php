<?php get_header(); //get_header_image()?>

<div class="container">
<div id="content" class="clearfix row">



  <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
      <!-- do stuff ... -->
    <?php endwhile; ?>
  <?php endif; ?>


</div>
<!-- content -->
</div>
<!-- container -->


<?php get_footer(); ?>