<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Adapter;
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Category;

final class Cookie_List
{
	private array $cookies;

	public function __construct(
		private Cookie_Category $category,
		Cookie_Adapter ...$cookies
	) {
		$this->cookies = $cookies;
	}

	public function name(): string
	{
		return $this->category->name();
	}

	public function label(): string
	{
		return $this->category->label();
	}

	public function description(): string
	{
		return $this->category->description();
	}

	public function required(): bool
	{
		return $this->category->required();
	}

	public function cookies(): array
	{
		return $this->cookies;
	}
}
