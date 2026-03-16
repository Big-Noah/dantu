<?php
/**
 * Template part for displaying the header navigation menu
 *
 * @package Base
 */

namespace CoderPlace;

?>
<div class="site-header-item site-header-focus-item site-header-item-mobile-navigation mobile-secondary-navigation-layout-stretch-<?php echo ( webapp()->option( 'mobile_secondary_navigation_stretch' ) ? 'true' : 'false' ); ?>" data-section="base_customizer_mobile_secondary_navigation">
	<?php
	/**
	 * Base Mobile Secondary Navigation
	 *
	 * Hooked CoderPlace\mobile_secondary_navigation
	 */
	do_action( 'base_mobile_secondary_navigation' );
	?>
</div><!-- data-section="mobile_secondary_navigation" -->
