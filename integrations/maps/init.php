<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Maps;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'wordpress_helfi_cookie_consent_setup', __NAMESPACE__ . '\\setup_cmplz_integration' );
function setup_cmplz_integration(): void {
	if ( \did_action( 'helsinki_wp_pre_setup' ) ) {
		\add_filter( 'cmplz_integrations', __NAMESPACE__ . '\\provide_cmplz_integration' );
		function provide_cmplz_integration( array $integrations ): array {
			$integrations[palvelukartta_hel_fi_integration()] = array(
				'constant_or_function' => __NAMESPACE__ . '\\palvelukartta_hel_fi_integration',
				'label'                => 'palvelukartta.hel.fi',
				'firstparty_marketing' => false,
			);

			$integrations[kartta_hel_fi_integration()] = array(
				'constant_or_function' => __NAMESPACE__ . '\\kartta_hel_fi_integration',
				'label'                => 'kartta.hel.fi',
				'firstparty_marketing' => false,
			);

			return $integrations;
		}

		\add_filter( 'cmplz_integration_path', __NAMESPACE__ . '\\provide_cmplz_integration_path', 10, 2 );
		function provide_cmplz_integration_path( string $path, string $integration ): string {
			return match( $integration ) {
				kartta_hel_fi_integration() => \plugin_dir_path( __FILE__ ) . 'complianz/maps.php',
				palvelukartta_hel_fi_integration() => \plugin_dir_path( __FILE__ ) . 'complianz/service-maps.php',
				default => $path,
			};
		}
	}
}

function kartta_hel_fi_integration(): string {
	return 'kartta_hel_fi';
}

function palvelukartta_hel_fi_integration(): string {
	return 'palvelukartta_hel_fi';
}
