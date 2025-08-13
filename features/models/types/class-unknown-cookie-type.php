<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Models\Types;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Type;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Traits\Label_Translations;

final class Unknown_Cookie_Type implements Cookie_Type
{
	use Label_Translations;

	protected array $labels = array(
		'fi' => 'Tuntematon',
		'sv' => 'Okänd',
		'en' => 'Unknown',
	);

	public function __construct(
		protected string $current_language
	) {}

	public function name(): string
	{
		return 'unknown';
	}

	public function label( string $language = '' ): string
	{
		return $this->translated_label( $language, $this->current_language )
			?: __( 'Unknown', 'wordpress-helfi-cookie-consent' );
	}

	public function code(): int
	{
		return 1;
	}
}
