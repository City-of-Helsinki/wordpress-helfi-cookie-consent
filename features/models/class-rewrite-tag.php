<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Rewrite_Tag
{
	public function __construct(
		private string $query_var,
		private string $regex
	) {}

	public function tag(): string
	{
		return '%' . $this->query_var . '%';
	}

	public function regex(): string
	{
		return $this->regex;
	}
}
