<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings\Traits;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cookie_List;

trait Creates_Cookie_Groups
{
	protected function lists_to_groups( array $cookie_lists ): array
	{
		return array_values(
			array_map(
				array( $this, 'create_cookie_group' ),
				$cookie_lists
			)
		);
	}

	protected function create_cookie_group( Cookie_List $cookie_list ): array
	{
		return array(
			'groupId' => $cookie_list->name(),
			'title' => array(
				'fi' => $cookie_list->label( 'fi' ),
				'sv' => $cookie_list->label( 'sv' ),
				'en' => $cookie_list->label( 'en' ),
			),
			'description' => array(
				'fi' => $cookie_list->description( 'fi' ),
				'sv' => $cookie_list->description( 'sv' ),
				'en' => $cookie_list->description( 'en' ),
			),
			'cookies' => array_map(
				array( $this, 'format_cookie' ),
				$cookie_list->cookies()
			),
		);
	}

	protected function format_cookie( Cookie_Adapter $cookie ): array
	{
		return array(
			'name' => str_contains( $cookie->name(), '*' ) ? $cookie->name() : $cookie->label(),
			'host' => $cookie->issuer(),
			'description' => array(
				'fi' => $cookie->description( 'fi' ),
				'sv' => $cookie->description( 'sv' ),
				'en' => $cookie->description( 'en' ),
			),
			'expiration' => array(
				'fi' => $cookie->retention( 'fi' ),
				'sv' => $cookie->retention( 'sv' ),
				'en' => $cookie->retention( 'en' ),
			),
			'storageType' => $cookie->type()->code(),
		);
	}
}
