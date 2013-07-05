<?php
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