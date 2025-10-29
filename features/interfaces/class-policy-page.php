<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Rewrite_Tag;

interface Policy_Page
{
	public function query_var(): string;
	public function type(): string;
	public function title(): string;
	public function content(): string;
	public function template_path(): string;
	public function slug( string $lang ): string;
	public function url( string $lang ): string;
	public function rewrite_tag(): ?Rewrite_Tag;
	public function rewrite_rules(): array;
}
