<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!-->
<html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title><?php
		        echo bloginfo('name');
		        if ($post->post_parent) {
				        echo ' '.get_the_title($post->post_parent);

		            wp_title('|', true, 'left');
		        } else {
				        wp_title('|', true, 'left');
		        };
		  ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- media-queries.js (fallback) -->
  <!--[if lt IE 9]>
  <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
  <![endif]-->

  <!-- html5.js -->
  <!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

  <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

  <!-- wordpress head functions -->
  <?php wp_head(); ?>
  <!-- end of wordpress head -->

  <style>
    body {
      /*padding-top: 50px;
      padding-bottom: 20px;*/
    }
  </style>

</head>
<body <?php body_class(); ?>>
<!--[if lt IE 7]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade
  your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to
  improve your experience.</p>
<![endif]-->

<header>
  <div class="relative-position">
      <?php if (is_front_page()): ?>
        <!--front page header -->
        <img class="header-image img-responsive" src="<?= get_stylesheet_directory_uri() ?>/img/herbert-pixner-header.jpg" alt=""/>
<!--        <div class="header-title-svg"><img src="--><?//= get_stylesheet_directory_uri()?><!--/img/herbert-pixner.svg" alt=""/></div>-->
        <div class="site-header-title"><h1 class="logo home">herbert pixner</h1></div>
      <?php else: ?>
		      <?php if(is_page()): ?>
      <?php if(is_page( 'projekt' ) || '5' == $post->post_parent): ?>
        <img class="header-image img-responsive" src="<?= get_stylesheet_directory_uri() ?>/img/herbert-pixner-projekt-header210.jpg" alt=""/>
<!--        <div class="header-title-svg"><img src="--><?//= get_stylesheet_directory_uri()?><!--/img/herbert-pixner-projekt.svg" alt=""/></div>-->
				<div class="site-header-title"><h1 class="logo projekt">herbert pixner projekt</h1></div>
      <?php endif; ?>
      <?php if(is_page( 'offroad' ) || '2' == $post->post_parent): ?>
        <img class="header-image img-responsive" src="<?= get_stylesheet_directory_uri() ?>/img/herbert-pixner-offroad-header210.jpg" alt=""/>
<!--        <div class="header-title-svg"><img src="--><?//= get_stylesheet_directory_uri()?><!--/img/herbert-pixner-offroad.svg" alt=""/></div>-->
				<div class="site-header-title"><h1 class="logo offroad">herbert pixner offroad</h1></div>
      <?php endif; ?>
      <?php if(is_page( 'three-saints-records' ) || '7' == $post->post_parent): ?>
        <img class="header-image img-responsive" src="<?= get_stylesheet_directory_uri() ?>/img/three-saints-records-header210.jpg" alt=""/>
<!--        <div class="header-title-svg"><img src="--><?//= get_stylesheet_directory_uri()?><!--/img/three-saints-records.svg" alt=""/></div>-->
				<div class="site-header-title"><h1 class="logo three-saints">three saints records</h1></div>
      <?php endif; ?>
      <?php if(is_page( 'pixner-privat' )): ?>
        <img class="header-image img-responsive" src="<?= get_stylesheet_directory_uri() ?>/img/herbert-pixner-projekt-header210.jpg" alt=""/>
<!--        <div class="header-title-svg"><img src="--><?//= get_stylesheet_directory_uri()?><!--/img/herbert-pixner.svg" alt=""/></div>-->
				<div class="site-header-title"><h1 class="logo privat">pixner privat</h1></div>
      <?php endif; ?>

			<?php endif; //end if page ?>
      <?php endif; ?>



<?php
//echo $post->post_parent;
//echo 'SLUG:::::::' . basename(get_permalink());
?>


</div>
  </div>
<div class="container">

  <div class="header-feature row">

      <div class="col-md-11 col-md-offset-1 col-sm-offset-0 col-sm-12">
  <div class="navbar navbar-default">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <!--<a class="navbar-brand" href="#">Project name</a>-->

      <div class="navbar-collapse collapse paddLR0">

            <?php wp_bootstrap_main_nav();//test_nav(); // Adjust using Menus in Wordpress Admin ?>

      </div>
      <!--/.navbar-collapse -->


      </div>
  </div>
  </div>
</header>