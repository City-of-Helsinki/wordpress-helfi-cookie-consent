<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Notices;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'admin_init', __NAMESPACE__ . '\\init' );
function init(): void {
	\add_action( 'admin_notices', __NAMESPACE__ . '\\display_cookie_provider_status' );
}

function display_cookie_provider_status(): void {
	if ( ! \apply_filters( 'wordpress_helfi_cookie_consent_has_cookie_provider', false ) ) {
		$notice = new Missing_Cookie_Provider_Notice();

		printf(
			'<div class="notice notice-%s">%s</div>',
			\esc_attr( $notice->type() ),
			\wp_kses_post( $notice->message() )
		);
	}
}
