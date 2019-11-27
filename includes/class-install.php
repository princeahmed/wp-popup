<?php

defined( 'ABSPATH' ) || exit;

/**
 * Class Install
 */
class WP_Popup_Install {

	public static function activate() {
		self::update_option();
	}


	private static function update_option() {
		update_option( 'wp_popup_flush_rewrite_rules', true );
	}

}