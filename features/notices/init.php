<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Notices;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

\add_action( 'admin_init', __NAMESPACE__ . '\\init' );
function init(): void {
	$hooks = create_admin_notices_hooks();

	\add_action(
		'wordpress_helfi_cookie_consent_add_admin_notice',
		array( $hooks, 'add_notice' )
	);

	\add_action(
		'admin_notices',
		array( $hooks, 'display_notices' )
	);
}

function create_admin_notices_hooks(): Admin_Notices_Hooks {
	return new Admin_Notices_Hooks();
}
