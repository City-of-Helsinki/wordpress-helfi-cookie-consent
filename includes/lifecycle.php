<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function setup() : void {
	if ( ! \did_action( 'wordpress_helfi_cookie_consent_setup' ) ) {
		\do_action( 'wordpress_helfi_cookie_consent_setup' );
	}
}

function loaded() : void {
	if ( ! \did_action( 'wordpress_helfi_cookie_consent_loaded' ) ) {
		\do_action( 'wordpress_helfi_cookie_consent_loaded' );
	}
}

function init() : void {
	if ( ! \did_action( 'wordpress_helfi_cookie_consent_init' ) ) {
		\do_action( 'wordpress_helfi_cookie_consent_init' );
	}
}

function activate() : void {
	setup();

	\do_action( 'wordpress_helfi_cookie_consent_activate' );
}

function deactivate() : void {
	setup();

	\do_action( 'wordpress_helfi_cookie_consent_deactivate' );
}

function uninstall() : void {
	setup();

	\do_action( 'wordpress_helfi_cookie_consent_uninstall' );
}
