<?php
/**
 * Plugin Name: blueimp lightbox
 * Plugin URI: http://blueimp.github.io/Gallery/
 * Description: Official blueimp Gallery lightbox for Wordpress.
 * Version: 1.0.1
 * Text Domain: blueimp-lightbox
 * Domain Path: /lang
 * Author: Sebastian Tschan
 * Author URI: https://blueimp.net/
 * License: GPLv2 or later
 */

require(dirname(__FILE__).'/lib/class-blueimp-lightbox.php');
new Blueimp_Lightbox(__FILE__);
