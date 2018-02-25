<?php
/*
Plugin Name: Sticky Side Buttons
Version: 1.0.5
Plugin URI: https://wordpress.org/plugins/sticky-side-buttons/
Description: Flexible button creator allowing you to stick floating buttons to the side of your site.
Author: Maeve Lander
Author URI: https://profiles.wordpress.org/enigmaweb/
Text Domain: sticky-side-buttons
Domain Path: /languages
License: GPL v3
*/

/**
 * Required plugin files
 */
require_once 'ssb-main.php';
require_once 'ssb-ui.php';


/**
 * Plugin Activation
 */
function ssb_activate() {

	$ssb_options = get_option( 'ssb_settings' );

	$default_options = array(
		'show_on_frontpage' => 1,
		'show_on_posts' => 1,
		'show_on_pages' => 1
	);

	$new_settings = array_merge($ssb_options, $default_options);

	update_option( 'ssb_settings', $new_settings );

}

register_activation_hook( __FILE__, 'ssb_activate' );


/**
 * SSB Instance
 */
$ssb = new ssb_main;
