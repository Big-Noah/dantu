<?php
/**
 * Header HTML2 Options
 *
 * @package CoderPlace
 */

namespace CoderPlace;

use Base\Theme_Customizer;
use function Base\webapp;

$settings = array(
	'header_mobile_search_bar_tabs' => array(
		'control_type' => 'base_tab_control',
		'section'      => 'header_mobile_search_bar',
		'settings'     => false,
		'priority'     => 1,
		'input_attrs'  => array(
			'general' => array(
				'label'  => __( 'General', 'coderplace-core' ),
				'target' => 'header_mobile_search_bar',
			),
			'design' => array(
				'label'  => __( 'Design', 'coderplace-core' ),
				'target' => 'header_mobile_search_bar_design',
			),
			'active' => 'general',
		),
	),
	'header_mobile_search_bar_tabs_design' => array(
		'control_type' => 'base_tab_control',
		'section'      => 'header_mobile_search_bar_design',
		'settings'     => false,
		'priority'     => 1,
		'input_attrs'  => array(
			'general' => array(
				'label'  => __( 'General', 'coderplace-core' ),
				'target' => 'header_mobile_search_bar',
			),
			'design' => array(
				'label'  => __( 'Design', 'coderplace-core' ),
				'target' => 'header_mobile_search_bar_design',
			),
			'active' => 'design',
		),
	),
	'header_mobile_search_bar_width' => array(
		'control_type' => 'base_range_control',
		'section'      => 'header_mobile_search_bar',
		'label'        => esc_html__( 'Search Bar Width', 'coderplace-core' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-mobile-search-bar form',
				'property' => 'width',
				'pattern'  => '$',
				'key'      => 'size',
			),
		),
		'default'      => webapp()->default( 'header_mobile_search_bar_width' ),
		'input_attrs'  => array(
			'min'        => array(
				'px'  => 100,
				'em'  => 4,
				'rem' => 4,
			),
			'max'        => array(
				'px'  => 600,
				'em'  => 12,
				'rem' => 12,
			),
			'step'       => array(
				'px'  => 1,
				'em'  => 0.01,
				'rem' => 0.01,
			),
			'units'      => array( 'px', 'em', 'rem' ),
			'responsive' => false,
		),
	),
	'header_mobile_search_bar_color' => array(
		'control_type' => 'base_color_control',
		'section'      => 'header_mobile_search_bar_design',
		'label'        => esc_html__( 'Input Text Colors', 'coderplace-core' ),
		'default'      => webapp()->default( 'header_mobile_search_bar_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-mobile-search-bar form input.search-field, .header-mobile-search-bar form .base-search-icon-wrap',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.header-mobile-search-bar form input.search-field:focus, .header-mobile-search-bar form input.search-submit:hover ~ .base-search-icon-wrap, .header-mobile-search-bar #main-header form button[type="submit"]:hover ~ .base-search-icon-wrap',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Color', 'coderplace-core' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Focus Color', 'coderplace-core' ),
					'palette' => true,
				),
			),
		),
	),
	'header_mobile_search_bar_background' => array(
		'control_type' => 'base_color_control',
		'section'      => 'header_mobile_search_bar_design',
		'label'        => esc_html__( 'Input Background', 'coderplace-core' ),
		'default'      => webapp()->default( 'header_mobile_search_bar_background' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-mobile-search-bar form input.search-field',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.header-mobile-search-bar form input.search-field:focus',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Color', 'coderplace-core' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Focus Color', 'coderplace-core' ),
					'palette' => true,
				),
			),
		),
	),
	'header_mobile_search_bar_border' => array(
		'control_type' => 'base_border_control',
		'section'      => 'header_mobile_search_bar_design',
		'label'        => esc_html__( 'Border', 'coderplace-core' ),
		'default'      => webapp()->default( 'header_mobile_search_bar_border' ),
		'live_method'     => array(
			array(
				'type'     => 'css_border',
				'selector' => '.header-mobile-search-bar form input.search-field',
				'pattern'  => '$',
				'property' => 'border',
				'pattern'  => '$',
				'key'      => 'border',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
			'color'      => false,
		),
	),
	'header_mobile_search_bar_border_color' => array(
		'control_type' => 'base_color_control',
		'section'      => 'header_mobile_search_bar_design',
		'label'        => esc_html__( 'Input Border Color', 'coderplace-core' ),
		'default'      => webapp()->default( 'header_mobile_search_bar_border_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-mobile-search-bar form input.search-field',
				'property' => 'border-color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.header-mobile-search-bar form input.search-field:focus',
				'property' => 'border-color',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Color', 'coderplace-core' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Focus Color', 'coderplace-core' ),
					'palette' => true,
				),
			),
		),
	),
	'header_mobile_search_bar_typography' => array(
		'control_type' => 'base_typography_control',
		'section'      => 'header_mobile_search_bar_design',
		'label'        => esc_html__( 'Font', 'coderplace-core' ),
		'default'      => webapp()->default( 'header_mobile_search_bar_typography' ),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => '.header-mobile-search-bar form input.search-field',
				'pattern'  => array(
					'desktop' => '$',
					'tablet'  => '$',
					'mobile'  => '$',
				),
				'property' => 'font',
				'key'      => 'typography',
			),
		),
		'input_attrs'  => array(
			'id' => 'header_mobile_search_bar_typography',
			'options' => 'no-color',
		),
	),
	'header_mobile_search_bar_margin' => array(
		'control_type' => 'base_measure_control',
		'section'      => 'header_mobile_search_bar_design',
		'default'      => webapp()->default( 'header_mobile_search_bar_margin' ),
		'label'        => esc_html__( 'Margin', 'coderplace-core' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-mobile-search-bar',
				'property' => 'margin',
				'pattern'  => '$',
				'key'      => 'measure',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
		),
	),
	'transparent_header_mobile_search_bar_color' => array(
		'control_type' => 'base_color_control',
		'section'      => 'transparent_header_design',
		'label'        => esc_html__( 'Search Bar Input Colors', 'coderplace-core' ),
		'context'      => array(
			array(
				'setting'  => '__device',
				'operator' => 'in',
				'value'    => array( 'tablet', 'mobile' ),
			),
		),
		'default'      => webapp()->default( 'transparent_header_mobile_search_bar_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.transparent-header .header-mobile-search-bar form input.search-field, .transparent-header .header-mobile-search-bar form .base-search-icon-wrap',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.transparent-header .header-mobile-search-bar form input.search-field:focus, .transparent-header .header-mobile-search-bar form input.search-submit:hover ~ .base-search-icon-wrap, .transparent-header #main-header .header-mobile-search-bar form button[type="submit"]:hover ~ .base-search-icon-wrap',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Color', 'coderplace-core' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Focus Color', 'coderplace-core' ),
					'palette' => true,
				),
			),
		),
	),
	'transparent_header_mobile_search_bar_background' => array(
		'control_type' => 'base_color_control',
		'section'      => 'transparent_header_design',
		'label'        => esc_html__( 'Search Bar Input Background', 'coderplace-core' ),
		'default'      => webapp()->default( 'transparent_header_mobile_search_bar_background' ),
		'context'      => array(
			array(
				'setting'  => '__device',
				'operator' => 'in',
				'value'    => array( 'tablet', 'mobile' ),
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.transparent-header .header-mobile-search-bar form input.search-field',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.transparent-header .header-mobile-search-bar form input.search-field:focus',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Color', 'coderplace-core' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Focus Color', 'coderplace-core' ),
					'palette' => true,
				),
			),
		),
	),
	'transparent_header_mobile_search_bar_border' => array(
		'control_type' => 'base_color_control',
		'section'      => 'transparent_header_design',
		'label'        => esc_html__( 'Search Bar Border Color', 'coderplace-core' ),
		'default'      => webapp()->default( 'transparent_header_mobile_search_bar_border' ),
		'context'      => array(
			array(
				'setting'  => '__device',
				'operator' => 'in',
				'value'    => array( 'tablet', 'mobile' ),
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.transparent-header .header-mobile-search-bar form input.search-field',
				'property' => 'border-color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.transparent-header .header-mobile-search-bar form input.search-field:focus',
				'property' => 'border-color',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Color', 'coderplace-core' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Focus Color', 'coderplace-core' ),
					'palette' => true,
				),
			),
		),
	),
);
if ( class_exists( 'woocommerce' ) ) {
	$settings = array_merge(
		$settings,
		array(
			'header_mobile_search_bar_woo' => array(
				'control_type' => 'base_switch_control',
				'section'      => 'header_mobile_search_bar',
				'priority'     => 10,
				'default'      => webapp()->default( 'header_mobile_search_bar_woo' ),
				'label'        => esc_html__( 'Search only Products?', 'coderplace-core' ),
				'transport'    => 'refresh',
			),
		)
	);
}

Theme_Customizer::add_settings( $settings );

