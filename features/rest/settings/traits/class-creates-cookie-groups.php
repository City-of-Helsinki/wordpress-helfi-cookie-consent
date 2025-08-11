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
				'fi' => $cookie_list->label(),
				'sv' => $cookie_list->label(),
				'en' => $cookie_list->label(),
			),
			'description' => array(
				'fi' => $cookie_list->description(),
				'sv' => $cookie_list->description(),
				'en' => $cookie_list->description(),
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
			'name' => $cookie->name(),
			'host' => $cookie->issuer(),
			'description' => array(
				'fi' => $cookie->description(),
				'sv' => $cookie->description(),
				'en' => $cookie->description(),
			),
			'expiration' => array(
				'fi' => $cookie->retention(),
				'sv' => $cookie->retention(),
				'en' => $cookie->retention(),
			),
			'storageType' => $cookie->type()->code(),
		);
	}
}
