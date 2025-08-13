"use strict";

(function (hds, config) {
  if (hds.CookieConsentCore && config.routes) {
    init_handler(config);
    function init_handler({
      routes,
      currentLanguage,
      cookiesHandler
    }) {
      let handlers = {
        complianz: complianz_cookies_handler,
        none: no_cookies_handler
      };
      if (!handlers.hasOwnProperty(cookiesHandler)) {
        cookiesHandler = 'none';
      }
      handlers[cookiesHandler](create_cookie_consent(routes.settings, currentLanguage));
    }
    function complianz_cookies_handler(cookieConsentPromise) {
      const allow = group => cmplz_set_consent(group, 'allow');
      const deny = group => cmplz_set_consent(group, 'deny');
      const denyAll = () => cmplz_deny_all();
      window.addEventListener('hds-cookie-consent-ready', event => {
        if (hds.cookieConsent) {
          hds.cookieConsent.getAllConsentStatuses().forEach(({
            consented,
            group
          }) => consented ? allow(group) : deny(group));
        }
      });

      // window.addEventListener('hds-cookie-consent-unapproved-item-found', event => {
      //   console.log(event);
      // });

      window.addEventListener('hds-cookie-consent-changed', event => {
        const {
          acceptedGroups
        } = event.detail || [];
        if (acceptedGroups.length > 0) {
          event.detail.acceptedGroups.forEach(group => allow(group));
        } else {
          denyAll();
        }
      });
    }
    function no_cookies_handler() {
      console.log('no_cookies_handler');
    }
    function create_cookie_consent(settingsUrl, language) {
      return hds.CookieConsentCore.create((() => {
        let params = new URLSearchParams();
        params.append('lang', language);
        return settingsUrl + '?' + params.toString();
      })(), {
        // focusTargetSelector: '',
        language: language,
        // pageContentSelector: '',
        // settingsPageSelector: '',
        // spacerParentSelector: '',
        submitEvent: true
        // targetSelector: true,
      });
    }
  }
})(hds, HelfiCookieConsent);