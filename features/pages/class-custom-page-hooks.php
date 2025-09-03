<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Features\Pages;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Policy_Page;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Nav_Menu;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Rewrite_Rule;
use CityOfHelsinki\WordPress\CookieConsent\Features\Models\Rewrite_Tag;

final class Custom_Page_Hooks
{
	public function __construct(
		private Policy_Page_Factory $factory,
		private string $current_language
	) {}

	public function helfi_custom_pages(): array
	{
		return $this->factory->all();
	}

	public function create_nav_menu_policy_pages( string $location ): void
	{
		$menu = new Nav_Menu( $location );

		if ( $menu->id() ) {
			$item_types = array_flip( $menu->item_types() );
			$pages_added = false;

			foreach( $this->factory->all() as $page ) {
				if ( ! isset( $item_types[$page->type()] ) ) {
					$item_id = \wp_update_nav_menu_item( $menu->id(), 0, array(
						'menu-item-title' => $page->title(),
						'menu-item-url' => '#',
						'menu-item-type' => $page->type(),
						'menu-item-status' => 'publish',
					) );

					if ( is_int( $item_id ) && $item_id ) {
						$pages_added = true;
					}
				}
			}

			if ( $pages_added ) {
				\do_action(
					'wordpress_helfi_cookie_consent_nav_menu_policy_pages_added',
					$location
				);

				\do_action(
					'wordpress_helfi_cookie_consent_add_admin_notice',
					new Nav_Menu_Policy_Pages_Added_Notice( $menu )
				);
			}
		}
	}

	public function wp_setup_nav_menu_item( $menu_item )
	{
		$page = $this->factory->from_item_type( $menu_item->type ?? '' );

		if ( $page ) {
			$menu_item->title = $page->title();
			$menu_item->url = $this->page_url( $page );
		}

		return $menu_item;
	}

	public function wp_nav_menu_objects( array $items ): array
	{
		foreach ($items as &$item) {
			$page = $this->factory->from_item_type( $item->type ?? '' );

			if ( $page ) {
				$item->title = $page->title();
				$item->url = $this->page_url( $page );
			}
		}

		return $items;
	}

	public function register_rewrites(): void
	{
		foreach( $this->factory->all() as $page ) {
			$this->register_rewrite_tag( $page->rewrite_tag() );

			array_map(
				array( $this, 'register_rewrite_rule' ),
				\apply_filters(
					'wordpress_helfi_cookie_consent_policy_page_rewrite_rules',
					$page->rewrite_rules(),
					$page
				)
			);
		}
	}

	public function policy_page_template( string $template ): string
	{
		$page = $this->get_current_policy_page();

		return $page ? $page->template_path() : $template;
	}

	public function policy_page_content(): void
	{
		$page = $this->get_current_policy_page();

		if ( $page ) {
			echo $page->content();
		}
	}

	public function current_policy_page( ?Policy_Page $page ): ?Policy_Page
	{
		return $this->get_current_policy_page() ?: $page;
	}

	public function document_title( string $title ): string
	{
		return apply_filters(
			'wordpress_helfi_cookie_consent_policy_page_meta_title',
			$title,
			' | '
		);
	}

	public function policy_page_title( string $title, string $separator ): string
	{
		$page = $this->get_current_policy_page();

		return $page
			? implode( $separator, $this->policy_page_title_parts( $page ) )
			: $title;
	}

	private function policy_page_title_parts( Policy_Page $page ): array
	{
		return array(
			$page->title(),
			\get_bloginfo( 'name' ),
			__( 'City of Helsinki', 'wordpress-helfi-cookie-consent' )
		);
	}

	private function get_current_policy_page(): ?Policy_Page
	{
		return $this->factory->from_item_type(
			\get_query_var( $this->factory->query_var(), '' )
		);
	}

	private function register_rewrite_tag( Rewrite_Tag $tag ): void
	{
		\add_rewrite_tag( $tag->tag(), $tag->regex() );
	}

	private function register_rewrite_rule( Rewrite_Rule $rule ): void
	{
		\add_rewrite_rule( $rule->regex(), $rule->query(), $rule->priority() );
	}

	private function page_url( Policy_Page $page ): string
	{
		return \home_url( \apply_filters(
			'wordpress_helfi_cookie_consent_policy_page_slug',
			'/' . ($page->slug( $this->current_language ) ?: $page->slug( 'en' )),
			$page,
			$this->current_language
		) );
	}
}
