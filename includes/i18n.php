<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function textdomain(): void {
	load_plugin_textdomain(
		'wordpress-helfi-cookie-consent',
		false,
		apply_filters( 'wordpress_helfi_cookie_consent_plugin_dirname', '' ) . '/languages'
	);
}
