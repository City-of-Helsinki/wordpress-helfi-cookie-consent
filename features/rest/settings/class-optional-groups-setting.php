<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cookie_Repository;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Cookie_List;
use CityOfHelsinki\WordPress\CookieConsent\Features\Rest\Settings\Traits\Creates_Cookie_Groups;

class Optional_Groups_Setting implements Setting_Interface
{
	use Creates_Cookie_Groups;

	public function __construct(
		private Cookie_Repository $repository
	) {}

	public function name(): string
	{
		return 'optionalGroups';
	}

	public function value(): mixed
	{
		return $this->lists_to_groups(
			array_filter(
				$this->repository->cookie_lists()->all(),
				fn( Cookie_List $cookie_list ) => ! $cookie_list->required()
			)
		);
	}
}
