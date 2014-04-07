<footer role="contentinfo" class="">
  <div class="black">
  <div class="container">
    <div id="inner-footer" class="clearfix row">

      <div id="widget-footer" class="clearfix row">
		            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer1') ) : ?>
		            <?php endif; ?>
		            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer2') ) : ?>
		            <?php endif; ?>
		            <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footer3') ) : ?>
		            <?php endif; ?>
		          </div>

      <div class="col-md-6 col-xs-6">
        <nav class="nav clearfix">
        <p class="footer-title">herbert pixner</p>
        <?php //wp_bootstrap_footer_links(); // Adjust using Menus in Wordpress Admin ?>
        <?php mr_footer_menu(); // Adjust using Menus in Wordpress Admin ?>
      </nav>
      </div>

      <!--					<p class="pull-right"><a href="http://320press.com" id="credit320" title="By the dudes of 320press">320press</a></p>-->
      <div class="col-md-6 col-xs-6">
        <div class="clearfix socials">

                        <a href="https://de-de.facebook.com/herbertpixnerprojekt" style="color:white;"><span class="fa-stack fa-lg fa-2x pull-right">
                          <!--<i class="fa fa-square-o fa-stack-2x"></i>-->
                          <i class="fa fa-facebook fa-stack-1x white"></i>
                        </span></a>
                        <a href="https://twitter.com/HerbertPixner" style="color:white;"><span class="fa-stack fa-lg fa-2x pull-right">
                          <!--<i class="fa fa-square-o fa-stack-2x"></i>-->
                          <i class="fa fa-twitter fa-stack-1x white"></i>
                        </span></a>
        </div>
        <div class="text-right">

          <address>
            Herbert Pixner<br/>
            Dreiheiligenstrasse 21<br/>
            6020 Innsbruck
          </address>
          <address>
            <a href="mailto:#">info@herbert-pixner.com</a><br/>

          </address>
        </div>
      </div> <!--end col-->

    </div> <!-- end #inner-footer -->

  </div> <!--end container div-->
  </div>
</footer> <!-- end footer -->

<!--[if lt IE 7 ]>
<script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
<script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->

<?php wp_footer(); // js scripts are inserted using this function ?>

</body>

</html>