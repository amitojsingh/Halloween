<?php
/**
 * Christmas Bell back compat functionality
 *
 * Prevents Christmas Bell from running on WordPress versions prior to 4.4,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.4.
 *
 * @package Christmas_Bell
 */

/**
 * Prevent switching to Christmas Bell on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since Christmas Christmas Bell 0.1
 */
function christmasbell_switch_theme() {
	switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

	unset( $_GET['activated'] );

	add_action( 'admin_notices', 'christmasbell_upgrade_notice' );
}
add_action( 'after_switch_theme', 'christmasbell_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * Christmas Bell on WordPress versions prior to 4.4.
 *
 * @since Christmas Christmas Bell 0.1
 *
 * @global string $wp_version WordPress version.
 */
function christmasbell_upgrade_notice() {
	$message = sprintf( __( 'Christmas Bell requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'christmas-bell' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );// WPCS: XSS ok.
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.4.
 *
 * @since Christmas Bell 0.1
 *
 * @global string $wp_version WordPress version.
 */
function christmasbell_customize() {
	wp_die( sprintf( __( 'Christmas Bell requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'christmas-bell' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );// WPCS: XSS ok.
}
add_action( 'load-customize.php', 'christmasbell_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.4.
 *
 * @since Christmas Bell 0.1
 *
 * @global string $wp_version WordPress version.
 */
function christmasbell_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'Christmas Bell requires at least WordPress version 4.4. You are running version %s. Please upgrade and try again.', 'christmas-bell' ), $GLOBALS['wp_version'] ) );// WPCS: XSS ok.
	}
}
add_action( 'template_redirect', 'christmasbell_preview' );
