<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Helsinkiteema;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Nav_Menu_Checker;

\add_action( 'wordpress_helfi_cookie_consent_setup', __NAMESPACE__ . '\\setup_cmplz_integration' );
function setup_cmplz_integration(): void {
	if ( 'wordpress-helfi-helsinkiteema' === wp_get_theme()->get_stylesheet() ) {
		\add_filter( 'cmplz_integrations', __NAMESPACE__ . '\\provide_cmplz_integration' );
		function provide_cmplz_integration( array $integrations ): array {
			$integrations[cmplz_integration_name()] = array(
				'constant_or_function' => __NAMESPACE__ . '\\cmplz_integration_name',
				'label'                => __( 'Helsinki Askem', 'wordpress-helfi-cookie-consent' ),
				'firstparty_marketing' => false,
			);

			return $integrations;
		}

		\add_filter( 'cmplz_integration_path', __NAMESPACE__ . '\\provide_cmplz_integration_path', 10, 2 );
		function provide_cmplz_integration_path( string $path, string $integration ): string {
			return cmplz_integration_name() === $integration
				? \plugin_dir_path( __FILE__ ) . 'complianz/askem.php'
				: $path;
		}
	}
}

function cmplz_integration_name(): string {
	return 'helsinki_theme_askem';
}

\add_action( 'helsinki_theme_setup_ready', __NAMESPACE__ . '\\init', 10 );
function init(): void {
	\add_filter( 'wordpress_helfi_cookie_consent_helsinkiteema_active', '__return_true' );
}

\add_action( 'admin_init', __NAMESPACE__ . '\\admin_init' );
function admin_init(): void {
	if ( \apply_filters( 'wordpress_helfi_cookie_consent_helsinkiteema_active', false ) ) {
		\add_action( 'admin_head-index.php', __NAMESPACE__ . '\\check_nav_menus_for_policy_pages' );
		\add_action( 'wp_update_nav_menu', __NAMESPACE__ . '\\provide_clear_policy_pages_in_nav_menu_cache' );

		\add_action(
			'wordpress_helfi_cookie_consent_nav_menu_pages_added',
			__NAMESPACE__ . '\\provide_cache_policy_pages_in_nav_menu'
		);
	}
}

function provide_clear_policy_pages_in_nav_menu_cache( int $menu_id ): void {
	foreach ( \get_nav_menu_locations() as $location => $id ) {
		if ( $id === $menu_id ) {
			clear_policy_pages_in_nav_menu_cache( $location );
		}
	}
}

function provide_cache_policy_pages_in_nav_menu( string $location ): void {
	$types = create_nav_menu_checker()
		->policy_page_types_in_menu_location( $location );

	if ( $types ) {
		cache_policy_pages_in_nav_menu( $location, $types );
	}
}

function check_nav_menus_for_policy_pages(): void {
	if ( should_check_policy_pages_in_nav_menu( 'footer_menu' ) ) {
		$types = create_nav_menu_checker()
			->policy_page_types_in_menu_location( 'footer_menu' );

		if ( $types ) {
			cache_policy_pages_in_nav_menu( 'footer_menu', $types );
		} else {
			\do_action(
				'wordpress_helfi_cookie_consent_add_nav_menu_policy_pages',
				'footer_menu'
			);
		}
	}
}

function create_nav_menu_checker(): Nav_Menu_Checker {
	return new Nav_Menu_Checker(
		\apply_filters(
			'wordpress_helfi_cookie_consent_nav_menu_metabox_pages',
			array()
		)
	);
}

function should_check_policy_pages_in_nav_menu( string $location ): bool {
	return empty( policy_pages_in_nav_menu_cache( $location ) );
}

function policy_pages_in_nav_menu_cache( string $location ): array {
	$transient = \get_transient( cache_key( $location ) );

	return is_array( $transient ) ? $transient : array();
}

function cache_policy_pages_in_nav_menu( string $location, array $pages ): bool {
	return \set_transient( cache_key( $location ), $pages, DAY_IN_SECONDS );
}

function clear_policy_pages_in_nav_menu_cache( string $location ): bool {
	return \delete_transient( cache_key( $location ) );
}

function cache_key( string $location ): string {
	return 'wordpress_helfi_cookie_consent_nav_menu_' . $location;
}
