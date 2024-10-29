<?php
/**
 * Plugin Name: Apa Banner Slider
 * Plugin URI: http://aamtaprakashadhikari.com.np
 * Easy configurable custom banner slider plugin for home page or other pages with images and multiple contents like title, subtitle etc.
 * Version: 1.0.0
 * Author:  apa
 * Author URI: http://aamtaprakashadhikari.com.np
 * License: APA
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
define('apabs_URL', plugins_url('', __FILE__));
define('apabs_FOLDER', plugin_dir_path(__FILE__));
wp_enqueue_style('apaorder', apabs_URL . '/css/style.css', array(), null);

global $wpdb; 
// this is the table prefix
$apabs_table_prefix = $wpdb->prefix;  
define('apabs_TABLE_PREFIX', $apabs_table_prefix);
// function to activate plugin
register_activation_hook(__FILE__,'apabs_plugin_install'); 
// function to deactivate plugin
register_deactivation_hook(__FILE__ , 'apabs_plugin_uninstall' ); 

function apabs_plugin_install()
{
  global $wpdb;
    $table = apabs_TABLE_PREFIX."banners";
    $schema = "CREATE TABLE $table (
        id INT(10) NOT NULL AUTO_INCREMENT,
        bannerName VARCHAR(255) NOT NULL,
		imgPath VARCHAR(255) NOT NULL,
        link VARCHAR(255) NOT NULL,
        banner_heading VARCHAR(255) NOT NULL,
        banner_subheading VARCHAR(255) NOT NULL,
		list_status enum('1','0') NOT NULL,
		heading_style enum('1','0') NOT NULL,
	UNIQUE KEY id (id)
    );";
    $wpdb->query($schema);
	
}

function apabs_plugin_uninstall()
{
	//remove Table and data
    global $wpdb;
    $table = apabs_TABLE_PREFIX."banners";
    $deletetable = "drop table if exists $table";
    $wpdb->query($deletetable);  
}

// Add menu in admin secttion for your plugin

add_action('admin_menu','apabs_master_menu');  // 'apabs_master_menu' would be called  
function apabs_master_menu() { 
if (function_exists('add_menu_page')) {
      
	add_menu_page(
		"Banner Slider ",
		"Banner Slider ",
		8,
		__FILE__,
		"banner_admin_menu_lists",
		apabs_URL."/images/banner.png"
	); 
	add_submenu_page(__FILE__,'Listing plugin data','All Data','8','list-plugin-data','apabs_admin_list_data');
	add_submenu_page(__FILE__,'Listing plugin data1','Add Data','8','list-plugin-data1','apabs_admin_add_data');
}
}
function banner_admin_menu_lists()

{
	require apabs_FOLDER . 'banners.php';
	 
}

function handle_image_upload($upload)
	{
	
		$overrides = array('test_form' => false);
		$file=wp_handle_upload($upload, $overrides);
		return $file;
	}	
// function to display data
function apabs_admin_list_data()
{
	require apabs_FOLDER . 'banners.php';
}

function apabs_admin_add_data()
{
	 require apabs_FOLDER . 'addBanner.php';
}