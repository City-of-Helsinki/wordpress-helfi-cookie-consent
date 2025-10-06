<?php

declare(strict_types = 1);

namespace CityOfHelsinki\WordPress\CookieConsent\Integrations\WordPressSeo;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Policy_Page;

\add_action( 'template_redirect', __NAMESPACE__ . '\\init' );
function init(): void {
	if ( ! is_wordpress_seo_active() ) {
		return;
	}

	$policy_page = current_page();
	if ( ! $policy_page ) {
		return;
	}

	$hooks = create_meta_data_hooks(
		$policy_page,
		\apply_filters(
			'wordpress_helfi_cookie_consent_current_language',
			'en'
		),
		title_separator()
	);

	\add_filter( 'wpseo_title', array( $hooks, 'title' ), 9999, 1 );
	\add_filter( 'wpseo_metadesc', array( $hooks, 'title' ), 9999, 1 );
	\add_filter( 'wpseo_twitter_title', array( $hooks, 'title' ), 9999, 1 );
	\add_filter( 'wpseo_twitter_description', array( $hooks, 'title' ), 9999, 1 );
	\add_filter( 'wpseo_twitter_image', array( $hooks, 'image_url' ), 9999, 1 );
	\add_filter( 'wpseo_opengraph_title', array( $hooks, 'title' ), 9999, 1 );
	\add_filter( 'wpseo_opengraph_desc', array( $hooks, 'title' ), 9999, 1 );
	\add_filter( 'wpseo_opengraph_url', array( $hooks, 'url' ), 9999, 1 );
	\add_filter( 'wpseo_opengraph_image', array( $hooks, 'image_url' ), 9999, 1 );

	\add_filter( 'wpseo_breadcrumb_links', array( $hooks, 'breadcrumbs' ) );
	\add_filter( 'wpseo_schema_graph', array( $hooks, 'schema_graph' ), 9999, 2 );
}

function is_wordpress_seo_active(): bool {
	return (bool) \did_action( 'wpseo_loaded' );
}

function title_separator(): string {
	$separator = \YoastSEO()?->helpers?->options?->get_title_separator();

	return $separator ? ' ' . $separator . ' ' : ' | ';
}

function current_page(): ?Policy_Page {
	return \apply_filters(
		'wordpress_helfi_cookie_consent_current_page',
		null
	);
}

function create_meta_data_hooks( Policy_Page $page, string $language, string $title_separator ): Meta_Data_Hooks {
	$slug = \apply_filters(
		'wordpress_helfi_cookie_consent_page_slug',
		$page->slug( $language ) ?: $page->slug( 'en' ),
		$page,
		$language
	);

	return new Meta_Data_Hooks(
		$page->title(),
		$title_separator,
		\trailingslashit( \home_url( '/' . $slug ) ),
		$language
	);
}
