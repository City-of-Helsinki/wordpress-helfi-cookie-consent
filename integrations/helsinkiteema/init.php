<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Helsinkiteema;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Nav_Menu_Checker;

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	if ( is_helsinkiteema_active() ) {
		\add_action( 'admin_head-index.php', __NAMESPACE__ . '\\check_nav_menus_for_policy_pages' );
		\add_action( 'wp_update_nav_menu', __NAMESPACE__ . '\\handle_clear_nav_menus_cache', 10, 2 );
	}
}

function is_helsinkiteema_active(): bool {
	return (bool) \did_action( 'helsinki_theme_setup_ready' );
}

function handle_clear_nav_menus_cache( int $menu_id, array $menu_data = array() ): void {
	foreach ( \get_nav_menu_locations() as $location => $id ) {
		if ( $id === $menu_id ) {
			clear_policy_pages_in_nav_menu_cache( $location );
			break;
		}
	}
}

function check_nav_menus_for_policy_pages(): void {
	if ( should_check_policy_pages_in_nav_menu( 'footer_menu' ) ) {
		$checker = create_nav_menu_checker(
			\apply_filters(
				'wordpress_helfi_cookie_consent_nav_menu_metabox_pages',
				array()
			)
		);

		$types = $checker->policy_page_types_in_menu_location( 'footer_menu' );
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

function create_nav_menu_checker( array $pages ): Nav_Menu_Checker {
	return new Nav_Menu_Checker( $pages );
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
