<?php

/**
 * Plugin Name: WP Popup
 * Plugin URI:  https://princeboss.com
 * Description: Intelligent Website Popups and Notifications.
 * Version:     1.0.0
 * Author:      Prince
 * Author URI:  http://princeboss.com
 * Text Domain: wp-popup
 * Domain Path: /languages/
 */

defined( 'ABSPATH' ) || exit();


/**
 * Main initiation class
 *
 * @since 1.0.0
 */
final class WP_Popup {

	public $version = '1.0.0';

	private $min_php = '5.6.0';

	private $name = 'WP Popup';

	protected static $instance = null;

	public function __construct() {

		if ( $this->check_environment() ) {
			$this->define_constants();
			$this->includes();
			$this->init_hooks();
			do_action( 'wp_popup_loaded' );
		}

	}

	function check_environment() {

		$return = true;

		if ( version_compare( PHP_VERSION, $this->min_php, '<=' ) ) {
			$return = false;

			$notice = sprintf(
			/* translators: %s: Min PHP version */
				esc_html__( 'Unsupported PHP version Min required PHP Version: "%s"', 'wp-radio-updater' ),
				$this->min_php
			);
		}

		if ( ! $return ) {

			add_action( 'admin_notices', function () use ( $notice ) { ?>
                <div class="notice is-dismissible notice-error">
                    <p><?php echo $notice; ?></p>
                </div>
			<?php } );

			if ( ! function_exists( 'deactivate_plugins' ) ) {
				require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			}

			deactivate_plugins( plugin_basename( __FILE__ ) );

			return $return;
		} else {
			return $return;
		}

	}

	function define_constants() {
		define( 'WP_POPUP_VERSION', $this->version );
		define( 'WP_POPUP_FILE', __FILE__ );
		define( 'WP_POPUP_PATH', dirname( WP_POPUP_FILE ) );
		define( 'WP_POPUP_INCLUDES', WP_POPUP_PATH . '/includes' );
		define( 'WP_POPUP_URL', plugins_url( '', WP_POPUP_FILE ) );
		define( 'WP_POPUP_ASSETS', WP_POPUP_URL . '/assets' );
		define( 'WP_POPUP_TEMPLATES', WP_POPUP_PATH . '/templates' );
	}

	function includes() {

		//core includes
		include_once WP_POPUP_INCLUDES . '/class-install.php';
		include_once WP_POPUP_INCLUDES . '/prince-settings/prince-loader.php';
		include_once WP_POPUP_INCLUDES . '/class-cpt.php';
		include_once WP_POPUP_INCLUDES . '/functions.php';
		include_once WP_POPUP_INCLUDES . '/class-enqueue.php';

		//admin includes
        if(is_admin()){
	        include_once WP_POPUP_INCLUDES . '/admin/class-admin.php';
	        include_once WP_POPUP_INCLUDES . '/admin/class-metabox.php';
        }

	}

	function init_hooks() {

		// Localize our plugin
		add_action( 'init', [ $this, 'localization_setup' ] );

		//action_links
		add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), [ $this, 'plugin_action_links' ] );

		register_activation_hook( __FILE__, [ 'WP_Popup_Install', 'activate' ] );

	}

	function localization_setup() {
		load_plugin_textdomain( 'wp-popup', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	function plugin_action_links( $links ) {

		return $links;
	}

	static function instance() {

		if ( is_null( self::$instance ) ) {

			self::$instance = new self();
		}

		return self::$instance;
	}

}

function wp_popup() {
	return WP_Popup::instance();
}

wp_popup();
