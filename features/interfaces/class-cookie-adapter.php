<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Cookie_Adapter
{
	public function issuer(): string;
	public function name(): string;
	public function label(): string;
	public function description(): string;
	public function retention(): string;
	public function type(): Cookie_Type;
	public function category(): Cookie_Category;
}
