<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Unknowns;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Type;

final class Unknown_Cookie_Adapter implements Cookie_Adapter
{
	public function __construct(
		private array $data
	) {}

	public function issuer(): string
	{
		return $this->data[__FUNCTION__];
	}

	public function name(): string
	{
		return $this->data[__FUNCTION__];
	}

	public function label(): string
	{
		return $this->data[__FUNCTION__];
	}

	public function description(): string
	{
		return $this->data[__FUNCTION__];
	}

	public function retention(): string
	{
		return $this->data[__FUNCTION__];
	}

	public function type(): Cookie_Type
	{
		return $this->data[__FUNCTION__];
	}

	public function category(): Cookie_Category
	{
		return $this->data[__FUNCTION__];
	}
}
