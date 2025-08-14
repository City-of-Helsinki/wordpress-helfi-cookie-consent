<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Known_Cookie_Data
{
	public function issuer(): string;
	public function name(): string;
	public function label(): string;
	public function descriptionTranslations(): array;
	public function retentionTranslations(): array;
	public function type(): string;
	public function category(): string;
}
