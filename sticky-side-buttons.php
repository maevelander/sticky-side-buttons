<?php
/*
Plugin Name: Sticky Side Buttons
Version: 2.0.0
Plugin URI: https://wordpress.org/plugins/sticky-side-buttons/
Description: Flexible button creator allowing you to stick floating buttons to the side of your site.
Author: Maeve Lander
Author URI: https://profiles.wordpress.org/enigmaweb/
Text Domain: sticky-side-buttons
Domain Path: /languages
License: GPL v3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.4
Network: false
*/

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

	/** @var  $default_options_showoncpt intializing empty array */
	$default_options_showoncpt = array();
	/** @var  $registered_cpts getting registered CPTs */
	$registered_cpts = get_post_types(array('_builtin' => false), 'objects');
	foreach ($registered_cpts as $registered_cpt){

		$default_options_showoncpt[] = $registered_cpt->name;

	}

	update_option('ssb_showoncpt', $default_options_showoncpt);

}

register_activation_hook( __FILE__, 'ssb_activate' );


/**
 * Initialize the plugin
 *
 * @since 1.0
 */
function ssb_init() {
	global $ssb;
	$ssb = new ssb_main();
}
add_action( 'plugins_loaded', 'ssb_init' );
