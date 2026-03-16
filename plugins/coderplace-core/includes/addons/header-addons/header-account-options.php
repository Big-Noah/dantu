<?php
/**
 * Header Account Options.
 *
 * @package CoderPlace
 */

namespace CoderPlace;

use Base\Theme_Customizer;
use function Base\webapp;

$settings = array(
	'header_account_tabs' => array(
		'control_type' => 'base_tab_control',
		'section'      => 'header_account',
		'settings'     => false,
		'priority'     => 1,
		'input_attrs'  => array(
			'general' => array(
				'label'  => __( 'General', 'coderplace-core' ),
				'target' => 'header_account',
			),
			'design' => array(
				'label'  => __( 'Design', 'coderplace-core' ),
				'target' => 'header_account_design',
			),
			'active' => 'general',
		),
	),
	'header_account_tabs_design' => array(
		'control_type' => 'base_tab_control',
		'section'      => 'header_account_design',
		'settings'     => false,
		'priority'     => 1,
		'input_attrs'  => array(
			'general' => array(
				'label'  => __( 'General', 'coderplace-core' ),
				'target' => 'header_account',
			),
			'design' => array(
				'label'  => __( 'Design', 'coderplace-core' ),
				'target' => 'header_account_design',
			),
			'active' => 'design',
		),
	),
	'header_account_preview' => array(
		'control_type' => 'base_radio_icon_control',
		'section'      => 'header_account',
		'default'      => webapp()->default( 'header_account_preview' ),
		'label'        => esc_html__( 'Preview/Customize', 'coderplace-core' ),
		'transport'    => 'refresh',
		'input_attrs'  => array(
			'layout' => array(
				'in' => array(
					'name' => __( 'Logged in view', 'coderplace-core' ),
				),
				'out' => array(
					'name' => __( 'Logged out view', 'coderplace-core' ),
				),
			),
			'responsive' => false,
			'class'      => 'base-two-forced',
		),
	),
	'info_header_account_logged_out' => array(
		'control_type' => 'base_title_control',
		'section'      => 'header_account',
		'label'        => esc_html__( 'Logged Out Options', 'coderplace-core' ),
		'settings'     => false,
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
		),
	),
	'header_account_style' => array(
		'control_type' => 'base_radio_icon_control',
		'section'      => 'header_account',
		'default'      => webapp()->default( 'header_account_style' ),
		'label'        => esc_html__( 'Account Style', 'coderplace-core' ),
		'partial'      => array(
			'selector'            => '.header-account-wrap',
			'container_inclusive' => true,
			'render_callback'     => 'CoderPlace\header_account',
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'label' => array(
					'name' => __( 'Label', 'coderplace-core' ),
				),
				'icon' => array(
					'name' => __( 'Icon', 'coderplace-core' ),
				),
				'label_icon' => array(
					'name' => __( 'Label + Icon', 'coderplace-core' ),
				),
				'icon_label' => array(
					'name' => __( 'Icon + Label', 'coderplace-core' ),
				),
			),
			'responsive' => false,
			'class'      => 'base-two-forced',
		),
	),
	'header_account_label' => array(
		'control_type' => 'base_text_control',
		'section'      => 'header_account',
		'sanitize'     => 'sanitize_text_field',
		'default'      => webapp()->default( 'header_account_label' ),
		'label'        => esc_html__( 'Account Label', 'coderplace-core' ),
		'live_method'     => array(
			array(
				'type'     => 'html',
				'selector' => '.header-account-in-wrap .header-account-label',
				'pattern'  => '$',
				'key'      => '',
			),
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_style',
				'operator'   => 'contain',
				'value'      => 'label',
			),
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
		),
	),
	'header_account_icon' => array(
		'control_type' => 'base_radio_icon_control',
		'section'      => 'header_account',
		'default'      => webapp()->default( 'header_account_icon' ),
		'label'        => esc_html__( 'Account Icon', 'coderplace-core' ),
		'partial'      => array(
			'selector'            => '.header-account-wrap',
			'container_inclusive' => true,
			'render_callback'     => 'CoderPlace\header_account',
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_style',
				'operator'   => 'contain',
				'value'      => 'icon',
			),
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'account' => array(
					'icon' => 'account',
				),
				'account2' => array(
					'icon' => 'account2',
				),
				'account3' => array(
					'icon' => 'account3',
				),
			),
			'responsive' => false,
		),
	),
	'header_account_action' => array(
		'control_type' => 'base_radio_icon_control',
		'section'      => 'header_account',
		'default'      => webapp()->default( 'header_account_action' ),
		'label'        => esc_html__( 'Account Action', 'coderplace-core' ),
		'transport'    => 'refresh',
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'link' => array(
					'name' => __( 'Link', 'coderplace-core' ),
				),
				'dropdown' => array(
					'name' => __( 'Dropdown Menu', 'coderplace-core' ),
				),
				'modal' => array(
					'name' => __( 'Modal Login', 'coderplace-core' ),
				),
			),
			'responsive' => false,
			'class'      => 'base-two-forced',
		),
	),
	'header_account_dropdown_direction' => array(
		'control_type' => 'base_radio_icon_control',
		'section'      => 'header_account',
		'default'      => webapp()->default( 'header_account_dropdown_direction' ),
		'label'        => esc_html__( 'Dropdown Direction', 'coderplace-core' ),
		'transport'    => 'refresh',
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
			array(
				'setting'    => 'header_account_action',
				'operator'   => '=',
				'value'      => 'dropdown',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'left' => array(
					'name' => __( 'Left', 'coderplace-core' ),
				),
				'right' => array(
					'name' => __( 'Right', 'coderplace-core' ),
				),
			),
			'responsive' => false,
			'class'      => 'base-two-forced',
		),
	),
	'header_account_modal_registration' => array(
		'control_type' => 'base_switch_control',
		'section'      => 'header_account',
		'context'      => array(
			array(
				'setting'    => 'header_account_action',
				'operator'   => '=',
				'value'      => 'modal',
			),
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
		),
		'default'      => webapp()->default( 'header_account_modal_registration' ),
		'label'        => esc_html__( 'Show registration link below login?', 'coderplace-core' ),
		'transport'    => 'refresh',
	),
	'header_account_modal_registration_link' => array(
		'control_type' => 'base_text_control',
		'section'      => 'header_account',
		'sanitize'     => 'esc_url_raw',
		'label'        => esc_html__( 'Registration Link', 'coderplace-core' ),
		'default'      => webapp()->default( 'header_account_modal_registration_link' ),
		'partial'      => array(
			'selector'            => '.header-account-wrap',
			'container_inclusive' => true,
			'render_callback'     => 'CoderPlace\header_account',
		),
		'priority'     => 20,
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
			array(
				'setting'    => 'header_account_action',
				'operator'   => '=',
				'value'      => 'modal',
			),
			array(
				'setting'    => 'header_account_modal_registration',
				'operator'   => '=',
				'value'      => true,
			),
		),
	),
	'header_account_link' => array(
		'control_type' => 'base_text_control',
		'section'      => 'header_account',
		'sanitize'     => 'esc_url_raw',
		'label'        => esc_html__( 'Account Item Link', 'coderplace-core' ),
		'default'      => webapp()->default( 'header_account_link' ),
		'partial'      => array(
			'selector'            => '.header-account-wrap',
			'container_inclusive' => true,
			'render_callback'     => 'CoderPlace\header_account',
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
			array(
				'setting'    => 'header_account_action',
				'operator'   => '!=',
				'value'      => 'modal',
			),
		),
	),
	'header_account_navigation_link' => array(
		'control_type' => 'base_focus_button_control',
		'section'      => 'header_account',
		'settings'     => false,
		'label'        => esc_html__( 'Select Menu', 'coderplace-core' ),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
			array(
				'setting'    => 'header_account_action',
				'operator'   => '=',
				'value'      => 'dropdown',
			),
		),
		'input_attrs'  => array(
			'section' => 'menu_locations',
		),
	),
	'info_header_account_design_logged_out' => array(
		'control_type' => 'base_title_control',
		'section'      => 'header_account_design',
		'label'        => esc_html__( 'Logged Out Options', 'coderplace-core' ),
		'settings'     => false,
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
		),
	),
	'header_account_icon_size' => array(
		'control_type' => 'base_range_control',
		'section'      => 'header_account_design',
		'label'        => esc_html__( 'Icon Size', 'coderplace-core' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-account-wrap .header-account-button .nav-drop-title-wrap > .base-svg-iconset, .header-account-wrap .header-account-button > .base-svg-iconset',
				'property' => 'font-size',
				'pattern'  => '$',
				'key'      => 'size',
			),
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
			array(
				'setting'    => 'header_account_style',
				'operator'   => 'contain',
				'value'      => 'icon',
			),
		),
		'default'      => webapp()->default( 'header_account_icon_size' ),
		'input_attrs'  => array(
			'min'        => array(
				'px'  => 0,
				'em'  => 0,
				'rem' => 0,
			),
			'max'        => array(
				'px'  => 100,
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
	'header_account_color' => array(
		'control_type' => 'base_color_control',
		'section'      => 'header_account_design',
		'label'        => esc_html__( 'Account Colors', 'coderplace-core' ),
		'default'      => webapp()->default( 'header_account_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-account-wrap .header-account-button',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.header-account-wrap .header-account-button:hover',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Color', 'coderplace-core' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Hover Color', 'coderplace-core' ),
					'palette' => true,
				),
			),
		),
	),
	'header_account_background' => array(
		'control_type' => 'base_color_control',
		'section'      => 'header_account_design',
		'label'        => esc_html__( 'Account Background', 'coderplace-core' ),
		'default'      => webapp()->default( 'header_account_background' ),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-account-wrap .header-account-button',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.header-account-wrap .header-account-button:hover',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Background', 'coderplace-core' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Hover Background', 'coderplace-core' ),
					'palette' => true,
				),
			),
		),
	),
	'header_account_radius' => array(
		'control_type' => 'base_measure_control',
		'section'      => 'header_account_design',
		'default'      => webapp()->default( 'header_account_radius' ),
		'label'        => esc_html__( 'Border Radius', 'coderplace-core' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-account-wrap .header-account-button',
				'property' => 'border-radius',
				'pattern'  => '$',
				'key'      => 'measure',
			),
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
		),
	),
	'header_account_typography' => array(
		'control_type' => 'base_typography_control',
		'section'      => 'header_account_design',
		'label'        => esc_html__( 'Label Font', 'coderplace-core' ),
		'default'      => webapp()->default( 'header_account_typography' ),
		'context'      => array(
			array(
				'setting'    => 'header_account_style',
				'operator'   => 'contain',
				'value'      => 'label',
			),
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => '.header-account-wrap .header-account-button .header-account-label',
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
			'id'      => 'header_account_typography',
			'options' => 'no-color',
		),
	),
	'header_account_padding' => array(
		'control_type' => 'base_measure_control',
		'section'      => 'header_account_design',
		'default'      => webapp()->default( 'header_account_padding' ),
		'label'        => esc_html__( 'Padding', 'coderplace-core' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-account-wrap .header-account-button',
				'property' => 'padding',
				'pattern'  => '$',
				'key'      => 'measure',
			),
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
		),
	),
	'header_account_margin' => array(
		'control_type' => 'base_measure_control',
		'section'      => 'header_account_design',
		'default'      => webapp()->default( 'header_account_margin' ),
		'label'        => esc_html__( 'Margin', 'coderplace-core' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-account-wrap',
				'property' => 'margin',
				'pattern'  => '$',
				'key'      => 'measure',
			),
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'out',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
		),
	),
	'info_header_account_logged_in' => array(
		'control_type' => 'base_title_control',
		'section'      => 'header_account',
		'label'        => esc_html__( 'Logged In Options', 'coderplace-core' ),
		'settings'     => false,
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
	),
	'header_account_in_style' => array(
		'control_type' => 'base_radio_icon_control',
		'section'      => 'header_account',
		'default'      => webapp()->default( 'header_account_in_style' ),
		'label'        => esc_html__( 'Account Style', 'coderplace-core' ),
		'partial'      => array(
			'selector'            => '.header-account-in-wrap',
			'container_inclusive' => true,
			'render_callback'     => 'CoderPlace\header_account',
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'label' => array(
					'name' => __( 'Label', 'coderplace-core' ),
				),
				'icon' => array(
					'name' => __( 'Icon', 'coderplace-core' ),
				),
				'label_icon' => array(
					'name' => __( 'Label + Icon', 'coderplace-core' ),
				),
				'icon_label' => array(
					'name' => __( 'Icon + Label', 'coderplace-core' ),
				),
				'user_label' => array(
					'name' => __( 'Avatar + Label', 'coderplace-core' ),
				),
				'label_user' => array(
					'name' => __( 'Label + Avatar', 'coderplace-core' ),
				),
				'user_name' => array(
					'name' => __( 'Avatar + User Name', 'coderplace-core' ),
				),
				'name_user' => array(
					'name' => __( 'User Name + Avatar', 'coderplace-core' ),
				),
				'icon_name' => array(
					'name' => __( 'Icon + User Name', 'coderplace-core' ),
				),
				'name_icon' => array(
					'name' => __( 'User Name + Icon', 'coderplace-core' ),
				),
			),
			'responsive' => false,
			'class'      => 'base-two-forced',
		),
	),
	'header_account_in_label' => array(
		'control_type' => 'base_text_control',
		'section'      => 'header_account',
		'sanitize'     => 'sanitize_text_field',
		'default'      => webapp()->default( 'header_account_in_label' ),
		'label'        => esc_html__( 'Account Label', 'coderplace-core' ),
		'context'      => array(
			array(
				'setting'    => 'header_account_in_style',
				'operator'   => 'contain',
				'value'      => 'label',
			),
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'html',
				'selector' => '.header-account-in-wrap .header-account-label',
				'pattern'  => '$',
				'key'      => '',
			),
		),
	),
	'header_account_in_icon' => array(
		'control_type' => 'base_radio_icon_control',
		'section'      => 'header_account',
		'default'      => webapp()->default( 'header_account_in_icon' ),
		'label'        => esc_html__( 'Account Icon', 'coderplace-core' ),
		'partial'      => array(
			'selector'            => '.header-account-in-wrap',
			'container_inclusive' => true,
			'render_callback'     => 'CoderPlace\header_account',
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_in_style',
				'operator'   => 'contain',
				'value'      => 'icon',
			),
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'account' => array(
					'icon' => 'account',
				),
				'account2' => array(
					'icon' => 'account2',
				),
				'account3' => array(
					'icon' => 'account3',
				),
			),
			'responsive' => false,
		),
	),
	'header_account_in_action' => array(
		'control_type' => 'base_radio_icon_control',
		'section'      => 'header_account',
		'default'      => webapp()->default( 'header_account_in_action' ),
		'label'        => esc_html__( 'Account Action', 'coderplace-core' ),
		'transport'    => 'refresh',
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'link' => array(
					'name' => __( 'Link', 'coderplace-core' ),
				),
				'dropdown' => array(
					'name' => __( 'Dropdown Menu', 'coderplace-core' ),
				),
			),
			'responsive' => false,
			'class'      => 'base-two-forced',
		),
	),
	'header_account_in_dropdown_source' => array(
		'control_type' => 'base_radio_icon_control',
		'section'      => 'header_account',
		'default'      => webapp()->default( 'header_account_in_dropdown_source' ),
		'label'        => esc_html__( 'Dropdown Source', 'coderplace-core' ),
		'transport'    => 'refresh',
		'context'      => array(
			array(
				'setting'    => 'header_account_in_action',
				'operator'   => '=',
				'value'      => 'dropdown',
			),
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'navigation' => array(
					'name' => __( 'Navigation Menu', 'coderplace-core' ),
				),
				'woocommerce' => array(
					'name' => __( 'Woocommerce Account Menu', 'coderplace-core' ),
				),
			),
			'responsive' => false,
			'class'      => 'base-two-forced',
		),
	),
	'header_account_in_dropdown_direction' => array(
		'control_type' => 'base_radio_icon_control',
		'section'      => 'header_account',
		'default'      => webapp()->default( 'header_account_in_dropdown_direction' ),
		'label'        => esc_html__( 'Dropdown Direction', 'coderplace-core' ),
		'transport'    => 'refresh',
		'context'      => array(
			array(
				'setting'    => 'header_account_in_action',
				'operator'   => '=',
				'value'      => 'dropdown',
			),
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
		'input_attrs'  => array(
			'layout' => array(
				'left' => array(
					'name' => __( 'Left', 'coderplace-core' ),
				),
				'right' => array(
					'name' => __( 'Right', 'coderplace-core' ),
				),
			),
			'responsive' => false,
			'class'      => 'base-two-forced',
		),
	),
	'header_account_in_link' => array(
		'control_type' => 'base_text_control',
		'section'      => 'header_account',
		'sanitize'     => 'esc_url_raw',
		'label'        => esc_html__( 'Account Item Link', 'coderplace-core' ),
		'default'      => webapp()->default( 'header_account_in_link' ),
		'partial'      => array(
			'selector'            => '.header-account-in-wrap',
			'container_inclusive' => true,
			'render_callback'     => 'CoderPlace\header_account',
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
	),
	'header_account_in_navigation_link' => array(
		'control_type' => 'base_focus_button_control',
		'section'      => 'header_account',
		'settings'     => false,
		'label'        => esc_html__( 'Select Menu', 'coderplace-core' ),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
			array(
				'setting'    => 'header_account_in_action',
				'operator'   => '=',
				'value'      => 'dropdown',
			),
			array(
				'setting'    => 'header_account_in_dropdown_source',
				'operator'   => '=',
				'value'      => 'navigation',
			),
		),
		'input_attrs'  => array(
			'section' => 'menu_locations',
		),
	),
	'info_header_account_design_logged_in' => array(
		'control_type' => 'base_title_control',
		'section'      => 'header_account_design',
		'label'        => esc_html__( 'Logged In Options', 'coderplace-core' ),
		'settings'     => false,
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
	),
	'header_account_in_icon_size' => array(
		'control_type' => 'base_range_control',
		'section'      => 'header_account_design',
		'label'        => esc_html__( 'Icon/Image Size', 'coderplace-core' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-account-in-wrap .header-account-button .nav-drop-title-wrap > .base-svg-iconset, .header-account-in-wrap .header-account-button > .base-svg-iconset',
				'property' => 'font-size',
				'pattern'  => '$',
				'key'      => 'size',
			),
			array(
				'type'     => 'css',
				'selector' => '.header-account-in-wrap .header-account-avatar',
				'property' => 'width',
				'pattern'  => '$',
				'key'      => 'size',
			),
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
		'default'      => webapp()->default( 'header_account_in_icon_size' ),
		'input_attrs'  => array(
			'min'        => array(
				'px'  => 0,
				'em'  => 0,
				'rem' => 0,
			),
			'max'        => array(
				'px'  => 100,
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
	'header_account_in_image_radius' => array(
		'control_type' => 'base_measure_control',
		'section'      => 'header_account_design',
		'default'      => webapp()->default( 'header_account_in_image_radius' ),
		'label'        => esc_html__( 'Avatar Border Radius', 'coderplace-core' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-account-in-wrap .header-account-avatar',
				'property' => 'border-radius',
				'pattern'  => '$',
				'key'      => 'measure',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_in_style',
				'operator'   => 'contain',
				'value'      => 'user',
			),
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
	),
	'header_account_in_color' => array(
		'control_type' => 'base_color_control',
		'section'      => 'header_account_design',
		'label'        => esc_html__( 'Account Colors', 'coderplace-core' ),
		'default'      => webapp()->default( 'header_account_in_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.site-header-item .header-account-in-wrap .header-account-button',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.site-header-item .header-account-in-wrap .header-account-button:hover',
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
					'tooltip' => __( 'Hover Color', 'coderplace-core' ),
					'palette' => true,
				),
			),
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
	),
	'header_account_in_background' => array(
		'control_type' => 'base_color_control',
		'section'      => 'header_account_design',
		'label'        => esc_html__( 'Account Background', 'coderplace-core' ),
		'default'      => webapp()->default( 'header_account_in_background' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.site-header-item .header-account-in-wrap .header-account-button',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.site-header-item .header-account-in-wrap .header-account-button:hover',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Background', 'coderplace-core' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Hover Background', 'coderplace-core' ),
					'palette' => true,
				),
			),
		),
	),
	'header_account_in_radius' => array(
		'control_type' => 'base_measure_control',
		'section'      => 'header_account_design',
		'default'      => webapp()->default( 'header_account_in_radius' ),
		'label'        => esc_html__( 'Border Radius', 'coderplace-core' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.site-header-item .header-account-in-wrap .header-account-button',
				'property' => 'border-radius',
				'pattern'  => '$',
				'key'      => 'measure',
			),
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
		),
	),
	'header_account_in_typography' => array(
		'control_type' => 'base_typography_control',
		'section'      => 'header_account_design',
		'label'        => esc_html__( 'Label/Name Font', 'coderplace-core' ),
		'default'      => webapp()->default( 'header_account_in_typography' ),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css_typography',
				'selector' => '.header-account-in-wrap .header-account-button .header-account-label, .header-account-in-wrap .header-account-button .header-account-username',
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
			'id'      => 'header_account_in_typography',
			'options' => 'no-color',
		),
	),
	'header_account_in_padding' => array(
		'control_type' => 'base_measure_control',
		'section'      => 'header_account_design',
		'default'      => webapp()->default( 'header_account_in_padding' ),
		'label'        => esc_html__( 'Padding', 'coderplace-core' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.site-header-item .header-account-in-wrap .header-account-button',
				'property' => 'padding',
				'pattern'  => '$',
				'key'      => 'measure',
			),
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
		),
	),
	'header_account_in_margin' => array(
		'control_type' => 'base_measure_control',
		'section'      => 'header_account_design',
		'default'      => webapp()->default( 'header_account_in_margin' ),
		'label'        => esc_html__( 'Margin', 'coderplace-core' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.header-account-in-wrap',
				'property' => 'margin',
				'pattern'  => '$',
				'key'      => 'measure',
			),
		),
		'context'      => array(
			array(
				'setting'    => 'header_account_preview',
				'operator'   => '=',
				'value'      => 'in',
			),
		),
		'input_attrs'  => array(
			'responsive' => false,
		),
	),
	// Transparent.
	'transparent_header_account_color' => array(
		'control_type' => 'base_color_control',
		'section'      => 'transparent_header_design',
		'label'        => esc_html__( 'Logged out Account Colors', 'coderplace-core' ),
		'default'      => webapp()->default( 'transparent_header_account_color' ),
		'context'      => array(
			array(
				'setting'  => '__device',
				'operator' => 'in',
				'value'    => array( 'desktop' ),
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.transparent-header .header-account-wrap .header-account-button',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.transparent-header .header-account-wrap .header-account-button:hover',
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
					'tooltip' => __( 'Hover Color', 'coderplace-core' ),
					'palette' => true,
				),
			),
		),
	),
	'transparent_header_account_background' => array(
		'control_type' => 'base_color_control',
		'section'      => 'transparent_header_design',
		'label'        => esc_html__( 'Logged out Account Background', 'coderplace-core' ),
		'default'      => webapp()->default( 'transparent_header_account_background' ),
		'context'      => array(
			array(
				'setting'  => '__device',
				'operator' => 'in',
				'value'    => array( 'desktop' ),
			),
		),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.transparent-header .header-account-wrap .header-account-button',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.transparent-header .header-account-wrap .header-account-button:hover',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Background', 'coderplace-core' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Hover Background', 'coderplace-core' ),
					'palette' => true,
				),
			),
		),
	),
	'transparent_header_account_in_color' => array(
		'control_type' => 'base_color_control',
		'section'      => 'transparent_header_design',
		'label'        => esc_html__( 'Logged in Account Colors', 'coderplace-core' ),
		'default'      => webapp()->default( 'transparent_header_account_in_color' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.transparent-header .site-header-item .header-account-in-wrap .header-account-button',
				'property' => 'color',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.transparent-header .site-header-item .header-account-in-wrap .header-account-button:hover',
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
					'tooltip' => __( 'Hover Color', 'coderplace-core' ),
					'palette' => true,
				),
			),
		),
		'context'      => array(
			array(
				'setting'  => '__device',
				'operator' => 'in',
				'value'    => array( 'desktop' ),
			),
		),
	),
	'transparent_header_account_in_background' => array(
		'control_type' => 'base_color_control',
		'section'      => 'transparent_header_design',
		'label'        => esc_html__( 'Logged in Account Background', 'coderplace-core' ),
		'default'      => webapp()->default( 'transparent_header_account_in_background' ),
		'live_method'     => array(
			array(
				'type'     => 'css',
				'selector' => '.transparent-header .site-header-item .header-account-in-wrap .header-account-button',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'color',
			),
			array(
				'type'     => 'css',
				'selector' => '.transparent-header .site-header-item .header-account-in-wrap .header-account-button:hover',
				'property' => 'background',
				'pattern'  => '$',
				'key'      => 'hover',
			),
		),
		'context'      => array(
			array(
				'setting'  => '__device',
				'operator' => 'in',
				'value'    => array( 'desktop' ),
			),
		),
		'input_attrs'  => array(
			'colors' => array(
				'color' => array(
					'tooltip' => __( 'Initial Background', 'coderplace-core' ),
					'palette' => true,
				),
				'hover' => array(
					'tooltip' => __( 'Hover Background', 'coderplace-core' ),
					'palette' => true,
				),
			),
		),
	),
);

Theme_Customizer::add_settings( $settings );
