<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Consent_View;

final class Cookie_Consent_Views
{
	public function __construct(
		private Cookie_Repository $repository,
		private array $views
	) {}

	public function setup(): void
	{
		array_walk(
			$this->views,
			fn( string $view ) => $this->create_view( $view )->setup()
		);
	}

	private function create_view( string $view ): Cookie_Consent_View
	{
		return new $view( $this->repository );
	}
}
