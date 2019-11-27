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
		wp_enqueue_style( 'grapes', WP_POPUP_ASSETS . '/css/grapes.min.css', [], '0.15.8' );
		wp_enqueue_style( 'font-awesome', WP_POPUP_ASSETS . '/css/font-awesome.min.css', [], '4.7.0' );
		wp_enqueue_style( 'wp-popup', WP_POPUP_ASSETS . '/css/admin.min.css', [], WP_POPUP_VERSION );

		wp_enqueue_script( 'grapes', WP_POPUP_ASSETS . '/js/grapes.min.js', [ 'jquery' ], '0.15.8', true );
		wp_enqueue_script( 'wp-popup', WP_POPUP_ASSETS . '/js/admin.min.js', [ 'jquery' ], WP_POPUP_VERSION, true );
	}

}

new WP_Popup_Enqueue();