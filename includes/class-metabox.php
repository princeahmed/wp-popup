<?php

defined( 'ABSPATH' ) || exit;

class WP_Popup_Metabox {

	function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'register_meta_boxes' ] );
		add_action( 'admin_init', array( $this, 'setting_meta_boxes' ) );
	}

	function setting_meta_boxes() {

		$metaboxes = [];

		$metaboxes[] = array(
			'id'       => 'wp_popup_settings_metabox',
			'title'    => __( 'Popup Settings', 'wp-radio' ),
			'desc'     => __( 'Settings for Popup', 'wp-radio' ),
			'pages'    => array( 'wp_popup' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				array(
					'id'   => 'logo',
					'type' => 'upload',
				),
			)
		);

		if ( function_exists( 'prince_register_meta_box' ) ) {
			foreach ( $metaboxes as $metabox ) {
				prince_register_meta_box( $metabox );
			}
		}

	}

	function register_meta_boxes() {
		add_meta_box( 'wp-popup-template', __( 'Design', 'wp-popup' ), [
			$this,
			'design_callback'
		], 'wp_popup', 'normal', 'high' );
	}

	function design_callback() {

		wp_popup_template( 'metabox' );

	}


}

new WP_Popup_Metabox();