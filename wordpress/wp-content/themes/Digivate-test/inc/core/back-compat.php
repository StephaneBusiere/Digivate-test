<?php
/**
 * Ignition back compat functionality
 *
 * Prevents Ignition from running on WordPress versions prior to 4.7,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.
 *
* @package Digivate-test
 * @since Ignition 1.0
 */

/**
 * Prevent switching to Ignition on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Ignition 1.0
 */
function digivate_test_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'digivate_test_upgrade_notice' );
}
add_action( 'after_switch_theme', 'digivate_test_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Ignition on WordPress versions prior to 4.7.
 *
 * @since Ignition 1.0
 *
 * @global string $wp_version WordPress version.
 */
function digivate_test_upgrade_notice() {
	$message = sprintf( __( 'Ignition requires at least WordPress version 5.5. You are running version %s. Please upgrade and try again.', 'digivate-test' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.
 *
 * @since Ignition 1.0
 *
 * @global string $wp_version WordPress version.
 */
function digivate_test_customize() {
	wp_die( sprintf( __( 'Ignition requires at least WordPress version 5.5. You are running version %s. Please upgrade and try again.', 'digivate-test' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'digivate_test_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.
 *
 * @since Ignition 1.0
 *
 * @global string $wp_version WordPress version.
 */
function digivate_test_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Ignition requires at least WordPress version 4.7. You are running version %s. Please upgrade and try again.', 'digivate-test' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'digivate_test_preview' );