

      <!--SIDE BAR-->

      <?php //wp_nav_menu(array('theme_location' => 'hp_side_menu', 'walker' => new MR_Child_Only_Walker(), 'depth' => 2)) //hp_side_nav(); //get_sidebar(); // sidebar 1 ?>

<?php //get_sidebar(); // sidebar 1 ?>

<?php
if ($post->post_parent)
    $children = wp_list_pages("title_li=&child_of=" . $post->post_parent . "&echo=0");
else
    $children = wp_list_pages("title_li=&child_of=" . $post->ID . "&echo=0");
if ($children) {
    ?>
    <!--responsive nav-->
    <div class="navbar">
        <ul class="nav nav-pills nav-stacked span2">
            <?php echo $children; ?>
        </ul>
    </div>
<?php } ?>

