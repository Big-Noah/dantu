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
class CoderPlaceCore_Plugin {

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
	 * Holds info if CoderPlace Settings is present.
	 *
	 * @static
	 * @access public
	 * @since 1.0.0
	 * @var bool
	 */
	public static $coderplace_settings_exists;


	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @access private
	 * @since 1.0.0
	 */
	private function __construct() {

		add_action( 'plugins_loaded', [ $this, 'load_textdomain' ] );

		// Include Files Frontend and Backend
		$this->includes();
		
		if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
			// Admin Only.
			$this->include_admin();
		} else {
			// Frontend Only.
			$this->include_frontend();
		}

		add_action( 'after_setup_theme', [ $this, 'set_coderplace_settings_exists' ] );

		// Load scripts & styles at Frontend and Backend.
		add_action( 'wp_enqueue_scripts', [ $this, 'scripts' ] );

		// Load scripts & styles at Frontend.
		if ( ! is_admin() ) {
			add_action( 'wp_enqueue_scripts', [ $this, 'scripts_frontend' ] );
		}

		// Register custom post-types and taxonomies.
		add_action( 'init', [ $this, 'register_post_types' ] );

		// User agent for news feed widget.
		add_action( 'wp_feed_options', [ $this, 'feed_user_agent' ], 10, 2 );

		// Register our admin widget.
		add_action( 'wp_dashboard_setup', [ $this, 'add_dashboard_widget' ], 100 );

		// Admin menu tweaks.
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );

		// Init Widgets.
		add_action( 'widgets_init', [ $this, 'widget_init' ] );

		// Plugin updater and activator
		//add_action( 'after_setup_theme', [ $this, 'coderplace_updater_activator' ], 5 );

		// Load all shortcode elements.
		$this->init_shortcodes();

	}

	/**
	 * Plugin specific text-domain loader.
	 *
	 * @return void
	 */
	public function load_textdomain() {

		// Set filter for plugin's languages directory.
		$cpcore_lang_dir = CPCORE_PATH . '/languages/';
		$cpcore_lang_dir = apply_filters( 'cpcore_languages_directory', $cpcore_lang_dir );

		// Load the default language files.
		load_plugin_textdomain( 'coderplace-core', false, $cpcore_lang_dir );

	}

	/**
	 * Include files.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function includes() {
		// Load Settings Class.
		require_once CPCORE_PATH . '/includes/class-coderplace-settings.php';
		// Load addons.
		require_once CPCORE_PATH . '/includes/addons/header-addons.php';
		// Load widget classes.
		$filenames = glob( CPCORE_PATH . '/includes/widgets/*.php', GLOB_NOSORT );
		foreach ( $filenames as $filename ) {
			require_once wp_normalize_path( $filename );
		}
	}

	/**
	 * On Load
	 */
	public function include_admin() {
		// Include Admin Files
		require_once CPCORE_PATH . '/admin/class-theme-admin.php';
	}

	/**
	 * On Load
	 */
	public function include_frontend() {}

	/**
	 * Sets the CoderPlace Library constant.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function set_coderplace_settings_exists() {
		self::$coderplace_settings_exists = class_exists( 'CoderPlaceCore_Settings' );
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
	 * Returns a cached query.
	 * If the query is not cached then it caches it and returns the result.
	 *
	 * @static
	 * @access public
	 * @param string|array $args Same as in WP_Query.
	 * @return object
	 */
	public static function coderplace_core_cached_query( $args ) {

		$query_id = md5( maybe_serialize( $args ) );
		$query    = wp_cache_get( $query_id, 'cpcore' );
		if ( false === $query ) {
			$query = new WP_Query( $args );
			wp_cache_set( $query_id, $query, 'cpcore' );
		}
		return $query;

	}

	/**
	 * Enqueues scripts at Frontend and Backend.
	 *
	 * @access public
	 */
	public function scripts() {}
	
	/**
	 * Enqueues scripts at Frontend.
	 *
	 * @access public
	 */
	public function scripts_frontend() {
		wp_enqueue_style( 'coderplace-core-frontend', CPCORE_URL . 'assets/css/frontend.css', [], CPCORE_VERSION );
	}


	/**
	 * Register custom post types.
	 *
	 * @access public
	 * @since 1.0.0
	 */
	public function register_post_types() {}

	/**
	 * Elastic Slider admin menu.
	 *
	 * @access public
	 */
	public function admin_menu() {}


	/**
	 * Register widgets.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function widget_init() {
		register_widget( 'CoderPlace_Widget_Contact_Info' );
	}

	/**
	 * Adds the news dashboard widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function add_dashboard_widget() {

		// Create the widget.
		wp_add_dashboard_widget( 'coderplace_news', apply_filters( 'cpcore_dashboard_widget_title', esc_attr__( 'CoderPlace News and Updates', 'CoderPlace' ) ), [ $this, 'display_news_dashboard_widget' ] );

		// Make sure our widget is on top off all others.
		global $wp_meta_boxes;

		// Get the regular dashboard widgets array.
		$normal_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

		$coderplace_widget_backup = [];
		if ( isset( $normal_dashboard['coderplace_news'] ) ) {
			// Backup and delete our new dashboard widget from the end of the array.
			$coderplace_widget_backup = [
				'coderplace_news' => $normal_dashboard['coderplace_news'],
			];
			unset( $normal_dashboard['coderplace_news'] );
		}

		// Merge the two arrays together so our widget is at the beginning.
		$sorted_dashboard = array_merge( $coderplace_widget_backup, $normal_dashboard );

		// Save the sorted array back into the original metaboxes.
		$wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
	}

	/**
	 * Renders the news dashboard widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function display_news_dashboard_widget() {

		// Create two feeds, the first being just a leading article with data and summary, the second being a normal news feed.
		$feeds = [
			'news' => [
				'link'         => 'https://coderplace.com/blog/',
				'url'          => 'https://coderplace.com/blog/feed/',
				'title'        => esc_attr__( 'CoderPlace News and Updates', 'coderplace-core' ),
				'items'        => 4,
				'show_summary' => 0,
				'show_author'  => 0,
				'show_date'    => 0,
			],
		];
		?>
		<div class="coderplace-news-wrapper">
			<div class="coderplace-news-header">
				<div class="coderplace-news-logo">
					<span class="coderplace-news-image-wrapper">
						<img src="<?php echo esc_url( CPCORE_URL . 'admin/assets/images/coderplace-logo.png' ); ?>" width="135" height="20" alt="<?php esc_attr_e( 'CoderPlace Logo', 'coderplace-core' ); ?>">
					</span>
				</div>
				<div class="coderplace-theme-info">
					<?php $version = defined( 'CPCORE_VERSION' ) ? 'v' . CPCORE_VERSION : ''; ?>
					<?php $name = defined( 'CPCORE_NAME' ) ? CPCORE_NAME : ''; ?>
					<span class="coderplace-core-name"><strong><?php echo esc_html( apply_filters( 'cpcore_name', $name ) ); ?></strong></span>
					<span class="coderplace-news-version"><?php echo esc_html( apply_filters( 'cpcore_db_version', $version ) ); ?></span>
				</div>
			</div>
			<?php wp_dashboard_primary_output( 'coderplace_news', $feeds ); ?>

			<div class="coderplace-news-footer">
				<ul>
					<li class="coderplace-news-footer-blog>"><a href="<?php echo esc_url( 'https://coderplace.com/blog/' ); ?>" target="_blank"><?php esc_html_e( 'Blog', 'coderplace-core' ); ?> <span class="screen-reader-text"><?php esc_html_e( '(opens in a new window)', 'coderplace-core' ); ?></span><span aria-hidden="true" class="dashicons dashicons-external"></span></a></li>
					<li class="coderplace-news-footer-docs>"><a href="<?php echo esc_url( 'https://coderplace.com/kb' ); ?>" target="_blank"><?php esc_html_e( 'Docs', 'coderplace-core' ); ?> <span class="screen-reader-text"><?php esc_html_e( '(opens in a new window)', 'coderplace-core' ); ?></span><span aria-hidden="true" class="dashicons dashicons-external"></span></a></li>
					<li class="coderplace-news-footer-ticket>"><a href="<?php echo esc_url( 'https://coderplace.com/support/' ); ?>" target="_blank"><?php esc_html_e( 'Ticket', 'coderplace-core' ); ?> <span class="screen-reader-text"><?php esc_html_e( '(opens in a new window)', 'coderplace-core' ); ?></span><span aria-hidden="true" class="dashicons dashicons-external"></span></a></li>
				</ul>
			</div>
		</div>
		<?php
	}

	/**
	 * Changes the user agent for the CoderPlace news widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @param  object $feed  SimplePie feed object, passed by reference.
	 * @param  mixed  $url   URL of feed to retrieve. If an array of URLs, the feeds are merged.
	 * @return void
	 */
	public function feed_user_agent( $feed, $url ) {

		if ( 'https://coderplace.com/blog/feed/' === $url ) {
			$feed->set_useragent( 'CoderPlace RSS Feed' );
		}
	}



	/**
	 * Find and include all shortcodes within shortcodes folder.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function init_shortcodes() {
			$filenames = glob( CPCORE_PATH . '/includes/shortcodes/*.php', GLOB_NOSORT );
			foreach ( $filenames as $filename ) {
				$info = pathinfo( $filename );
				require_once wp_normalize_path( $filename );
			}
	}

}
