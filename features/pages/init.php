<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cache;
use WP_Post;
use WP_Query;

\add_action( 'wordpress_helfi_cookie_consent_activate', __NAMESPACE__ . '\\clear_rewrite_rules' );
\add_action( 'wordpress_helfi_cookie_consent_deactivate', __NAMESPACE__ . '\\clear_rewrite_rules' );

/**
 * @source https://developer.wordpress.org/reference/functions/flush_rewrite_rules/#comment-4023
 */
function clear_rewrite_rules(): void {
	\delete_option( 'rewrite_rules' );
}

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	\add_action( 'admin_head-nav-menus.php', __NAMESPACE__ . '\\document_pages_metabox' );

	$current_language = \apply_filters(
		'wordpress_helfi_cookie_consent_current_language',
		'en'
	);

	$hooks = create_custom_page_hooks(
		create_page_factory( $current_language ),
		$current_language
	);

	\add_filter(
		'wordpress_helfi_cookie_consent_current_page',
		array( $hooks, 'current_page' ),
		1
	);

	\add_filter( 'wp_setup_nav_menu_item', array( $hooks, 'wp_setup_nav_menu_item' ) );
	\add_filter( 'wp_nav_menu_objects', array( $hooks, 'wp_nav_menu_objects' ) );
	\add_filter(
		'wordpress_helfi_cookie_consent_nav_menu_metabox_pages',
		array( $hooks, 'helfi_custom_pages' )
	);

	\add_action( 'init', array( $hooks, 'register_rewrites' ) );

	\add_action(
		'wordpress_helfi_cookie_consent_policy_page_url',
		array( $hooks, 'policy_page_url' )
	);

	\add_action( 'template_include', array( $hooks, 'page_template' ) );
	\add_action(
		'wordpress_helfi_cookie_consent_page',
		array( $hooks, 'page_content' )
	);

	\add_filter( 'the_content', array( $hooks, 'custom_page_content' ) );

	\add_filter( 'document_title', array( $hooks, 'document_title' ), 9999, 1 );
	\add_filter( 'wp_title', array( $hooks, 'document_title' ), 9999, 1 );

	\add_filter(
		'wordpress_helfi_cookie_consent_page_meta_title',
		array( $hooks, 'page_title' ),
		9999, 2
	);

	\add_action(
		'wordpress_helfi_cookie_consent_add_nav_menu_policy_pages',
		array( $hooks, 'create_nav_menu_pages' ),
	);
}

function create_custom_page_hooks( Page_Factory $factory, string $current_language ): Custom_Page_Hooks {
	return new Custom_Page_Hooks( $factory, $current_language );
}

function create_page_factory( string $current_language ): Page_Factory {
	return new Page_Factory( new Cache(), $current_language );
}

function document_pages_metabox(): void {
	\add_meta_box(
		'helfi-cookie-consent-documents',
		__( 'Helsinki Cookie Consent', 'wordpress-helfi-cookie-consent' ),
		__NAMESPACE__ . '\\render_document_pages_metabox',
		'nav-menus',
		'side',
		'low'
	);
}

function render_document_pages_metabox(): void {
	$template_path = \apply_filters(
		'wordpress_helfi_cookie_consent_path_to_php_file',
		array( 'features', 'pages', 'templates', 'document-pages-metabox' )
	);

	if ( is_string( $template_path ) && $template_path ) {
		require_once $template_path;
	}
}
