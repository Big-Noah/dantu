<?php
/**
 * The main plugin class.
 *
 * @since 1.0.0
 * @package CoderPlace Core
 */

/**
 * The main coderplace-core class.
 */
class CoderPlaceCore_Settings {

	/**
	* Plugin version, used for cache-busting of style and script file references.
	*
	* @since   1.0.0
	* @var  string
	*/
	const VERSION = CPCORE_VERSION;

	/**
	 * Instance of the class.
	 *
	 * @static
	 * @access protected
	 * @since 1.0.0
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * This is the data key for database.
	 *
	 * @var string
	 */
	public $settings_key = 'coderplace_core_settings';

	/**
	 * This is if it's a multisite.
	 *
	 * @var bool
	 */
	public static $multisite = false;


	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @access private
	 * @since 1.0.0
	 */
	private function __construct() {

		if ( is_multisite() ) {
			$show_local_activation = apply_filters( 'coderplace_activation_individual_multisites', false );
			if ( $show_local_activation ) {
				self::$multisite = false;
			} else {
				self::$multisite = true;
			}
		}

		add_action( 'init', array( $this, 'load_api_settings' ) );

		/* $update_array = array(
			$this->tmc_api_key          => '',
			$this->tmc_activation_email => '',
			'option_name'               => '',
		);
		$this->update_setting_option( $this->tmc_instance_key, self::$instance );
		$this->update_setting_option( $this->tmc_data_key, $update_array ); */

	}

	/**
	 * Return an instance of this class.
	 *
	 * @static
	 * @access public
	 * @since 1.0.0
	 * @return object  A single instance of the class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set yet, set it now.
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;

	}

	/**
	 * Register settings
	 */
	public static function load_api_settings() {
		register_setting(
			'coderplace_core_plugin_settings',
			'coderplace_core_plugin_settings',
			array(
				'type'              => 'string',
				'description'       => __( 'CoderPlace Core Settings', 'coderplace-core' ),
				'sanitize_callback' => 'sanitize_text_field',
				'show_in_rest'      => true,
				'default'           => '',
			)
		);
	}

	/**
	 * Updates Settings.
	 *
	 * @param string $key the setting Key.
	 * @param mixed  $option the setting value.
	 */
	public static function update_setting_option( $key, $option ) {
		if ( self::$multisite && is_multisite() ) {
			update_site_option( $key, $option );
		} else {
			update_option( $key, $option );
		}
	}
	/**
	 * Retrives Settings.
	 *
	 * @param string $key the setting Key.
	 * @param mixed  $default the setting default value.
	 */
	public static function get_setting_option( $key, $default = null ) {
		if ( self::$multisite && is_multisite() ) {
			return get_site_option( $key, $default );
		} else {
			return get_option( $key, $default );
		}
	}
	/**
	 * Delete Settings.
	 *
	 * @param string $key the setting Key.
	 */
	public static function delete_setting_option( $key ) {
		if ( self::$multisite && is_multisite() ) {
			delete_site_option( $key );
		} else {
			delete_option( $key );
		}
	}


}
