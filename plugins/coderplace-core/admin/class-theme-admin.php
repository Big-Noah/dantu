<?php
/**
 * Build Admin Page with settings.
 *
 * @package Base
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Build Admin Page class
 *
 * @category class
 */
class Base_Theme_Admin_Settings {

	/**
	 * Settings of this class
	 *
	 * @var array
	 */
	public static $settings = array();

	/**
	 * Instance of this class
	 *
	 * @var null
	 */
	private static $instance = null;
	/**
	 * Static var active plugins
	 *
	 * @var $active_plugins
	 */
	private static $active_plugins;

	/**
	 * This file
	 *
	 * @var string
	 */
	private $file = '';

	/**
	 * Instance Control
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	/**
	 * Class Constructor.
	 */
	public function __construct() {
		
		$this->file = __FILE__;

		// add_action( 'admin_menu', array( $this, 'add_menu' ) );

		// add CSS to show SubPage
		add_action( 'admin_enqueue_scripts', array( $this, 'basic_css_menu_support' ) );

		if ( class_exists( 'CoderPlace_Theme' ) ) {
			CoderPlace_Theme::global_config_theme_plugin();
		}
		// Load the Theme Plugins array.
		require_once dirname( $this->file ) . '/recommended-plugins.php';
	
		// Load the TGM Config.
		require_once dirname( $this->file ) . '/tmgpa/tgmpa-config.php';
	
		// Include OCDI functions only if plugin activated and PHP version meets min requirments
		$phpversion = phpversion();
		if( class_exists( 'OCDI_Plugin' ) && version_compare( (float)$phpversion, '5.3.2', '>' ) ) {
			require_once dirname( $this->file ) . '/ocdi/ocdi.php';
		}
	
		// Load the Theme Setup.
		require_once dirname( $this->file ) . '/setup/theme-setup-admin.php';
		

	}

	/**
	 * Add option page menu
	 */
	public function add_menu() {

		$page = add_theme_page(
			__( 'CoderPlace', 'coderplace-core' ),
			__( 'CoderPlace', 'coderplace-core' ),
			apply_filters( 'base_admin_settings_capability', 'manage_options' ),
			'coderplace',
			array( $this, 'config_page' ),
			100,
		);
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		do_action( 'coderplace_theme_admin_menu' );
	}

	/**
	 * Add a little css for submenu items.
	 */
	public function basic_css_menu_support() {
		wp_register_style( 'coderplace-core-admin', false );
		wp_enqueue_style( 'coderplace-core-admin' );
		$css = '#menu-appearance .wp-submenu a[href^="themes.php?page=coderplace-"]:before, #menu-appearance .wp-submenu a[href^="edit.php?post_type=base_element"]:before, #menu-appearance .wp-submenu a[href^="edit.php?post_type=tmc_font"]:before {content: "\21B3";margin-right: 0.5em;opacity: 0.5;}';
		wp_add_inline_style( 'coderplace-core-admin', $css );
	}
	

	/**
	 * Admin Required.
	 */
	public function theme_admin_required() {
	}

	/**
	 * Loads admin style sheets and scripts
	 */
	public function scripts() {
		wp_enqueue_style( 'coderplace-admin-dashboard', CPCORE_URL . 'admin/assets/css/admin.css', array(), CPCORE_VERSION );
		wp_enqueue_style( 'base-dashboard', get_template_directory_uri() . '/inc/dashboard/react/dash-controls.min.css', array( 'wp-components' ), CPCORE_VERSION );
	}

	/**
	 * Loads config page
	 */
	public function config_page() {
		?>
	
		<div class="wrap base_theme_dash">
			<div class="base_theme_dash_notices">
				<h2 class="notices" style="display:none;"></h2>
				<?php settings_errors(); ?>
			</div>
			<div class="theme_core_dash_head">
				<div class="theme_core_dash_head_container">
					<div class="base_theme_dash_logo">
						<img src="<?php echo esc_attr( CPCORE_URL . 'admin/assets/images/coderplace-logo.png' ); ?>">
					</div>
					<?php if ( defined( 'TMTHEME_NAME' ) ) { ?>
					<div class="base_theme_dash_right">
						<span class="theme-title"><strong><?php echo esc_html( TMTHEME_NAME );?></strong></span>
						<div class="base_theme_dash_version">
							<span>
								<?php echo esc_html( TMTHEME_VERSION ); ?>
							</span>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
			<div class="base_theme_dashboard theme_core_dashboard">
				<div class="page-grid">
					<div class="base_theme_dashboard_panel">
						<div class="base_theme_dashboard_more">
							<?php do_action( 'coderplace_core_dashboard_panel' ); ?>
							<?php do_action( 'coderplace_core_dashboard_panel_information' ); ?>
						</div>
					</div>
					<div class="side-panel">
						<div class="support-section sidebar-section components-panel">
							<div class="components-panel__body is-opened">
								<h2><?php esc_html_e( 'Video Tutorials', 'coderplace-core' ); ?></h2>
								<p><?php esc_html_e( 'Want a guide? We have video tutorials to walk you through getting started.', 'coderplace-core' ); ?></p>
								<a href="https://coderplace.com/video-tutorials/" target="_blank" class="sidebar-link"><?php esc_html_e( 'Watch Videos', 'coderplace-core' ); ?></a>
							</div>
						</div>
						<div class="support-section sidebar-section components-panel">
							<div class="components-panel__body is-opened">
								<h2><?php esc_html_e( 'Documentation', 'coderplace-core' ); ?></h2>
								<p><?php esc_html_e( 'Need help? We have a knowledge base full of articles to get you started.', 'coderplace-core' ); ?></p>
								<a href="https://coderplace.com/kb" target="_blank" class="sidebar-link"><?php esc_html_e( 'Browse Docs', 'coderplace-core' ); ?></a>
							</div>
						</div>
						<div class="support-section sidebar-section components-panel">
							<div class="components-panel__body is-opened">
								<h2><?php esc_html_e( 'Support', 'coderplace-core' ); ?></h2>
								<p><?php esc_html_e( 'Have a question, we are happy to help! Get in touch with our support team.', 'coderplace-core' ); ?></p>
								<a href="https://coderplace.com/support/" target="_blank" class="sidebar-link"><?php esc_html_e( 'Submit a Ticket', 'coderplace-core' ); ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

}
Base_Theme_Admin_Settings::get_instance();
