=== Awesome Featured Post Widget ===
Contributors: Accrete InfoSolution Technologies LLP
Tags: featured posts, latest featured posts , category, tags, thumbnails, slider, excerpt, widget,
sidebar, taxonomy, post meta, plugin, wordpress
Requires at least: 4.4.2
Tested up to: 4.7.2
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Awesome Featured Post Widget helps you to display Latest Featured Posts with thumbnails, post excerpt, 

slider, and much more.

== Description ==
The **Awesome featured posts** is a light weight Wordpress plugin. It enables custom, flexible and 

featured posts. User can see Latest Featured Posts in **Simple List View/Slider View**. User can 

display posts from **specific category / tag** or **multiple categories / tags**. User can style the 

widget individually.It allows you to display a list of featured posts with/without thumbnail, excerpt, 

post date and much more. You can set the size for the thumbnail or just take the standard from your 

options. You can also show the excerpt with first 3 or more words and with/without `Read More` text 

option. It allows user to choose where to display posts in website.

== Features ==
1. Allows to display Featured Posts in two ways:
 a. **Simple List View** 
 b. **Using Slider**
2. Most useful feature of this plugin is user can see **Latest Featured Posts by setting number of
months field** *eg: 2 months / 5 months old posts*
3. Allows to display posts in slider by just **Turn On/Off Show Posts In Slider**
4. Allows you to display featured posts from **specific category / tag** or **multiple categories / 
tags**
5. Slider options such as *AutoPlay, Pagination, Stop on Hover, Time Interval, Sliding Speed*
6. Allows to set Title
7. Allows to assign text Before/After Post
8. Supports Post, Page post type
9. Supports Offset field
10. Allows to set number of Posts to display
11. Order by Date, ID, Parent, Comment Count, Random 
12. Turn On/Off Post Meta field, *eg: [post_categories] [post_tags]*
13. Display excerpt, with customizable length and `read more...` text
14. Display post date / post modified date / Relative Date. eg: 5 days ago of Post
15. Display thumbnails, with customizable size and alignment
16. Choose pages to display posts
17. Allows to add Custom css to display Featured Posts

== Installation ==

**Through Dashboard**

1. Log in to your WordPress admin panel and go to Plugins -> Add New -> Upload Plugin
2. Type `Awesome Featured Post Widget` in the search box and click on search button
3. Find `Awesome Featured Post Widget` plugin
4. Then click on Install Now after that activate the plugin
5. Go to the widgets page Appearance -> Widgets
6. Find and Drag the plugin from `Available widget` area, place it  and customize your widgets

**Installing Via FTP**

1. Download the plugin to your harddisk
2. Log in to your WordPress admin panel and go to Plugins -> Add New -> Upload Plugin
3. Select zip file of plugin -> Install Now
4. Then select `Activate the plugin`
5. Go to the widgets page Appearance -> Widgets
6. Find and Drag the plugin from `Available widget` area, place it  and customize your widgets

== Frequently Asked Questions ==
= Some parts of plugins are not working =
Please check whether the plugin is already present in `Inactive widget` area or not? If yes, then you 

better clear `Inactive widget` and Refresh page.

= Display of Posts is not in a format as shown =
There is a possibility of another plugin's css applied over this plugin's css.

= How to add custom style? =
The plugin comes with a very basic style, if you want to add custom style please do `wp_dequeue_style` 

to remove the default stylesheet. Place the code below in your theme `functions.php`.
`
function prefix_remove_mfpw_style() {
	wp_dequeue_style( 'mfpw-style' );
}
add_action( 'wp_enqueue_scripts', 'prefix_remove_mfpw_style', 10 );
`
Then you can add your custom style using Custom CSS plugin or in your theme `style.css`.

== Screenshots ==
1. Custom Post settings
2. Screen Settings - select posts according to category, tag or taxonomy.
3. Screen Settings - select particular posts.
4. Slider Setting
5. Display date of post and excerpt
6. Display post image size
7. Display Posts Vertically
8. Display Posts Horizontally in Slider

== Changelog ==
= 1.0 =
*Initial Release*
= 1.1 =
*Updated Release*