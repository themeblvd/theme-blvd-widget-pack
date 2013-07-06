<?php
/*
Plugin Name: Theme Blvd Widget Pack
Description: This plugin adds a pack of widgets that work with the Theme Blvd framework.
Version: 1.0.3
Author: Theme Blvd
Author URI: http://themeblvd.com
License: GPL2

    Copyright 2013  Theme Blvd

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/

define( 'TB_WIDGET_PACK_PLUGIN_VERSION', '1.0.3' );
define( 'TB_WIDGET_PACK_PLUGIN_DIR', dirname( __FILE__ ) );
define( 'TB_WIDGET_PACK_PLUGIN_URI', plugins_url( '' , __FILE__ ) );

/**
 * Run Widget Pack
 *
 * @since 1.0.0
 */
function themeblvd_widget_pack_init() {

	// Include general functions
	include_once( TB_WIDGET_PACK_PLUGIN_DIR . '/includes/general.php' );

	// Check to make sure Theme Blvd Framework 2.2+ is running
	if( ! defined( 'TB_FRAMEWORK_VERSION' ) || version_compare( TB_FRAMEWORK_VERSION, '2.2.0', '<' ) ) {
		add_action( 'admin_notices', 'themeblvd_widget_pack_warning' );
		add_action( 'admin_init', 'themeblvd_widget_pack_disable_nag' );
		return;
	}

	// Include widgets
	include_once( TB_WIDGET_PACK_PLUGIN_DIR . '/includes/tb-widget-contact.php' );
	include_once( TB_WIDGET_PACK_PLUGIN_DIR . '/includes/tb-widget-horz-nav.php' );
	include_once( TB_WIDGET_PACK_PLUGIN_DIR . '/includes/tb-widget-mini-post-grid.php' );
	include_once( TB_WIDGET_PACK_PLUGIN_DIR . '/includes/tb-widget-mini-post-list.php' );
	include_once( TB_WIDGET_PACK_PLUGIN_DIR . '/includes/tb-widget-video.php' );

	// Register Widgets
	register_widget('TB_Widget_Contact');
	register_widget('TB_Horz_Menu');
	register_widget('TB_Widget_Mini_Post_Grid');
	register_widget('TB_Widget_Mini_Post_List');
	register_widget('TB_Widget_Video');

}
add_action( 'after_setup_theme', 'themeblvd_widget_pack_init' );

/**
 * Register text domain for localization.
 *
 * @since 1.0.0
 */
function themeblvd_widget_pack_textdomain() {
	load_plugin_textdomain( 'themeblvd_widget_pack', false, TB_WIDGET_PACK_PLUGIN_DIR . '/lang' );
}
add_action( 'plugins_loaded', 'themeblvd_widget_pack_textdomain' );