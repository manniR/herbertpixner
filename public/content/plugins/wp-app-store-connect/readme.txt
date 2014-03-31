=== WP App Store Connect ===
Contributors: Pirate0815
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=H849NNDJ5R5JS
Tags: app, app charts, app store, apple, itunes, itunes store, iphone, ipad, ipod, top charts, itunes charts, app store charts, app charts, top apps, itunes chart widget, app store chart widget, app store widget, app store data, app data, widget, app widget, itunes widget
Requires at least: 2.6
Tested up to: 3.4.2
Stable tag: 1.2.1

Display Apple's App Store data & charts within your posts and pages via shortcode or in a sidebar widget. English & German

== Description ==

With *WP App Store Connect* you can retrieve data and charts from Apple's App Store. The plugin supports both iOS and MAC apps. It has a very basic support for other iTunes items. The Plugin provides a shortcode to include data to a given app id or charts in a post or page or in a sidebar widget. You can select what data to be shown and tweak its appearance. Supports English and German language.

Main features:

* Show app store data on a given app id in a post or page.
* Show app store charts (top paid apps, top free iPad apps etc) in post, page or sidebar widget.
* Data output is fully customizable.
* Supports different output styles (templates).
* Comes with six pre-installed templates (3 app data, 1 chart list, 2 chart widget).
* Output in english or german language.
* Creates Affiliate link to app store.
* Shows app screenshots in customizable gallery.
* Supports these app data items: app name, developer name, link to developer, , link to app store, app icon, price, currency, is or is not universal app, categories, supported devides, languages, size in MB, version, release date, content advisory rating, user rating, description, release notes, screenshots.
* Supports these chart items: app id, chart position, app name, developer name, link to app store, app icon, price, category, release date, description.

Example for usage:

Insert in post: [appstore id="123456789"]
-> Shows Infos on app '123456789', using default template.

Insert in post: [appstore id="135791113" style="%APPNAME%: download %FILESIZE%."]
-> Shows something like 'SUPERDUPER HD: download 23.19 MB.'.

Insert in post: [apptoplist list="toppaidapplications"]
-> Chart list for Top Paid Apps for all categories. Template and store are default values from admin panel settings.

Configure and use widget to show top charts.

**[Plugin Website](http://www.softcontent.eu/wp-app-store-connect.html)**
**[iPhone & iPad AppStore Plugin in Action](http://appdamit.de/)**
**[see example of templates](http://appdamit.de/wp-app-store-connect-templates/)**

== Installation ==

To install the plugin and get it working

1. Unzip wp-app-store-connect.zip and create a new directory `/wp-content/plugins/wp-app-store-connect'
2. Upload the contents to your `/wp-content/plugins/wp-app-store-connect` directory
3. Activate the plugin through the 'Plugins' menu in WordPress
4. Configure the plugin settings. This includes default values and HTML-style of the data output. Learn from the plugin settings, how you can use the provided shortcodes and widget.

== Frequently Asked Questions ==

= Where can I find the latest templates? =

You can find the latest templates on http://appdamit.de/wp-app-store-connect-templates

When upgrading, the plugin does not override your previously saved templates (or other options). 

= On the front page / index page / archive pages I only see the shortcode [appstore id="..."] but not data for this app? =

This is due to the nature of wordpress. Wordpress doesn't execute shortcodes when compiling excerpts of posts (text before more-tag) to an index page (frontpage or archives). It just takes the text directly from the database and ignores shortcodes. To show the content of a shortcode you have to tweak your theme's index page. There is no universally valid way as every theme might work a bit different.

On the admin panel, you need to have a look at Design -> Editor, which show all the templates of your theme. Usually you have a template called 'index.php' which puts the frontpage together. In this template (could be named depending on your theme) there is usually something like

 while ( have_posts() ) : the_post();

also known as 'the loop': http://codex.wordpress.org/The_Loop

Wordpress fetches posts from the database and does something with them, like putting them on the front page. At this point you would instruct wordpress to execute any shortcodes in the post by inserting

 $post->post_content = do_shortcode($post->post_content);

The new line should read

 while ( have_posts() ) : the_post(); $post->post_content = do_shortcode($post->post_content);

Whenever fiddling with templates, you need to have back-ups of the working template as syntax errors in a central template will bring down the whole blog (500 Internal Server Error).

**[Support and requests](www.softcontent.eu/wp-app-store-connect.html)**

== Screenshots ==

1. The admin page, general settings.
2. The admin page, settings for app data (single app in single post)
3. The admin page, settings for chart widget
4. And that's how it looks. In this case, an info box with almost all data. Remember, the HTML can be customized as you need.
5. Sample chart list.
6. Sample chart list in sidebar widget.

== Upgrade Notice ==

Upgrading from 0.9.1: Visit plugin settings to learn all the new features. The data variables have been changed so you have to update your html templates. Visit www.softcontent.eu/wp-app-store-connect.html to get the latest html templates, as your settings will be preserved.

Upgrading from 0.9: Deactivate and de-install the plugin. Then install the newest version. Your custom settings will be preserved.

== Changelog ==

= 1.2.1 =
* Fixes issue with showing blank template without the app date. Data retrieval should be more stable now.
* Fixes issue with app store selection in editor. Overriding app store settings in an individual post didn't work properly, as the paramter has been named false, both in documentation and editor's buttons. To choose a store, insert in post: [appstore id="123456789" store="XX"], where XX ist the iso code of the store, like US for USA.

= 1.2 =
* added buttons in editor to insert shortcodes in posts & pages
* added customizable text for universal app description
* added customizable link for "view in iTunes" button

= 1.1 =
* new image screenshot gallery: plain image list.
* new image screenshot gallery: custom html for your individual screenshot gallery.
* resize screenshots to max width & height while keeping aspect ratio.
* limit number of screenshots or show all of them.
* custom headline for screenshot gallery.
* fixed "Warning: Cannot modify header information".

= 1.0 =
* Complete overhaul, including.
* top charts in posts.
* top charts in sidbar widget.
* use [appstore] shortcode in top charts to retrieve single data items.
* free style for [appstore] to display single data items.
* support for MAC apps.
* basic support for other iTunes items.
* support for all iTunes affiliate networks.

= 0.9.1 =
* Bugfix: On some circumstances the admin-page showed up on the dashboard home page. Therefor no user could log in (except administrators).

= 0.9 =
* Initial version.