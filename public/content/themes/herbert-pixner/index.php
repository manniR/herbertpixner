<?php get_header(); get_header_image()?>

  <!-- Main jumbotron for a primary marketing message or call to action -->
  <div class="jumbotron">
    <div class="container">
      <h1>Hello, world!</h1>

      <p>This is a template for a simple marketing or informational website. It includes a large callout called
        the hero unit and three supporting pieces of content. Use it as a starting point to create something
        more unique.</p>

      <p><a class="btn btn-primary btn-lg">Learn more &raquo;</a></p>
    </div>
  </div>


<div class="container">
  <!-- Example row of columns -->
  <div class="row">
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
<!-- /container -->

<hr>

<?php get_footer(); ?>