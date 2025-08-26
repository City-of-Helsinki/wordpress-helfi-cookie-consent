<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Policy_Page;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Rewrite_Rule;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Rewrite_Tag;

final class Cookie_Policy_Page implements Policy_Page
{
	private array $slugs = array(
		'fi' => 'evasteasetukset',
		'en' => 'cookie-settings',
		'sv' => 'cookie-installningar',
	);

	public function __construct(
		private string $query_var
	) {}

	public function query_var(): string
	{
		return $this->query_var;
	}

	public function type(): string
	{
		return 'helfi_cookie_policy';
	}

	public function title(): string
	{
		return __( 'Cookie Policy', 'wordpress-helfi-cookie-consent' );
	}

	public function content(): string
	{
		$id = \apply_filters( 'wordpress_helfi_cookie_consent_settings_element_id', '' );

		return $id ? sprintf( '<div id="%s"></div>', \esc_attr( $id ) ) : '';
	}

	public function template_path(): string
	{
		return \apply_filters(
			'wordpress_helfi_cookie_consent_path_to_php_file',
			array( 'features', 'pages', 'templates', 'cookie-policy' )
		);
	}

	public function slug( string $lang ): string
	{
		return $this->slugs[$lang] ?? '';
	}

	public function rewrite_tag(): Rewrite_Tag
	{
		return new Rewrite_Tag( $this->query_var(), '([^&]+)' );
	}

	public function rewrite_rules(): array
	{
		return array_map(
			fn( string $slug ) => new Rewrite_Rule(
				$this->query_var(),
				$slug,
				$this->type()
			),
			$this->slugs
		);
	}
}
