<?php
/*
Plugin Name: Image Pro
Plugin URI: http://www.mihaivalentin.com/image-pro-wordpress-image-management/
Description: WordPress media & images management done right!
Author: Mihai Valentin
Version: 0.31
Author URI: http://www.mihaivalentin.com/
*/

/*  Copyright 2012  Mihai Valentin  (email : http://www.mihaivalentin.com/about-me/)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* load external components */
require_once('src/thumb/phpthumb.class.php');
require_once('src/klogger/klogger.php');

/* load plugin classes */
require_once('src/base.php');
require_once('src/log.php');
require_once('src/pathsmanager.php');
require_once('src/paths/default.php');
require_once('src/requirements.php');
require_once('src/folder.php');
require_once('src/editor.php');
require_once('src/thumbs.php');

class impro {

    /* holding the version of the plugin */
    private static $version;

	/**
	 * Initializes the Image Pro plugin
	 */
	public static function init() {
		/* init browser support */
		impro_requirements::initRequirements();
		
		/* init logging (will be in plugin/logs/impro.log) */
		impro_log::initLogging();

		/* setup the paths */
		impro_paths_manager::initPaths();
			
		/* use the plugin only if in post/page editing and browser is supported */
		if (self::isPostPage() && impro_requirements::isBrowserSupported()) {
			add_action("admin_print_footer_scripts", array('impro',"do_scripts"));
			add_action('add_meta_boxes', array('impro_editor','init'));
			add_action('add_meta_boxes', array('impro_folder','init'));
			impro_thumbs::init();			
		}

        /* get version */
        if (!function_exists('get_plugin_data')) {
            require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
        if (function_exists('get_plugin_data')) {
            $pluginData = get_plugin_data(__FILE__, false, false);
            self::$version = $pluginData['Version'];
        } else {
            self::$version = md5(file_get_contents(__FILE__));
        }

        /* initialize internationalization */
        load_plugin_textdomain('imagepro', false, basename(dirname( __FILE__ )) . '/languages');
	}
	
	/**
	 * Returns if the current page is "New Post/Page" or "Edit Post/Page"
	 * @return Boolean whether is a new/edit post/page
	 */
	public static function isPostPage() {
		global $pagenow;
		return in_array($pagenow, array('post.php', 'post-new.php'));
	}
	
	/**
	 * Callback to out script loading tags for the plugin
	 */
	public static function do_scripts() {
		echo impro_base::js("/src/js/impro.js");
		echo impro_base::inlinejs('impro.url = "' . impro::url() . '";');	// set url to javascript
		echo impro_base::inlinejs('impro.admin_url = "' . get_admin_url() . '";');	// set url to javascript
		echo impro_base::inlinejs('impro.nonce.deleteNonce = "' . wp_create_nonce('impro-delete-attachment') . '"');	
	}
	
	/* these two methods should be here, in this dir, otherwise they would not return correctly */
	public static function path() {return WP_PLUGIN_DIR.'/'.dirname(plugin_basename( __FILE__ ));}
	public static function url() {return WP_PLUGIN_URL.'/'.dirname(plugin_basename( __FILE__ ));}

    /* gets the version of the plugin */
    public static function getVersion() { return self::$version; }
}

impro::init();


