<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;
use CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\HDS_Cookie_Consent;
use Closure;

final class Known_Cookies
{
	private Closure $callback;

	public function __construct(
		callable $callback
	) {
		$this->callback = Closure::fromCallable( $callback );
	}

	public function list(): array
	{
		return array_map(
			array( $this, 'to_cookie_data' ),
			$this->get_cookies()
		);
	}

	private function get_cookies(): array
	{
		return array_values(
		    array_unique(
		        array_merge(
		            $this->default_cookies(),
		            call_user_func( $this->callback )
		        )
		    )
		);
	}

	private function to_cookie_data( string $cookie ): Known_Cookie_Data
	{
		return new $cookie();
	}

	private function default_cookies(): array
	{
		return array(
			HDS_Cookie_Consent::class,
		);
	}
}
