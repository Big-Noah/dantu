<?php
/**
 * Template part for displaying the header navigation menu
 *
 * @package Base
 */

namespace CoderPlace;

use function Base\webapp;

?>
<div class="site-header-item site-header-focus-item site-header-item-main-navigation header-navigation-layout-stretch-<?php echo ( webapp()->option( 'quaternary_navigation_stretch' ) ? 'true' : 'false' ); ?> header-navigation-layout-fill-stretch-<?php echo ( webapp()->option( 'quaternary_navigation_fill_stretch' ) ? 'true' : 'false' ); ?>" data-section="base_customizer_quaternary_navigation">
	<?php
	/**
	 * Base quaternary Navigation
	 *
	 * Hooked CoderPlace\quaternary_navigation
	 */
	do_action( 'base_quaternary_navigation' );
	?>
</div><!-- data-section="quaternary_navigation" -->
