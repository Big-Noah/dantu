<?php
/**
 * Shortcode Class to display search form.
 *
 * @author     CoderPlace
 * @copyright  (c) Copyright by CoderPlace
 * @link       https://coderplace.com
 * @package    CoderPlace Core
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

/**
 * Shortcode class.
 */
if ( ! class_exists( 'CoderPlace_Shortcode_Search' ) ) {

class CoderPlace_Shortcode_Search {

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function __construct() {
		add_shortcode( 'scode_search', [ $this, 'render' ] );
	}

	/**
	 * Render the element.
	 *
	 * @access public
	 * @since 1.0.0
	 * @param array  $args    Shortcode parameters.
	 * @param string $content Content between shortcode.
	 * @return void|string     HTML output.
	 */
	public function render( $args, $content = '' ) {

		$args = shortcode_atts(
			[
				'size'   => 'normal',
				'type'   => 'blog', // blog , product
				'style'  => '',
				'class'  => '',
			],
			$args,
			'scode_search'
		);

		$classes	= array( 'searchform-wrapper' , 'scode-search', 'relative' );
		
		extract($args);
		if( $class ) $classes[] = $class;
		if( $visibility ) $classes[] = $visibility;
		if( $style ) $classes[] = 'form-'.$style;
		if( $size ) $classes[] = 'is-'.$size;
		$classes = implode(' ', $classes);
	
		ob_start();

		echo '<div class="'. $classes. '">';
		$this->get_search_form( $type );
		echo '</div>';

		$html = apply_filters( 'scode_search_content', ob_get_clean(), $args );

		return $html;
	}

	/**
	 * Output the search form.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function get_search_form( $type = 'blog' ) {
		if( 'product' == $type && function_exists('get_product_search_form')) {
	        get_product_search_form();
	    } else {
	        get_search_form();
	    }
	}

}

new CoderPlace_Shortcode_Search();

}