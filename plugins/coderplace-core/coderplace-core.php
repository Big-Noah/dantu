<?php
/**
 * Plugin Name:  CoderPlace Core - Plugin for the CoderPlace Theme
 * Plugin URI:   https://coderplace.com/#premium
 * Description:  This is core plugin required by the CoderPlace Theme for the core features of theme.
 * Version:      1.0.0
 * Author:       CoderPlace
 * Author URI:   #
 * License:      GPL2
 * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 * Domain Path:  /languages
 * Text Domain:  coderplace-core
 * Requires PHP: 7.0
 *
 * @package CoderPlace Core
 */

// Block direct access to the main plugin file.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin Name.
if ( ! defined( 'CPCORE_NAME' ) ) {
	define( 'CPCORE_NAME', 'CoderPlace Core' );
}

// Plugin Slug.
if ( ! defined( 'CPCORE_SLUG' ) ) {
	define( 'CPCORE_SLUG', 'coderplace-core' );
}

// Plugin Version.
if ( ! defined( 'CPCORE_VERSION' ) ) {
	define( 'CPCORE_VERSION', '1.0.0' );
}

// Plugin Folder Path.
if ( ! defined( 'CPCORE_PATH' ) ) {
	define( 'CPCORE_PATH', wp_normalize_path( dirname( __FILE__ ) ) );
}

// Plugin Folder URL.
if ( ! defined( 'CPCORE_URL' ) ) {
	define( 'CPCORE_URL', plugin_dir_url( __FILE__ ) );
}

// The main plugin file path.
if ( ! defined( 'CPCORE_MAIN_PLUGIN_FILE' ) ) {
	define( 'CPCORE_MAIN_PLUGIN_FILE', __FILE__ );
}

// Minimum PHP version required.
if ( ! defined( 'CPCORE_MIN_PHP_VER_REQUIRED' ) ) {
	define( 'CPCORE_MIN_PHP_VER_REQUIRED', '7.0' );
}

// Minimum WP version required.
if ( ! defined( 'CPCORE_MIN_WP_VER_REQUIRED' ) ) {
	define( 'CPCORE_MIN_WP_VER_REQUIRED', '5.0' );
}

if ( ! function_exists('coderplace_check_required_theme') ) {

	function coderplace_check_required_theme() {
		$is_theme_exists = false;
		$current_theme = wp_get_theme();
		if ( get_template_directory() !== get_stylesheet_directory() ) {
			$is_theme_exists = ( 'avanam' === $current_theme->get( 'Template' ) ? true : false );
		} else {
			$is_theme_exists = ( 'Avanam' === $current_theme->get( 'Name' ) ? true : false );
		}
		return $is_theme_exists;
	}

}

/**
 * Compatibility check.
 *
 * Check that the site meets the minimum requirements for the plugin before proceeding.
 *
 * @since 4.0
 */
if ( version_compare( $GLOBALS['wp_version'], CPCORE_MIN_WP_VER_REQUIRED, '<' ) || version_compare( PHP_VERSION, CPCORE_MIN_PHP_VER_REQUIRED, '<' ) || false == coderplace_check_required_theme() ) {
	require_once CPCORE_PATH . '/includes/bootstrap-compat.php';
	return;
}

/**
 * Bootstrap the plugin.
 *
 * @since 1.0
 */
require_once CPCORE_PATH . '/includes/bootstrap.php';
