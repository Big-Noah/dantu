<?php
/**
 * WP and PHP compatibility.
 *
 * Functions used to gracefully fail when the plugin doesn't meet the minimum WP or PHP versions required.
 * Only call this file after initially checking that the site doesn't meet either the WP or PHP requirement.
 *
 * @package CoderPlace Core
 * @since 1.0.0
 */

add_action( 'admin_notices', 'coderplace_core_compat_upgrade_notice' );

/**
 * Outputs an admin notice with the compatibility issue.
 *
 * @since  1.0.0
 * @return void
 */
function coderplace_core_compat_upgrade_notice() {
	echo '<div class="error notice">';

	if ( version_compare( $GLOBALS['wp_version'], CPCORE_MIN_WP_VER_REQUIRED, '<' ) ) {
		printf(
			/* Translators: 1 is the required WordPress version and 2 is the user's current version. */
			'<p>' . esc_html__( 'CoderPlace Core requires at least WordPress version %1$s. You are running version %2$s. Please upgrade and try again.' ) . '</p>',
			esc_html( CPCORE_MIN_WP_VER_REQUIRED ),
			esc_html( $GLOBALS['wp_version'] )
		);
	}

	if ( version_compare( PHP_VERSION, CPCORE_MIN_PHP_VER_REQUIRED, '<' ) ) {
		printf(
			/* Translators: 1 is the required PHP version and 2 is the user's current version. */
			'<p>' . esc_html__( 'CoderPlace Core requires at least PHP version %1$s. You are running version %2$s. Please upgrade and try again.' ) . '</p>',
			esc_html( CPCORE_MIN_PHP_VER_REQUIRED ),
			esc_html( PHP_VERSION )
		);
	}

	if ( false == coderplace_check_required_theme() ) {
		printf(
			/* Translators: %s is a link to the theme. */
			'<p>' . esc_html__( 'CoderPlace Core requires the %s or it\'s child theme to be active for it to work.' ) . '</p>',
			'<a target="_blank" href="https://avanam.org/">Avanam Theme</a>'
		);
	}

	echo '</div>';
}
