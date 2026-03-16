<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.5.2 for parent theme tm for publication
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */
/**
 * Include the TGM_Plugin_Activation class.
 */
require trailingslashit(get_stylesheet_directory()) . '/custom/class-tgm-plugin-activation.php' ;
add_action( 'tgmpa_register', 'tempmela_register_required_plugins' );
/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function tempmela_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// This is an example of how to include a plugin bundled with a theme.
		array(
			'order'     => 10,
			'name'      => esc_html__( 'Elementor', 'avanam' ),
			'slug'      => 'elementor',
			'required'  => true
		),
		array(
			'order'     => 20,
			'name'      => esc_html__( 'Contact Form 7', 'avanam' ),
			'slug'      => 'contact-form-7',
			'required'  => false,
		),
		array(
			'order'     => 30,
			'name'      => esc_html__( 'Newsletter', 'avanam' ),
			'slug'      => 'newsletter',
			'required'  => false,
		),
		array(
			'order'     => 40,
			'name'      => esc_html__( 'One Click Demo Import', 'avanam' ),
			'slug'      => 'one-click-demo-import',
			'required'  => false
		),
		array(
			'order'     => 50,
			'name'      => esc_html__( 'Woocommerce', 'avanam' ),
			'slug'      => 'woocommerce',
			'required'  => false,
		),
		array(
			'order'     => 60,
			'name'      => esc_html__('Woo Smart Quick View','avanam'),
			'slug'      => 'woo-smart-quick-view',
			'required'  => false,
		),
		array(
			'order'     => 70,
			'name'      => esc_html__( 'Woo Smart Compare', 'avanam' ),
			'slug'      => 'woo-smart-compare',			
			'required'  => false,
		),
		array(
			'order'     => 80,
			'name'      => esc_html__( 'Woo Smart Wishlist', 'avanam' ),
			'slug'      => 'woo-smart-wishlist',			
			'required'  => false,
		),
		array(
			'order'     => 90,
			'name'      => esc_html__( 'Filter Everything', 'avanam' ),
			'slug'      => 'filter-everything',
			'required'  => false,
		),
		array(
			'order'     		 => 100,
			'name'               => esc_html__( 'Custom Shortcodes', 'avanam' ), // The plugin name.
			'slug'               => 'custom-shortcodes', // The plugin slug (typically the folder name).
			'source'             => get_stylesheet_directory().'/custom/plugins/custom-shortcodes.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'order'     		 => 110,
			'name'     		     => esc_html__( 'Revolution Slider', 'avanam' ), // The plugin name.
			'slug'      		 => 'revslider', // The plugin slug (typically the folder name).
			'source'             => get_stylesheet_directory().'/custom/plugins/revslider.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		array(
			'order'     		 => 120,
			'name'     		     => esc_html__( 'CoderPlace Core', 'avanam' ), // The plugin name.
			'slug'      		 => 'coderplace-core', // The plugin slug (typically the folder name).
			'source'             => get_stylesheet_directory().'/custom/plugins/coderplace-core.zip', // The plugin source.
			'required'           => true, // If false, the plugin is only 'recommended' instead of required.
			'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher. If the plugin version is higher than the plugin version installed, the user will be notified to update the plugin.
			'external_url'       => '', // If set, overrides default API URL and points to an external URL.
			'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
	);
	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'avanam',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'theme-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => false,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);
	tgmpa( $plugins, $config );
}
?>