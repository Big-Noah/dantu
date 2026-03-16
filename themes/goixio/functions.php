<?php
/**
 * Custom Function
 */
require get_stylesheet_directory() . '/custom/functions.php';

/**
 * Setup Child Theme Styles
 */
function goixio_enqueue_styles() {	
	wp_enqueue_style( 'goixio-style', get_stylesheet_directory_uri() . '/style.css', false, '1.0.0' );
	wp_enqueue_style( 'child-owlcarousel', get_stylesheet_directory_uri() . '/assets/css/owl-carousel.min.css', array(), 102);
	
}
add_action( 'wp_enqueue_scripts', 'goixio_enqueue_styles', 20 );

/**
 * Setup Child Theme Java Script
 */	
function goixio_load_scripts_child() {			
	wp_enqueue_script( 'child-theme-js', get_stylesheet_directory_uri() . '/assets/js/custom.js', array(), 103);
	wp_enqueue_script( 'child-owl-carousel', get_stylesheet_directory_uri() . '/assets/js/owlcarousel.min.js', array(), 104);
	wp_enqueue_script( 'countdown-js', get_stylesheet_directory_uri() . '/assets/js/countdown.min.js', array(), 105);	
}
add_action( 'wp_enqueue_scripts', 'goixio_load_scripts_child' );

/**
 * Setup Child Theme Palettes
 *
 * @param string $palettes registered palette json.
 * @return string
 */
function goixio_change_palette_defaults( $palettes ) {
	$palettes = '{"palette":[
			{"color":"#111111","slug":"palette1","name":"Palette Color 1"},
			{"color":"#111111","slug":"palette3","name":"Palette Color 2"},
			{"color":"#111111","slug":"palette3","name":"Palette Color 3"},
			{"color":"#111111","slug":"palette4","name":"Palette Color 4"},
			{"color":"#777777","slug":"palette5","name":"Palette Color 5"},
			{"color":"#111111","slug":"palette6","name":"Palette Color 6"},
			{"color":"#e5e5e5","slug":"palette7","name":"Palette Color 7"},
			{"color":"#f5f5f5","slug":"palette8","name":"Palette Color 8"},
			{"color":"#FFFFFF","slug":"palette9","name":"Palette Color 9"}],
			
			"second-palette":[				
			{"color":"#2B6CB0","slug":"palette1","name":"Palette Color 1"},
			{"color":"#215387","slug":"palette3","name":"Palette Color 2"},
			{"color":"#1A202C","slug":"palette3","name":"Palette Color 3"},
			{"color":"#2D3748","slug":"palette4","name":"Palette Color 4"},
			{"color":"#4A5568","slug":"palette5","name":"Palette Color 5"},
			{"color":"#718096","slug":"palette6","name":"Palette Color 6"},
			{"color":"#EDF2F7","slug":"palette7","name":"Palette Color 7"},
			{"color":"#F7FAFC","slug":"palette8","name":"Palette Color 8"},
			{"color":"#ffffff","slug":"palette9","name":"Palette Color 9"}],
			
			"third-palette":[
			{"color":"#2B6CB0","slug":"palette1","name":"Palette Color 1"},
			{"color":"#215387","slug":"palette3","name":"Palette Color 2"},
			{"color":"#1A202C","slug":"palette3","name":"Palette Color 3"},
			{"color":"#2D3748","slug":"palette4","name":"Palette Color 4"},
			{"color":"#4A5568","slug":"palette5","name":"Palette Color 5"},
			{"color":"#718096","slug":"palette6","name":"Palette Color 6"},
			{"color":"#EDF2F7","slug":"palette7","name":"Palette Color 7"},
			{"color":"#F7FAFC","slug":"palette8","name":"Palette Color 8"},
			{"color":"#ffffff","slug":"palette9","name":"Palette Color 9"}],"active":"palette"}';
	return $palettes;
}
add_filter( 'base_global_palette_defaults', 'goixio_change_palette_defaults', 10);

/**
 * Setup Child Theme Defaults
 *
 * @param array $defaults registered option defaults with kadence theme.
 * @return array
 */

/**
 * Siderbar popup toggle in Responsive
 */
function sidebar_popup_toggle() {	
	?>
	<div class="side-mobile-toggle-open-container">		
		<button id="side-mobile-toggle" class="side-menu-toggle-open drawer-toggle">			
			<span class="menu-toggle-icon">Open</span>
		</button>
	</div>
	<?php
}
add_action( 'base_hero_header', 'sidebar_popup_toggle' );

function close_shop_filter() {	
	?>
	<div class="base-hide-sidebar-btn">		
		<button id="menu-toggle-icon" class="menu-toggle-close">			
			<span class="menu-toggle-icon">close</span>
		</button>
	</div>
	<?php
}
add_action( 'base_before_sidebar', 'close_shop_filter' );


function themename_change_option_defaults( $defaults ) {
	$new_defaults = array(
		'site_background' => array(
			'desktop' => array(
				'color' => 'palette9',
			),
		),
		'content_width'   => array(
			'size' => 1400,
			'unit' => 'px',
		),
		'content_edge_spacing'   => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 0,
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'boxed_grid_spacing'   => array(
			'size' => array(
				'mobile'  => 1,
				'tablet'  => 1,
				'desktop' => 1,
			),
			'unit' => array(
				'mobile'  => 'rem',
				'tablet'  => 'rem',
				'desktop' => 'rem',
			),
		),
		// Typography.
		'base_font' => array(
			'size' => array(
				'desktop' => 16,
			),
			'lineHeight' => array(
				'desktop' => 1.6,
			),
			'family'  => 'Red Hat Display',
			'google'  => true,
			'weight'  => '500',
			'variant' => '500',
			'color'   => 'palette2',
			'letterSpacing' => array(
				'desktop' => '0.3',
			),
			'spacingType'=> 'px',
		),
		'heading_font'        => array(
			'family' => 'Red Hat Display',
		),
		'h1_font' => array(
			'size' => array(
				'desktop' => 30,
			),
			'lineHeight' => array(
				'desktop' => 1.5,
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '700',
			'variant' => '700',
			'color'   => 'palette2',
		),
		'h2_font' => array(
			'size' => array(
				'desktop' => 24,
				'mobile'  => 18,
			),
			'lineHeight' => array(
				'desktop' => 1.5,
				'mobile' => 1.5,
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '700',
			'variant' => '6
			00',
			'color'   => 'palette2',
		),
		'h3_font' => array(
			'size' => array(
				'desktop' => 20,
			),
			'lineHeight' => array(
				'desktop' => 1.5,
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '700',
			'variant' => '700',
			'color'   => 'palette2',
		),
		'h4_font' => array(
			'size' => array(
				'desktop' => 18,
			),
			'lineHeight' => array(
				'desktop' => 1.5,
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
			'color'   => 'palette2',
		),
		'h5_font' => array(
			'size' => array(
				'desktop' => 20,
			),
			'lineHeight' => array(
				'desktop' => 2.4,
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '700',
			'variant' => '700',
			'color'   => 'palette2',
		),
		'h6_font' => array(
			'size' => array(
				'desktop' => 16,
			),
			'lineHeight' => array(
				'desktop' => 1.2,
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
			'color'   => 'palette2',
			'letterSpacing' => array(
				'desktop' => '0.2',
			),
			'spacingType'=> 'px',
		),
		// Header.
		'header_desktop_items'       => array(
			'top' => array(
				'top_left'         => array('html'),
				'top_left_center'  => array(),
				'top_center'       => array(),
				'top_right_center' => array(),
				'top_right'        => array('html2','account'),
			),
			'main' => array(
				'main_left'         => array('logo'),
				'main_left_center'  => array(),
				'main_center'       => array('toggle-widget','search-bar'),
				'main_right_center' => array(),
				'main_right'        => array('navigation-3','cart'),
			),
			'bottom' => array(
				'bottom_left'         => array('navigation'),
				'bottom_left_center'  => array(),
				'bottom_center'       => array(),
				'bottom_right_center' => array(),
				'bottom_right'        => array('button'),
			),
		),

		// header_bottom 

		'header_bottom_layout'        => array(
			'mobile'  => '',
			'tablet'  => '',
			'desktop' => 'fullwidth',
		),
		'header_bottom_height'       => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 55,
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'header_bottom_background'  => array(
			'desktop' => array(
				'color' => 'palette9',
			),
			'tablet' => array(
				'color' => 'palette9',
			),
		),
		'logo_layout'     => array(
			'include' => array(
				'mobile'  => 'logo_only',
				'tablet'  => 'logo_only',
				'desktop' => 'logo_only',
				),
			'layout' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 'standard',
				),
		),
		'logo_width' => array(
			'size' => array(
				'mobile'  => 140,
				'tablet'  => 170,
				'desktop' => 170,
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),	
	
		// Buttons.
		'buttons_border'        => array(),
		'buttons_border_radius' => array(
			'size' => array(
				'mobile'  => '5',
				'tablet'  => '5',
				'desktop' => '5',
			),
		'unit' => array(
			'mobile'  => 'px',
			'tablet'  => 'px',
			'desktop' => 'px',
			),
		),
		'buttons_color'  => array(
			'color'  => 'palette9',
			'hover'  => 'palette9',
		),
		'buttons_background' => array(
			'color'  => 'palette1',
			'hover'  => 'palette1',
		),
		'buttons_typography'    => array(
			'size' => array(
				'desktop' => '16',
			),
			'lineHeight' => array(
				'desktop' => '1',
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
			'transform' => 'capitalize',
		),
		// Header Top.
		'header_top_layout'        => array(
			'mobile'  => '',
			'tablet'  => '',
			'desktop' => 'fullwidth',
		),
		'header_top_height' => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '42',
				'desktop' => '42',
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'header_top_bottom_border' => array(
			'desktop' => array(
				'width' => 0,
				'unit'  => 'px',
				'style' => 'solid',
				'color'   => 'palette5',
				),
		),
		'header_top_padding' => array(
			'size'   => array( 
				'desktop' => array( '', '', '', '' ),
			),
			'unit'   => array(
				'desktop' => 'px',
			),
			'locked' => array(
				'desktop' => false,
			),
		),
		'brand_typography'            => array(
						'size' => array(
							'desktop' => 26,
						),
						'lineHeight' => array(
							'desktop' => 1.2,
						),
						'family'  => 'inherit',
						'google'  => false,
						'weight'  => '700',
						'variant' => '700',
						'color'   => 'palette9',
					),
		// Header Main.
		'header_main_background' => array(
						'desktop' => array(
							'color' => 'palette1',
						),
					),
		'header_main_layout'         => array(
			'mobile'  => '',
			'tablet'  => '',
			'desktop' => 'fullwidth',
		),
		'header_main_height' => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '84',
				'desktop' => 84,
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'header_main_top_border'    => array(
			'desktop' => array(
				'width' => 1,
				'unit'  => 'px',
				'style' => 'solid',
				'color'  => '#ffffff30',
			),
		),
		'header_main_bottom_border' => array(
				'desktop' => array(
				'width' => 0,
				'unit'  => 'px',
				'style' => 'solid',
				'color'  => 'palette5',
			),
		),
		'header_main_padding' => array(
			'size'   => array( 
				'desktop' => array( '', '', '', '' ),
			),
			'unit'   => array(
				'desktop' => 'px',
			),
			'locked' => array(
				'desktop' => false,
			),
		),


		// Header Bottom.
		'header_bottom_padding' => array(
			'size'   => array( 
				'desktop' => array( '', '', '', '' ),
			),
			'unit'   => array(
				'desktop' => 'px',
			),
			'locked' => array(
				'desktop' => false,
			),
		),
		// Header Search.
		'header_search_color'              => array(
			'color' => 'palette2',
			'hover' => 'palette2',
		),
		'header_search_typography'            => array(
			'size' => array(
				'desktop' => '24',
			),
			'lineHeight' => array(
				'desktop' => '',
			),
			'family'  => 'inherit',
			'google'  => false,
			'weight'  => '',
			'variant' => '',
		),
		'header_search_icon_size' => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 1,
			),
			'unit' => array(
				'mobile'  => 'em',
				'tablet'  => 'em',
				'desktop' => 'em',
			),
		),
		'header_search_bar_width' => array(
				'size' => 850,
				'unit' => 'px',
		),
		'header_mobile_search_bar_width' => array(
			'size' => 400,
			'unit' => 'px',
		),
		'header_search_bar_color' => array(
			'color' => 'palette2',
			'hover' => 'palette2',
		),
		'header_search_bar_border' => array(
			'width' => 0,
			'unit'  => 'px',
			'style' => 'solid',
			'color' => 'palette5',
		),
		'header_mobile_search_bar_border' => array(
			'width' => 1,
			'unit'  => 'px',
			'style' => 'solid',
			'color' => 'palette9',
		),
		'header_mobile_search_bar_border_color' => array(
			'color' => 'palette9',
			'hover' => 'palette9',
		),
		// Header Contact
		'header_contact_items' => array(
			'items' => array(
				array(
				'id'      => 'phone',
				'enabled' => false,
				'source'  => 'icon',
				'url'     => '',
				'imageid' => '',
				'width'   => 24,
				'link'    => '',
				'icon'    => 'phoneAlt',
				'label'   => 'Call Us : (+01) 589 559 555',
				),
				array(
				'id'      => 'email',
				'enabled' => false,
				'source'  => 'icon',
				'url'     => '',
				'imageid' => '',
				'width'   => 24,
				'link'    => '',
				'icon'    => 'emailAlt2',
				'label'   => 'example@gmail.com',
				),
				array(
				'id'      => 'hours',
				'enabled' => false,
				'source'  => 'icon',
				'url'     => '',
				'imageid' => '',
				'width'   => 24,
				'link'    => '',
				'icon'    => 'hoursAlt',
				'label'   => 'Mon - Fri: 09:00 - 17:00',
				),
			),
		),
		'header_mobile_contact_items' => array(
			'items' => array(
				array(
				'id'      => 'phone',
				'enabled' => true,
				'source'  => 'icon',
				'url'     => '',
				'imageid' => '',
				'width'   => 24,
				'link'    => '',
				'icon'    => 'phoneAlt',
				'label'   => 'Call Us : (+01) 589 559 555',
				),
				array(
				'id'      => 'email',
				'enabled' => true,
				'source'  => 'icon',
				'url'     => '',
				'imageid' => '',
				'width'   => 24,
				'link'    => '',
				'icon'    => 'emailAlt2',
				'label'   => 'example@gmail.com',
				),
				array(
				'id'      => 'hours',
				'enabled' => false,
				'source'  => 'icon',
				'url'     => '',
				'imageid' => '',
				'width'   => 24,
				'link'    => '',
				'icon'    => 'hoursAlt',
				'label'   => 'Mon - Fri: 09:00 - 17:00',
				),
			),
		),
		'header_contact_item_spacing' => array(
			'size' => 25,
			'unit' => 'px',
		),
		'header_contact_icon_size' => array(
			'size' => '15',
			'unit' => 'px',
		),
		'header_contact_color' => array(
			'color' => 'palette2',
			'weight'  => '500',
			'variant' => '500',
			),
		// Header Cart.
		'header_cart_label' => 'My Cart',
		'header_cart_style' => 'slide',
		'header_cart_icon' => 'shopping-cart',					
		'header_cart_icon_size' => array(
			'size' => '24',
			'unit' => 'px',
		),	
		'header_cart_color' => array(
			'color' => 'palette9',
			'hover' => 'palette9', 
		),
		'header_cart_total_color' => array(
			'color' => 'palette9',
			'hover' => 'palette9',
		),
		'header_cart_total_background' => array(
			'color' => 'palette1',
			'hover' => 'palette1',
		),
		'header_cart_typography' => array(
			'size' => array(
				'desktop' => '15',
			),
			'lineHeight' => array(
				'desktop' => '',
			),
			'family'  => 'inherit',
			'google'  => false,
			'weight'  => '500',
			'variant' => '',
		),
		'header_cart_padding' => array(
			'size'   => array( '', '', '', '0' ),
			'unit'   => 'px',
			'locked' => false,
		),
		// Header Divider.
		'header_divider_border' => array(
			'width' => 1,
			'unit'  => 'px',
			'style' => 'solid',
			'color' => 'palette7',
		),
		'header_divider_height'=> array(
			'size' => '35',
			'unit' => 'px',
		),
		'header_divider_margin' => array(
			'size'   => array( '', '20', '', '20' ),
			'unit'   => 'px',
			'locked' => false,
		),
		// Header Divider.
		'header_divider2_border'=> array(
			'width' => 1,
			'unit'  => 'px',
			'style' => 'solid',
			'color' => '#D2B611',
		),
		'header_divider2_height'=> array(
			'size' => '23',
			'unit' => 'px',
		),
		'header_divider2_margin' => array(
			'size'   => array( '', '0', '', '32' ),
			'unit'   => 'px',
			'locked' => false,
		),
		'header_contact_margin' => array(
			'size'   => array( '0', '10', '0', '0' ),
			'unit'   => 'px',
			'locked' => false,
		),		
		// Header HTML1.
		'header_html_content'    => __( 'Get 50% off on new items, Limited Time Only!', 'avanam' ),
		
		// Header HTML2
		'header_html2_content'    => __( '<a href="https://coderplace.net/woo/WCM03/WCM03068/contact-us/">Store Locator</a><a href="https://coderplace.net/woo/WCM03/WCM03068/orders/">Track Your Order</a>', 'avanam' ),
		'header_html2_link_color'   => array(
			'color' => 'palette5',
			'hover' => 'palette5',
		),
		'header_html2_typography' => array(
			'size' => array(
				'desktop' => '15',
			),
			'lineHeight' => array(
				'desktop' => '',
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
			'color'   => 'palette5',
		),
		// Header Account
		'header_account_in_style' => __( 'label'),
		'header_account_style' => __( 'icon_label'),
		'header_account_in_label' => __( 'My Account', 'avanam' ),
		'header_account_label' => __( 'Login', 'avanam' ),	
		'header_account_in_link' => 'https://coderplace.net/woo/WCM03/WCM03068/my-account/',
		'header_account_link' => 'https://coderplace.net/woo/WCM03/WCM03068/my-account/',
		'header_account_in_action' => 'dropdown',
		'header_account_in_dropdown_source' => 'woocommerce',
		'header_account_in_icon_size' => array(
			'size' => '15',
			'unit' => 'px',
		),
		'header_account_in_dropdown_direction' => 'left',
		'header_account_in_color' => array(
			'color'  => 'palette5',
			'hover'  => 'palette5',
		),
		'header_account_in_typography' => array(
			'size' => array(
				'desktop' => '15',
			),
			'unit' => array(
				'desktop' => 'px',
			),
			'lineHeight' => array(
				'desktop' => '',
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
			'transform' => 'capitalize',
		),
		// Header Mobile Account
		'header_mobile_account_in_style' => __( 'icon_label'),
		'header_mobile_account_style' => __( 'icon_label'),
		'header_mobile_account_in_label' => __( 'Account', 'avanam' ),
		'header_mobile_account_label' => __( 'Login', 'avanam' ),	
		'header_mobile_account_in_link' => 'https://coderplace.net/woo/WCM03/WCM03068/my-account/',
		'header_mobile_account_link' => 'https://coderplace.net/woo/WCM03/WCM03068/my-account/',

		// Mobile Header.
		'header_mobile_items' => array(	
			'popup' => array(
				'popup_content' => array('mobile-navigation'),
			),	
			'top' => array(
				'top_left'   => array(),
				'top_center' => array('html2','account'),
				'top_right'  => array(),
			),
			'main' => array(
				'main_left'   => array( 'mobile-logo', 'mobile-toggle-widget'),
				'main_center' => array(),
				'main_right'  => array( 'popup-toggle','navigation-3','mobile-cart'),
			),
			'bottom' => array(
				'bottom_left'   => array('mobile-search-bar'),
				'bottom_center' => array(),
				'bottom_right'  => array('button'),
			),
		),
		
		// Mobile Trigger.
		'mobile_trigger_color' => array(
			'color' => 'palette9',
			'hover' => 'palette9',
		),
		'mobile_trigger_icon'   => 'menu3',
		'mobile_trigger_icon_size'   => array(
			'size' => 24,
			'unit' => 'px',
		),
		'header_mobile_search_bar_margin'  => array(
			'size'   => array( '8', '0', '8', '0' ),
			'unit'   => 'px',
			'locked' => false,
		),
		'mobile_secondary_navigation_vertical_spacing' => array(
			'size' => '24',
			'unit' => 'px',
		),
		// Mobile Navigation.
		'mobile_navigation_color'  => array(
			'color'  => 'palette2',
			'hover'  => 'palette2',
			'active' => 'palette2',
		),
		'mobile_navigation_vertical_spacing'   => array(
			'size' => 0.6,
			'unit' => 'em',
		),
		'mobile_navigation_divider' => array(
			'width' => 1,
			'unit'  => 'px',
			'style' => 'solid',
			'color' => 'palette7',
		),
		'mobile_navigation_typography' => array(
			'size' => array(
				'desktop' => 15,
			),
			'lineHeight' => array(
				'desktop' => '',
			),
			'family'  => 'inherit',
			'google'  => false,
			'weight'  => '',
			'variant' => '',
		),
		// Mobile Cart.
		'header_mobile_cart_style' => 'slide',
		// Mobile Header HTML1.
		'mobile_html_content'    => __( 'Biggest Offer On -WaterProof, DSLR Camera Lenses & Earphones', 'avanam' ),	
		'mobile_html_margin' => array(
			'size'   => array( '0', '0', '0', '0' ),
			'unit'   => 'px',
			'locked' => false,
		),
		'header_mobile_account_in_style' => __( 'icon_label'),
		
		'mobile_button_shadow' => array(
			'color'   => 'rgba(0,0,0,0)',
			'hOffset' => 0,
			'vOffset' => 0,
			'blur'    => 0,
			'spread'  => 0,
			'inset'   => false,
		),
		'mobile_button_shadow_hover' => array(
			'color'   => 'rgba(0,0,0,0)',
			'hOffset' => 0,
			'vOffset' => 0,
			'blur'    => 0,
			'spread'  => 0,
			'inset'   => false,
		),
		// Dropdown.
		'dropdown_navigation_reveal' => 'fade-down',
		'dropdown_navigation_width'  => array(
			'size' => 220,
			'unit' => 'px',
		),
		'dropdown_navigation_vertical_spacing'   => array(
			'size' => 5,
			'unit' => 'px',
		),
		'dropdown_navigation_color'              => array(
			'color'  => 'palette2',
			'hover'  => 'palette2',
			'active' => 'palette2',
		),
		'dropdown_navigation_background'              => array(
			'color'  => 'palette9',
			'hover'  => 'palette9',
			'active' => 'palette9',
		),
		'dropdown_navigation_typography'            => array(
			'size' => array(
				'desktop' => 15,
			),
			'lineHeight' => array(
				'desktop' => '1.6',
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
		),
		// Navigation.
		'primary_navigation_typography'   => array(
			'size' => array(
				'desktop' => '15',
			),
			'unit' => array(
				'desktop' => 'px',
			),
			'lineHeight' => array(
				'desktop' => '1.2',
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
			'transform' => 'uppercase',
		),
		'primary_navigation_vertical_spacing'   => array(
			'size' => 35,
			'unit' => 'px',
		),
		'primary_navigation_color' => array(
			'color'  => 'palette2',
			'hover'  => 'palette2',
			'active' => 'palette2',
		),
		'primary_navigation_spacing' => array(
			'size' => 48,
			'unit' => 'px',
		),
		//Header Toggle Widget
		'header_toggle_widget_label' => __( '', 'avanam' ),
		'header_toggle_widget_color' => array(
			'color'  => 'palette9',
			'hover'  => 'palette9',
			'active' => 'palette9',
		),
		'header_toggle_widget_side'=> 'left',
		'header_toggle_widget_icon_size' => array(
			 'size' => '24',		
			 'unit' => 'px',			
		),			
		'header_toggle_widget_typography' => array(
			'size' => array(
				'desktop' => '',
			),
			'unit' => array(
				'desktop' => '',
			),
			'lineHeight' => array(
				'desktop' => '1.2',
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
			'transform' => 'capitalize',
		),
		'header_toggle_widget_pop_background' => array(
			'desktop' => array(
				'color' => 'palette9',
			),
		),
		'header_toggle_widget_close_color' => array(
			'color' => 'palette3',
		),
		'header_widget2_title' => array(
			'size' => array(
				'desktop' => '18',
			),
			'unit' => array(
				'desktop' => 'px',
			),
			'lineHeight' => array(
				'desktop' => '1.2',
			),
			'family'  => 'inherit',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
			'transform' => 'capitalize',
		),
		'header_widget2_link_colors' => array(
			'color' => 'palette2',
			'hover' => 'palette2',
		),
		'header_toggle_widget_padding' => array(
			'size'   => array( 
				'desktop' => array( '0', '0', '0', '0' ),
			),
			'unit'   => array(
				'desktop' => 'px',
			),
			'locked' => array(
				'desktop' => false,
			),
		),
		
		// Header Button.
		'header_sticky_background' => array(
			'desktop' => array(
				'color' => 'palette1',
			),
		),
		'header_top_background'    => array(
			'desktop' => array(
				'color' => 'palette1',
			),
		),
		'header_html_typography' => array(
			'size' => array(
				'desktop' => '15',
			),
			'lineHeight' => array(
				'desktop' => '',
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
			'color'   => 'palette5',
		),
		'header_button_label'      => __( '+(01) 123-456-789', 'avanam' ),
		'header_button_link'      => 'https://coderplace.net/woo/WCM03/WCM03068/shop/',
		'header_button_padding'   => array(
			'size'   => array( '11', '29', '11', '29' ),
			'unit'   => 'px',
			'locked' => false,
		),
		'header_button_color'  => array(
			'color' => 'palette9',
			'hover' => 'palette9',
		),
		'header_button_background' => array(
			'color' => 'palette1',
			'hover' => 'palette1',
		),
		'header_button_shadow_hover' => array(
			'color'   => '0',
			'hOffset' => 0,
			'vOffset' => 0,
			'blur'    => 0,
			'spread'  => 0,
			'inset'   => false,
		),
		'header_button_typography' => array(
			'size' => array(
				'desktop' => '16',
			),
			'lineHeight' => array(
				'desktop' => '1.2',
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
		),
		'header_button_size' => 'custom',
		// Header Button2.
		'header_button2_label' => __( 'Gift Cards', 'avanam' ),
		'header_button2_link'  => 'https://coderplace.net/woo/WCM03/WCM03068/shop/',
		'header_button2_padding'   => array(
			'size'   => array( '0', '0', '0', '0' ),
			'unit'   => 'px',
			'locked' => false,
		),
		'header_button2_color'  => array(
			'color' => 'palette3',
			'hover' => 'palette3',
		),
		'header_button2_background' => array(
			'color' => 'transparent',
			'hover' => 'transparent',
		),
		'header_button2_shadow_hover' => array(
			'color'   => '0',
			'hOffset' => 0,
			'vOffset' => 0,
			'blur'    => 0,
			'spread'  => 0,
			'inset'   => false,
		),
		'header_button2_typography' => array(
			'size' => array(
				'desktop' => '16',
			),
			'lineHeight' => array(
				'desktop' => '1.2',
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '700',
			'variant' => '700',
		),
		'header_button2_size' => 'custom',
		'header_button2_margin' => array(
			'size'   => array( '', '', '', '30' ),
			'unit'   => 'px',
			'locked' => false,
		),
		'content_spacing'   => array(
			'size' => array(
				'mobile'  => 3,
				'tablet'  => 3,
				'desktop' => 3,
			),
			'unit' => array(
				'mobile'  => 'rem',
				'tablet'  => 'rem',
				'desktop' => 'rem',
			),
		),
		// Sidebar.
		'sidebar_width'   => array(
			'size' => '21',
			'unit' => '%',
		),
		'sidebar_widget_spacing'   => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 2,
			),
			'unit' => array(
				'mobile'  => 'em',
				'tablet'  => 'em',
				'desktop' => 'em',
			),
		),
		'sidebar_widget_title' => array(
			'size' => array(
				'desktop' => 20,
			),
			'lineHeight' => array(
				'desktop' => 1.5,
			),
			'family'  => 'inherit',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
			'color'   => 'palette2',
		),
		'sidebar_widget_content'            => array(
			'size' => array(
				'desktop' => '',
			),
			'lineHeight' => array(
				'desktop' => '',
			),
			'family'  => 'inherit',
			'google'  => false,
			'weight'  => '',
			'variant' => '',
			'color'   => 'palette2',
		),
		// Scroll To Top.
		'scroll_up_icon_size'   => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' =>25,
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'scroll_up_style' => 'filled',
		'scroll_up_color' => array(
			'color'  => 'palette9',
			'hover'  => 'palette9',
		),
		'scroll_up_background' => array(
			'color'  => 'palette1',
			'hover'  => 'palette1',
		),
		'scroll_up_border_colors'         => array(
			'color'  => 'palette1',
			'hover'  => 'palette1',
		),
		'scroll_up_radius' => array(
			'size'   => array( 30, 30, 30, 30 ),
			'unit'   => 'px',
			'locked' => true,
		),
		// Page Layout.
		'page_title_elements'      => array( 'breadcrumb', 'title', 'meta' ),
		'page_title_element_breadcrumb' => array(
			'enabled' => true,
			'show_title' => true,
		),
		'page_content_style'      => 'unboxed',	
		'page_title_background'   => array(
			'desktop' => array(
				'color' => 'palette8',
			),
		),
		'page_title_align'         => array(
			'mobile'  => 'left',
			'tablet'  => 'left',
			'desktop' => 'left',
		),
		'page_title_height'       => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 170,
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		// Footer.
		'footer_wrap_background' => array(
			'desktop' => array(
				'color' => 'palette9',
			),
		),
		'footer_items'       => array(
			'top' => array(
				'top_1' => array('footer-widget1'),
				'top_2' => array(),
				'top_3' => array(),
				'top_4' => array(),
				'top_5' => array(),
			),
			'middle' => array(
				'middle_1' => array('footer-widget2','footer-social'),
				'middle_2' => array('footer-widget3'),
				'middle_3' => array('footer-widget4'),
				'middle_4' => array('footer-widget5'),
				'middle_5' => array(),
			),
			'bottom' => array(
				'bottom_1' => array( 'footer-html' ),
				'bottom_2' => array('footer-widget6'),
				'bottom_3' => array(),
				'bottom_4' => array(),
				'bottom_5' => array(),
			),
		),
		
		// Footer Top.
		'footer_top_height' => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => '110',
			),
			'unit' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 'px',
			),
		),
		'footer_top_columns' => '1',
		'footer_top_background' => array(
			'desktop' => array(
				'color' => 'palette1',
			),
		),	
		// Footer Middle.
		'footer_middle_background' => array(
			'desktop' => array(
				'color' => '',
			),
		),
		'footer_middle_columns' => '4',
		'footer_middle_layout'  => array(
			'mobile'  => 'row',
			'tablet'  => '',
			'desktop' => 'left-forty',
		),
		'footer_middle_top_border'    => array(
			'desktop' => array(
				'width' => 0,
				'unit'  => 'px',
				'style' => 'solid',
				'color'  => 'palette5',
			),
		),
		'footer_middle_bottom_border' => array(
			'desktop' => array(
			    'width' => 1,
			    'unit'  => 'px',
			    'style' => 'solid',
			    'color'  => '#e5e5e5',
			),
		),
		'footer_middle_direction'         => array(
			'mobile'  => '',
			'tablet'  => '',
			'desktop' => 'column',
		),
		'footer_middle_widget_title'  => array(
			'size' => array(
				'desktop' => '16',
			),
			'lineHeight' => array(
				'desktop' => '',
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '700',
			'variant' => '700',
			'color'   => 'palette2',
			'transform' => 'capitalize',
		),
		'footer_middle_widget_content' => array(
			'size' => array(
				'desktop' => '16',
			),
			'lineHeight' => array(
				'desktop' => '',
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
			'color'   => 'palette2',
			'transform' => 'capitalize',
		),
		'footer_middle_link_colors' => array(
			'color' => 'palette2',
			'hover' => 'palette2',
		),
		'footer_middle_top_spacing' => array(
			'size' => array(
				'mobile'  => '50',
				'tablet'  => '70',
				'desktop' => '100',
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'footer_middle_bottom_spacing' => array(
			'size' => array(
				'mobile'  => '50',
				'tablet'  => '70',
				'desktop' => '100',
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'footer_html_vertical_align'         => array(
			'mobile'  => '',
			'tablet'  => '',
			'desktop' => 'middle',
		),
		'footer_html_content'    => '{copyright} {year} All Rights Reserved. Developed By CoderPlace',
		'footer_html_typography' => array(
			'size' => array(
				'desktop' => '15',
			),
			'lineHeight' => array(
				'desktop' => '',
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
			'color'   => 'palette2',
		),
		// Footer Social.
		'footer_social_title'=> __( '', 'avanam' ),
		'footer_social_items' => array(
			'items' => array(
				array(
					'id'      => 'facebook',
					'enabled' => true,
					'source'  => 'icon',
					'url'     => '',
					'imageid' => '',
					'width'   => 20,
					'icon'    => 'facebookAlt2',
					'label'   => 'Facebook',
				),
				array(
					'id'      => 'twitter',
					'enabled' => true,
					'source'  => 'icon',
					'url'     => '',
					'imageid' => '',
					'width'   => 20,
					'icon'    => 'twitter',
					'label'   => 'Twitter',
				),
				array(
					'id'      => 'instagram',
					'enabled' => true,
					'source'  => 'icon',
					'url'     => '',
					'imageid' => '',
					'width'   => 20,
					'icon'    => 'instagramAlt',
					'label'   => 'Instagram',
				),
				array(
					'id'      => 'google_reviews',
					'enabled' => true,
					'source'  => 'icon',
					'url'     => '',
					'imageid' => '',
					'width'   => 20,
					'icon'    => 'google_reviews',
					'label'   => 'Google Reviews',
				),
				array(
					'id'      => 'youtube',
					'enabled' => false,
					'source'  => 'icon',
					'url'     => '',
					'imageid' => '',
					'width'   => 20,
					'icon'    => 'youtube',
					'label'   => 'YouTube',
				),
				array(
					'id'      => 'vimeo',
					'enabled' => false,
					'source'  => 'icon',
					'url'     => '',
					'imageid' => '',
					'width'   => 20,
					'icon'    => 'vimeo',
					'label'   => 'Vimeo',
				),
			),
		),
		'footer_social_item_spacing' => array(
			'size' => 0.6,
			'unit' => 'em',
		),
		'footer_social_icon_size' => array(
			'size' => 1.25,
			'unit' => 'em',
		),
		'footer_social_color' => array(
			'color' => 'palette3',
			'hover' => 'palette9',
		),
		'footer_social_align'         => array(
			'mobile'  => '',
			'tablet'  => 'left',
			'desktop' => 'left',
		),
		'footer_social_background' => array(
			'color' => '#ececf1',
			'hover' => 'palette1',
		),
		'footer_social_style'        => 'filled',
		'footer_social_border_radius' => array(
			'size' => 50,
			'unit' => 'px',
		),
		'footer_social_vertical_align'         => array(
			'mobile'  => '',
			'tablet'  => '',
			'desktop' => 'middle',
		),
		// Footer Bottom.
		'footer_bottom_columns' => '2',
		'footer_bottom_layout'  => array(
			'mobile'  => 'row',
			'tablet'  => '',
			'desktop' => 'row',
		),
		'footer_bottom_top_spacing' => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => '10',
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'footer_bottom_bottom_spacing' => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => '10',
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		// Post Archive.
		'post_archive_layout'               => 'left',
		'post_archive_sidebar_id'           => 'sidebar-secondary',
		'post_archive_title_background'    => array(
			'desktop' => array(
				'color' => 'palette9',
			),
		),
		'post_archive_title_align'        => array(
			'mobile'  => 'left',
			'tablet'  => 'left',
			'desktop' => 'left',
		),
		'post_archive_columns'              => '2',
		'post_archive_title_height'       => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => '170',
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'post_archive_title_element_breadcrumb' => array(
			'enabled' => true,
			'show_title' => true,
		),
		'post_archive_title_overlay_color'              => array(
			'color' => 'palette8',
		),
		'post_archive_item_meta_color' => array(
			'color' => 'palette6',
			'hover' => 'palette6',
		),
		'post_archive_item_meta_font'   => array(
			'size' => array(
				'desktop' => '15',
			),
			'lineHeight' => array(
				'desktop' => '',
			),
			'family'  => 'inherit',
			'google'  => false,
			'weight'  => '',
			'variant' => '',
		),	
		'post_archive_element_categories'   => array(
			'enabled' => false,
			'style'   => 'normal',
			'divider' => 'vline',
		),
		'post_archive_element_readmore'   => array(
			'enabled' => false,		
		),
		'post_archive_element_excerpt' => array(
			'enabled'     => true,
			'words'       => 20,
			'fullContent' => false,
		),
		// Post Layout.
		'post_layout'             => 'left',
		'post_content_style'      => 'unboxed',
		'post_sidebar_id'         => 'sidebar-secondary',
		'post_feature_position'   => 'below',
		'post_related'            => false,
		'post_related_columns'    => '3',	
		'post_related_background'   => array(
			'desktop' => array(
				'color' => 'palette8',
			),
		),
		'post_title_background'   => array(
			'desktop' => array(
				'color' => 'palette8',
			),
		),
		'post_title_height'       => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 200,
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'post_title_align'         => array(
			'mobile'  => 'center',
			'tablet'  => 'center',
			'desktop' => 'center',
		),
		// 'post_title_elements'           => array( 'categories' => true, 'meta' => true, ),
		'post_title_elements'           => array( 'breadcrumb', 'categories', 'title', 'meta', 'excerpt' ),
					'post_title_element_categories' => array(
						'enabled' => true,
						'style'   => 'normal',
						'divider' => 'vline',
					),
					'post_title_element_title' => array(
						'enabled' => true,
					),
					'post_title_element_breadcrumb' => array(
						'enabled' => true,
						'show_title' => true,
					),
					'post_title_element_excerpt' => array(
						'enabled' => false,
					),
					'post_title_element_meta' => array(
						'id'                     => 'meta',
						'enabled'                => true,
						'divider'                => 'dot',
						'author'                 => true,
						'authorLink'             => true,
						'authorImage'            => false,
						'authorImageSize'        => 25,
						'authorEnableLabel'      => true,
						'authorLabel'            => '',
						'date'                   => true,
						'dateTime'               => false,
						'dateEnableLabel'        => false,
						'dateLabel'              => '',
						'dateUpdated'            => false,
						'dateUpdatedTime'        => false,
						'dateUpdatedDifferent'   => false,
						'dateUpdatedEnableLabel' => false,
						'dateUpdatedLabel'       => '',
						'categories'             => false,
						'categoriesEnableLabel'  => false,
						'categoriesLabel'        => '',
						'comments'               => false,
						'commentsCondition'      => false,
					),
		'post_title_element_breadcrumb' => array(
			'enabled' => false,
			'show_title' => false,
		),
		'post_title_category_color' => array(
			'color' => 'palette5',
			'hover' => 'palette5',
		),
		'post_title_category_font'   => array(
			'size' => array(
				'desktop' => '15',
			),
			'lineHeight' => array(
				'desktop' => '',
			),
			'family'  => 'inherit',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
			'transform' => 'none',
		),
		'post_title_meta_color' => array(
			'color' => 'palette6',
			'hover' => 'palette6',
		),
		'post_title_meta_font'   => array(
			'size' => array(
				'desktop' => '15',
			),
			'lineHeight' => array(
				'desktop' => '',
			),
			'family'  => 'inherit',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
		),
		
		// Store Notice:
		'woo_store_notice_background'  => array(
			'color' => 'palette2',
		),
		'woo_store_notice_font'   => array(
			'size' => array(
				'desktop' => '15',
			),
			'lineHeight' => array(
				'desktop' => '',
			),
			'family'  => 'Red Hat Display',
			'google'  => false,
			'weight'  => '500',
			'variant' => '500',
			'color'   => 'palette9',
		),
		// WooCommerce
		// Product Controls.
		'custom_quantity' => true,
		'product_above_layout' => 'title',
		'product_archive_sidebar_id' => 'sidebar-primary',
		'product_title_align' => array(
			'mobile'  => 'left',
			'tablet'  => 'left',
			'desktop' => 'left',
		),
		'product_title_height'       => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => 170,
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'product_title_element_category' => array(
			'enabled' => false,
		),
		'product_title_element_breadcrumb' => array(
			'enabled' => true,
			'show_title' => true,
		),
		'product_content_element_category' => array(
			'enabled' => true,
		),
		'product_content_element_extras' => array(
			'enabled'   => true,
			'title'     => __( 'Free shipping on orders over $50!', 'avanam' ),
			'feature_1' => __( 'Satisfaction Guaranteed', 'avanam' ),
			'feature_2' => __( 'No Hassle Refunds', 'avanam' ),
			'feature_3' => __( 'Secure Payments', 'avanam' ),
			'feature_4' => '',
			'feature_5' => '',
			'feature_1_icon' => 'shield_check',
			'feature_2_icon' => 'shield_check',
			'feature_3_icon' => 'shield_check',
			'feature_4_icon' => 'shield_check',
			'feature_5_icon' => 'shield_check',
		),
		'product_content_element_payments' => array(
			'enabled' => true,
			'title'     => __( 'GUARANTEED SAFE CHECKOUT', 'avanam' ),
			'visa' => true,
			'mastercard' => true,
			'amex' => true,
			'discover' => true,
			'paypal' => true,
			'applepay' => false,
			'stripe' => false,
			'card_color' => 'inherit',
			'custom_enable_01' => false,
			'custom_img_01' => '',
			'custom_id_01' => '',
			'custom_enable_02' => false,
			'custom_img_02' => '',
			'custom_id_02' => '',
			'custom_enable_03' => false,
			'custom_img_03' => '',
			'custom_id_03' => '',
			'custom_enable_04' => false,
			'custom_img_04' => '',
			'custom_id_04' => '',
			'custom_enable_05' => false,
			'custom_img_05' => '',
			'custom_id_05' => '',
		),
		'product_tab_style'   => 'center',
		'variation_direction' => 'vertical',
		'product_title_background'   => array(
			'desktop' => array(
				'color' => 'palette8',
			),
		),
		// Product Archive Controls.
		'product_archive_title_element_breadcrumb' => array(
			'enabled' => true,
			'show_title' => true,
		),
		'product_archive_title_align'        => array(
			'mobile'  => 'left',
			'tablet'  => 'left',
			'desktop' => 'left',
		),
		'product_archive_layout'             => 'left',
		'product_archive_image_hover_switch' => 'fade',
		'product_archive_style'  => 'action-visible',
		'product_archive_button_style'       => 'button',
		'product_archive_title_height'       => array(
			'size' => array(
				'mobile'  => '',
				'tablet'  => '',
				'desktop' => '170',
			),
			'unit' => array(
				'mobile'  => 'px',
				'tablet'  => 'px',
				'desktop' => 'px',
			),
		),
		'product_archive_title_background'    => array(
			'desktop' => array(
				'color' => 'palette8',
			),
		),
		'product_related_columns'    => '10',
		// Woo Account
		'woo_account_navigation_layout' => 'left',
		'woo_account_navigation_avatar' => false,

	);
	return wp_parse_args( $new_defaults, $defaults );
}
add_filter( 'base_theme_options_defaults', 'themename_change_option_defaults', 20 );



/**
 * Setup Child Theme Defaults
 *
 * @param array $defaults registered option defaults with kadence theme.
 * @return array
 */
function goixio_change_option_defaults( $defaults ) {
	$new_defaults = '{"post_content_style":"unboxed"}';
	$new_defaults = json_decode( $new_defaults, true );
	return wp_parse_args( $new_defaults, $defaults );
}
add_filter( 'base_theme_options_defaults', 'goixio_change_option_defaults', 20 );

/**
 * Add svg icons
 * 
 */
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml'; 
	return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

/**
 * Add Blog excerpt
 * 
 */  
if ( ! function_exists( 'avanam_blog_post_excerpt' ) ) :
	function avanam_blog_post_excerpt( $limit ) {
		$excerpt = get_the_content();
		$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
		$excerpt = strip_tags($excerpt);
		$excerpt = substr($excerpt, 0, $limit);
		$excerpt = substr($excerpt, 0, strripos($excerpt, " "));
		return $excerpt;
	}
endif;

/**
 * Woocommerce rating stars always
 * 
 */  
function get_rating_html($rating_html, $rating)
{
	if ( $rating > 0 ) {
		$title = sprintf(
		// translators: %s: Product rating.
		__( 'Rated %s out of 5', 'avanam' ), $rating );
	} 
	else {
		$title = 'Not yet rated';
		$rating = 0;
	}
	$rating_html  = '<div class="star-rating" title="' . $title . '">';
	$rating_html .= '<span style="width:' . (($rating / 5) * 100) . '%"><strong class="rating">' . $rating . '</strong> ' . esc_attr__('out of 5', 'avanam') . '</span>';
	$rating_html .= '</div>';
	return $rating_html;
}	
add_filter('woocommerce_product_get_rating_html','get_rating_html',10, 2);
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); 
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_loop_rating', 5);
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );

/**
 * Remove the product description Title
 * 
 */ 
add_filter( 'woocommerce_product_description_heading', '__return_null' );

/**
 * Remove the additional information title
 * 
 */ 
add_filter( 'woocommerce_product_additional_information_heading', '__return_null' );

/**
 *  Change position of Coupon form on Checkout page
 */
function woocommerce_checkout_coupon_form_custom() {
    echo '<tr class="coupon-form"><td colspan="2">';    
    wc_get_template(
        'checkout/form-coupon.php',
        array(
            'checkout' => WC()->checkout(),
        )
    );
    echo '</tr></td>';
}
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );
add_action( 'woocommerce_review_order_after_cart_contents', 'woocommerce_checkout_coupon_form_custom', 90 );


/**
 *  Add Wrap to extra Wishlist, Compare and Quick View buttons.
 * 
 */
// Start Action Extra buttons wrap.
function archive_extra_button_wrap_start() {
	echo '<div class="archive-extra-button-wrap">';
	do_action( 'archive_extra_button_wrap' );
}
// Close Action Extra buttons wrap.
function archive_extra_button_wrap_end() {
	echo '</div>';
}
// Start image wrap.
function archive_image_wrap_start() {
	echo '<div class="archive-image-wrap">';
	do_action( 'archive_image_wrap' );
}
// Close image wrap.
function archive_image_wrap_end() {
	echo '</div>';
}
// To display Wishlist in product block
function wishlist_in_product(){
	if ( in_array( 'woo-smart-wishlist/wpc-smart-wishlist.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ):
		echo do_shortcode( "[woosw]" );
	endif;	
}
// quick view block
 function quickview_in_product(){
	if ( in_array( 'woo-smart-quick-view/wpc-smart-quick-view.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ):
		echo do_shortcode( "[woosq]" );
	endif;
}
// Compare Button 
 function compare_in_product(){
	if ( in_array( 'woo-smart-compare/wpc-smart-compare.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ):
		echo do_shortcode( "[woosc]" );
	endif;
}
// Image wrap
add_action( 'woocommerce_before_shop_loop_item_title',  'archive_image_wrap_start' ,4  );
add_action( 'woocommerce_before_shop_loop_item_title',  'archive_image_wrap_end' ,51);
// Add Wrap to extra button.
add_action( 'archive_image_wrap', 'archive_extra_button_wrap_start',5);
add_action( 'archive_image_wrap', 'archive_extra_button_wrap_end',5);
add_action( 'archive_extra_button_wrap', 'wishlist_in_product');
add_action( 'archive_extra_button_wrap',  'compare_in_product' );
add_action( 'archive_extra_button_wrap',   'quickview_in_product');

// Add wishlist and compare button on Single Product Page.
add_action( 'woocommerce_after_add_to_cart_button', 'wishlist_in_product');
add_action( 'woocommerce_after_add_to_cart_button',  'compare_in_product' );

// Add homepage page loader 
function coderplace_pageloader(){
    if( is_front_page() ) {
        echo "<div class='pageloader'></div>";
	}	
}
add_action('wp_body_open', 'coderplace_pageloader');

/**
 * Add scoped body class for custom frame list archive styling.
 *
 * @param array $classes Body classes.
 * @return array
 */
function goixio_shop_archive_body_class( $classes ) {
	if ( function_exists( 'is_shop' ) && ( is_shop() || is_product_category() || is_product_tag() ) ) {
		$classes[] = 'goixio-frame-list';
	}
	return $classes;
}
add_filter( 'body_class', 'goixio_shop_archive_body_class' );
