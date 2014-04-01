<?php get_header(); //get_header_image()?>

<div class="container">
<div id="content" class="clearfix row">

    <div id="sidebar1" class="col-sm-2 col-sm-offset-1" role="complementary">
    <?php require_once('sidebar1.php'); ?>
    </div>
    <!--END SIDEBAR-->
    <div class="col-sm-8">



        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope
                     itemtype="http://schema.org/BlogPosting">

                <header>

                    <!--<div class="page-header"><h1 class="page-title" itemprop="headline">-->
                    <?php //the_title(); ?><!--</h1></div>-->

                </header>
                <!-- end article header -->

                <section class="post_content clearfix" itemprop="articleBody">
                    <?php the_content(); ?>

                    <div class="galerie">
                        <?php
												// Bildergalerie
                        $rows = get_field('bildergalerie');
                        //echo count($rows[0]);
/*                                echo '<pre>';
                                var_dump($rows[0]);
                                echo '</pre>';*/
                        if ($rows) {
                            echo '<ul>';

                            foreach ($rows as $row) {


//                                $image = wp_get_attachment_image_src($row['galeriebild'], 'thumbnail');
                                echo '<img src="' . $row['bild']['sizes']['medium'] . '" />';
                                //echo '<li>sub_field_1 = ' . '' .'</li>'; // . ', sub_field_2 = ' . $row['sub_field_2'] .', etc</li>';
                            }

                            echo '</ul>';
                        }?>

                    </div>


                </section>
                <!-- end article section -->


                <footer>

                    <?php the_tags('<p class="tags"><span class="tags-title">' . __("Tags", "wpbootstrap") . ':</span> ', ', ', '</p>'); ?>

                </footer>
                <!-- end article footer -->

            </article> <!-- end article -->



        <?php endwhile; ?>

        <?php else : ?>

            <article id="post-not-found">
                <header>
                    <h1><?php _e("Not Found", "wpbootstrap"); ?></h1>
                </header>
                <section class="post_content">
                    <p><?php _e("Sorry, but the requested resource was not found on this site.", "wpbootstrap"); ?></p>
                </section>
                <footer>
                </footer>
            </article>

        <?php endif; ?>

</div>

</div>
<!-- content -->
</div>
<!-- container -->

<?php get_footer(); ?>