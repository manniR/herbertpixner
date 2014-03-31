<div class="wrap" style="max-width:950px !important;">

<h2>WP App Store Connect</h2>

<form name="WPAppStoreConnect" action="<?php echo $action_url ?>" method="post">

<input type="hidden" name="submitted" value="1" /> 

<?php
	wp_nonce_field('wp-app-store-connect', 'wp-app-store-connect-nonce');
	$myDir = plugins_url('/', __FILE__);
?>


<div class=wpasctabsmain>

 <div class=wpasctabs>

    <div id=wpasctabs1>

   <a href="#wpasctabs1">Default Values</a>

   <div>

	<h2>Usage</h2>
   
    <p>With <strong>WP App Store Connect</strong> you can retrieve data from the Apple App Store. This plugin lets you</p>
	<p>Retrieve Data to a given App ID for <b>full or short description of an app</b>. This is used via shortcut wihtin a post or page. See tab <a href="#tab1">App Data (Post)</a>.</p>
	<p>Retrieve various <b>App Store Charts to show within a post or a page</b>. See tab <a href="#tab2">App Store Charts (Post)</a>.</p>
	<p>Retrieve various <b>App Store Charts to show in a Sidebar Widget</b>. See tab <a href="#tab3">App Store Charts (Widget)</a>.</p>
	<p>The plugin will use these values if you don't specify otherwise in the shortcode. With a given Tradedoubler Affiliate ID, the plugin generates valid affilate links to the app store.</p>

	<h2>Default Settings</h2>
	
	<table>

	<tr>
		<td width="180">&nbsp;</td>
		<td width="180">&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	
	<tr><td colspan="3"><h2>Overall</h2></td></tr>

	<tr>
	<td>
		<label for="storecountry"> App Store's default country code</label><br />
	</td>
	<td colspan="2">
		<select name="storecountry" style="width:150px;">
			<?php
				foreach (array_keys($country_codes) as $i)
					{
					if ($i == $storecountry) {$selected=" selected";} else {$selected="";}
					if ($country_codes[$i]['country']) {echo '<option value="'.$i.'"'.$selected.'>'.$country_codes[$i]['country'].'</option>';}
					}
			?>
		</select>
	</td>
	</tr>

	<tr>
	<td>
		<label for="dateformat"> Date format</label>  <br />
	</td>
	<td colspan="2">
		<select name="dateformat" style="width:150px;">
			<?php
				foreach(array("YYYY-MM-DD","YYYY/MM/DD","DD.MM.YYYY","DD-MM-YYYY") as $i)
					{
					if ($i == $dateformat) {$selected=" selected";} else {$selected="";}
					echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
					}	
			?>
		</select>
	</td>
	</tr>

	<tr>
	<td valign="top">
		<label for="starrate_color"> Star rating color</label>  <br />
	</td>
	<td valign="top">
		<select name="starrate_color" style="width:150px;">
			<?php
				foreach(array("yellow", "red", "orange", "blue", "green") as $i)
					{
					if ($i == $starrate_color) {$selected=" selected";} else {$selected="";}
					echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
					}	
			?>
		</select>
	</td>
	<td>
		<img src="<?php echo $myDir ?>img/rating_yellow_8.gif"><br />
		<img src="<?php echo $myDir ?>img/rating_red_8.gif"><br />
		<img src="<?php echo $myDir ?>img/rating_orange_8.gif"><br />
		<img src="<?php echo $myDir ?>img/rating_blue_8.gif"><br />
		<img src="<?php echo $myDir ?>img/rating_green_8.gif">
	</td>
	</tr>

	<tr>
	<td>
		<label for="txtisuniversalapp"> Universal App</label>  <br />
	</td>
	<td>
		<input type="text" name="txtisuniversalapp" style="width:350px;" value="<?php echo $txtisuniversalapp ?>" />
	</td>
	<td>Custom text for universal app.</td>
	</tr>

	<tr>
	<td valign="top">
		<label for="txtfreeprize"> Free Prize</label>  <br />
	</td>
	<td valign="top">
		<input type="text" name="txtfreeprize" style="width:350px;" value="<?php echo $txtfreeprize ?>" />
	</td>
	<td>
		Custom text for 'free' apps. App Data contains a numeric value for the prize, like 0.99 USD or 0 USD. Instead of "0 USD" you could have a custom text, like 'free'. If left blank, original data will be used ("0 USD"). This applys only to app data in a single post or page and only if the prize is nil.
	</td>
	</tr>

	<tr>
	<td valign="top">
		<label for="imgitunesbutton"> iTunes Button</label>  <br />
	</td>
	<td valign="top">
		<input type="text" name="imgitunesbutton" style="width:350px;" value="<?php echo $imgitunesbutton ?>" />
	</td>
	<td>
		Link to "View in iTunes" - button. Link to your custom button or use one of these<br>
		<ul>
			<li>viewinitunes_en.png <img src="<?php echo $myDir ?>img/viewinitunes_en.png"></li>
			<li>viewinitunes_de.png <img src="<?php echo $myDir ?>img/viewinitunes_de.png"></li>
			<li>viewinitunes_es.png <img src="<?php echo $myDir ?>img/viewinitunes_es.png"></li>
			<li>viewinitunes_fr.png <img src="<?php echo $myDir ?>img/viewinitunes_fr.png"></li>
			<li>viewinitunes_it.png <img src="<?php echo $myDir ?>img/viewinitunes_it.png"></li>
			<li>viewinitunes_nl.png <img src="<?php echo $myDir ?>img/viewinitunes_nl.png"></li>
			<li>viewinitunes_jp.png <img src="<?php echo $myDir ?>img/viewinitunes_jp.png"></li>
		</ul>
		<p><strong>Rember to change the url matching to you blog's domain.</strong></p>
	</td>
	</tr>
	
	<tr><td colspan="3"><h2>Affiliate</h2></td></tr>

	<tr>
	<td>
		<label for="affiliateprogram"> Affiliate Network</label>  <br />
	</td>
	<td colspan="2">
	<select name="affiliateprogram" style="width:150px;">
		<?php
			foreach (array_keys($affiliate_programs) as $i)
				{
				if ($i == $affiliateprogram) {$selected=" selected";} else {$selected="";}
				if ($i == 'US' || $i == 'CA') {$affprogramname = 'iTunes @ Linkshare ';} else {$affprogramname = 'iTunes @ Tradedoubler ';}
				if ($i == '') {$affprogramname = 'no affiliate program';}
				echo '<option value="'.$i.'"'.$selected.'>'.$affprogramname.$country_codes[$i]['country'].'</option>';
				}
		?>
	</select>
	</td>
	</tr>

	<tr>
	<td>
		<label for="affiliateid"> Affiliate ID (website ID)</label>  <br />
	</td>
	<td colspan="2">
		<input type="text" name="affiliateid" style="width:150px;" value="<?php echo $affiliateid ?>" />
	</td>
	</tr>

	<tr><td colspan="3"><h2>Screenshot gallery</h2></td></tr>

	<tr>
	<td>
		<label for="gallerytype"> Gallery type</label>  <br />
	</td>
	<td colspan="2">
		<select name="gallerytype" style="width:150px;">
			<?php
				foreach(array("stacked horizontally","with Thumbnails","plain Image List","custom HTML") as $i)
					{
					if ($i == $gallerytype) {$selected=" selected";} else {$selected="";}
					echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
					}	
			?>
		</select>
	</td>
	</tr>

	<tr>
	<td>
		<label for="screenshotsubheadline"> Screenshot Headline<br />Screenshot Headline iPad</label>  <br />
	</td>
	<td>
		<input type="text" name="screenshotsubheadline" style="width:150px;" value="<?php echo $screenshotsubheadline ?>" /><br />
		<input type="text" name="screenshotsubheadlineipad" style="width:150px;" value="<?php echo $screenshotsubheadlineipad ?>" />
	</td>
	<td>Set a subheadline for the screenshot gallery, like 'Screenshots iPhone'. HTML is allowed as well as the variable %IMAGETITLE%.</td>
	</tr>

	<tr>
	<td>
		<label for="resizemaxwidth"> Resize (max width x height)</label>  <br />
	</td>
	<td>
		<input type="text" name="resizemaxwidth" style="width:70px;" value="<?php echo $resizemaxwidth ?>" />
		x
		<input type="text" name="resizemaxheight" style="width:70px;" value="<?php echo $resizemaxheight ?>" />
	</td>
	<td>Resize screenshots to max width and height. Does not apply to the "stacked horizontally" gallery, as this comes with fixed image sizes. Image will keep it proportions (aspect ratio). Depending on your template, good size would be around 400 to 500 pixels.</td>
	</tr>

	<tr>
	<td>
		<label for="maxscreenshots"> Max number of screenshots</label>  <br />
	</td>
	<td>
		<input type="text" name="maxscreenshots" style="width:150px;" value="<?php echo $maxscreenshots ?>" />
	</td>
	<td>Maximum number of screenshots to be displayed. Leave blank for all available screenshots.</td>
	</tr>

	<tr>
		<td valign="top">
			<label for="customhtmlscreenshotsbefore"> Custom HTML - before</label>
		</td>
		<td>
			<textarea name="customhtmlscreenshotsbefore" rows="5" cols="60"><?php echo stripslashes($customhtmlscreenshotsbefore) ?></textarea>
		</td>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td valign="top">
			<label for="customhtmlscreenshots"> Custom HTML - individual image</label>
		</td>
		<td valign="top">
			<textarea name="customhtmlscreenshots"  rows="10" cols="60"><?php echo stripslashes($customhtmlscreenshots) ?></textarea>
		</td>
		<td>
		<h3>Variables</h3>
		<table>
			<tr>
				<td>%IMAGE%</td>
				<td>Image URL</td>
			</tr>
			<tr>
				<td>%IMAGETITLE%</td>
				<td>Image Title</td>
			</tr>
			<tr>
				<td>%RESIZE%</td>
				<td>Code for image resize option, an OnLoad-JavaScript trigger. You need to put this in an IMG-tag if you want the screenshot images to be resized.</td>
			</tr>
			<tr>
				<td>%IMAGECOUNT%</td>
				<td>Number of the current screenshot. Something for '%%IMAGECOUNT%. screenshot of %IMAGETITLE%'</td>
			</tr>
		</table>
		<h3>Example</h3>
		<p><strong>custom code:</strong> &lt;li&gt;&lt;img %RESIZE% src="%IMAGE%" title="%IMAGETITLE%"&gt;&lt;/li&gt;</p>
		<p><strong>output code:</strong> &lt;li&gt;&lt;img onload="wpasc_ResizeImage(this,400,400)" src="http://app-url.jpg" title="App Name"&gt;&lt;/li&gt;</p>
		</td>
	</tr>

	<tr>
		<td valign="top">
			<label for="customhtmlscreenshotsafter"> Custom HTML - after</label>
		</td>
		<td>
			<textarea name="customhtmlscreenshotsafter"  rows="5" cols="60"><?php echo stripslashes($customhtmlscreenshotsafter) ?></textarea>
		</td>
		<td>The preinstalled custom HTML code shows thumbnail screenshots in a single row. Each thumbnail links to the full size image in a new browser tab. Rember to resize to 100x100 or smaller!</td>
	</tr>
	
	</table>
	
	<div><input type="submit" name="ituneschartswidget_save_options" id="ituneschartswidget_save_options" value="Save Options" class="button-primary"/></div>

	<h2>other iTunes store items</h2>
	
	<p>This plugin has been developed to display data and charts for</p>
	
	<ul>
		<li>iOS apps</li>
		<li>Mac apps</li>
	</ul>
	
	<p>It does retrieve data for other iTunes store items like books, movies, music etc. However, currently I highly recommend to only use the charts widget for other items than apps as not all of the data items are supported. For example, customers ratings for other items than apps currently doesn't work.</p>
	
   </div>

  </div>

  
  <div id=wpasctabs2>
   <a href="#wpasctabs2">App Data (Post)</a>

   <div>
					
					<h2>Usage</h2>
					<p>With WP App Store Connect you can retrieve data from the Apple App Store related to a given app id. The Plugin provides a shortcode to include those data in a post or page. You can select what data to be shown and tweak its appearance.</p>
					<p>You can show a single data item, like price or ratings or multiple data items, like a full description of the iTunes Store item. If you want to show multiple data items at the same time, use the data styles below as every shortcut results in a query for data from Apple servers. One query retrieves all data to the given id.</p>
					<p>You can show a single data item, like price or ratings or multiple data items, like a full description of the iTunes Store item. If you want to show multiple data items at the same time, use the data styles below as every shortcut results in a query for data from Apple servers. One query retrieves all data to the given id.</p>
					<p>Insert this shortcode in your post / page </p>
					<p>[appstore <b>id</b>="appid" <b><i>country</b>="store"</i> <b><i>style</b>="data style or data item"</i>]</p>

					<table>
						<tr>
							<th width=150>parameter</th>
							<th>value</th>
						</tr>
						<tr bgcolor="lightgrey">
							<th>id - required</th>
							<td>
							The app id like in http://itunes.apple.com/us/app/angry-birds/id<b>343200656</b>?mt=8
							</td>
						</tr>
						<tr>
							<th>store - optional</th>
							<td>
							ISO country code for the app store. US for USA, DE for Germany, GB for United Kingdom, FR for france etc.<br />
							If ommited, default value on tab 'Default Values' will be used.
							</td>
						</tr>
						<tr bgcolor="lightgrey">
							<th>style - optional</th>
							<td>
							Name of style for data output. The plugin comes with three pre-installed styles to choose from. You can customize them as you like. Set default style and custom styles below.<br />
							e.g. style="full"<br />
							Instead of a style you can use any data items with HTML-Code.<br />
							e.g. style="App is %FILESIZE% MB large and was released on %RELEASEDATE%."
							</td>
						</tr>
					</table>


					</p>

					<p>Examples</p>
					<table>
						<tr>
							<td>[appstore id="123456789"]</td>
							<td>Shows Infos on app '123456789', using default template.</td>
						</tr>
						<tr>
							<td>[appstore id="987654321" style="full"]</td>
							<td>Shows Infos on app '987654321', using 'full' template.</td>
						</tr>
						<tr>
							<td>[appstore id="135791113" style="%APPNAME%: download %FILESIZE%."]</td>
							<td>Shows something like 'SUPERDUPER HD: download 23.19 MB.'.</td>
						</tr>
					</table>
					
					<h2>Settings</h2>

					<table>
					<tr>
					<td>
						<label for="style"> Default data style. Will be used whenever <i>style</i> is omitted.</label>  <br />
					</td>
					<td>
						<select name="style" style="width:150px;">
							<?php
								foreach(array("full","infobox","smallbox","custombox1","custombox2","custombox3","custombox4") as $i)
									{
									if ($i == $style) {$selected=" selected";} else {$selected="";}
									echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
									}	
							?>
						</select>
					</td>
					</tr>
					</table>

					<br />											

					<table>
					<tr>
						<td>
							<label for="stylefull"> <b>full</b> Shows all data.</label><br />
							<textarea name="stylefull"  rows="10" cols="60"><?php echo stripslashes($stylefull) ?></textarea>
						</td>
						<td>
							<label for="styleinfobox"> <b>infobox</b> Without description and release notes.</label><br />
							<textarea name="styleinfobox"  rows="10" cols="60"><?php echo stripslashes($styleinfobox) ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<label for="stylesmallbox"> <b>smallbox</b> Smaller info box with fewer data.</label><br />
							<textarea name="stylesmallbox"  rows="10" cols="60"><?php echo stripslashes($stylesmallbox) ?></textarea>
						</td>
						<td>
							&nbsp;
						</td>
					</tr>
					<tr>
						<td>
							<label for="stylecustombox1"> <b>custombox1</b> Custom Template #1.</label><br />
							<textarea name="stylecustombox1"  rows="10" cols="60"><?php echo stripslashes($stylecustombox1) ?></textarea>
						</td>
						<td>
							<label for="stylecustombox2"> <b>custombox2</b> Custom Template #2.</label><br />
							<textarea name="stylecustombox2"  rows="10" cols="60"><?php echo stripslashes($stylecustombox2) ?></textarea>
						</td>
					</tr>
					<tr>
						<td>
							<label for="stylecustombox3"> <b>custombox3</b> Custom Template #3.</label><br />
							<textarea name="stylecustombox3"  rows="10" cols="60"><?php echo stripslashes($stylecustombox3) ?></textarea>
						</td>
						<td>
							<label for="stylecustombox4"> <b>custombox4</b> Custom Template #4.</label><br />
							<textarea name="stylecustombox4"  rows="10" cols="60"><?php echo stripslashes($stylecustombox4) ?></textarea>
						</td>
					</tr>
					</table>

					<div><input type="submit" name="ituneschartswidget_save_options" id="ituneschartswidget_save_options" value=
					"Save Options" class="button-primary"/></div>


					<h2>Variables</h2>
					
					<p>Use the predefined templates to show App Store data for a single App or customize them as you like. Each app store data item is represented by a variable, which you can arrange as you like. The plugin retrieves the following data items:</p>

					<table>
					<tr><td><b>Variable</b></td><td><b>Description</b></td><td><b>Example</b></td></tr>					
					<tr><td>%APPNAME%</td><td>The name of the app.</td><td>Supercool App HD</td></tr>
					<tr><td>%DEVELOPERNAME%</td><td>App developer's name.</td><td>Great company</td></tr>
					<tr><td>%DEVELOPERURL%</td><td>URL to developer's website.</td><td>http://greatcompany.com</a></td></tr>
					<tr><td>%ITUNESURL%</td><td>Url to the app store. This will be a TradeDoubler affiliate link if ID is given.</td><td>http://itunes.apple.com/...</td></tr>
					<tr><td>%ITUNESLINK%</td><td>Link to the app store. This will be a TradeDoubler affiliate link if ID is given.</td><td><a href="#"><img src="<?php echo $myDir ?>img/viewinitunes_en.png"></a></td></tr>
					<tr><td>%APPICON<##>%</td><td>App icon resized to ##x## pixels. With %APPICON<75>% you get a 75x75 icon</td><td><img src="<?php echo $myDir ?>img/admin.jpg"></td></tr>
					<tr><td>%ICONURL%</td><td>URL to App icon. Remember, the original icon size is 512x512.</td><td>http://a3.mzstatic.com/us/r1000/113/Purple/v4/6b/a7/d2/6ba7d2b2-7f9e-c4e9-3224-f5f83e2f6d09/mzl.zqxmszay.png</td></tr>
					<tr><td>%PRICE%</td><td>The price of the app.</td><td>4.99</td></tr>					
					<tr><td>%CURRENCY%</td><td>Currency of the price.</td><td>USD</td></tr>					
					<tr><td>%UNIVERSALAPP%</td><td>Shows. if an app is a universal app for iPhone & iPad. Otherwise stays blank.</td><td><img src="<?php echo $myDir ?>img/universalapp.gif"> This app is designed for both iPhone and iPad</td></tr>
					<tr><td>%CATEGORIES%</td><td>List of categories, the app is associated with.</td><td>Games, Tools, Entertainment</td></tr>
					<tr><td>%SUPPORTED%</td><td>List of iOS devices the app supports</td><td>iPhone 4, iPhone 4S, iPad 2 WiFi</td></tr>
					<tr><td>%LANGUAGES%</td><td>List of languages the app supports</td><td>English, German, Japanese</td></tr>
					<tr><td>%FILESIZE%</td><td>Size of the app in megabytes.</td><td>75.8 MB</td></tr>
					<tr><td>%VERSION%</td><td>App program version.</td><td>1.0</td></tr>
					<tr><td>%RELEASEDATE%</td><td>Release date of the app. This is the last date of the last release.</td><td>2012-01-31</td></tr>
					<tr><td>%CONTENTRATING%</td><td>Is the app safe for small children?</td><td>12+</td></tr>
					<tr><td>%RATING%</td><td>How's the app rated (5 stars image)?</td><td><img src="<?php echo $myDir ?>img/rating_yellow_9.gif"></td></tr>
					<tr><td>%RATINGCOUNT%</td><td>How many ratings for the the app?</td><td>450</td></tr>
					<tr><td>%RATINGVALUE%</td><td>How's the app rated (numeric value)?</td><td>4.5</td></tr>
					<tr><td>%DESCRIPTION<i><##></i>%</td><td>## characters of app's description from the app store. One lengthy marketing gibberish, often in bad english. With %DESCRIPTION<160>% you get the first 160 characters of the app description. Does recognize word boundaries. %DESCRIPTION% (without char-value) displays the full description.</td><td>This is the greatet app ever and now we'll show you the top 100 reasons why our app is great...</td></tr>
					<tr><td>%RELEASENOTES<i><##></i>%</td><td>## characters of the relase notes for the current version. With %RELEASENOTES<160>% you get the first 160 characters of the release notes. Does recognize word boundaries. %RELEASENOTES% (without char-value) displays the full release notes.</td><td>We are proud to present version 1.0.1 which comes with a whole lot of features. Most of them you won't even notice...<td></td></tr>
					<tr><td>%SCREENSHOTS%</td><td>The app's screenshots. Both, iPhone & iPad</td><td><i>[gallery with screenshots]</i></td></tr>
					</table>
    
   </div>

  </div>

  <div id=wpasctabs3>

   <a href="#wpasctabs3">App Store Charts (Post)</a>

   <div>

	<h2>Usage</h2>
	<p>With WP App Store Connect you can retrieve various chart lists from the App Store. The Plugin provides a shortcode to include those data in a post or page. You can select what data to be shown and tweak its appearance.</p>
	<p>Insert this shortcode in your post / page </p>
	<p>[apptoplist <b>list</b>="chartlist" <b><i>genre</b>="category"</i> <b><i>limit</b>="limit"</i> <b><i>country</b>="US"</i> <b><i>style</b>="liststyle1"</i>]</p>

	<table>
		<tr>
			<th width=150>parameter</th>
			<th>value</th>
		</tr>
		<tr bgcolor="lightgrey">
			<th>list - required</th>
			<td>
			<i>Look up valid values for this parameter on tab 'App Store Charts (Widget)'. Choose a chart section and type and see the corresponding parameter right next to the dropdown box.</i><br />
			e.g. 'topfreeapplications' or 'topmovies'
			</td>
		</tr>
		<tr>
			<th>genre - optional</th>
			<td>
			<i>Look up valid values for this parameter on tab 'App Store Charts (Widget)'. Choose a chart section and category and see the corresponding parameter right next to the dropdown box.</i><br />
			If ommited, all categories will be shown. Genre code is numeric, like '6001'
			</td>
		</tr>
		<tr bgcolor="lightgrey">
			<th>limit - optional</th>
			<td>
			Number of items to be displayed. Maximum is 25.<br />
			If ommited, default value will be used.
			</td>
		</tr>
		<tr>
			<th>store - optional</th>
			<td>
			ISO country code for the app store. US for USA, DE for Germany, GB for United Kingdom, FR for france etc.<br />
			If ommited, default value on tab 'Default Values' will be used.
			</td>
		</tr>
		<tr bgcolor="lightgrey">
			<th>liststyle - optional</th>
			<td>
			Choose list style (listsytle1 - liststyle3).<br />
			If ommited, default list style (below) will be used.
			</td>
		</tr>
	</table>

	<p>Examples</p>
	<table>
		<tr>
			<td>[apptoplist list="toppaidapplications"]</td>
			<td>Chart list for Top Paid Apps for all categories. Template and store are default values from admin panel settings.</td>
		</tr>
		<tr>
			<td>[apptoplist list="topfreeipadapplications" genre="6014" style="liststyle2"]</td>
			<td>Chart list for Top Free iPad games, using template 'liststyle2'.</td>
		</tr>
	</table>

	<h2>Settings</h2>
   
	<table>
	<tr>
	<td>
		<label for="listitemdisplay">Items to display</label>
	</td>
	<td>
		<select name="listitemdisplay" style="width:150px;">
			<?php
				foreach(array("5","10","15","20","25") as $i)
					{
					if ($i == $listitemdisplay) {$selected=" selected";} else {$selected="";}
					echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
					}	
			?>
		</select>
	</td>
	</tr>
	<tr>
	<td>
		<label for="liststyle">List style</label>
	</td>
	<td>
		<select name="liststyle" style="width:150px;">
			<?php
				foreach(array("liststyle1","liststyle2","liststyle3","liststyle4") as $i)
					{
					if ($i == $liststyle) {$selected=" selected";} else {$selected="";}
					echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
					}	
			?>
		</select>
	</td>
	</tr>
	</table>
	
	<table>
	<tr>
	<td>
		<label for="liststyle1"> <b>liststyle1</b> Custom Template #1.</label><br />
		<textarea name="liststyle1"  rows="10" cols="60"><?php echo stripslashes($liststyle1) ?></textarea>
	</td>
	<td>
		<label for="liststyle2"> <b>liststyle2</b> Custom Template #2.</label><br />
		<textarea name="liststyle2"  rows="10" cols="60"><?php echo stripslashes($liststyle2) ?></textarea>
	</td>
	</tr>
	<tr>
	<td>
		<label for="liststyle3"> <b>liststyle3</b> Custom Template #3.</label><br />
		<textarea name="liststyle3"  rows="10" cols="60"><?php echo stripslashes($liststyle3) ?></textarea>
	</td>
	<td>
		<label for="liststyle4"> <b>liststyle4</b> Custom Template #4.</label><br />
		<textarea name="liststyle4"  rows="10" cols="60"><?php echo stripslashes($liststyle4) ?></textarea>
	</td>
	</tr>
	</table>
   
   	<div><input type="submit" name="ituneschartswidget_save_options" id="ituneschartswidget_save_options" value="Save Options" class="button-primary"/></div>


		<h2>Variables</h2>
		
		<p>Use the predefined templates to show App Store Charts or customize them as you like. The App Store Charts list can display the following app data:</p>
		
		<table>
		<tr><td><b>Variable</b></td><td><b>Description</b></td><td><b>Example</b></td></tr>					
		<tr><td>%APPID%</td><td>The App Store ID of the app.</td><td>1</td></tr>
		<tr><td>%POSITION%</td><td>Chartposition of the app.</td><td>1</td></tr>
		<tr><td>%APPNAME%</td><td>The name of the app.</td><td>Supercool App HD</td></tr>
		<tr><td>%DEVELOPERNAME%</td><td>App developer's name.</td><td>Great company</td></tr>
		<tr><td>%ITUNESLINK%</td><td>Link to the app store. This will be a TradeDoubler affiliate link if ID is given.<br>ITUNESLINK will just put out the URL, so use in a link contect,<br>like &lt;a href="ITUNESLINK"&gt;</td><td><a href="#">Supercool App HD</a></td></tr>
		<tr><td>%APPICON<##>%</td><td>App icon resized to ##x## pixels. With %APPICON<50>% you get a 50x50 icon.</td><td><img src="<?php echo $myDir ?>img/admin.jpg" width="50" height="50"></td></tr>
		<tr><td>%ICONURL%</td><td>URL to App icon. Remember, the original icon size is 512x512.</td><td>http://a3.mzstatic.com/us/r1000/113/Purple/v4/6b/a7/d2/6ba7d2b2-7f9e-c4e9-3224-f5f83e2f6d09/mzl.zqxmszay.png</td></tr>
		<tr><td>%PRICE%</td><td>The price of the app including Currency depending on the App Store.</td><td>4.99 USD</td></tr>					
		<tr><td>%CATEGORIE%</td><td>Main category, the app is associated with.</td><td>Games</td></tr>
		<tr><td>%RELEASEDATE%</td><td>Release date of the app.</td><td>2012-01-31</td></tr>
		<tr><td>%DESCRIPTION<##>%</td><td>## characters of the app's description. With %DESCRIPTION<160>% you get the first 160 characters of the app description. Does recognize word boundaries.</td><td>2012-01-31</td></tr>
		</table>
   
   </div>

  </div>

  <div id=wpasctabs4>

   <a href="#wpasctabs4">App Store Charts (Widget)</a>

   <div>

    <h2>Settings</h2>
   
	<table>
	<tr>
	<td>
		<label for="widgettitle"> Widget Title</label>
	</td>
	<td>
		<input type="text" name="widgettitle" style="width:150px;" value="<?php echo $widgettitle ?>" />
	</td>
	</tr>
	<tr>
	<td>
		<label for="itemdisplay">Items to display</label>
	</td>
	<td>
		<select name="itemdisplay" style="width:150px;">
			<?php
				foreach(array("3","5","8","10","15","20","25") as $i)
					{
					if ($i == $itemdisplay) {$selected=" selected";} else {$selected="";}
					echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
					}	
			?>
		</select>
	</td>
	</tr>
	<tr>
		<td>
			<label for="appstoreconnect_chart_section">Chart Section</label>
			<input type="hidden" id="appstoreconnect_chart_section_hidden" value="<?php echo $appstoreconnect_chart_section; ?>" />
		</td>
		<td>
			<select name="appstoreconnect_chart_section" id="appstoreconnect_chart_section"  style="width:150px;"></select>
		</td>
	</tr>	
	
	<tr>
		<td>
			<label for="appstoreconnect_chart_type">Chart Type</label>
			<input type="hidden" id="appstoreconnect_chart_type_hidden" value="<?php echo $appstoreconnect_chart_type; ?>" />
		</td>
		<td>
			<select id="appstoreconnect_chart_type" name="appstoreconnect_chart_type" style="width:150px;"></select>
			<i>'list' value in App Store Charts: </i><input type="text" id="appstoreconnect_chart_type_value" disabled />
		</td>
	</tr>	
	
	<tr>
		<td>
			<label for="appstoreconnect_chart_category">Chart Category</label>
			<input type="hidden" id="appstoreconnect_chart_category_hidden" value="<?php echo $appstoreconnect_chart_category; ?>" />
		</td>
		<td>
			<select id="appstoreconnect_chart_category" name="appstoreconnect_chart_category" style="width:150px;"></select>
			<i>'genre' value in App Store Charts: </i><input type="text" id="appstoreconnect_chart_category_value" disabled />
		</td>
	</tr>	
	<tr>
	<td>
		<label for="widgetstyle">Widget style</label>
	</td>
	<td>
		<select name="widgetstyle" style="width:150px;">
			<?php
				foreach(array("style1","style2","style3","style4") as $i)
					{
					if ($i == $widgetstyle) {$selected=" selected";} else {$selected="";}
					echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
					}	
			?>
		</select>
	</td>
	</tr>
	</table>
	
	<table>
	<tr>
	<td>
		<label for="widgetstyle1"> <b>style1</b> Custom Template #1.</label><br />
		<textarea name="widgetstyle1"  rows="10" cols="60"><?php echo stripslashes($widgetstyle1) ?></textarea>
	</td>
	<td>
		<label for="widgetstyle2"> <b>style2</b> Custom Template #2.</label><br />
		<textarea name="widgetstyle2"  rows="10" cols="60"><?php echo stripslashes($widgetstyle2) ?></textarea>
	</td>
	</tr>
	<tr>
	<td>
		<label for="widgetstyle3"> <b>style3</b> Custom Template #3.</label><br />
		<textarea name="widgetstyle3"  rows="10" cols="60"><?php echo stripslashes($widgetstyle3) ?></textarea>
	</td>
	<td>
		<label for="widgetstyle4"> <b>style4</b> Custom Template #4.</label><br />
		<textarea name="widgetstyle4"  rows="10" cols="60"><?php echo stripslashes($widgetstyle4) ?></textarea>
	</td>
	</tr>
	</table>

		<div><input type="submit" name="ituneschartswidget_save_options" id="ituneschartswidget_save_options" value="Save Options" class="button-primary"/></div>


		<h2>Variables</h2>
		
		<p>Use the predefined templates to show App Store Charts or customize them as you like. The Widget can display the following app data:</p>
		
		<table>
		<tr><td><b>Variable</b></td><td><b>Description</b></td><td><b>Example</b></td></tr>					
		<tr><td>%APPID%</td><td>The App Store ID of the app.</td><td>1</td></tr>
		<tr><td>%POSITION%</td><td>Chartposition of the app.</td><td>1</td></tr>
		<tr><td>%APPNAME%</td><td>The name of the app.</td><td>Supercool App HD</td></tr>
		<tr><td>%DEVELOPERNAME%</td><td>App developer's name.</td><td>Great company</td></tr>
		<tr><td>%ITUNESLINK%</td><td>Link to the app store. This will be a TradeDoubler affiliate link if ID is given.<br>ITUNESLINK will just put out the URL, so use in a link contect,<br>like &lt;a href="ITUNESLINK"&gt;</td><td><a href="#">Supercool App HD</a></td></tr>
		<tr><td>%APPICON<##>%</td><td>App icon resized to ##x## pixels. With APPICON<50> you get a 50x50 icon.</td><td><img src="<?php echo $myDir ?>img/admin.jpg" width="50" height="50"></td></tr>
		<tr><td>%ICONURL%</td><td>URL to App icon. Remember, the original icon size is 512x512.</td><td>http://a3.mzstatic.com/us/r1000/113/Purple/v4/6b/a7/d2/6ba7d2b2-7f9e-c4e9-3224-f5f83e2f6d09/mzl.zqxmszay.png</td></tr>
		<tr><td>%PRICE%</td><td>The price of the app including Currency depending on the App Store.</td><td>4.99 USD</td></tr>					
		<tr><td>%CATEGORY%</td><td>Main category, the app is associated with.</td><td>Games</td></tr>
		<tr><td>%RELEASEDATE%</td><td>Release date of the app.</td><td>2012-01-31</td></tr>
		</table>

		<h2>If you want to use more than one widget at the same time</h2>
		
		<p>This plugin comes with one widget. If you want to have more charts in your sidebar, simply create a new text widget, put your widget title in the title field and an apptoplist shortcode in the body field. See tab 'App Store Charts (Post)' for more details. Don't forget to use a widget style!.</p>
		
		<p>Example: [apptoplist limit="5" list="toptvepisodes" style="style1"]</p>
		
		Normally, Wordpress doesn't execute shortcodes in widgets. The widget will just show the shortcode rather than the chart list. If this is the case, please install and activate the author's plugin <a href="http://www.softcontent.eu/use-shortcodes-in-sidebar-widgets.html" target="_blank">Use Shortcodes in Sidebar Widgets</a>. It's very light-weight, just 1.2 KB, and doesn't need any settings. Just install and activate.</p>
		
   </div>

  </div>

  
 </div>

</div>

</form>


			<table>
			<tr>
			<td>If you like this plugin, please donate to ensure it's further development...</td>
			<td>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
			<input type="hidden" name="cmd" value="_s-xclick">
			<input type="hidden" name="hosted_button_id" value="H849NNDJ5R5JS">
			<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
			<img alt="" border="0" src="https://www.paypalobjects.com/de_DE/i/scr/pixel.gif" width="1" height="1">
			</form>
			</td>
			</tr>
			<tr>
			<td>... or you might want to put up a link to this iOS related website:</td>
			<td>
			<a href="http://www.appdamit.de" target="_blank">http://www.appdamit.de</a><br />
			<a href="http://appdamit.de/top-app/" target="_blank">http://appdamit.de/top-app/</a><br />
			<a href="http://appdamit.de/top-cydia-apps/" target="_blank">http://appdamit.de/top-cydia-apps/</a><br />
			<a href="http://appdamit.de/category/iphone-apps/" target="_blank">http://appdamit.de/category/iphone-apps/</a><br />
			<a href="http://appdamit.de/category/ipad-apps/" target="_blank">http://appdamit.de/category/ipad-apps/</a>
			</td>
			</tr>
			</table>

			<h2>Support: <a href="mailto:mail@softcontent.eu">Email</a></h2>
			
			<p>(c) Kai Fenner - <a href="http://www.softcontent.eu/wp-app-store-connect.html">WP App Store Connect Support Site</a> | <a href="http://appdamit.de/wp-app-store-connect-templates/" target="_blank">Plugin's HTML templates (code & output)</a></p>
			
</div>