<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Cookies\WordPress;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class WP_Saving_Post implements Known_Cookie_Data
{
	public function issuer(): string
	{
		return 'WordPress';
	}

	public function name(): string
	{
		return 'wp-saving-post';
	}

	public function label(): string
	{
		return 'wp-saving-post';
	}

	public function descriptionTranslations(): array
	{
		return array(
			'fi' => 'Tallentaa viestin editoriin. Seuraa, onko muokattavalle viestille tallennettua viestiä.',
			'sv' => 'Lagrar ett inlägg i redigeraren. Spårar om det finns ett sparat inlägg för det aktuella inlägget som redigeras.',
			'en' => 'Stores a post in the editor. Tracks whether a saved post exists for the current post being edited.',
		);
	}

	public function retentionTranslations(): array
	{
		return array(
			'fi' => '1 päivä',
			'sv' => '1 dag',
			'en' => '1 day'
		);
	}

	public function type(): string
	{
		return 'cookie';
	}

	public function category(): string
	{
		return 'functional';
	}
}
