<?php
/**
 * Sticky Side Buttons Uninstall
 * 
 * Uninstalling Sticky Side Buttons deletes user data and plugin options.
 * 
 * @package Sticky_Side_Buttons
 * @since 2.0.0
 */

// Prevent direct access
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Security check - make sure we're being called from the proper WordPress uninstall process
if ( ! current_user_can( 'activate_plugins' ) ) {
	return;
}

// Remove plugin options from database
$options_to_delete = array(
	'ssb_settings',
	'ssb_buttons', 
	'ssb_showoncpt',
);

foreach ( $options_to_delete as $option ) {
	delete_option( $option );
	// For multisite
	delete_site_option( $option );
}

// Clear any cached data that has been removed
wp_cache_flush();