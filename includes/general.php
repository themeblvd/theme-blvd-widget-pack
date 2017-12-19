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

	// DEBUG: delete_user_meta( $current_user->ID, 'tb-nag-widget-pack-no-framework' );

	if ( ! get_user_meta( $current_user->ID, 'tb-nag-widget-pack-no-framework' ) ) {

		echo '<div class="updated">';

		echo '<p><strong>Theme Blvd Widget Pack:</strong> ' . __( 'You are not using a theme with the Theme Blvd Framework v2.2+, and so this plugin will not do anything.', 'theme-blvd-widget-pack' ) . '</p>';

		echo '<p><a href="'.themeblvd_widget_pack_disable_url( 'widget-pack-no-framework').'">' . __( 'Dismiss this notice', 'theme-blvd-widget-pack' ) . '</a> | <a href="http://www.themeblvd.com" target="_blank">' . __( 'Visit ThemeBlvd.com', 'theme-blvd-widget-pack' ) . '</a></p>';

		echo '</div>';

	}
}

/**
 * Dismiss an admin notice.
 *
 * @since 1.0.4
 */
function themeblvd_widget_pack_disable_nag() {

	global $current_user;

	if ( ! isset( $_GET['nag-ignore'] ) ) {

		return;

	}

	if ( 0 !== strpos( $_GET['nag-ignore'], 'tb-nag-' ) ) { // meta key must start with "tb-nag-"

		return;

	}

	if ( isset( $_GET['security'] ) && wp_verify_nonce( $_GET['security'], 'themeblvd-widget-pack-nag' ) ) {

		add_user_meta( $current_user->ID, $_GET['nag-ignore'], 'true', true );

	}
}

/**
 * Disable admin notice URL.
 *
 * @since 1.0.4
 */
function themeblvd_widget_pack_disable_url( $id ) {

	global $pagenow;

	$url = admin_url( $pagenow );

	if( ! empty( $_SERVER['QUERY_STRING'] ) ) {

		$url .= sprintf( '?%s&nag-ignore=%s', $_SERVER['QUERY_STRING'], 'tb-nag-' . $id );

	} else {

		$url .= sprintf( '?nag-ignore=%s', 'tb-nag-'.$id );

	}

	$url .= sprintf( '&security=%s', wp_create_nonce( 'themeblvd-widget-pack-nag' ) );

	return $url;

}
