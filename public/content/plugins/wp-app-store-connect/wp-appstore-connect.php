<?php
/*
Plugin Name: WP App Store Connect
Plugin URI: http://softcontent.eu/wp-app-store-connect.html
Description: Show various data for iOS and Mac apps from Apple's app store for any given id. Show top charts within posts or sidebar widgets. Also comes with top lists for other iTunes items (books, movies etc).
Version: 1.2.1
Author: Kai Fenner
Author URI: http://softcontent.eu/wp-app-store-connect.html
License: GPL2
*/

/*  Copyright 2012  Kai Fenner (email : kai@appdamit.de)

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

	global $wp_version;
	if (version_compare($wp_version, "2.6", "<")) {
		  exit('WP App Store Connect require WordPress 2.6 or newer. <a href="http://codex.wordpress.org/Upgrading_WordPress">Please update!</a>');
	  }

	require_once("lib/functions_common.php");
	#require_once("lib/functions_appstore.php");
	  
	# Avoid name collisions.
	if (!class_exists('WP_App_Store_Connect')) {
	  class WP_App_Store_Connect
	  {
		  # this variable will hold url to the plugin  
		  var $plugin_url;
		  
		  # name for our options in the DB
		  var $db_option = 'WP_App_Store_Connect_Options';

          # Initialize the plugin
          function WP_App_Store_Connect()
          {
              $this->plugin_url = trailingslashit( WP_PLUGIN_URL . '/' .dirname ( plugin_basename(__FILE__) ) );
              
              # add shortcode handler
              add_shortcode('appstore', array(&$this, 'AppStoreInfos'));

              # add shortcode handler
              add_shortcode('apptoplist', array(&$this, 'AppTopList'));

              # add options Page
              add_action('admin_menu', array(&$this, 'admin_menu'));
			  
			  # add CSS stylesheet
			  add_action('wp_enqueue_scripts', array(&$this, 'add_my_stylesheet'));
			  
			  add_action('init', array(&$this, 'WPAppStoreConnect_WidgetInit'));

			  add_action('init', array(&$this,'add_wpasc_mce_button'));
			  
			  if (strpos($_SERVER['REQUEST_URI'], 'wp-appstore-connect.php' ) == true) 
				{
				add_action('admin_head', array(&$this, 'my_admin_head'));
				add_action('admin_init', array(&$this, 'add_jquery'));
				}
              
          }

		function add_wpasc_mce_button() {
		   if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			 return;
		   if ( get_user_option('rich_editing') == 'true') {
			 add_filter('mce_external_plugins', array(&$this,'add_wpasc_mce_tinymce_plugin'));
			 add_filter('mce_buttons', array(&$this,'register_wpasc_mce_button'));
		   }
		}		  

		function register_wpasc_mce_button($buttons) {
		   array_push($buttons, "|", "btnWPASCAppData", "btnWPASCAppCharts");
		   return $buttons;
		}

		function add_wpasc_mce_tinymce_plugin($plugin_array) {
		   $plugin_array['wpasc_mce'] = $this->plugin_url . '/js/mce_plugin.js';
		   return $plugin_array;
		}
		
		function add_jquery()
		{
			wp_enqueue_script('jquery');
            wp_enqueue_script('charts', WP_CONTENT_URL. '/plugins/wp-app-store-connect/js/charts.js');
            wp_enqueue_script('iacw', WP_CONTENT_URL. '/plugins/wp-app-store-connect/js/jquery.iacw.js');
		}
		  
		  function my_admin_head() {
           echo '<link rel="stylesheet" type="text/css" href="' . plugins_url('wp-appstore-connect-admin.css', __FILE__). '">';
		  }
		  
		  function WPAppStoreConnect_WidgetInit(){
			register_sidebar_widget('WP App Store Connect', array(&$this, 'WPAppStoreConnect_Widget'));
		  }

		  function WPAppStoreConnect_Widget($args){

			$options = $this->get_options();

			echo $args['before_widget'];
			if ($options['widgettitle']) {echo $args['before_title'] . $options['widgettitle'] . $args['after_title'];}

			if ($options['appstoreconnect_chart_type'] == '') {$options['appstoreconnect_chart_type'] = 'topfreeapplications';}

			echo $this->AppTopList(array(
				'store' => $options['storecountry'],
				'limit' => $options['itemdisplay'],
				'list' => $options['appstoreconnect_chart_type'],
				'genre' => $options['appstoreconnect_chart_category'],
				'style' => $options['widgetstyle']

			)
			);

			echo $args['after_widget'];
			
		  }
		  
          # hook the options page
          function admin_menu()
          {
              add_options_page('WP App Store Connect Options', 'WP App Store Connect', "manage_options", basename(__FILE__), array(&$this, 'handle_options'));
          }

          function scripts_action()
          {
              $options = $this->get_options();
              
          }

          # handle plugin options
          function get_options()
          {

			# load default html templates
			include plugin_dir_path( __FILE__ ) . '/lib/default_html.php';

			# default values
              $options = array(
					'style' => 'infobox',
					'stylefull' => $stylefull,
					'styleinfobox' => $styleinfobox,
					'stylesmallbox' => $stylesmallbox,
					'stylecustombox1' =>  '',
					'stylecustombox2' =>  '',
					'stylecustombox3' =>  '',
					'stylecustombox4' =>  '',
					
					'listitemdisplay' => '10',
					'liststyle' => 'liststyle1',
					'liststyle1' => $liststyle1,
					'liststyle2' => '',
					'liststyle3' => '',
					'liststyle4' => '',
					
					'widgettitle' => 'App Store Charts',
					'itemdisplay' => '10',
					'appstoreconnect_chart_section' => 'iOS Apps',
					'appstoreconnect_chart_type' => 'toppaidapplications',
					'appstoreconnect_chart_category' => '',
					'widgetstyle' => 'style1',
					'widgetstyle1' => $widgetstyle1,
					'widgetstyle2' => $widgetstyle2,
					'widgetstyle3' => $widgetstyle3,
					'widgetstyle4' => '',

					'storecountry' => 'US',
					'dateformat' => 'DD.MM.YYYY',
					'txtisuniversalapp' => 'This app is designed for both iPhone and iPad',
					'txtfreeprize' => 'free',
					'imgitunesbutton' => 'http://YOURBLOG.COM/wp-content/plugins/wp-app-store-connect/img/viewinitunes_en.png',
					'gallerytype' => 'with Thumbnails',
					'screenshotsubheadline' => '<h3>Screenshots %IMAGETITLE%</h3>',
					'screenshotsubheadlineipad' => '<h3>Screenshots %IMAGETITLE% for iPad</h3>',
					'starrate_color' => 'yellow',
					'affiliateprogram' => '',
					'affiliateid' => '',
					'customhtmlscreenshotsbefore' => '<table><tr>',
					'customhtmlscreenshots' => '<td><a href="%IMAGE%" target="_blank">
<img %RESIZE% src="%IMAGE%" title="%IMAGETITLE%"></a></td>',
					'customhtmlscreenshotsafter' => '</tr></table>',
					'maxscreenshots' => '',
					'resizemaxwidth' => '400',
					'resizemaxheight' => '400'

					);

			  # get saved options
              $saved = get_option($this->db_option);
              
              # assign them
              if (!empty($saved)) {
                  foreach ($saved as $key => $option)
                      $options[$key] = $option;
              }
              
              # update the options if necessary
              if ($saved != $options)
                  update_option($this->db_option, $options);
              
              # return the options  
              return $options;
          }
          
          # Set up everything
          function install()
          {
              # set default options
              $this->get_options();
          }

          # handle the admin options page
          function handle_options()
          {
				# load constants for country codes and supported devices
				include plugin_dir_path( __FILE__ ) . 'constants.php';

				$options = $this->get_options();

              if (isset($_POST['submitted'])) {
              		
              	  # check security
              	  check_admin_referer('wp-app-store-connect', 'wp-app-store-connect-nonce');
              		
				  # update option
				  $options = array();

                  $options['style'] = $_POST['style'];
                  $options['stylefull'] = stripslashes($_POST['stylefull']);
                  $options['styleinfobox'] = stripslashes($_POST['styleinfobox']);
                  $options['stylesmallbox'] = stripslashes($_POST['stylesmallbox']);
                  $options['stylecustombox1'] = stripslashes($_POST['stylecustombox1']);
                  $options['stylecustombox2'] = stripslashes($_POST['stylecustombox2']);
                  $options['stylecustombox3'] = stripslashes($_POST['stylecustombox3']);
                  $options['stylecustombox4'] = stripslashes($_POST['stylecustombox4']);

				  $options['listitemdisplay'] = $_POST['listitemdisplay'];
				  $options['liststyle'] = $_POST['liststyle'];
				  $options['liststyle1'] = stripslashes($_POST['liststyle1']);
				  $options['liststyle2'] = stripslashes($_POST['liststyle2']);
				  $options['liststyle3'] = stripslashes($_POST['liststyle3']);
				  $options['liststyle4'] = stripslashes($_POST['liststyle4']);
				  
                  $options['widgettitle'] = $_POST['widgettitle'];
				  $options['itemdisplay'] = $_POST['itemdisplay'];
				  $options['appstoreconnect_chart_section'] = $_POST['appstoreconnect_chart_section'];
				  $options['appstoreconnect_chart_type'] = $_POST['appstoreconnect_chart_type'];
				  $options['appstoreconnect_chart_category'] = $_POST['appstoreconnect_chart_category'];
				  $options['widgetstyle'] = $_POST['widgetstyle'];
				  $options['widgetstyle1'] = stripslashes($_POST['widgetstyle1']);
				  $options['widgetstyle2'] = stripslashes($_POST['widgetstyle2']);
				  $options['widgetstyle3'] = stripslashes($_POST['widgetstyle3']);
				  $options['widgetstyle4'] = stripslashes($_POST['widgetstyle4']);

                  $options['storecountry'] = $_POST['storecountry'];
                  $options['affiliateprogram'] = $_POST['affiliateprogram'];
                  $options['affiliateid'] = $_POST['affiliateid'];
                  $options['dateformat'] = $_POST['dateformat'];
                  $options['txtisuniversalapp'] = $_POST['txtisuniversalapp'];
                  $options['txtfreeprize'] = $_POST['txtfreeprize'];
                  $options['imgitunesbutton'] = $_POST['imgitunesbutton'];
                  $options['gallerytype'] = $_POST['gallerytype'];
				  $options['screenshotsubheadline'] = $_POST['screenshotsubheadline'];
				  $options['screenshotsubheadlineipad'] = $_POST['screenshotsubheadlineipad'];
                  $options['starrate_color'] = $_POST['starrate_color'];
                  $options['maxscreenshots'] = $_POST['maxscreenshots'];
                  $options['resizemaxwidth'] = $_POST['resizemaxwidth'];
                  $options['resizemaxheight'] = $_POST['resizemaxheight'];
                  $options['customhtmlscreenshotsbefore'] = stripslashes($_POST['customhtmlscreenshotsbefore']);
                  $options['customhtmlscreenshots'] = stripslashes($_POST['customhtmlscreenshots']);
                  $options['customhtmlscreenshotsafter'] = stripslashes($_POST['customhtmlscreenshotsafter']);

                  update_option($this->db_option, $options);
                  
                  echo '<div class="updated fade"><p>Plugin settings saved.</p></div>';

			  }
              
			  # store options
              $style = $options['style'];
              $stylefull = $options['stylefull'];
              $styleinfobox = $options['styleinfobox'];
              $stylesmallbox = $options['stylesmallbox'];
              $stylecustombox1 = $options['stylecustombox1'];
              $stylecustombox2 = $options['stylecustombox2'];
              $stylecustombox3 = $options['stylecustombox3'];
              $stylecustombox4 = $options['stylecustombox4'];

			  $listitemdisplay = $options['listitemdisplay'];
			  $liststyle = $options['liststyle'];
			  $liststyle1 = $options['liststyle1'];
			  $liststyle2 = $options['liststyle2'];
			  $liststyle3 = $options['liststyle3'];
			  $liststyle4 = $options['liststyle4'];
			  
              $widgettitle = $options['widgettitle'];
              $itemdisplay = $options['itemdisplay'];
			  $appstoreconnect_chart_section = $options['appstoreconnect_chart_section'];
			  $appstoreconnect_chart_type = $options['appstoreconnect_chart_type'];
			  $appstoreconnect_chart_category = $options['appstoreconnect_chart_category'];
			  $widgetstyle = $options['widgetstyle'];
			  $widgetstyle1 = $options['widgetstyle1'];
			  $widgetstyle2 = $options['widgetstyle2'];
			  $widgetstyle3 = $options['widgetstyle3'];

              $storecountry = $options['storecountry'];
              $affiliateprogram = $options['affiliateprogram'];
              $affiliateid = $options['affiliateid'];
			  $dateformat = $options['dateformat'];
              $txtisuniversalapp= $options['txtisuniversalapp'];
              $txtfreeprize = $options['txtfreeprize'];
              $imgitunesbutton = $options['imgitunesbutton'];
			  $gallerytype = $options['gallerytype'];
			  $screenshotsubheadline = $options['screenshotsubheadline'];
			  $screenshotsubheadlineipad = $options['screenshotsubheadlineipad'];
			  $starrate_color = $options['starrate_color'];
			  $maxscreenshots = $options['maxscreenshots'];
			  $resizemaxwidth = $options['resizemaxwidth'];
			  $resizemaxheight = $options['resizemaxheight'];
 			  $customhtmlscreenshotsbefore = $options['customhtmlscreenshotsbefore'];
 			  $customhtmlscreenshots = $options['customhtmlscreenshots'];
 			  $customhtmlscreenshotsafter = $options['customhtmlscreenshotsafter'];

              # URL for form submit, equals our current page
              $action_url = $_SERVER['REQUEST_URI'];

              # include admin page
			  include(plugin_dir_path( __FILE__ ) . 'wp-appstore-connect-admin.php');
          }		  

		  # main function to retrieve app store data
		  function AppStoreInfos($atts){

				# plugin directory
				$myDir = plugins_url('/', __FILE__);;

				# load constants for country codes and supported devices
				include plugin_dir_path( __FILE__ ) . 'constants.php';

				# get plugin options from admin page
			  $options = $this->get_options();

			  # get options from shortcode
			  extract(shortcode_atts( array(
					'id' => "343200656", # in case app id is omitted
					'store' => $options['storecountry'],
					'style' => $options['style'],
					'printtemplate' => 'no'
				), $atts ));

				# store is
				# -> from shortcode
				# -> if omitted from admin options
				# -> if omitted = 'US'
				if ($store == '') {$store = 'US';}

				# get html-template based on selected style
				# -> from shortcode
				# -> if omitted from admin options
				# -> if omitted = 'infobox'

				$ShowAdLink = true;
				
				switch ($style) {
					case "infobox";
						$html = $options['styleinfobox'];
						break;
					case "full";
						$html = $options['stylefull'];
						break;
					case "smallbox";
						$html = $options['stylesmallbox'];
						$ShowAdLink = false;
						break;
					case "custombox1";
						$html = $options['stylecustombox1'];
						$ShowAdLink = false;
						break;
					case "custombox2";
						$html = $options['stylecustombox2'];
						$ShowAdLink = false;
						break;
					case "custombox3";
						$html = $options['stylecustombox3'];
						$ShowAdLink = false;
						break;
					case "custombox4";
						$html = $options['stylecustombox4'];
						$ShowAdLink = false;
						break;
					case '';
						$html = $options['styleinfobox'];
						break;
					default;
						$ShowAdLink = false;
						$html = $style;
				  };

				if ($printtemplate == "yes")
					{
					# load html templates
					include plugin_dir_path( __FILE__ ) . 'lib/default_html.php';
					switch ($style) {
						case "infobox";
							$html = $styleinfobox;
							break;
						case "full";
							$html = $stylefull;
							break;
						case "smallbox";
							$html = $stylesmallbox;
							break;
						}
					$html = preg_replace('/</', '&lt;', $html);
					$html = preg_replace('/>/', '&gt;', $html);
					return nl2br('<div style="background-color:lightYellow;border:10px solid #EEE;padding:10px;font-family:monospace;font-size:12px;color:#0000C0;">'.$html.'</div>');
					}
				  
				# get the iTunes data 
				$search_term = 'id=' .  $id;
				$search_term = $search_term . '&country=' . $store;
				$app_url = 'http://itunes.apple.com/lookup?' . $search_term;
				$itunes_data = trim(get_final_url ($app_url));

				# decode the JSON string returned 
				# http://jsonformatter.curiousconcept.com/
				$itunes_data = json_decode("$itunes_data",true);

				# retrieve data from array
				$data = array(
				"%CURRENCY%" => $itunes_data["results"][0]["currency"],
				"%PRICE%" => $itunes_data["results"][0]["price"],
				"%DEVELOPERNAME%" => $itunes_data["results"][0]["artistName"],
				"artistiD" => $itunes_data["results"][0]["artistiD"],
				"%VERSION%" => $itunes_data["results"][0]["version"],
				"%RELEASEDATE%" => $this->make_AppStoreDate($itunes_data["results"][0]["releaseDate"], 'DD.MM.YYYY'),
				"%FILESIZE%" =>  round(($itunes_data["results"][0]["fileSizeBytes"] / 1048576 ), 2) . " MB",
				"%DEVELOPERURL%" => $itunes_data["results"][0]["sellerUrl"],
				"%RATING%" => '<img src="' . $myDir . 'img/rating_' . $options['starrate_color'] . '_' . ($itunes_data["results"][0]["averageUserRating"] * 2) . '.gif" width="55" height="11">',
				"%RATINGVALUE%" => $itunes_data["results"][0]["averageUserRating"],
				"%RATINGCOUNT%" => $itunes_data["results"][0]["userRatingCount"],
				"trackViewUrl" => $itunes_data["results"][0]["trackViewUrl"],
				"%APPNAME%" => $itunes_data["results"][0]["trackName"],
				"%ICONURL%" => $itunes_data["results"][0]["artworkUrl512"],
				"%DESCRIPTION%" => $itunes_data["results"][0]["description"],
				"%CONTENTRATING%" => $itunes_data["results"][0]["contentAdvisoryRating"],
				"%RELEASENOTES%" => $itunes_data["results"][0]["releaseNotes"]
				);

				if ($data['%PRICE%'] == '0' && $options['txtfreeprize']) {$data['%PRICE%'] = $options['txtfreeprize']; $data['%CURRENCY%'] = '';}
				
				# Make affiliate link if a tradedoubler website id has been configured.
				# The syntax is
				# http://clkde.tradedoubler.com/click?p=23761&a=XXXXXX&url=iTunes Store URL&partnerId=2003
				# where 'XXXXXX' is the website id
				# and iTunes Store URL the link to the iTunes Srore item.
				$data["trackViewUrl"] = $this->make_Affiliate_Link($options['affiliateprogram'], $affiliate_programs[$options['affiliateprogram']], $options['affiliateid'], $data["trackViewUrl"], $itunes_data["results"][0]["trackId"]);

				# app description
				$data["%DESCRIPTION%"] = preg_replace("/\\n/", "<br />",$data["%DESCRIPTION%"]);
				if (preg_match("/%DESCRIPTION<(\d.*?)>%/", $html, $matches))
					{
					$description_length = $matches[1];
					$data["%DESCRIPTION%"] = preg_replace("#(?<=.{".$description_length."}?\\b)(.*)#is", "", $data["%DESCRIPTION%"], 1);
					}
				$data["%DESCRIPTION%"] = $this->linker($data["%DESCRIPTION%"]);
				
				# app release notes
				$data["%RELEASENOTES%"] = preg_replace("/\\n/", "<br />",$data["%RELEASENOTES%"]);
				if (preg_match("/%RELEASENOTES<(\d.*?)>%/", $html, $matches))
					{
					$releasenotes_length = $matches[1];
					$data["%RELEASENOTES%"] = preg_replace("#(?<=.{".$releasenotes_length."}?\\b)(.*)#is", "", $data["%RELEASENOTES%"], 1);
					}
				$data["%RELEASENOTES%"] = $this->linker($data["%RELEASENOTES%"]);

				# is universal app or not
				if (isset($itunes_data["results"][0]["features"]))
					{
					if (in_array("iosUniversal", $itunes_data["results"][0]["features"]))
						{
						$iosUniversal = '<img src="' . $myDir . 'img/universalapp.gif" width="10" height="10" title="' . $options['txtisuniversalapp'] . '">' . $options['txtisuniversalapp'];
						}
					}
				
				
				# app languages
				if (isset($itunes_data["results"][0]["languageCodesISO2A"])) {
				foreach ($itunes_data["results"][0]["languageCodesISO2A"] as $lang)
				{
					if ($country_codes[$lang])
						{
						if ($store == "DE") {$lang = $country_codes[$lang]['language2'];}
						else {$lang = $country_codes[$lang]['language1'];}
						}
					$languages .= $lang . ", ";
				}
				$languages = preg_replace("/, $/", "", $languages);
				}

				# app supported devices
				if (isset($itunes_data["results"][0]["supportedDevices"])) {
				foreach ($itunes_data["results"][0]["supportedDevices"] as $devices)
				{
					if ($supported_devices[$devices])
					{$supporteddevices .= $supported_devices[$devices] . ", ";}
					else {$supporteddevices .= $devices . ", ";}
				}
				$supporteddevices = preg_replace("/, $/", "", $supporteddevices);
				}
				
				# app categoried
				if (isset($itunes_data["results"][0]["genres"])) {
				foreach ($itunes_data["results"][0]["genres"] as $genre)
				{
					$genres .= $genre . ", ";
				}
				$genres = preg_replace("/, $/", "", $genres);
				}
				
				# link to app store
				$ituneslink = '<img src="' . $options['imgitunesbutton'] . '" title="show in iTunes">';
				$itunesurl = $data["trackViewUrl"];
				$ituneslink = '<a href="' . $itunesurl . '" target="_blank">' . $ituneslink . '</a>';
				
				# app screenshots
				if (isset($itunes_data["results"][0]["screenshotUrls"]))
					{$screenshothtml .= $this->make_ImageGallery($itunes_data["results"][0]["screenshotUrls"], "galleryiPhone", $data['%APPNAME%'], $options['gallerytype'], $options);}
				if (isset($itunes_data["results"][0]["ipadScreenshotUrls"]))
					{$screenshothtml .= $this->make_ImageGallery($itunes_data["results"][0]["ipadScreenshotUrls"], "galleryiPad", $data['%APPNAME%'], $options['gallerytype'], $options);}

				# delimeters for preg_match
				foreach (array_keys($data) as $key)	{$searchpatterns[] = '/' . $key .'/' ;}

				# app icon
				if (preg_match("/%APPICON<(\d.*?)>%/", $html, $matches))
				{
				$artworksize = $matches[1];
				$artwork = '<img src="' . $data["%ICONURL%"] . '" width="' . $artworksize . '" height="' . $artworksize . '" title="' . $data['%APPNAME%'] . '" alt="' . $data['%APPNAME%'] . '" class="wpasc_rounded">';
				}
				
				# put data in html template
				$html = preg_replace("/%DESCRIPTION<$description_length>%/", "%DESCRIPTION%", $html);
				$html = preg_replace("/%RELEASENOTES<$releasenotes_length>%/", "%RELEASENOTES%", $html);
				$html = preg_replace($searchpatterns, $data, $html);

				$html = preg_replace("/%UNIVERSALAPP%/", $iosUniversal, $html);
				$html = preg_replace("/%ITUNESLINK%/", $ituneslink, $html);
				$html = preg_replace("/%ITUNESURL%/", $itunesurl, $html);
				$html = preg_replace("/%SCREENSHOTS%/", $screenshothtml, $html);
				$html = preg_replace("/%APPICON<$artworksize>%/", $artwork, $html);
				$html = preg_replace("/%LANGUAGES%/", $languages, $html);
				$html = preg_replace("/%SUPPORTED%/", $supporteddevices, $html);
				$html = preg_replace("/%CATEGORIES%/", $genres, $html);

				# that's it
				
				if ($ShowAdLink == true) {$html = $html . $this->make_PluginLink();}
				
				return $html;

			}

			# main function to retrieve app store top list
			function AppTopList($atts){

			  $options = $this->get_options();

			  # load constants for country codes and supported devices
			  include plugin_dir_path( __FILE__ ) . 'constants.php';

			  # get options from shortcode
			  extract(shortcode_atts( array(
					'list' => "topfreeapplications",
					'genre' => '',
					'limit' => "10",
					'store' => $options['storecountry'],
					'style' => $options['liststyle'],
					'printtemplate' => 'no'
				), $atts ));

				# store is
				# -> from shortcode
				# -> if omitted from admin options
				# -> if omitted = 'US'
				if ($store == '') {$store = 'US';}				
				
				switch ($style) {
					case "style1";
						$html = $options['widgetstyle1'];
						break;
					case "style2";
						$html = $options['widgetstyle2'];
						break;
					case "style3";
						$html = $options['widgetstyle3'];
						break;
					case "style4";
						$html = $options['widgetstyle4'];
						break;
					case "liststyle1";
						$html = $options['liststyle1'];
						break;
					case "liststyle2";
						$html = $options['liststyle2'];
						break;
					case "liststyle3";
						$html = $options['liststyle3'];
						break;
					case "liststyle4";
						$html = $options['liststyle4'];
						break;
					default;
						$html = $options['liststyle1'];
				  }

				if ($printtemplate == "yes")
					{
					# load html templates
					include plugin_dir_path( __FILE__ ) . 'lib/default_html.php';
					switch ($style) {
						case "style1";
							$html = $widgetstyle1;
							break;
						case "style2";
							$html = $widgetstyle2;
							break;
						case "style3";
							$html = $widgetstyle3;
							break;
						case "liststyle1";
							$html = $liststyle1;
							break;
						}
					$html = preg_replace('/</', '&lt;', $html);
					$html = preg_replace('/>/', '&gt;', $html);
					return nl2br('<div style="background-color:lightYellow;border:10px solid #EEE;padding:10px;font-family:monospace;font-size:12px;color:#0000C0;">'.$html.'</div>');
					}

				if ($limit > 25) {$limit = 25;}
				if ($genre != '') {$genre  = 'genre=' . $genre;}
				$url = 'http://itunes.apple.com/'.$store.'/rss/'.$list.'/limit='.$limit.'/'.$genre.'/xml';
				$result = xml2array(get_final_url($url));

				$output_html = '';
				
				for ($i = 0; $i < count($result["feed"]["entry"]); $i++){

					$curhtml = $html;
					unset($parse);
					$parse = $result["feed"]["entry"][$i];

					$appdate = $this->make_AppStoreDate(htmlentities(addslashes($parse['im:releaseDate']), ENT_QUOTES, 'UTF-8'), $options['dateformat']);

					$appposition = $i + 1;

					$appid = htmlentities(addslashes($parse['id_attr']['im:id']), ENT_QUOTES, 'UTF-8');
					
					$applink = $this->make_Affiliate_Link($options['affiliateprogram'], $affiliate_programs[$options['affiliateprogram']], $options['affiliateid'], htmlentities(addslashes($parse['id']), ENT_QUOTES, 'UTF-8'),  $appid);
					
					$appimage = htmlentities(addslashes($parse['im:image']['0']), ENT_QUOTES, 'UTF-8');
					$appprice = htmlentities(addslashes($parse['im:price']), ENT_QUOTES, 'UTF-8');
					if (preg_match("/\\$/", $appprice)) {$appprice = '\\' . $appprice;}
					$appartist = htmlentities(addslashes($parse['im:artist']), ENT_QUOTES, 'UTF-8');
					$appname = htmlentities(addslashes($parse['im:name']), ENT_QUOTES, 'UTF-8');
					$appcategory = htmlentities(addslashes($parse['category_attr']['label']), ENT_QUOTES, 'UTF-8');
					
					# app icon
					if (preg_match("/APPICON<(\d.*?)>/", $html, $matches))
					{
					$artworksize = $matches[1];
					$appimage = '<img src="' . $appimage . '" width="' . $artworksize . '" height="' . $artworksize . '" title="' . $appname . '" alt="' . $appname . '">';
					}

					# app description
					if (preg_match("/%DESCRIPTION<(\d.*?)>%/", $html, $matches))
					{
					$description_length = $matches[1];
					$appdescription = preg_replace("#(?<=.{".$description_length."}?\\b)(.*)#is", "", htmlentities(addslashes($parse['summary']), ENT_QUOTES, 'UTF-8'), 1);
					}

					# put data in html template
					$curhtml = preg_replace("/%APPID%/", $appid, $curhtml);
					$curhtml = preg_replace("/%POSITION%/", $appposition, $curhtml);
					$curhtml = preg_replace("/%APPNAME%/", $appname, $curhtml);
					$curhtml = preg_replace("/%DEVELOPERNAME%/", $appartist, $curhtml);
					$curhtml = preg_replace("/%APPICON<$artworksize>%/", $appimage, $curhtml);
					$curhtml = preg_replace("/%DESCRIPTION<$description_length>%/", $appdescription, $curhtml);
					$curhtml = preg_replace("/%ITUNESLINK%/", $applink, $curhtml);
					$curhtml = preg_replace("/%PRICE%/", $appprice, $curhtml);
					$curhtml = preg_replace("/%CATEGORY%/", $appcategory, $curhtml);
					$curhtml = preg_replace("/%RELEASEDATE%/", $appdate, $curhtml);

					$output_html .= $curhtml;
					
				}

				$output_html .= $this->make_PluginLink();
				
				$output_html = do_shortcode($output_html);
				
				return $output_html;
		
			}
				
			function make_Affiliate_Link($program, $program_id, $affiliate_id, $app_link, $app_id){

				if ($program == '' || $affiliate_id == '') {return $app_link;}
				
				$Linkshare_Link ='http://click.linksynergy.com/fs-bin/click?id=AFFILIATE_ID&offerid=PROGRAM_ID.APP_ID&type=3&subid=0&tmpid=1826&RD_PARM1=TARGET_URL&partnerId=30';
				$Tradedoubler_Link = 'http://clk.tradedoubler.com/click?p=PROGRAM_ID&a=AFFILIATE_ID&url=TARGET_URL&partnerId=2003';

				if ($program == 'US' || $program == 'CA') {$Return_Link = $Linkshare_Link;} else {$Return_Link = $Tradedoubler_Link;}
				
				$Return_Link = preg_replace("/PROGRAM_ID/", $program_id, $Return_Link);
				$Return_Link = preg_replace("/AFFILIATE_ID/", $affiliate_id, $Return_Link);
				$Return_Link = preg_replace("/APP_ID/", $app_id, $Return_Link);
				$Return_Link = preg_replace("/TARGET_URL/", $app_link, $Return_Link);

				return $Return_Link;
			
			}
			
			
			function make_PluginLink(){
			
			if (preg_match("/appdamit\.de/", WP_PLUGIN_URL)) {return "";}
			
			return '<div style="margin-right:10px;"><p style="text-align:right; font-size: 8pt"><a href="http://www.appdamit.de/" target="_blank">iPhone & iPad Apps</a><a href="http://www.softcontent.eu/wp-app-store-connect.html" target="_blank"> iTunes Plugin</a></p></div>';
			
			}
				
			function make_AppStoreDate($appdate, $datetemplate) {
			
			preg_match('/(\d\d\d\d)-(\d\d)-(\d\d)/', $appdate, $matches);
			
			$datetemplate = preg_replace('/YYYY/', $matches[1], $datetemplate);
			$datetemplate = preg_replace('/MM/', $matches[2], $datetemplate);
			$datetemplate = preg_replace('/DD/', $matches[3], $datetemplate);
			
			return  $datetemplate;
			
			}
				
				
			# make image gallery
			function make_ImageGallery($screenShots, $gallerytype, $imagetitle, $displaytype, $options) {

				if ($options['maxscreenshots'] == 0 || $options['maxscreenshots'] == "") {$options['maxscreenshots']='9999';}

				# sometimes empty array
				if (count($screenShots) == 0) {return;}

				# captions for iPhone & iPad gallery
				if ($gallerytype == "galleryiPad")
					{
						$imagegallery = preg_replace('/%IMAGETITLE%/', $imagetitle, $options['screenshotsubheadlineipad']);
						$imagetitle .= " iPad";
					}
				else
					{
						$imagegallery = preg_replace('/%IMAGETITLE%/', $imagetitle, $options['screenshotsubheadline']);
						$imagetitle .= " iPhone";
					}

				switch ($displaytype) {
					case 'stacked horizontally';
						$options['customhtmlscreenshotsbefore'] = '<p><ul id="wpasc_gallery">';
						$options['customhtmlscreenshots'] = '<li><a href="#"><img src="%IMAGE%" alt="%IMAGETITLE%" title="%IMAGETITLE%"></a></li>';
						$options['customhtmlscreenshotsafter'] = '</ul></p>';
						break;
					case 'with Thumbnails';
						$options['customhtmlscreenshotsbefore'] = '				
<script type="text/javascript">
<!--
function wpasc_ResizeImage(wpasc_Image, wpasc_MaxWidth, wpasc_MaxHeight)
{
var wpasc_ratio = wpasc_Image.height / wpasc_Image.width;
if (wpasc_Image.width > wpasc_MaxWidth)	{wpasc_Image.width = wpasc_MaxWidth; wpasc_Image.height = Math.round(wpasc_MaxWidth * wpasc_ratio);}
if (wpasc_Image.height > wpasc_MaxHeight) {wpasc_Image.height = wpasc_MaxHeight; wpasc_Image.width = Math.round(wpasc_MaxHeight / wpasc_ratio);}
}
//-->
</script>'.'<div class="wpasc_container">';
						$options['customhtmlscreenshots'] = '<a class="wpasc_pics" href="#" tabindex="1"><img class="wpasc_thumb" src="%IMAGE%" width="50" height="50" alt="%IMAGETITLE%" title="%IMAGETITLE%" /><span><img onload="wpasc_ResizeImage(this,'.$options['resizemaxwidth'].','.$options['resizemaxheight'].')" src="%IMAGE%" alt="%IMAGETITLE%" title="%IMAGETITLE%" /></span></a>';
						
						$options['customhtmlscreenshotsafter'] = '</div>';
						break;
					case 'plain Image List';
						$options['customhtmlscreenshotsbefore'] = '				
<script type="text/javascript">
<!--
function wpasc_ResizeImage(wpasc_Image, wpasc_MaxWidth, wpasc_MaxHeight)
{
var wpasc_ratio = wpasc_Image.height / wpasc_Image.width;
if (wpasc_Image.width > wpasc_MaxWidth)	{wpasc_Image.width = wpasc_MaxWidth; wpasc_Image.height = Math.round(wpasc_MaxWidth * wpasc_ratio);}
if (wpasc_Image.height > wpasc_MaxHeight) {wpasc_Image.height = wpasc_MaxHeight; wpasc_Image.width = Math.round(wpasc_MaxHeight / wpasc_ratio);}
}
//-->
</script>';
						$options['customhtmlscreenshots'] = '<img onload="wpasc_ResizeImage(this,'.$options['resizemaxwidth'].','.$options['resizemaxheight'].')" src="%IMAGE%" alt="%IMAGETITLE%" title="%IMAGETITLE%" />';
						$options['customhtmlscreenshotsafter'] = '';
						break;

					default;
						$options['customhtmlscreenshotsbefore'] = '				
<script type="text/javascript">
<!--
function wpasc_ResizeImage(wpasc_Image, wpasc_MaxWidth, wpasc_MaxHeight)
{
var wpasc_ratio = wpasc_Image.height / wpasc_Image.width;
if (wpasc_Image.width > wpasc_MaxWidth)	{wpasc_Image.width = wpasc_MaxWidth; wpasc_Image.height = Math.round(wpasc_MaxWidth * wpasc_ratio);}
if (wpasc_Image.height > wpasc_MaxHeight) {wpasc_Image.height = wpasc_MaxHeight; wpasc_Image.width = Math.round(wpasc_MaxHeight / wpasc_ratio);}
}
//-->
</script>'.$options['customhtmlscreenshotsbefore'];
				  };

				$imagegallery .= $options['customhtmlscreenshotsbefore'];
				$imagecounter=0;
				foreach ($screenShots as $image)
					{
					$imagecounter++;
					if ($imagecounter <= $options['maxscreenshots'])
						{
						$imagehtml = $options['customhtmlscreenshots'];
						$imagehtml = preg_replace('/%IMAGECOUNT%/', $imagecounter, $imagehtml);
						$imagehtml = preg_replace('/%IMAGE%/', $image, $imagehtml);
						$imagehtml = preg_replace('/%IMAGETITLE%/', $imagetitle, $imagehtml);
						$imagehtml = preg_replace('/%RESIZE%/', 'onload="wpasc_ResizeImage(this,'.$options['resizemaxwidth'].','.$options['resizemaxheight'].')"', $imagehtml);
						$imagegallery .= $imagehtml;
						}
					}

				$imagegallery .= $options['customhtmlscreenshotsafter'];

				
				# that's it
				return $imagegallery;

				}

			# enqueue style-file, if it exists.
			function add_my_stylesheet()
			{
				$myStyleUrl = plugins_url('style.css', __FILE__); // Respects SSL, Style.css is relative to the current file
				$myStyleFile = WP_PLUGIN_DIR . '/wp-app-store-connect/style.css';
				if ( file_exists($myStyleFile) ) {
					wp_register_style('myStyleSheets', $myStyleUrl);
					wp_enqueue_style( 'myStyleSheets');
				}
			}

			# convert plain text-links to clickable links
			function linker($link)
			{
			$link = str_replace("http://www.","www.",$link);
			$link = str_replace("www.","http://www.",$link);
			$link = preg_replace(
			"/([\w]+:\/\/[\w-?&;#~=\.\/\@]+[\w\/])/i","<a href=\"$1\" target=_blank>$1</a>", $link);
			$link = preg_replace(
			"/([\w-?&;#~=\.\/]+\@(\[?)[a-zA-Z0-9\-\.]+\.
			([a-zA-Z]{2,3}|[0-9]{1,3})(\]?))/i","<a href=\"mailto:$1\" target=_blank>$1</a>",$link);
			return $link;
			}

		}
	}
	else
	  { exit("Class WP_App_Store_Connect already declared!"); }

	// create new instance of the class
	$WP_App_Store_Connect = new WP_App_Store_Connect();
	if (isset($WP_App_Store_Connect)) {
	  // register the activation function by passing the reference to our instance
	  register_activation_hook(__FILE__, array(&$WP_App_Store_Connect, 'install'));
	}
	
?>