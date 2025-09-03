<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Polylang;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'wordpress_helfi_cookie_consent_loaded', __NAMESPACE__ . '\\init', 10 );
function init(): void {
	if ( is_polylang_active() ) {
		$translations = create_translated_policy_pages();

		\add_filter(
			'wordpress_helfi_cookie_consent_policy_page_rewrite_rules',
			array( $translations, 'translate_rewrite_rules' ),
			10, 2
		);

		\add_filter(
			'pll_the_language_link',
			array( $translations, 'policy_page_language_link' ),
			10, 3
		);

		\add_filter(
			'wordpress_helfi_cookie_consent_policy_page_slug',
			array( $translations, 'policy_page_slug' ),
			10, 3
		);
	}
}

function create_translated_policy_pages(): Translated_Policy_Pages {
	return new Translated_Policy_Pages();
}

function is_polylang_active(): bool {
	return (bool) \did_action( 'pll_init' );
}
