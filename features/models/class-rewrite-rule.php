<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Rewrite_Rule
{
	public function __construct(
		private string $query_var,
		private string $slug,
		private string $type
	) {}

	public function regex(): string
	{
		return sprintf( '^%s/?$', $this->slug );
	}

	public function query(): string
	{
		return sprintf( 'index.php?%s=%s', $this->query_var, $this->type );
	}

	public function priority(): string
	{
		return 'top';
	}
}
