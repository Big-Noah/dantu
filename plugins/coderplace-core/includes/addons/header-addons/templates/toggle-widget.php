<?php
/**
 * Template part for displaying the header toggle widget
 *
 * @package CoderPlace
 */

namespace CoderPlace;

?>
<div class="site-header-item site-header-focus-item" data-section="base_customizer_header_toggle_widget">
	<?php
	/**
	 * Base Header Toggle Widget
	 *
	 * Hooked CoderPlace\header_toggle_widget
	 */
	do_action( 'base_header_toggle_widget' );
	?>
</div><!-- data-section="header_toggle_widget" -->
