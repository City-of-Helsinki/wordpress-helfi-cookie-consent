(function (hds, config) {
  if (hds.CookieConsentCore && config.routes) {
    const CONSENT_CHANGED = 'hds-cookie-consent-changed';
    const CONSENT_GRANTED = 'wp-cookie-consent-granted';
    initCookieConsent(config);
    function CookieConsentFacade({
      cookieConsent
    }) {
      return {
        consents: () => cookieConsent.getAllConsentStatuses(),
        grant: groups => {
          if (!Array.isArray(groups)) {
            groups = [groups];
          }
          cookieConsent.setGroupsStatusToAccepted(groups);
        }
      };
    }
    function Placeholder(element) {
      const _consentButton = element?.querySelector('[data-wp-cookie-consent-grant]');
      var _consentType = [];
      if (_consentButton) {
        _consentType = [...JSON.parse(_consentButton.getAttribute('data-wp-cookie-consent-grant'))];
      }
      if (_consentButton) {
        _consentButton.disabled = false;
        _consentButton.addEventListener('click', event => dispatchConsentGranted(_consentType));
      }
      return {
        requiresConsentType: type => _consentType.includes(type)
      };
    }
    function PlaceholderLoader({
      element,
      tag,
      dataAttr
    }) {
      const _placeholder = Placeholder(element.querySelector('.wp-cookie-consent-placeholder'));
      const _shouldLoad = consents => {
        return consents.reduce((current, {
          group,
          consented
        }) => {
          return _placeholder.requiresConsentType(group) ? consented : current;
        }, false);
      };
      const _load = () => {
        let attributes = JSON.parse(element.getAttribute(dataAttr));
        let createdElement = document.createElement(tag);
        for (let attribute in attributes) {
          createdElement.setAttribute(attribute, attributes[attribute]);
        }
        element.replaceWith(createdElement);
        return true;
      };
      return {
        load: consents => _shouldLoad(consents) && _load()
      };
    }
    function dispatchConsentGranted(type) {
      window.dispatchEvent(new CustomEvent(CONSENT_GRANTED, {
        detail: {
          group: type
        }
      }));
    }
    function initCookieConsent(config) {
      let {
        cookiesHandler
      } = config || {};
      let handlers = {
        complianz: createComplianzAdapter,
        none: noCookiesHandler
      };
      if (!handlers.hasOwnProperty(cookiesHandler)) {
        cookiesHandler = 'none';
      }
      createCookieConsent(config).then(cookieConsent => {
        const facade = CookieConsentFacade({
          ...config,
          cookieConsent
        });
        handlers[cookiesHandler](facade);
        createIframeLoaders(facade);
        createScriptLoaders(facade);
        window.addEventListener(CONSENT_GRANTED, event => facade.grant(event.detail.group));
      }).catch(error => console.error(error));
    }
    function createIframeLoaders(facade) {
      let iframes = document.querySelectorAll('[data-wp-cookie-consent-iframe]');
      setupLoaders(facade, Array.from(iframes).map(iframe => PlaceholderLoader({
        element: iframe,
        tag: 'iframe',
        dataAttr: 'data-wp-cookie-consent-iframe'
      })));
    }
    function createScriptLoaders(facade) {
      let scripts = document.querySelectorAll('[data-wp-cookie-consent-script]');
      setupLoaders(facade, Array.from(scripts).map(script => PlaceholderLoader({
        element: script,
        tag: 'script',
        dataAttr: 'data-wp-cookie-consent-script'
      })));
    }
    function setupLoaders(facade, loaders) {
      const maybeRunLoaders = () => {
        loaders = loaders.filter(loader => !loader.load(facade.consents()));
        if (!loaders.length) {
          window.removeEventListener(CONSENT_CHANGED, maybeRunLoaders);
        }
      };
      if (loaders.length) {
        window.addEventListener(CONSENT_CHANGED, maybeRunLoaders);
        maybeRunLoaders();
      }
    }
    function createComplianzAdapter(facade) {
      const allow = group => cmplz_set_consent(group, 'allow');
      const deny = group => cmplz_set_consent(group, 'deny');
      const denyAll = () => cmplz_deny_all();
      const handleComplianzCategoryEnabled = event => facade.grant(event.detail.category);
      const handleConsentChanges = () => {
        document.removeEventListener('cmplz_enable_category', handleComplianzCategoryEnabled);
        facade.consents().forEach(({
          consented,
          group
        }) => consented ? allow(group) : deny(group));
        document.addEventListener('cmplz_enable_category', handleComplianzCategoryEnabled);
      };
      handleConsentChanges();
      window.addEventListener(CONSENT_CHANGED, handleConsentChanges);
    }
    function noCookiesHandler() {
      console.error('no cookies handler');
    }
    function createCookieConsent({
      routes,
      options
    }) {
      return hds.CookieConsentCore.create((({
        language
      }) => {
        let params = new URLSearchParams();
        params.append('lang', language);
        return routes.settings + '?' + params.toString();
      })(options), options);
    }
  }
})(hds, HelfiCookieConsent);