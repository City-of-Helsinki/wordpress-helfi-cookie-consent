<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Placeholders;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Placeholder_Content
{
	public function notice_icon(): string;
	public function notice_title(): string;
	public function notice_text(): string;
	public function notice_buttons(): array;
}
