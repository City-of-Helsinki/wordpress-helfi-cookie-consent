<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\Complianz;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Cookie_Database;

final class Complianz_Cookie_Database implements Cookie_Database
{
	private array $category_map;

	private array $known_cookies = array(
		'comment_author_email' => '',
		'comment_author_email_' => '',
		'comment_author_url' => '',
		'comment_author_url_' => '',
		'comment_author' => '',
		'comment_author_' => '',
		'wordpress_logged_in_' => '',
		'wordpress_logged_in' => '',
		'wordpress_sec_' => '',
		'wordpress_sec' => '',
		'wordpress_test_cookie' => '',
		'wp-api-schema-model' => '',
		'wp-autosave' => '',
		'wp-autosave-' => '',
		'wp-settings-time' => '',
		'wp-settings-time-' => '',
		'wp-settings' => '',
		'wp-settings-' => '',
		'wp-saving-post' => '',
		'wp_lang' => '',
		'wp-postpass' => '',
		'wp-postpass_' => '',
		'WP_DATA_USER' => '',
		'WP_DATA_USER_' => '',
		'WP_PREFERENCES_USER' => '',
		'WP_PREFERENCES_USER_' => '',
	);

	public function __construct(
		private \wpdb $db
	) {
		$this->category_map = array(
			'Functional' => 'functional',
			'Preferences' => 'preferences',
			'Statistics' => 'statistics',
			'Statistics (anonymous)' => 'statistics_anonymous',
			'Marketing' => 'marketing',
		);
	}

	public function cookies(): array
	{
		return $this->determine_cookies_categories(
			$this->merge_cookies(
				$this->query_cookies()
			)
		);
	}

	private function determine_cookies_categories( array $cookies ): array
	{
		array_walk(
			$cookies,
			function( &$cookie ) {
				$purpose = $cookie['purpose']['en'] ?? '';

				if ( $purpose && isset( $this->category_map[$purpose] ) ) {
					$cookie['category'] = $this->category_map[$purpose];
				} else {
					$cookie['category'] = 'unknown';
				}

				unset($cookie['purpose']);
			}
		);

		return $cookies;
	}

	private function merge_cookies( array $cookies ): array
	{
		return array_reduce(
			$cookies,
			function( array $sorted, \stdClass $cookie ) {
				if ( $this->is_known_cookie( $cookie->slug ) ) {
					return $sorted;
				}

				if ( ! isset( $sorted[$cookie->slug] ) ) {
					$sorted[$cookie->slug] = array(
						'service_name' => $cookie->service_name,
						'service_slug' => $cookie->service_slug,
						'name' => $cookie->name,
						'slug' => $cookie->slug,
						'type' => '',
					);
				}

				if ( empty( $sorted[$cookie->slug]['type'] ) && ! empty( $cookie->type ) ) {
					$sorted[$cookie->slug]['type'] = mb_strtolower( $cookie->type );
				}

				$translatables = array(
					'retention',
					'cookie_function',
					'purpose',
				);

				foreach ( $translatables as $key ) {
					if ( ! isset( $sorted[$cookie->slug][$key] ) ) {
						$sorted[$cookie->slug][$key] = array();
					}

					if ( ! isset( $sorted[$cookie->slug][$key][$cookie->language] ) ) {
						$sorted[$cookie->slug][$key][$cookie->language] = $cookie->$key;
					}
				}

				return $sorted;
			},
			array()
		);
	}

	private function is_known_cookie( string $name ): bool
	{
		return isset( $this->known_cookies[$name] );
	}

	private function query_cookies(): array
	{
		return $this->db->get_results(
			"SELECT
				c.name,
				c.slug,
				c.retention,
				c.type,
				c.cookieFunction AS cookie_function,
				c.purpose,
				c.language,
				c.isTranslationFrom AS cookie_translation_id,
				c.serviceID AS service_id,
				cs.name AS service_name,
				cs.slug AS service_slug
			FROM
				{$this->db->prefix}cmplz_cookies AS c
			INNER JOIN
				{$this->db->prefix}cmplz_services AS cs ON c.serviceID = cs.ID
			WHERE
				`ignored` = 0
				AND `deleted` = 0
				AND `showOnPolicy` = 1;"
		);
	}
}
