# WP Helsinki Cookie Consent

WP Implementation of the standalone version of the [HDS CookieConsent](https://hds.hel.fi/components/cookie-consent/).

## Assets

Source: `/assets/public`

- `js/scripts(.min).js` determines current cookie handler and creates `hds.CookieConsentCore` using the inline `HelfiCookieConsent` configuration variable.
- `js/vendor(.min).js` contains `hds-js/standalone/cookieConsent/index.js`.

## Features

### HDS CookieConsent

Source: `/features/models`

- Uses `apply_filters( 'wordpress_helfi_cookie_consent_cookie_type_factory', Cookie_Type_Factory $factory )` to create `Cookie_Type` objects. The default factory uses flyweight for the created types.
- Uses `apply_filters( 'wordpress_helfi_cookie_consent_cookie_category_factory', Cookie_Category_Factory $factory )` to create `Cookie_Category` objects. The default factory uses flyweight for the created categories.
- Uses `apply_filters( 'wordpress_helfi_cookie_consent_cookie_database', Cookie_Database $database )` to configure `Cookie_Repository` cookie database.
- Uses `apply_filters( 'wordpress_helfi_cookie_consent_cookie_adapter_factory', Cookie_Adapter_Factory $factory, Cookie_Category_Factory $categories, Cookie_Type_Factory $types, string $current_language )` to configure `Cookie_Repository` cookie factory.
- Uses `apply_filters( 'wordpress_helfi_cookie_consent_known_cookies', array $cookies )` to configure `Cookie_Repository` known cookies.
- Provides `Cookie_Repository` via `wordpress_helfi_cookie_consent_cookie_repository` filter.

### Known cookies

Source: `/features/cookies`

- Provides configuration for known cookies as `Known_Cookie_Data`.

**Cookies**

- `helfi-cookie-consents` from `HDS_Cookie_Consent`

### Notices

Source: `/features/notices`

- Handles displaying `admin_notices` on action.
- Additional notices can be displayed by `do_action( 'wordpress_helfi_cookie_consent_add_admin_notice', Admin_Notice $notice )` before `admin_notices`.
- Displays `Missing_Cookie_Provider_Notice`, if `wordpress_helfi_cookie_consent_has_cookie_provider` is `false`.

### Pages

Source: `/features/pages`

- Registers rewrite tags and rules for dynamic policy pages.
- Determines the current policy page based on `get_query_var()` value.
- Clears rewrite rules when the plugin is either activated or deactivated.
- Provides `Helsinki Cookie Consent` nav menu metabox for adding policy page menu items to a navigation menu.
- Provides dynamic titles and urls for the policy page menu items.
- Provides custom `features/pages/templates/cookie-policy.php` template for policy pages.
- Determines the page content. The page content is extendable with action hooks.
- Determines `document_title` for a policy page.
- Adds policy page links to menu location on `do_action( 'wordpress_helfi_cookie_consent_add_nav_menu_policy_pages', string $location )`.
- Displays `Nav_Menu_Policy_Pages_Added_Notice` when pages are added to menu location.

#### Dynamic pages

- About the website
- Cookie settings

### REST API

Source: `/features/rest`

- Registers versioned REST endpoint `/settings` in `helfi-cookie-consent` namespace.
- The `/settings` endpoint returns HDS CookieConsent settings in `json` format.
- Uses `apply_filters( 'wordpress_helfi_cookie_consent_cookie_repository', Cookie_Repository $repository )` to provide cookie data.
- Provides inline `HelfiCookieConsent` JavaScript configuration variable to HDS CookieConsent in `hel-cookie-consent` script.

### Views

Source: `/features/views`

- Registers `hel-cookie-consent-vendor` and `hel-cookie-consent` scripts.
- Registers inline styles for the cookie consent settings wrap element using dynamic handle name based on the `wordpress_helfi_cookie_consent_settings_element_id` filter.
- Provides default value for `wordpress_helfi_cookie_consent_settings_element_id`.

### Settings

Source: `/features/settings`

- Register custom **Reading** setting for using custom policy pages.
- Registers custom **Reading** settings for `about_website` and `cookie_policy` pages.
- If custom pages are enabled then the custom rewrite rules are disabled.
- When custom pages are enabled it is expected that the user selects which pages display the policy pages.
- Policy content is automatically **appended** using `the_content` filter to the main content of the selected page. The content **must** be within The Loop.

## Integrations

### Complianz – GDPR/CCPA Cookie Consent

From: [complianz.io](https://complianz.io/) and [Plugin Directory](https://wordpress.org/plugins/complianz-gdpr/).

Source: `/integrations/complianz`

- The plugin uses Complianz as a cookie data provider.
- Provides the cookies identified by Complianz to the CookieConsent component.
- Disables the default Complianz cookie banner, cookie banner styles, and replaces the `cookie-statement` document with CookieConsent container.
- The JavaScript `complianz_cookies_handler` function acts as an adapter between Complianz and CookieConsent scripts.
- Provides implementation of `Cookie_Database` to `wordpress_helfi_cookie_consent_cookie_database`.
- Provides implementation of `Cookie_Adapter_Factory` to  `wordpress_helfi_cookie_consent_cookie_adapter_factory`.
- Flags `wordpress_helfi_cookie_consent_has_cookie_provider` as `true`.

### Helsinkiteema

From: [City-of-Helsinki/wordpress-helfi-helsinkiteema](https://github.com/City-of-Helsinki/wordpress-helfi-helsinkiteema)

Source: `/integrations/helsinkiteema`

- On Dashboard view, checks, if the menu location `footer_menu` contains cookie policy pages' links.
- If policy pages' links are missing from the menu, adds the missing ones.
- The check result is cached in a transient for one day.
- The cache transient is cleared when a menu attached to `footer_menu` location is updated.
- The custom **Reading** are not available for Helsinkiteema. The site is expected to use the auto-generated policy pages.

### Polylang

From: [polylang.pro](https://polylang.pro/) and [Plugin Directory](https://fi.wordpress.org/plugins/polylang/)

Source: `/integrations/polylang`

- Provides multilingual support for the custom policy pages by translating their page slugs.
- Adds the translated policy page url to the language selector.

### Yoast SEO

From: [yoast.com](https://yoast.com/) and [Plugin Directory](https://wordpress.org/plugins/wordpress-seo/)

Source: `/integrations/wordpressseo`

- Provides SEO meta data for the custom policy pages.

## Custom cookies

You can provide custom cookies to the consent banner and settings.

**0)** Check the cookie consent plugin is available.

```
if ( did_action( 'wordpress_helfi_cookie_consent_loaded' ) ) {
  // your code here...
}
```

**1)** Create a cookie data class which implements `Known_Cookie_Data`.

```
use CityOfHelsinki\WordPress\CookieConsent\Features\Interfaces\Known_Cookie_Data;

final class My_Custom_Cookie implements Known_Cookie_Data interface
{
  // Name of the service or functionality issuing the cookie
  public function issuer(): string
  {
    return 'My custom cookie';
  }

  // Name of the cookie, if the name has variable suffix, append _* to the name
  public function name(): string
  {
    return 'my_custom_cookie';
    // return 'my_variable_cookie_*';
  }

  // Cookie name for humans, shown on the consent banner and settings
  public function label(): string
  {
    return 'my_custom_cookie';
  }

  // Translated description of what the cookie is used for
  public function descriptionTranslations(): array
  {
    return array(
      'fi' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
      'sv' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
      'en' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
    );
  }

  // Retention time translations
  public function retentionTranslations(): array
  {
    return array(
      'fi' => '100 päivää',
      'sv' => '100 dagar',
      'en' => '100 days'
    );
  }

  // Supported types: cachestorage, indexeddb, localstorage, sessionstorage
  // Invalid type will be marked as unknown
  public function type(): string
  {
    return 'localstorage';
  }

  // Supported categories: preferences, functional, marketing, statistics, statistics_anonymous
  // Invalid category will be marked as unknown
  public function category(): string
  {
    return 'statistics';
  }
}
```

**2)** Pass the fully qualified name of custom cookie to the consent banner with a filter.

```
add_filter( 'wordpress_helfi_cookie_consent_known_cookies', 'provide_my_custom_cookie' );
function provide_my_custom_cookie( array $cookies ): array {
  $cookies[] = My_Custom_Cookie::class;

  return $cookies;
}
```

The filter can be used in both plugins and themes.

**3)** Make sure your cookie issuer respects the consent banner.

The cookie consent plugin currently only supports Complianz as the general cookie data provider and cookie blocker. Refer to the [developer documentation](https://complianz.io/developers-guide-for-third-party-integrations/) for integrating your cookie issuing functionality with Complianz and to have your cookie blocked automatically.

See the HDS CookieConsent [component documentation](https://hds.hel.fi/components/cookie-consent/api/#events), if you need to listen to the consent events dispatched by the consent banner.
