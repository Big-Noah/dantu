<?php
/**
 * Template part for displaying the header navigation menu
 *
 * @package Base
 */

namespace CoderPlace;

use function Base\webapp;

?>
<div class="site-header-item site-header-focus-item site-header-item-main-navigation header-navigation-layout-stretch-<?php echo ( webapp()->option( 'tertiary_navigation_stretch' ) ? 'true' : 'false' ); ?> header-navigation-layout-fill-stretch-<?php echo ( webapp()->option( 'tertiary_navigation_fill_stretch' ) ? 'true' : 'false' ); ?>" data-section="base_customizer_tertiary_navigation">
	<?php
	/**
	 * Base tertiary Navigation
	 *
	 * Hooked CoderPlace\tertiary_navigation
	 */
	do_action( 'base_tertiary_navigation' );
	?>
</div><!-- data-section="tertiary_navigation" -->
