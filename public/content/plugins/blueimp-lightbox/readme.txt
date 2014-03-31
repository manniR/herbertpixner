=== blueimp lightbox ===
Contributors: blueimp
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=MW4CRDG7Q4CQN
Tags: lightbox,mobile,desktop,responsive,swipe,touch,mouse,keyboard,slideshow
Requires at least: 3.6.1
Tested up to: 3.7.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://opensource.org/licenses/GPL-2.0

Official blueimp Gallery lightbox for Wordpress.

== Description ==
[blueimp Gallery](http://blueimp.github.io/Gallery/) is a touch-enabled, responsive and customizable image and video gallery, carousel and lightbox, optimized for both mobile and desktop web browsers.  
It features swipe, mouse and keyboard navigation, transition effects, slideshow functionality, fullscreen support and on-demand content loading and can be extended to display additional content types.  
This is the official Wordpress plugin for the Gallery lightbox functionality.  
By default it automatically adds lightbox functionality to image links ending with gif, jpg, jpeg and png extensions. The plugin provides an options page to disable the automatic feature and to restrict the list of media types. It is also possible to add lightbox functionality for a link manually.

== Installation ==
1. Upload the `blueimp-lightbox` folder to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Ready! :)

== Frequently Asked Questions ==
= How to manually activate the lightbox functionality for a link? =
Simply add the attribute `data-gallery` to the link tag and it will be opened in the lightbox:

`<a href="banana.jpg" data-gallery>Banana</a>`

If multiple links on the page have the `data-gallery` attribute, the lightbox enables gallery navigation between the linked resources.  
To create separate gallery groups, add a value for the `data-gallery` attribute:

`<a href="banana.jpg" data-gallery="#blueimp-gallery-fruits">Banana</a>`
`<a href="apple.jpg" data-gallery="#blueimp-gallery-fruits">Apple</a>`

`<a href="cat.jpg" data-gallery="#blueimp-gallery-animals">Cat</a>`
`<a href="dog.jpg" data-gallery="#blueimp-gallery-animals">Dog</a>`

= How can I enable the lightbox HTML5 fullscreen mode for a link? =
To enable the HTML5 fullscreen mode, add the `#blueimp-gallery-fullscreen` value for the `data-gallery` attribute:

`<a href="banana.jpg" data-gallery="#blueimp-gallery-fullscreen">Banana</a>` 

Please note that this only has an effect in browsers which support the HTML5 fullscreen API.  
Other browsers will simply display the lightbox without HTML5 fullscreen mode.

= How can I display HTML5 videos in the lightbox? =
Add the `data-gallery` attribute and a `type` attribute with the video content type to the link:

`<a href="cats.mp4" type="video/mp4" data-gallery>Cats</a>`
`<a href="dogs.ogv" type="video/ogv" data-gallery>Dogs</a>`

Please note that this is only supported in browsers which can play native HTML5 video and support the required video codec.

= How can I display YouTube videos in the lightbox? =
Add the `data-gallery` attribute, set the `type` attribute to `text/html` and add a `data-youtube` attribute with the [YouTube](https://www.youtube.com/) video ID:

`<a href="https://www.youtube.com/watch?v=zi4CIXpx7Bg" type="text/html" data-youtube="zi4CIXpx7Bg" data-gallery>LES TWINS - An Industry Ahead</a>`

= How can I display Vimeo videos in the lightbox? =
Add the `data-gallery` attribute, set the `type` attribute to `text/html` and add a `data-vimeo` attribute with the [Vimeo](https://vimeo.com/) video ID:

`<a href="https://vimeo.com/73686146" type="text/html" data-vimeo="73686146" data-gallery>KN1GHT - Last Moon</a>`

= Where can I find more documentation for this plugin? =
Head over to the [blueimp Gallery](https://github.com/blueimp/Gallery) project page and check out the [Gallery docs](https://github.com/blueimp/Gallery/blob/master/README.md).

== Screenshots ==
1. Options page
2. Lightbox with bright image
3. Lightbox with dark image

== Changelog ==
= 1.0.1 =
* Updated resource files to blueimp Gallery 2.11.5.
* Added a workaround for the plugin urls if the plugin is included via symlink.
* Replaced plugins_url with plugin_dir_path for the path to the HTML templates. 
= 1.0.0 =
* Initial release.

== Upgrade Notice ==
= 1.0.1 =
* Fixes issues when pausing YouTube videos in the lightbox.
* Fixes issues when the plugin is included via symlink.
* Fixes issues including the HTML template files.
= 1.0.0 =
* Initial release.
