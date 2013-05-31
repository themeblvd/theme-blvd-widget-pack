<?php
/*
Plugin Name: Theme Blvd Widget Pack
Plugin URI: 
Description: This plugin adds a pack of widgets that work with the Theme Blvd framework.
Version: 1.0.2
Author: Jason Bobich
Author URI: http://jasonbobich.com
License: GPL2

    Copyright 2012  Jason Bobich

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

define( 'TB_WIDGET_PACK_PLUGIN_VERSION', '1.0.2' );
define( 'TB_WIDGET_PACK_PLUGIN_DIR', dirname( __FILE__ ) ); 
define( 'TB_WIDGET_PACK_PLUGIN_URI', plugins_url( '' , __FILE__ ) );

/**
 * Run Widget Pack
 *
 * @since 1.0.0
 */

function themeblvd_widget_pack_init() {
	
	// Check to make sure Theme Blvd Framework 2.2+ is running
	if( ! defined( 'TB_FRAMEWORK_VERSION' ) || version_compare( TB_FRAMEWORK_VERSION, '2.2.0', '<' ) ) {
		add_action( 'admin_notices', 'themeblvd_widget_pack_warning' );
		add_action( 'admin_init', 'themeblvd_widget_pack_disable_nag' );
		return;
	}
	
	// Include widgets
	include_once( TB_WIDGET_PACK_PLUGIN_DIR . '/widgets/tb-widget-contact.php' );
	include_once( TB_WIDGET_PACK_PLUGIN_DIR . '/widgets/tb-widget-horz-nav.php' );
	include_once( TB_WIDGET_PACK_PLUGIN_DIR . '/widgets/tb-widget-mini-post-grid.php' );
	include_once( TB_WIDGET_PACK_PLUGIN_DIR . '/widgets/tb-widget-mini-post-list.php' );
	include_once( TB_WIDGET_PACK_PLUGIN_DIR . '/widgets/tb-widget-video.php' );
	include_once( TB_WIDGET_PACK_PLUGIN_DIR . '/widgets/tb-widget-twitter.php' );
	
	// Register Widgets
	register_widget('TB_Widget_Contact');
	register_widget('TB_Horz_Menu');
	register_widget('TB_Widget_Mini_Post_Grid');
	register_widget('TB_Widget_Mini_Post_List');
	register_widget('TB_Widget_Twitter');
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

/**
 * Display warning telling the user they must have a 
 * theme with Theme Blvd framework v2.2+ installed in 
 * order to run this plugin.
 *
 * @since 1.0.0
 */

function themeblvd_widget_pack_warning() {
	global $current_user;
	// DEBUG: delete_user_meta( $current_user->ID, 'tb_widget_pack_no_framework' )
	if( ! get_user_meta( $current_user->ID, 'tb_widget_pack_no_framework' ) ){
		echo '<div class="updated">';
		echo '<p>'.__( 'You currently have the "Theme Blvd Widget Pack" plugin activated, however you are not using a theme with Theme Blvd Framework v2.2+, and so this plugin will not do anything.', 'themeblvd_widget_pack' ).'</p>';
		echo '<p><a href="?tb_nag_ignore=tb_widget_pack_no_framework">'.__('Dismiss this notice', 'themeblvd_shortcodes').'</a> | <a href="http://www.themeblvd.com" target="_blank">'.__('Visit ThemeBlvd.com', 'themeblvd_widget_pack').'</a></p>';
		echo '</div>';
	}
}

/**
 * Dismiss an admin notice.
 *
 * @since 1.0.2
 */

function themeblvd_widget_pack_disable_nag() {
	global $current_user;
    if ( isset( $_GET['tb_nag_ignore'] ) )
         add_user_meta( $current_user->ID, $_GET['tb_nag_ignore'], 'true', true );
}