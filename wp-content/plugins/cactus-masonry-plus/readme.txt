=== Plugin Name ===
Contributors: bortpress
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=forum%40cactus%2ecloud&lc=AU&item_name=cactus%2ecloud&item_number=masonry&currency_code=AUD&
Tags: Gallery, Masonry, Image, Masonry Gallery, Post Gallery, Thumbnail Gallery, Featured Image Gallery
Requires at least: 4.4.2
Tested up to: 4.6
Stable tag: 0.0.5.5
License: GNU AGPLv3
License URI: http://cactus.cloud/licenses/agpl-3.0.txt

Displays a customizable masonry gallery of your posts or WordPress galleries.

== Description ==
= What is Cactus Masonry Plus =
Cactus Masonry Plus allows you to build a responsive, efficient, and very highly customizable gallery on your WordPress website.  With this plugin you can either build a gallery of your post thumbnails or represent a WordPress gallery from a given post using our masonry layout technology.

This plugin is designed to be lightweight, so it doesn’t unnecessarily slow down your site.  As a result, Cactus Masonry Plus is shortcode powered, which means that no inbuilt design menu is available.  Instead, we have provided an interactive [Shortcode Builder](http://cactus.cloud/masonryplus/cactus-masonry-plus/shortcode-builder), hosted on our website.  So, now we’re slowing down our site, not yours.

= Getting Started =
Cactus Masonry Plus is powered by shortcodes.  Shortcodes are lines of text enclosed within square brackets.  Within these brackets, you provide instructions on how the plugin should run.  As this can be quite complicated, we have provided a [Shortcode Builder](http://cactus.cloud/masonryplus/cactus-masonry-plus/shortcode-builder) to help you generate the shortcode you need, without any of the hard work.

Simply visit our [Shortcode Builder](http://cactus.cloud/masonryplus/cactus-masonry-plus/shortcode-builder), select the options you want, preview the result, and copy the shortcode back onto your website.  You can place your shortcode within any post, page, or anywhere else your theme allows.  When you preview the page, you should see a working masonry gallery.

= Getting Help =
Now, we all run into problems every now and again.  You may find a bug in the plugin, have a feature request, or simply get stuck on how to set things up.  If you do, check out our [Support Forum](http://support.cactus.cloud).  Here, you can get all the help you need to build a responsive masonry gallery for your website.

= Pricing =
It’s free!  Although, if you do like the product, and feel that it is worth it, any [donations](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=forum%40cactus%2ecloud&lc=AU&item_name=cactus%2ecloud&item_number=masonry&currency_code=AUD&) would be greatly appreciated… no pressure though.


== Changelog ==
= 0.0.5.5 =
* Fixed an issue that stopped the dateFormat parameter from working correctly

= 0.0.5.4 =
* Fixed an issue with html character replacing in post titles

= 0.0.5.3 =
* Fixed the links in the readme file

= 0.0.5.2 =
* Fixed a bug that caused some lowercase orderby parameters to fail
* Fixed a bug that caused results to be returned in reverse order on each page

= 0.0.5.1 =
* Fixed a bug where pretty pagination permalinks would break the pagination

= 0.0.5.0 =
* Fixed an issue where images were being rendered too tall with maximum widths set
* Fixed a rare issue where the gallery may appear with scrollbars due to theme conflicts
* Added an offset to the lazyLoad function such that the gallery will load images up to 1000px beyond the end of the window
* Fixed an issue with lazyLoading WP gallery based galleries
* Fixed a bug that was causing the linkAction parameter to fail when set to anything other than post
* Enabled the linkAction method on WP gallery based galleries
* Fixed an issue that could cause percentage width bricks to wrap when they shouldn't.  For example, 50% width bricks may not fit together side-by-side.

= 0.0.4.4 = 
* Fixed a JavaScript bug that could break the gallery on some sites

= 0.0.4.3 =
* Added banner images and screenshots to the repository

= 0.0.4.2 =
* Added 'Getting Started' page to WordPress dashboard

= 0.0.4.1 =
* Fixed a bug that sometimes causes one brick to flow over another brick
* Fixed a bug where the post data box would appear even when it had no content
* Fixed a bug that caused the post linking behaviour to fail or work unpredictably
* Updated the readme
* Added some screenshots to the WordPress plugin repository

= 0.0.4.0 =
* Fixed numerous sizing and spacing bugs.
* Added lazy load support

= 0.0.3.0 =
* Major improvement to image scaling and sizing under a variety of conditions.  Fixed how max heights are handled.
* Added the ability to include category names in the search result meta box.

= 0.0.2.1 =
* Fix for a potential issue that may cause the plugin to fail to activate under certain conditions

= 0.0.2.0 =
* Added a new theme which enables the data box to be positioned below each brick
* Added the ability to specify where each brick links to when clicked.  This can either be set to the post, the full sized image, the large sized image, the medium sized image, the thumbnail sized image, or nowhere at all.
* Added the ability to have the author's name behave like a link when clicked - linking to the author's URL.
* Added infinite scroll for large galleries.
* Fixed a bug that could cause the gallery to fail if certain new and upcoming parameters were set to false.
* Fixed an issue where a blank numerical parameter could cause the gallery to fail.

= 0.0.1.4 =
* Fixed a major bug that prevented the 'includedPostIds' and 'excludedPostIds' parameters from functioning
* Improved the efficiency of the plugin's filtering of the 'includedPostIds' and 'excludedPostIds' parameters when empty
* Moved script tags to the footer for content prioritized page loading and to improve SEO

= 0.0.1.3 =
* Updated WordPress repository tags
* Updated logo for WordPress repository
* Updated readme header information
* Updated compatability information

= 0.0.1.2 =
* Fixed issue with incorrectly referenced JS in initial release
* Changed install directory to match the directory assigned by WordPress

= 0.0.1.1 =
* Styling fix to stop pagination from being cropped from the gallery when displayed on some pages
* Documentation links updated to match new documentation website
* Documentation updated to reflect the plugin's feature set

= 0.0.1.0 =
* First beta release.

= 0.0.0.1 =
* Initial concept build


== Upgrade Notice ==
= 0.0.5.4 =
* Removed htmlspecialchars from the post titles

= 0.0.3.0 =
* Warning: This update contains a major revision to the layout and styling engine.

= 0.0.2.1 =
* Uncommon bug fix

= 0.0.2.0 =
* Fixed some bugs and added new parameters and styling options

= 0.0.1.4 =
* Fixed a major bug with included/excluded IDs and made caching easier


== Screenshots ==

1. The front page gallery [visible at](http://cactus.cloud/masonryplus)
The shortcode generated by the [Shortcode Builder](http://cactus.cloud/masonryplus/cactus-masonry-plus/shortcode-builder) was 
[cactusMasonry margin="5" width="33.333%" maxWidth="350px" minWidth="200px" maxHeight="400px" imageQuality="medium" lazyLoad="true"]

2. A thin horizontal layout generated by the [Shortcode Builder](http://cactus.cloud/masonryplus/cactus-masonry-plus/shortcode-builder)

3. An example of the "metabelow" theme in the [Shortcode Builder](http://cactus.cloud/masonryplus/cactus-masonry-plus/shortcode-builder).
Note that the boxes below can be styled and coloured using CSS.

4. A columnar layout generated by setting a pixel width for each image in the [Shortcode Builder](http://cactus.cloud/masonryplus/cactus-masonry-plus/shortcode-builder)

5. An example of the gallery's box sorting algorithm in the [Shortcode Builder](http://cactus.cloud/masonryplus/cactus-masonry-plus/shortcode-builder).
Here width limited images have been used with shrinkToFitFactor="0.2".  This allows larger images to shrink to better fill gaps.
The blank images belong to pages without featured images.  These images could be removed from the results by specifying withoutThumbnail="false".