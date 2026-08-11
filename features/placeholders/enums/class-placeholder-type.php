<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders\Enums;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

enum Placeholder_Type: string
{
	case IFRAME = 'iframe';
	case SCRIPT = 'script';
}
