<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Notices;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Admin_Notice;

final class Admin_Notices_Hooks
{
	private array $notices;

	public function __construct()
	{
		$this->notices = array();
	}

	public function add_notice( Admin_Notice $notice ): void
	{
		$this->notices[] = $notice;
	}

	public function display_notices(): void
	{
		$this->setup_notice_filters();

		array_walk( $this->notices, array( $this, 'render_notice' ) );
	}

	private function setup_notice_filters(): void
	{
		if ( ! \apply_filters( 'wordpress_helfi_cookie_consent_has_cookie_provider', false ) ) {
			$this->notices[] = new Missing_Cookie_Provider_Notice();
		}
	}

	private function render_notice( Admin_Notice $notice ): void
	{
		printf(
			'<div class="notice notice-%s">%s</div>',
			\esc_attr( $notice->type() ),
			\wp_kses_post( $notice->message() )
		);
	}
}
