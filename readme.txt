=== Plugin Name ===
Contributors: aatmaadhikari
Donate link: http://aamtaprakashadhikari.com.np
Tags: banner, slider, image, mainslider, bannerimage, apa, wordpress, main, image, advertisements, advertising, banner, customizable, event, flag, marketing, multilanguage, promotion, publicity
Requires at least: 3.2
Tested up to: 4.5.3
Stable tag: 1.0.0
License: Aatma Prakash Adhikari
License URI: http://aamtaprakashadhikari.com.np

Easy configurable custom banner slider plugin for home page or other pages with images and multiple contents like title, subtitle etc.
== Description ==

Easy configurable custom banner slider plugin for home page or other pages with images and multiple contents like title, subtitle etc.




== Installation ==

1= Using The WordPress Dashboard =

1. Navigate to the 'Add New' Plugin Dashboard
1. Select 'apa-banner-slider.zip' from your computer
1. Install
1. Activate the plugin on the WordPress Plugin Dashboard

= Using FTP =

1. Extract 'apa-banner-slider.zip' to your computer
1. Upload the 'apa-banner-slider' directory to your '/wp-content/plugins/' directory
1. Activate the plugin on the WordPress Plugins dashboard
1. Display the 'Banner Slider ' into a menu in WordPress.


== Frequently Asked Questions ==

= There are auto display frontend images =

No useing for some codex please see below 


== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets 
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png` 
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0 =
* A change since the previous version.
* Another change.

= 0.5 =
* List versions from most recent at top to oldest at bottom.

== Upgrade Notice ==

= 1.0 =
Upgrade notices describe the reason a user should upgrade.  No more than 300 characters.

= 0.5 =
This version fixes a security related bug.  Upgrade immediately.



Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up  for **strong**.

<?php 
$result = $wpdb->get_results("select * from ".$wpdb->prefix."banners WHERE list_status= '1' and bannerName='vision' "); 
			
	if( $result ) {

           			foreach( $result as $entry_detail ) {
            	  
					
					echo '<img src="'.$entry_detail->imgPath.'">';

					echo $entry_detail->bannerName;
					
					echo $entry_detail->banner_heading;
					echo $entry_detail->banner_subheading;
					
			 
			   } 
			 } 
  ?> 