<?php
/**
 * One Click Import Data
 */

// Add CSS for the admin page.
function ocdi_admin_style() {
	wp_enqueue_style( 'ocdi-css', CPCORE_URL . 'admin/ocdi/ocdi.css', false, CPCORE_VERSION );
}
add_action( 'admin_enqueue_scripts', 'ocdi_admin_style' );


global $ocdi_import_config;
if ( !isset( $ocdi_import_config ) && defined( 'TMTHEME_PATH' ) ) {
	require_once TMTHEME_PATH . '/admin/ocdi-import.php';
}

if ( isset($ocdi_import_config) && !empty($ocdi_import_config) ) {
	add_filter( 'pt-ocdi/import_files', 'base_ocdi_import_files' );
	add_filter( 'ocdi/import_files', 'base_ocdi_import_files' );

	function base_ocdi_import_files() {
		global $ocdi_import_config;
		return $ocdi_import_config;
	}
}

function base_ocdi_upload_file_path( $download_directory_path ) {
	$uploads = wp_upload_dir();
	$data_path = untrailingslashit( $uploads['basedir'] ) . '/coderplace-data/';
	if ( ! file_exists( $data_path ) ) {
		mkdir( $data_path, 0750, true );
	}
	return $data_path;
}
add_filter( 'pt-ocdi/upload_file_path', 'base_ocdi_upload_file_path' );
add_filter( 'ocdi/upload_file_path', 'base_ocdi_upload_file_path' );


function base_ocdi_after_content_import_execution( $selected_import_files, $import_files, $selected_index ) {

	$ocdi       = OCDI\OneClickDemoImport::get_instance();
	$log_path   = $ocdi->get_log_file_path();
	OCDI\Helpers::append_to_file( 'Slider Revolution Import.', $log_path );

	$downloader = new OCDI\Downloader();
	// Import Revolution Slider
	if ( class_exists( 'RevSlider' ) ) :
		if ( ! empty( $import_files[ $selected_index ]['import_revslider_url'] ) ) :
			$file_path = $downloader->download_file( $import_files[ $selected_index ]['import_revslider_url'], 'demo-revslider-import-file-' . $index . '-' . date( 'Y-m-d__H-i-s' ) . '.zip' );
			if ( $file_path ) :
				$slider = new RevSlider();
				$slider->importSliderFromPost( true, true, $file_path );
			endif;
		endif;
   endif;

	delete_transient( '_revslider_welcome_screen_activation_redirect' );
}
add_action( 'pt-ocdi/after_content_import_execution', 'base_ocdi_after_content_import_execution', 3, 99 );
add_action( 'ocdi/after_content_import_execution', 'base_ocdi_after_content_import_execution', 3, 99 );


function base_ocdi_time_for_one_ajax_call() {
	return 180;
}
add_action( 'pt-ocdi/time_for_one_ajax_call', 'base_ocdi_time_for_one_ajax_call' );
add_action( 'ocdi/time_for_one_ajax_call', 'base_ocdi_time_for_one_ajax_call' );


function ocdi_plugin_page_setup( $default_settings ) {
	$default_settings['parent_slug'] = 'themes.php';
	$default_settings['page_title']  = esc_html__( 'CoderPlace - One Click Demo Import', 'one-click-demo-import' );
	//$default_settings['menu_title']  = esc_html__( 'CoderPlace Demos', 'one-click-demo-import' );
	$default_settings['capability']  = 'import';
	$default_settings['menu_slug']   = 'one-click-demo-import';

	return $default_settings;
}
add_filter( 'pt-ocdi/plugin_page_setup', 'ocdi_plugin_page_setup' );
add_filter( 'ocdi/plugin_page_setup', 'ocdi_plugin_page_setup' );


function ocdi_register_plugins( $plugins ) {

	global $recommended_plugins;
	return array_merge( $plugins, $recommended_plugins );
}
add_filter( 'pt-ocdi/register_plugins', 'ocdi_register_plugins' );
add_filter( 'ocdi/register_plugins', 'ocdi_register_plugins' );


function base_plugin_intaller_after_plugin_activation() {

	if ( did_action( 'elementor/loaded' ) ) {
		remove_action( 'admin_init', array( \Elementor\Plugin::$instance->admin, 'maybe_redirect_to_getting_started' ) );
	}
	delete_transient( '_wc_activation_redirect' );
	delete_transient( '_revslider_welcome_screen_activation_redirect' );
	delete_transient( '_vc_page_welcome_redirect' );
	delete_transient( 'elementor_activation_redirect' );
	delete_transient( 'leadin_redirect_after_activation' );
	delete_transient( '_wc_gzd_activation_redirect' );
	delete_option( '_wc_gzd_setup_wizard_redirect' );
	delete_option( 'c4wp_redirect_after_activation' );
	add_filter( 'woocommerce_enable_setup_wizard', '__return_false' );
	add_filter( 'monsterinsights_enable_onboarding_wizard', '__return_false' );
	remove_action( 'admin_menu', 'vc_menu_page_build' );
	remove_action( 'network_admin_menu', 'vc_network_menu_page_build' );
	remove_action( 'vc_activation_hook', 'vc_page_welcome_set_redirect' );
	remove_action( 'admin_init', 'vc_page_welcome_redirect' );
	update_option( 'should_redirect_after_install_free', false );

}
add_filter( 'pt-ocdi/plugin_intaller_after_plugin_activation', 'base_plugin_intaller_after_plugin_activation' );
add_filter( 'ocdi/plugin_intaller_after_plugin_activation', 'base_plugin_intaller_after_plugin_activation' );


add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );
add_filter( 'ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
add_filter( 'ocdi/disable_pt_branding', '__return_true' );

// NOTE:  ocdi/after_import  will be used in theme plugin
