(function(){
  const cookieConsent = document.querySelector('.hel-cookie-consent');
  if (cookieConsent) {
    initCookieToggle(cookieConsent.querySelector('.cookies-panel-toggle'));
    initCookieListToggles(cookieConsent.querySelectorAll('.cookie-list-toggle'));
  }

  function initCookieToggle(toggle) {
    if (toggle) {
      initToggle({
        toggle,
        onOpen: () => cookieConsent.classList.add('cookies-panel-visible'),
        onClose: () => cookieConsent.classList.add('cookies-panel-visible'),
      });
    }
  }

  function initCookieListToggles(toggles) {
    toggles.forEach(toggle => initToggle({toggle}));
  }

  function initToggle({toggle, onOpen, onClose}) {
    toggle.addEventListener('click', function(event) {
      event.preventDefault();

      if ('false' === toggle.getAttribute('aria-expanded')) {
        toggle.setAttribute('aria-expanded', 'true');
        onOpen && onOpen();
      } else {
        toggle.setAttribute('aria-expanded', 'false');
        onClose && onClose();
      }
    });
  }
})();
