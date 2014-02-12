<?php get_header(); ?>

			<div id="content" class="clearfix row">

                <?php wp_nav_menu(array('theme_location'=>'hp_side_menu', 'walker'=> new MR_Child_Only_Walker(), 'depth'=>2)) //hp_side_nav(); //get_sidebar(); // sidebar 1 ?>


				<div id="main" class="col-sm-8 clearfix" role="main">




                    <?php

                    /**
                     * @var wpdb $post
                     */


                    // Call class:
                    /*$My_Walker = new Bootstrap_walker();

                    $args = array(
                        //'walker'      => $My_Walker,
                        'depth' =>4

                    );

                    wp_list_pages( $args );*/





                    /*echo '<pre>';
                    var_dump($post->ID);
                    echo '</pre>';

                    $parent = get_top_parent_page_id();*/

                    /*$args = array(
                        'walker' => new My_Custom_Walker(),
                        'depth' => 1,
                        'child_of' => $parent
                    );
                    wp_list_pages($args);*/



                    ?>


                    <?php
                    if($post->post_parent)
                        $children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0");
                    else
                        $children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0");
                    if ($children) { ?>
                        <ul>
                            <?php echo $children; ?>
                        </ul>
                    <?php } ?>



					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

					<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

						<header>

							<div class="page-header"><h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1></div>

						</header> <!-- end article header -->

						<section class="post_content clearfix" itemprop="articleBody">
							<?php the_content(); ?>

						</section> <!-- end article section -->

						<footer>

							<?php the_tags('<p class="tags"><span class="tags-title">' . __("Tags","wpbootstrap") . ':</span> ', ', ', '</p>'); ?>

						</footer> <!-- end article footer -->

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

				</div> <!-- end #main -->



			</div> <!-- end #content -->

<?php get_footer(); ?>