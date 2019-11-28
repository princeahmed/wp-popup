<?php

defined( 'ABSPATH' ) || exit();

class WP_Popup_Enqueue {

	function __construct() {
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
	}

	function frontend_scripts() {

	}

	function admin_scripts() {
		wp_enqueue_style( 'grapesjs', WP_POPUP_ASSETS . '/css/grapes.min.css', [], '0.15.8' );
		wp_enqueue_style( 'font-awesome', WP_POPUP_ASSETS . '/css/font-awesome.min.css', [], '4.7.0' );
		wp_enqueue_style( 'wp-popup', WP_POPUP_ASSETS . '/css/admin.min.css', [], WP_POPUP_VERSION );


		wp_enqueue_script( 'grapesjs', WP_POPUP_ASSETS . '/js/grapes.min.js', [ 'jquery' ], '0.15.8', true );
		wp_enqueue_script( 'grapesjs-preset-webpage', WP_POPUP_ASSETS . '/js/grapesjs-preset-webpage.min.js', [ 'jquery', 'grapesjs' ], '0.1.10', true );
		wp_enqueue_script( 'wp-popup', WP_POPUP_ASSETS . '/js/admin.min.js', [ 'jquery' ], WP_POPUP_VERSION, true );

		/* create localized JS array */
		$localized_array = [
			'storeUrl' => site_url(),
			'loadUrl'  => site_url(),
			'popupId'  => 1,
		];

		wp_localize_script( 'wp-popup', 'wpPopup', $localized_array );

	}

}

new WP_Popup_Enqueue();