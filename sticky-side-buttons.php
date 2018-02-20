<?php
/*
Plugin Name: Sticky Side Buttons
Version: 1.0.4
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
 * SSB Instance
 */
$ssb = new ssb_main;
