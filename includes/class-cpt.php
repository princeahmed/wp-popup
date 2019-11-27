<?php

/* Block direct access */
defined( 'ABSPATH' ) || exit();


class WP_Popup_CPT {

	function __construct() {
		add_action( 'init', [ $this, 'register_post_types' ] );
		add_action( 'init', [ $this, 'flush_rewrite_rules' ], 99 );
	}

	function register_post_types() {
		register_post_type( 'wp_popup', array(
			'labels'              => $this->get_posts_labels( __( 'Popups', 'wp-popup' ), __( 'Popup', 'wp-popup' ), __( 'Popups', 'wp-popup' ) ),
			'hierarchical'        => false,
			'supports'            => apply_filters( 'wp_popup_post_supports', array( 'title' ) ),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'menu_position'       => 5,
			//'menu_icon'           => WP_POPUP_ASSETS . '/images/wp-popup-icon-w20.png',
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => false,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => array( 'slug' => apply_filters( 'wp_popup_slug', 'popup' ) ),
			'capability_type'     => 'post',
		) );
	}


	protected static function get_posts_labels( $menu_name, $singular, $plural, $type = 'plural' ) {
		$labels = array(
			'name'               => 'plural' == $type ? $plural : $singular,
			'all_items'          => sprintf( __( "All %s", 'wp-popup' ), $plural ),
			'singular_name'      => $singular,
			'add_new'            => sprintf( __( 'Add New %s', 'wp-popup' ), $singular ),
			'add_new_item'       => sprintf( __( 'Add New %s', 'wp-popup' ), $singular ),
			'edit_item'          => sprintf( __( 'Edit %s', 'wp-popup' ), $singular ),
			'new_item'           => sprintf( __( 'New %s', 'wp-popup' ), $singular ),
			'view_item'          => sprintf( __( 'View %s', 'wp-popup' ), $singular ),
			'search_items'       => sprintf( __( 'Search %s', 'wp-popup' ), $plural ),
			'not_found'          => sprintf( __( 'No %s found', 'wp-popup' ), $plural ),
			'not_found_in_trash' => sprintf( __( 'No %s found in Trash', 'wp-popup' ), $plural ),
			'parent_item_colon'  => sprintf( __( 'Parent %s:', 'wp-popup' ), $singular ),
			'menu_name'          => $menu_name,
		);

		return $labels;
	}


	function flush_rewrite_rules() {
		if ( get_option( 'wp_popup_flush_rewrite_rules' ) ) {
			flush_rewrite_rules();
			delete_option( 'wp_popup_flush_rewrite_rules' );
		}
	}
}

new WP_Popup_CPT();

