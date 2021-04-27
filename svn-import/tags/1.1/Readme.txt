=== Plugin Name ===
Contributors: mstumpf
Donate link: http://mikestumpf.com/portfolio/wordpress-reading-list-plugin/
Tags: reading-list, books, custom-post, plugin, posts, images, links
Requires at least: 3.0.1
Tested up to: 3.6
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

**WP Reading List** is a plugin designed to help organize and display books, magazines, articles, and anything else that you have read lately. 

== Description ==

**WP Reading List** (or, **WPRL**) is a plugin designed to help organize and display books, magazines, articles, and anything else that you have read lately.  This plugin allows users to display what they have read, attach text like a review or notes to it, and provide a link to where visitors can find the piece.  The plugin comes bundled with three existing templates, complete with easily customizable CSS.

== Installation ==

1. Upload `wp-reading-list.php` to the `/wp-content/plugins/` directory **or** Install the plugin by searching for "WP Reading List" in the WordPress.org plugin directory 
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Set the plugin settings via the submenu "WP Reading List" under "Settings" in the WordPress admin menu
4. Add Reading List items in the "Book" tab
5. View your Reading List items at "yourdomain.com/books"

== Frequently Asked Questions ==

= How do I see my WP Reading List items? =

After activating the plugin, publish a reading list item or two under the "Books" tab in the WordPress admin menu and then navigate to "yourdomain.com/books/".  Adding the "/books/" to your site's base url directs users to your reading list items.  You can then add this url to your custom menu to make it easier for users to get to.

= If I deactivate/delete the WP Reading List plugin will I lose all the reading list items and authors I have already created? =

If you deactivate or delete the plugin, you will not lose the content you have created but you will lose your plugin settings.

= Why aren't my widgets displaying on the WP Reading List layout or single item view? =

At this point, the plugin does not support widgets in its templates due to difficulty organizing the lists due to the unpredictability of widget sizes.  

= What can I do if I want to change the look of the Reading List layout to better fit with my theme? =

There are several options available in the WP Reading List admin settings to help the reading list layouts fit smoothly into any existing theme.  In addition, the templates have been highly detailed in terms of extra id's and classes for easy customization via CSS.  Many themes have a "Custom CSS" tab built into the admin menu where you can add your changes.  Otherwise, you can always place your modifications within the "style.css" file of your parent or child theme.

= How can I change the default WP Reading List image I see when I do not upload a "Cover Image"? =

This will hopefully be implemented as an admin option for the plugin in the future.  For now, you will have to go to your website's file manager and go to "wp-content/plugins/wp-reading-list/wprl-theme/" and replace the "sample.png" image with your image of the same name.  It is recommended that you choose a default image with a 3:4 aspect ratio (width:height) to match the other cover images.

= The "Books", "Authors" and "Reading List" terminology is confusing.  Is there a easier way to think of these things? =

Yes. Think of "books" as specialized "posts" and similarly for "authors" as a different kind of "tags".  The "Reading List" and "Reading List Items" is trying to be include reading materials other than books such as magazines, articles, etc.  


== Screenshots ==

1. Grid Layout

2. List Layout

3. Single Item View

4. Author View

== Changelog ==

= 1.1 =
* Added code documentation and improved the WordPress Readme file
* Fixed an activation problem
* Removed delete items with uninstallation of plugin function
* Added a header picture and screenshots
* Added missing validate function for admin setting
* Finished "author" view template
* Fixed several display-related bugs
* Minor edits

= 1.0 =
* First Stable release

== Upgrade Notice ==

= 1.1 =
Fixed activation problem and fine-tuned plugin code from version 1.0