<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Settings\Reading\Reading_Settings;

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init' );
function init(): void {
	$hooks = create_settings_hooks( array(
		create_reading_settings()
	) );

	\add_action( 'init', array( $hooks, 'provide_field_values' ), 5 );
	\add_action( 'admin_init', array( $hooks, 'register' ) );
}

function create_settings_hooks( array $settings ): Settings_Hooks {
	return new Settings_Hooks( $settings );
}

function create_reading_settings(): Reading_Settings {
	return new Reading_Settings();
}
