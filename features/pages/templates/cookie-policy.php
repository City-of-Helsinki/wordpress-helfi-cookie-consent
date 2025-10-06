<?php

$current_page = apply_filters( 'wordpress_helfi_cookie_consent_current_page', null );

get_header();

do_action( 'wordpress_helfi_cookie_consent_page_before', $current_page );

do_action( 'wordpress_helfi_cookie_consent_page_top', $current_page );

do_action( 'wordpress_helfi_cookie_consent_page', $current_page );

do_action( 'wordpress_helfi_cookie_consent_page_bottom', $current_page );

do_action( 'wordpress_helfi_cookie_consent_page_after', $current_page );

get_footer();
