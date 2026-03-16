<?php
/**
 * Welcome setup
 */

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'CoderPlace_Theme_Setup' ) ) {

	// options stage key
	if ( ! defined( 'CPC_OPTION_STAGE_KEY' ) ) {
		define( 'CPC_OPTION_STAGE_KEY', 'base_option_stage' );
	}


	class CoderPlace_Theme_Setup {

		private $theme_slug = 'coderplace-core';
		private $tgmpa_url = 'themes.php?page=tgmpa-install-plugins';
		private $tgmpa_menu_slug = 'tgmpa-install-plugins';

		// Constructor
		function __construct() {

			// add_action( 'admin_menu', array( $this, 'tmc_welcome_setup_menu' ) );
			add_action( 'admin_head', array( $this, 'tmc_skip_activation' ) );
			add_action( 'admin_head', array( $this, 'tmc_hide_gf_integration_warning_on_welcome_admin_page' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'tmc_welcome_load_scripts_and_styles' ) );

			add_action( 'wp_ajax_tmc_setup_plugins', array( $this, 'ajax_plugins' ) );
			add_action( 'wp_ajax_tmc_activate_theme_key', array( $this, 'ajax_activate_theme_key' ) );

			add_action( 'admin_init', array( $this, 'prevent_plugins_redirect' ), 1 );

		}

		/**
		 * Create menu option
		 */
		function tmc_welcome_setup_menu() {
			add_theme_page(
				__( 'TM Setup', 'coderplace-core' ),
				__( 'TM Setup', 'coderplace-core' ),
				apply_filters( 'base_admin_settings_capability', 'manage_options' ),
				'coderplace-setup',
				array( $this, 'tmc_welcome_setup_page' ),
				101,
			);
		}

		/**
		 * Skip activation listener
		 */
		function tmc_skip_activation() {
			$skip_activation = array_key_exists( 'skip-activation', $_POST ) ? true : false;
			if ( false != $skip_activation ) {
				// skip activation prompt for 30 seconds
				set_transient( 'skip_coderplace_core_activation', true, 30 );
			}
		}

		/**
		 * Hide gravity forms integration warning
		 */
		function tmc_hide_gf_integration_warning_on_welcome_admin_page() {
			$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : false;

			// hide gravity forms integration warning on this page
			if ( is_a( $screen, 'WP_Screen' ) && 'appearance_page_coderplace-setup' === $screen->base ) {
				add_filter( 'tmc_suggest_hide_gravity_forms_activation_warning', '__return_true' );
			}
		}

		/**
		 * Welcome page callback
		 */
		function tmc_welcome_setup_page() {

			$status = get_option( $this->theme_slug . '_license_key_status', false );

			$requested_stage = array_key_exists( 'stage', $_REQUEST ) ? intval( $_REQUEST['stage'] ) : 0;

			$posts = get_posts( 'post_type=post&posts_per_page=10' );
			$posts_count = count( $posts );
			$posts_installed = ( $posts_count > 1 ) ? true : false;

			$skip_activation = array_key_exists( 'skip-activation', $_REQUEST ) ? true : false;
			
			if ( $skip_activation ) {
				// skip activation prompt for 30 seconds
				set_transient( 'skip_coderplace_core_activation', true, 30 );
			} else {
				$skip_activation = get_transient( 'skip_coderplace_core_activation' );
				$skip_activation = apply_filters( 'base_skip_theme_activation', $skip_activation );
			}

				// use security to ensure requested stage is legit
			if ( $requested_stage > 1 ) {
				check_admin_referer( 'stage-check', 'stage-check' );
			}

				$stage = 1;
			if ( 'valid' == $status || $skip_activation ) {
				$stage = 2;
			}

				$skip_plugins = apply_filters( 'base_skip_plugin_installation', false );
			if ( 3 == $requested_stage || $skip_plugins ) {
				$stage = 3;
			}

			if ( 4 == $requested_stage ) {
				$stage = 4;
			}

				// save the stage
				update_option( CPC_OPTION_STAGE_KEY, $stage );

			?>

			<div class="wrap base_theme_dash">
				<div class="base_theme_dash_notices">
					<h2 class="notices" style="display:none;"></h2>
					<?php settings_errors(); ?>
				</div>
				<div class="theme_core_dash_head">
					<div class="theme_core_dash_head_container">
						<h1 class="theme-welcome">Welcome to CoderPlace Setup</h1><br>
						<?php if ( defined( 'TMTHEME_NAME' ) ) { ?>
						<span class="theme-name">
							<strong><?php echo esc_html( TMTHEME_NAME );?></strong>
							<?php echo esc_html( TMTHEME_VERSION ); ?>
						</span>
						<?php } ?>
					</div>
				</div>
				<div class="tmc-setupwizard">

					<?php
						$this->tmc_theme_intro_header( $stage );
					?>
						<?php if ( $posts_installed && $stage == 3 ) : ?>
							<div class="tmc-setupwizard__upgradenotice">
								<h2 class="tmc-setupwizard__title"><?php esc_html_e( 'Data Already Exists', 'coderplace-core' ); ?></h2>
								<p><?php esc_html_e( 'It looks like you have existing data, please remove previously installed data before importing demo.', 'coderplace-core' ); ?></p>
							</div>
						<?php endif; ?>
						<div class="tmc-setupwizard__content">
						<?php
						switch ( $stage ) {
							case 1:
								$this->tmc_theme_license_tab();
								break;
							case 2:
								$this->tmc_theme_install_reqd_plugins();
								break;
							case 3:
								$this->tmc_theme_install_sample_content();
								break;
							case 4:
								$this->tmc_theme_setup_complete();
								break;
							default:
								// default action
								break;
						}
						?>
					</div>

				</div><!-- /tmc-setupwizard -->
			</div>
			
		<?php
		}

		/**
		 * Progress bar
		 */
		function tmc_theme_intro_header( $current_stage ) {
			// valid stages
			$stages = array( 1, 2, 3, 4 );
			?>
			<div class="tmc-progressbar">
				<ul>
				<?php foreach ( $stages as $key => $stage ) : ?>
					<?php $active_class = ( $stage == $current_stage ) ? ' active ' : ''; ?>
					<?php $complete_class = ( $stage < $current_stage ) ? ' complete ' : ''; ?>
					<?php $justcomplete_class = ( $stage == ( $current_stage - 1 ) ) ? ' justcomplete ' : ''; ?>
					<li class="<?php echo $complete_class . $justcomplete_class . $active_class; ?>">
						<?php echo $stage; ?>						
					</li>
				<?php endforeach; ?>
				</ul>
			</div>
			<?php
		}

		/**
		 * Theme license tab
		 */
		function tmc_theme_license_tab() {
			
			$license = trim( get_option( $this->theme_slug . '_license_key' ) );
			$status = get_option( $this->theme_slug . '_license_key_status', false );
			?>

			<div class="base_theme_dashboard theme_core_dashboard">
			

				<h2 class="tmc-setupwizard__title"><?php esc_html_e( 'CoderPlace Theme Setup Wizard', 'coderplace-core' ); ?></h2>
				
				<p class="tmc-setupwizard__actions step">
					<?php if ( isset( $_GET['page'] ) && 'coderplace-setup' === $_GET['page'] ) { ?>
						<?php $stage_check = wp_create_nonce( 'stage-check' ); ?>
						<a href="?page=coderplace-setup&stage=2&skip-activation=1&stage-check=<?php echo $stage_check; ?>" class="button button-large button-next"><?php esc_html_e( 'Continue Setup', 'coderplace-core' ); ?></a>
						<?php wp_nonce_field( 'tmc-theme-setup' ); ?>
					<?php } ?>
				<p>
				
			</div>

			<?php
		}

		/**
		 * Email alerts signup tab
		 * not used in theme
		 */
		function tmc_theme_email_alerts_tab() {
			$current_user = wp_get_current_user();
			?>
				<h2 class="tmc-setupwizard__title"><?php esc_html_e( 'Sign up for email notifications', 'coderplace-core' ); ?></h2>
				<p><?php 
				/* Translators: %s is the URL. */
				printf( __( 'Visit <a href="%s" target="_blank">CoderPlace</a>, or signup with the form below for more tips, guides and addons to harness the power of your new product', 'coderplace-core' ), 'https://coderplace.com' ); ?></p>
				<!-- Sign up form -->
				<!-- Begin MailChimp Signup Form -->
				<link href="//cdn-images.mailchimp.com/embedcode/classic-081711.css" rel="stylesheet" type="text/css" >
				<style type="text/css">
					#mc_embed_signup{clear:left; font:14px Helvetica,Arial,sans-serif; max-width: 600px; }
					#mc_embed_signup .indicates-required, #mc_embed_signup .mc-field-group .asterisk {display: none;}
					/* Add your own MailChimp form style overrides in your site stylesheet or in this style block.
					   We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
				</style>
				<div id="mc_embed_signup">
				<form action="#" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
					<div id="mc_embed_signup_scroll">
				<div class="indicates-required"><span class="asterisk">*</span> <?php esc_html_e( 'indicates required', 'coderplace-core' ); ?></div>
				<div class="mc-field-group">
					<label for="mce-EMAIL"><?php esc_html_e( 'Email Address', 'coderplace-core' ); ?>  <span class="asterisk">*</span>
				</label>
					<input type="email" value="<?php echo $current_user->user_email; ?>" name="EMAIL" class="required email" id="mce-EMAIL">
					<input type="hidden" value="<?php echo $current_user->user_firstname; ?>" name="FNAME" class="" id="mce-FNAME">
					<input type="hidden" value="<?php echo $current_user->user_lastname; ?>" name="LNAME" class="" id="mce-LNAME">
					<input type="hidden" id="group_4096" name="group[925][4096]" value="1" /><!-- signup location = HKB Dashboard (group 4096) -->
					<input type="hidden" name="SIGNUP" id="SIGNUP" value="tmc-base-theme-dash" />
				</div>
					<div id="mce-responses" class="clear">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
					<div style="position: absolute; left: -5000px;"><input type="text" name="b_958c07d7ba2f4b21594564929_db684b9928" tabindex="-1" value=""></div>
					<input type="submit" value="<?php esc_html_e( 'Subscribe', 'coderplace-core' ); ?>" name="subscribe" id="mc-embedded-subscribe" class="button">
					<?php $stage_check = wp_create_nonce( 'stage-check' ); ?>
					<a href="?page=coderplace-setup&stage=3&stage-check=<?php echo $stage_check; ?>"
					   class="button button-large button-next"><?php esc_html_e( 'Skip This Step', 'coderplace-core' ); ?></a>
					<?php wp_nonce_field( 'tmc-theme-setup' ); ?>					
					</div>
				</form>
				</div>
				<script type='text/javascript' src='//s3.amazonaws.com/downloads.mailchimp.com/js/mc-validate.js'></script><script type='text/javascript'>(function($) {window.fnames = new Array(); window.ftypes = new Array();fnames[0]='EMAIL';ftypes[0]='email';fnames[1]='FNAME';ftypes[1]='text';fnames[2]='LNAME';ftypes[2]='text';}(jQuery));var $mcj = jQuery.noConflict(true);</script>
				<!--End mc_embed_signup-->
				</script>

			<?php
		}

		function sort_plugins( $a, $b ) {
			if ( $a['order'] == $b['order'] ) {
				return 0;
			}
				return ( $a['order'] < $b['order'] ) ? -1 : 1;
		}

		/**
		 * Install required plugins tab
		 */
		function tmc_theme_install_reqd_plugins() {
			$all_plugins_ready = false;
			?>

				<h2 class="tmc-setupwizard__title"><?php esc_html_e( 'Install Required Plugins', 'coderplace-core' ); ?></h2>
				<form method="post">

					<?php

					$tgm_plugins = $this->get_all_tgm_config_plugins();

					uasort( $tgm_plugins->plugins, array( $this, 'sort_plugins' ) );

					if ( true /*todo - logic for detecting required plugins active?*/ ) {
						?>
						<p><?php esc_html_e( 'Your website needs a few essential plugins. The following plugins will be installed or updated:', 'coderplace-core' ); ?></p>
						<ul class="theme-install-setup-plugins">
							<?php foreach ( $tgm_plugins->plugins as $key => $plugin ) : ?>

								<?php
									$slug = $plugin['slug'];
									$plugin_already_installed = $tgm_plugins->is_plugin_installed( $slug ) && false === $tgm_plugins->does_plugin_have_update( $slug ) && ! $tgm_plugins->can_plugin_activate( $slug );
									$plugin_required = ( $plugin['required'] ) ? true : false;
									$disable_selection = ( $plugin_already_installed || $plugin['required'] ) ? 'disabled' : '';

								?>
								<li class="tmc-plugin-li" data-slug="<?php echo esc_attr( $slug ); ?>">
									<span class="tmc-plugin-item">
										<input type="checkbox" name="base-theme-plugin-<?php echo esc_attr( $slug ); ?>" data-slug="<?php echo esc_attr( $slug ); ?>" checked <?php echo $disable_selection; ?> />
										<label for="base-theme-plugin-<?php echo esc_attr( $slug ); ?>">
											<?php echo esc_html( $plugin['name'] . ' - ' ); ?>
											<?php
											if ( $plugin_already_installed ) {
												$info = esc_html( 'Already Installed and Active', 'coderplace-core' );
											}
											if ( ! $tgm_plugins->is_plugin_installed( $slug ) ) {
												$info = esc_html( 'Installation', 'coderplace-core' );
												if ( $plugin_required ) {
													$info .= ' ' . esc_html( 'required', 'coderplace-core' );
												} else {
													$info .= ' ' . esc_html( 'optional', 'coderplace-core' );
												}
											}
											if ( $tgm_plugins->is_plugin_installed( $slug ) && false !== $tgm_plugins->does_plugin_have_update( $slug ) ) {
												$info = esc_html( 'Update', 'coderplace-core' );
												if ( $plugin_required ) {
													$info .= ' ' . esc_html( 'required', 'coderplace-core' );
												} else {
													$info .= ' ' . esc_html( 'optional', 'coderplace-core' );
												}
											}
											if ( $tgm_plugins->can_plugin_activate( $slug ) ) {
												$info = esc_html( 'Activation', 'coderplace-core' );
												if ( $plugin_required ) {
													$info .= ' ' . esc_html( 'required', 'coderplace-core' );
												} else {
													$info .= ' ' . esc_html( 'optional', 'coderplace-core' );
												}
											}
											echo $info;
											?>
										</label>
										<span class="tmc-plugin-item-info"></span>
										<div class="spinner"></div>
									</span>
								</li>
							<?php endforeach; ?>
						</ul>
						<?php
					} else {
						$all_plugins_ready = true;
						echo '<p><strong>' . esc_html__( 'Good news! All plugins are already installed and up to date. Please continue.', 'coderplace-core' ) . '</strong></p>';
					}
					?>

					<?php $stage_check = wp_create_nonce( 'stage-check' ); ?>

					<p class="tmc-u-notice"><span><?php esc_html_e( 'Note:', 'coderplace-core' ); ?></span><?php esc_html_e( 'You can add and remove plugins later on from within WordPress.', 'coderplace-core' ); ?></p>

					<p class="tmc-setupwizard__actions step">
						<a href="?page=coderplace-setup&stage=3&stage-check=<?php echo $stage_check; ?>"
						   class="button-primary button button-large button-next"
						   data-callback="installPlugins"><?php esc_html_e( 'Check and Verify Selected', 'coderplace-core' ); ?></a>
						<a href="?page=coderplace-setup&stage=3&stage-check=<?php echo $stage_check; ?>"
						   class="button button-large button-next"><?php esc_html_e( 'Skip This Step', 'coderplace-core' ); ?></a>
						<?php wp_nonce_field( 'tmc-theme-setup' ); ?>
					</p>
					
				</form>

			<?php
		}

		/**
		 * Install sample content tab
		 */
		function tmc_theme_install_sample_content() {
			?>
				<?php 
					global $ocdi_import_config;

					if( class_exists( 'OCDI\OneClickDemoImport') ) {
						$ocdi = OCDI\OneClickDemoImport::get_instance();
					}
				?>

				<h2 class="tmc-setupwizard__title"><?php esc_html_e( 'Install Sample Content', 'coderplace-core' ); ?></h2>

				<?php
					// only display if no posts
					$posts = get_posts( 'post_type=post&posts_per_page=10' );
					$posts_count = count( $posts );
					$checkstate = ( $posts_count > 1 ) ? '' : 'checked';
					$enable_posts_checkstate = '';
				?>

				<?php if ( $posts_count <= 1 ) : ?>


					<p><?php esc_html_e( 'It\'s time to insert some default content for your new WordPress website. Choose what you would like inserted below and click Import Demo.', 'coderplace-core' ); ?></p>

				<?php else : ?>

					<p><?php esc_html_e( 'It looks like you already have content installed, you can check the items below to add additional demo data or re-install any missing items.', 'coderplace-core' ); ?></p>

				<?php endif; ?>					
				
				<input type="hidden" name="stage" value="5" />
				<?php $stage_check = wp_create_nonce( 'stage-check' ); ?>

				<?php
				if( class_exists( 'OCDI\OneClickDemoImport') ) {
					
				
				?>

			<p class="tmc-u-notice">
				<span><?php esc_html_e( 'Manual Demo File Import:', 'coderplace-core' ); ?></span>
				<?php esc_html_e( 'Using Manual Import, you can import only selected parts of the demos, i.e., pages, widgets, and customizer settings separately.', 'coderplace-core' ); ?>
				<a href="<?php echo esc_url( $ocdi->get_plugin_settings_url( array( 'import-mode' => 'manual' ) ) ); ?>" class="ocdi-import-mode-switch"><?php esc_html_e( 'Click here for a Manual Import.', 'coderplace-core' ); ?></a>
				<br/><br/>
				<span><?php esc_html_e( 'Predefined Layouts - Quick Import:', 'coderplace-core' ); ?></span>
				<?php esc_html_e( 'If you want to import all the demo data of a selected layout at once, please select the predefined layouts below and click on Import This Demo.', 'coderplace-core' ); ?>
			</p>


			<p class="tmc-setupwizard__action tmc-setupwizard__title step">
				<a href="<?php echo esc_url( $ocdi->get_plugin_settings_url( array( 'import-mode' => 'manual' ) ) ); ?>"
					class="button button-large button-next">
					<?php esc_html_e( 'Manual Demo File Import', 'coderplace-core' ); ?></a>
				<a href="?page=coderplace-setup&stage=4&stage-check=<?php echo $stage_check; ?>"
					class="button button-large button-next"><?php esc_html_e( 'Skip Demo Import', 'coderplace-core' ); ?></a>
				<?php wp_nonce_field( 'tmc-theme-setup' ); ?>
			</p>
			<p></p><hr><p></p>

			<h3 class="tmc-setupwizard__title"><?php esc_html_e( 'Predefined Layouts - Quick Import', 'coderplace-core' ); ?></h3>

				<?php if ( $posts_count <= 1 ) : ?>

				<p class="tmc-u-notice"><span><?php esc_html_e( 'Note:', 'coderplace-core' ); ?></span><?php esc_html_e( 'It will import sample data from selected layout. Once inserted, this content can be managed from the WordPress admin dashboard.', 'coderplace-core' ); ?></p>

				<?php else : ?>

				<p class="tmc-u-notice"><span><?php esc_html_e( 'Note:', 'coderplace-core' ); ?></span><?php esc_html_e( 'The checked items will be installed. You can skip this step if you are upgrading Theme.', 'coderplace-core' ); ?></p>

				<?php endif; ?>

				<div class="ocdi__gl-item-container js-ocdi-gl-item-container">
					<?php foreach ( $ocdi_import_config as $index => $import_file ) : ?>
						<?php
							// Prepare import item display data.
							$img_src = isset( $import_file['import_preview_image_url'] ) ? $import_file['import_preview_image_url'] : '';
							// Default to the theme screenshot, if a custom preview image is not defined.
							if ( empty( $img_src ) ) {
								$theme = wp_get_theme();
								$img_src = $theme->get_screenshot();
							}

						?>
						<div class="ocdi__gl-item js-ocdi-gl-item" data-name="<?php echo esc_attr( strtolower( $import_file['import_file_name'] ) ); ?>">
							<div class="ocdi__gl-item-image-container">
								<?php if ( ! empty( $img_src ) ) : ?>
									<img class="ocdi__gl-item-image" src="<?php echo esc_url( $img_src ) ?>">
								<?php else : ?>
									<div class="ocdi__gl-item-image  ocdi__gl-item-image--no-image"><?php esc_html_e( 'No preview image.', 'coderplace-core' ); ?></div>
								<?php endif; ?>
							</div>
							<div class="ocdi__gl-item-footer<?php echo ! empty( $import_file['preview_url'] ) ? '  ocdi__gl-item-footer--with-preview' : ''; ?>">
								<h4 class="ocdi__gl-item-title" title="<?php echo esc_attr( $import_file['import_file_name'] ); ?>"><?php echo esc_html( $import_file['import_file_name'] ); ?></h4>
								<span class="ocdi__gl-item-buttons">
									<?php if ( ! empty( $import_file['preview_url'] ) ) : ?>
										<a class="ocdi__gl-item-button button" href="<?php echo esc_url( $import_file['preview_url'] ); ?>" target="_blank"><?php esc_html_e( 'Preview Demo', 'coderplace-core' ); ?></a>
									<?php endif; ?>
									<a class="ocdi__gl-item-button  button  button-primary" href="<?php echo $ocdi->get_plugin_settings_url( [ 'step' => 'import', 'import' => esc_attr( $index ) ] ); ?>#wpfooter"><?php esc_html_e( 'Import Demo', 'coderplace-core' ); ?></a>
								</span>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<?php
				} else {
				?>
				
				<h3><?php esc_html_e( 'It looks like you do not have installed One Click Demo Import Plugin', 'coderplace-core' ); ?></h3>
				<p><?php esc_html_e( 'This step required One Click Demo Import Plugin. You can skip this step.', 'coderplace-core' ); ?></p>

				<?php
				}
				?>
				<p class="tmc-setupwizard__action tmc-setupwizard__title step">
					<a href="?page=coderplace-setup&stage=4&stage-check=<?php echo $stage_check; ?>"
					class="button button-large button-next"><?php esc_html_e( 'Skip Demo Import', 'coderplace-core' ); ?></a>
				</p>
			<?php
		}

		/**
		 * Theme setup complete tab
		 */
		function tmc_theme_setup_complete() {
			?>

				<h2 class="tmc-setupwizard__title"><?php esc_html_e( 'You\'re All Set!', 'coderplace-core' ); ?></h2>

				<p style="text-align:center"><?php esc_html_e( 'CoderPlace has been successfully setup and your website is ready!', 'coderplace-core' ); ?></p>

				<p style="text-align:center">
					<a class="button-primary button button-large tmc-viewsite" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank">
						<?php esc_html_e( 'View Your Site', 'coderplace-core' ); ?>
					</a>

					<a class="button-primary button button-large tmc-viewsite" href="<?php echo esc_url( admin_url( 'themes.php?page=coderplace' ) ); ?>">
						<?php esc_html_e( 'Customize Your Site', 'coderplace-core' ); ?>
					</a>
				</p>

				<div class="tmc-setup-nextsteps">
					<h2><?php esc_html_e( 'What Next?', 'coderplace-core' ); ?></h2>

					<ul>
						<li><a href="<?php echo esc_url( admin_url( 'themes.php?page=coderplace' ) ); ?>"><?php esc_html_e( 'Customize your site with your logo and colours', 'coderplace-core' ); ?></a></li>
						<li><a href="https://coderplace.com/kb" target="_blank"><?php esc_html_e( 'Check the knowledge base to get the most from your theme', 'coderplace-core' ); ?></a></li>
						<li><a href="https://coderplace.com/support/"><?php esc_html_e( 'Have a question? we are happy to help! Contact our team', 'coderplace-core' ); ?></a></li>
					</ul>

				</div>

			<?php
		}

		/**
		 * Get TGM config plugins
		 */
		function get_tgm_config_plugins() {
			$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
			$plugins  = array(
				'all'      => array(), // Meaning: all plugins which still have open actions.
				'install'  => array(),
				'update'   => array(),
				'activate' => array(),
			);

			foreach ( $instance->plugins as $slug => $plugin ) {
				if ( $instance->is_plugin_active( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
					// No need to display plugins if they are installed, up-to-date and active.
					continue;
				} else {
					$plugins['all'][ $slug ] = $plugin;

					if ( ! $instance->is_plugin_installed( $slug ) ) {
						$plugins['install'][ $slug ] = $plugin;
					} else {
						if ( false !== $instance->does_plugin_have_update( $slug ) ) {
							$plugins['update'][ $slug ] = $plugin;
						}

						if ( $instance->can_plugin_activate( $slug ) ) {
							$plugins['activate'][ $slug ] = $plugin;
						}
					}
				}
			}

			return $plugins;
		}

		/**
		 * Get ALL TGM config plugins
		 */
		function get_all_tgm_config_plugins() {
			$tgm_plugins = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );

			return $tgm_plugins;
		}

		/**
		 * ajax handler for theme key activation
		 */
		function ajax_activate_theme_key() {
			if ( ! check_ajax_referer( 'tmc_setup_setup_security', 'wpnonce' ) ) {
				wp_send_json_error(
					array(
						'error' => 1,
						'message' => esc_html__(
							'Failed Security',
							'coderplace-core'
						),
					)
				);
			}

			$json = array();

			$key = filter_input( INPUT_POST, 'key', FILTER_SANITIZE_STRING );

			$attempt = filter_input( INPUT_POST, 'attempt', FILTER_SANITIZE_NUMBER_INT );

			update_option( $this->theme_slug . '_license_key', $key );

			$status = get_option( $this->theme_slug . '_license_key_status', false );

			$retry = false;

			// response license_valid
			$license_valid = false;

			if ( 'valid' == $status ) {
				$message = esc_html__( 'License successfully activated. Redirecting...', 'coderplace-core' );
				$license_valid = true;
			} else {
				// workaround for when the license is valid, but has not activated correctly, retry upto three times
				if ( $attempt < 2 ) {
					$message = esc_html__( 'Validating license with CoderPlace', 'coderplace-core' ) . sprintf( ' (%s)', $attempt );
					$retry = true;
				} else {
					$message = esc_html__( 'There is a problem with the license key.', 'coderplace-core' );
					$message .= ' ';
					$message .= esc_html__( 'Check your license status, add or remove sites from your CoderPlace.com account.', 'coderplace-core' );
				}
			}

			// send response
			wp_send_json(
				array(
					'done' => 1,
					'valid' => $license_valid,
					'message' => $message,
					'retry' => $retry,
					'attempt' => $attempt + 1,
				)
			);
			// needed on ajax calls to exit cleanly
			exit;
		}

		/**
		 * ajax handler for plugin installation
		 */
		function ajax_plugins() {

			if ( ! check_ajax_referer( 'tmc_setup_setup_security', 'wpnonce' ) ) {
				wp_send_json_error(
					array(
						'error' => 1,
						'message' => esc_html__(
							'Failed Security',
							'coderplace-core'
						),
					)
				);
			}

			if ( empty( $_POST['slug'] ) ) {
				wp_send_json_error(
					array(
						'error' => 1,
						'message' => esc_html__(
							'Missing plugin slug',
							'coderplace-core'
						),
					)
				);
			}

			$json = array();
			// send back some json we use to hit up TGM
			$plugins = $this->get_tgm_config_plugins();
			// what are we doing with this plugin?
			foreach ( $plugins['activate'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => admin_url( $this->tgmpa_url ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-activate',
						'action2'       => - 1,
						'message'       => esc_html__( 'Activating Plugin', 'coderplace-core' ),
					);
					break;
				}
			}
			foreach ( $plugins['update'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => admin_url( $this->tgmpa_url ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-update',
						'action2'       => - 1,
						'message'       => esc_html__( 'Updating Plugin', 'coderplace-core' ),
					);
					break;
				}
			}
			foreach ( $plugins['install'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => admin_url( $this->tgmpa_url ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-install',
						'action2'       => - 1,
						'message'       => esc_html__( 'Installing Plugin', 'coderplace-core' ),
					);
					break;
				}
			}

			if ( ! empty( $json ) ) {
				$json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
				wp_send_json( $json );
			} else {
				wp_send_json(
					array(
						'done' => 1,
						'message' => esc_html__(
							'Success',
							'coderplace-core'
						),
					)
				);
			}
			exit;

		}

		/**
		 * Load scripts and styles
		 */
		function tmc_welcome_load_scripts_and_styles() {
			$screen = get_current_screen();
			if ( is_a( $screen, 'WP_Screen' ) && 'appearance_page_coderplace-setup' == $screen->base ) {
				// enqueue style
				wp_enqueue_style( 'theme-setup-css', CPCORE_URL . 'admin/setup/css/theme-setup-admin-style.css' );
				
				// enqueue style
				wp_enqueue_style( 'coderplace-admin-dashboard', CPCORE_URL . 'admin/assets/css/admin.css', array(), CPCORE_VERSION );
				
				wp_enqueue_style( 'base-dashboard', get_template_directory_uri() . '/inc/dashboard/react/dash-controls.min.css', array( 'wp-components' ), CPCORE_VERSION );
		
				// enqueue script
				wp_enqueue_script( 'jquery-blockui', CPCORE_URL . 'admin/setup/js/jquery.blockUI.js', array( 'jquery' ), '2.70', true );

				$theme_welcome_js_file_src = ( WP_DEBUG ) ? CPCORE_URL . 'admin/setup/js/theme-setup-js.js' : CPCORE_URL . 'admin/setup/js/theme-setup-js.min.js';
				wp_enqueue_script(
					'theme-setup-js',
					$theme_welcome_js_file_src,
					array(
						'jquery',
						'jquery-blockui',
					),
					CPCORE_VERSION
				);
				wp_localize_script(
					'theme-setup-js',
					'tmc_theme_setup',
					array(
						'tgm_plugin_nonce' => array(
							'update'  => wp_create_nonce( 'tgmpa-update' ),
							'install' => wp_create_nonce( 'tgmpa-install' ),
						),
						'theme_slug'       => $this->theme_slug,
						'tgm_bulk_url'     => admin_url( $this->tgmpa_url ),
						'ajaxurl'          => admin_url( 'admin-ajax.php' ),
						'wpnonce'          => wp_create_nonce( 'tmc_setup_setup_security' ),
						'verify_text'      => esc_html__( '...verifying', 'coderplace-core' ),
					)
				);

			}

		}

		/**
		 * Prevent plugins redirect.
		 */
		public function prevent_plugins_redirect() {
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

	}

}

if ( class_exists( 'CoderPlace_Theme_Setup' ) ) {
	$base_welcome_setup_init = new CoderPlace_Theme_Setup();
}
