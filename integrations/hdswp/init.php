<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\HDSWP;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'wordpress_helfi_cookie_consent_setup', function() {

	\add_action( 'template_redirect', function() {

		\add_filter(
			'hds_wp_embedded_figure_iframe_html',
			__NAMESPACE__ . '\\script_load_embedded_figure_iframe',
			10, 3
		);

		\add_action(
			'helsinki_maintenance_footer',
			__NAMESPACE__ . '\\render_cookie_banner_button',
			30
		);

	} );

} );

function script_load_embedded_figure_iframe( string $iframe, string $type, array $attributes ): string {
	$placeholder = \apply_filters(
		'wordpress_helfi_cookie_consent_iframe_placeholder',
		'',
		$attributes['src'] ?? ''
	);

	if ( $placeholder ) {
		return sprintf(
			'<div class="wp-cookie-consent-iframe has-placeholder" data-wp-cookie-consent-iframe="%1$s">%2$s</div>',
			htmlspecialchars( json_encode( $attributes ) ),
			\wp_kses_post( $placeholder )
		);
	}

	return $iframe;
}

function render_cookie_banner_button(): void {
	printf(
		'<button id="wp-cookie-consent-open" class="link" type="button">%s</button>',
		\esc_html( __( 'Cookie settings', 'wordpress-helfi-cookie-consent' ) )
	);
}
