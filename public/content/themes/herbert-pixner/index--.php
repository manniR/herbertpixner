<?php get_header(); //get_header_image()?>

<div class="container">
<div id="content" class="clearfix row">

    <div id="sidebar1" class="col-sm-3" role="complementary">
    <?php require_once('sidebar1.php'); ?>
    </div>
    <!--END SIDEBAR-->
    <div class="col-xs-9">



    <div class="col-sm-3 col-xs-12">
      <a href="<?= get_stylesheet_directory_uri() ?>/img/01.jpg" class="gallery">
        <img class="thumbnail img-responsive" src="<?= get_stylesheet_directory_uri() ?>/img/01_thumb.jpg" alt="...">
      </a>
    </div>
    <div class="col-sm-3 col-xs-12">
      <a href="<?= get_stylesheet_directory_uri() ?>/img/02.jpg" class="gallery ">
        <img class="thumbnail img-responsive" src="<?= get_stylesheet_directory_uri() ?>/img/02_thumb.jpg" alt="...">
      </a>
    </div>
    <div class="col-sm-3 col-xs-12">
      <a href="<?= get_stylesheet_directory_uri() ?>/img/03.jpg" class="gallery ">
        <img class="thumbnail img-responsive" src="<?= get_stylesheet_directory_uri() ?>/img/03_thumb.jpg" alt="...">
      </a>
    </div>
    <div class="col-sm-3 col-xs-12">
      <a href="<?= get_stylesheet_directory_uri() ?>/img/04.jpg" class="gallery ">
        <img class="thumbnail img-responsive" src="<?= get_stylesheet_directory_uri() ?>/img/04_thumb.jpg" alt="...">
      </a>
    </div>
  </div>

  <div class="row">
    <article class="col-lg-4">
      <header><h1>Heading</h1>

        <p>Lorem ipsum dolor</p>

        <p></p>
      </header>
      <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor
        mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna
        mollis euismod. Donec sed odio dui. </p>
      <a class="btn btn-default" href="#">View details &raquo;</a>
    </article>
    <article class="col-lg-4">
      <h1>Heading</h1>

      <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris
        condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis
        euismod. Donec sed odio dui. </p>

      <p><a class="btn btn-default" href="#">View details &raquo;</a></p>
    </article>
    <article class="col-lg-4">
      <h1>Heading</h1>

      <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula
        porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut
        fermentum massa justo sit amet risus.</p>

      <p><a class="btn btn-default" href="#">View details &raquo;</a></p>
    </article>
  </div>

</div>

</div>
<!-- content -->
</div>
<!-- container -->
<hr>

<?php get_footer(); ?>