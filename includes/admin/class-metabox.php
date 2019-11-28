<?php

defined( 'ABSPATH' ) || exit;

class WP_Popup_Metabox {

	function __construct() {
		add_action( 'add_meta_boxes', [ $this, 'register_meta_boxes' ] );
		add_action( 'admin_init', array( $this, 'setting_meta_boxes' ) );
	}

	function setting_meta_boxes() {

		$metaboxes = [];

		$metaboxes['wp_popup_settings_metabox'] = array(
			'id'       => 'wp_popup_settings_metabox',
			'title'    => __( 'Popup Settings', 'wp-radio' ),
			'desc'     => __( 'Settings for Popup', 'wp-radio' ),
			'pages'    => array( 'wp_popup' ),
			'context'  => 'normal',
			'priority' => 'high',
			'fields'   => array(
				'general-tab' => array(
					'id'    => 'general-tab',
					'label' => __( 'General', 'wp-radio' ),
					'type'  => 'tab',
				),

				'stream_url' => array(
					'label' => __( 'Station Stream URL', 'wp-radio' ),
					'id'    => 'stream_url',
					'type'  => 'text',
					'desc'  => sprintf( __( 'Enter the %s of the radio station', 'wp-radio' ), '<code>Live Stream URL</code>' ),
					'attrs' => array(
						'placeholder' => 'Stream URL'
					),
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

		add_meta_box( 'wp_popup_template_editor_metabox', __( 'Design', 'wp-popup' ), [
			$this,
			'template_editor_metabox'
		], 'wp_popup', 'normal', 'high' );

		add_meta_box( 'wp_popup_template_selector_metabox', __( 'Choose Template', 'wp-popup' ), [
			$this,
			'template_selector_metabox'
		], 'wp_popup', 'side', 'high' );

	}

	function template_editor_metabox() {
		include WP_POPUP_INCLUDES . '/admin/views/metabox/editor.php';
	}

	function template_selector_metabox() {
		include WP_POPUP_INCLUDES . '/admin/views/metabox/template.php';
	}


}

new WP_Popup_Metabox();