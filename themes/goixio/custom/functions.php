<?php
/**
 * Base\Woocommerce\Component class
 *
 * @package base
 */

/*Add TGMPA library file */
require get_stylesheet_directory() . '/custom/theme-plugins-install.php';

add_theme_support( "wp-block-styles" );
add_theme_support( "custom-logo");
add_theme_support( "custom-header");
add_theme_support( "custom-background");
add_theme_support( 'register_block_style' );
add_theme_support( 'register_block_pattern' );


/********************************************************
**************** One Click Import Data ******************
********************************************************/
if ( ! function_exists( 'sampledata_import_files' ) ) :
	function sampledata_import_files() {
		return array(
			array(
				'import_file_name'            => 'goixio',
				'local_import_file'           => trailingslashit( get_stylesheet_directory() ) . 'custom/one-click/goixio-export.xml',
				'local_import_customizer_file'=> trailingslashit( get_stylesheet_directory() ) . 'custom/one-click/goixio_customizer_export.dat',
				'local_import_widget_file'    => trailingslashit( get_stylesheet_directory() ) . 'custom/one-click/goixio_widgets_settings.wie',
				'import_notice'               => esc_html__( 'Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'avanam' ),
			),
		);
	}
add_filter( 'pt-ocdi/import_files', 'sampledata_import_files' );
endif;


if ( ! function_exists( 'sampledata_after_import' ) ) :
	function sampledata_after_import($selected_import) {
		//Set Menu
		$main_menu = get_term_by('name', 'My Menu', 'nav_menu');
		set_theme_mod( 'nav_menu_locations' , array(
				'primary'   => $main_menu->term_id,
			)
		);

		echo esc_html__( '1', 'avanam' );
		
		if ( ! function_exists( 'base_sticky_post' ) ) :
			function base_sticky_post() {
				if ( is_sticky() )
				// translators: %s: Sticky
				echo '<span class="sticky-inner"><span class="sticky-post">'. esc_html__( 'sticky', 'avanam' ) . '</span></span>';		
			}
		endif;
		add_action('thebase_after_loop_entry_meta', 'base_sticky_post',10);

		echo esc_html__( '2', 'avanam' );

		//Set Front page and blog page
		$page = get_page_by_title( 'Home');
		if ( isset( $page->ID ) ) {
			update_option( 'page_on_front', $page->ID );
			update_option( 'show_on_front', 'page' );
		}
		$post = get_page_by_title( 'Blog');
		if ( isset( $page->ID ) ) {
			update_option( 'page_for_posts', $post->ID );
			update_option( 'show_on_posts', 'post' );
		}

		echo esc_html__( '3', 'avanam' );
		
		//Import Revolution Slider
		if ( class_exists( 'RevSlider' ) ) {
			$slider_array = array(
				get_stylesheet_directory()."/custom/one-click/goixio_slider.zip",
			//	get_stylesheet_directory()."/custom/one-click/goixio_video_slider.zip",
			);
			$slider = new RevSlider();

			foreach($slider_array as $filepath){
				$slider->importSliderFromPost(true,true,$filepath);
			}
			echo esc_html__( 'Slider import successfully', 'avanam' );
		}
		echo esc_html__( '4', 'avanam' );
	}
add_action( 'pt-ocdi/after_import', 'sampledata_after_import' );
endif;

function tempmela_change_time_of_single_ajax_call() {	
	return 180;
}
add_action( 'pt-ocdi/time_for_one_ajax_call', 'tempmela_change_time_of_single_ajax_call' );
/* remove notice info*/
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );