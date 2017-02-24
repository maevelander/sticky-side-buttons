<?php
/*
Plugin Name: Sticky Side Buttons
Version: 1.0.1
Plugin URI: http://enigmaplugins.com.au/
Description: Flexible button creator allowing you to stick floating buttons to the side of your site.
Author: Enigma Plugins
Author URI: http://enigmaweb.com.au/
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
