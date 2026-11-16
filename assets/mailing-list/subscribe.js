/**
 * Mailing list popup.
 *
 * Hand-written (not built by Vite); see the note at the top of
 * inc/mailing-list.php. Config comes from wp_localize_script as `fmSubscribe`.
 */
(function () {
	'use strict';

	var cfg = window.fmSubscribe;
	var dialog = document.getElementById('fm-subscribe');
	if (!cfg || !dialog || typeof dialog.showModal !== 'function') return;

	var form = dialog.querySelector('form');
	var input = dialog.querySelector('#fm-subscribe-email');
	var submit = dialog.querySelector('.fm-subscribe__submit');
	var status = dialog.querySelector('.fm-subscribe__status');
	var STORE = 'fmSubscribe';
	var openedAt = 0;
	var lastFocus = null;
	var subscribed = false;
	var recaptchaPromise = null;

	// Storage can throw (private mode, blocked site data). Every access is
	// wrapped so the popup still works, it just may reappear next visit.
	function readStore() {
		try { return JSON.parse(localStorage.getItem(STORE)) || {}; } catch (e) { return {}; }
	}
	function writeStore(v) {
		try { localStorage.setItem(STORE, JSON.stringify(v)); } catch (e) { /* ignore */ }
	}

	function suppressed() {
		var s = readStore();
		return s.subscribed || (s.until && Date.now() < s.until);
	}

	// reCAPTCHA is loaded only when the popup first opens, so pages where
	// nobody opens it never pay for Google's script.
	function loadRecaptcha() {
		if (!cfg.siteKey) return Promise.resolve(null);
		if (recaptchaPromise) return recaptchaPromise;
		recaptchaPromise = new Promise(function (resolve, reject) {
			var s = document.createElement('script');
			s.src = 'https://www.google.com/recaptcha/api.js?render=' + encodeURIComponent(cfg.siteKey);
			s.async = true;
			s.onload = function () { window.grecaptcha.ready(function () { resolve(window.grecaptcha); }); };
			s.onerror = function () { recaptchaPromise = null; reject(new Error('recaptcha')); };
			document.head.appendChild(s);
		});
		return recaptchaPromise;
	}

	function open() {
		if (dialog.open) return;
		lastFocus = document.activeElement;
		dialog.showModal();
		openedAt = Date.now();
		loadRecaptcha().catch(function () { /* surfaced on submit */ });
		if (!subscribed) input.focus();
	}

	function close() {
		if (!dialog.open) return;
		dialog.close();
	}

	// Remember a dismissal so the popup does not nag on every page view.
	dialog.addEventListener('close', function () {
		if (!subscribed) {
			var days = parseInt(cfg.dismissDays, 10) || 0;
			if (days > 0) writeStore({ until: Date.now() + days * 864e5 });
		}
		if (lastFocus && typeof lastFocus.focus === 'function') lastFocus.focus();
	});

	dialog.querySelectorAll('[data-fm-subscribe-close]').forEach(function (b) {
		b.addEventListener('click', close);
	});

	// Backdrop click: the click lands on <dialog> itself, not on the panel.
	dialog.addEventListener('click', function (e) {
		if (e.target === dialog) close();
	});

	// Manual triggers (footer link, or any element with the attribute).
	document.querySelectorAll('[data-fm-subscribe-open]').forEach(function (el) {
		el.addEventListener('click', function (e) {
			e.preventDefault();
			open();
		});
	});

	function setStatus(msg, isError) {
		status.textContent = msg;
		status.classList.toggle('is-error', !!isError);
		input.setAttribute('aria-invalid', isError ? 'true' : 'false');
	}

	form.addEventListener('submit', function (e) {
		e.preventDefault();
		var email = input.value.trim();
		if (!email || !input.checkValidity()) {
			setStatus('Please enter a valid email address.', true);
			input.focus();
			return;
		}

		submit.disabled = true;
		setStatus('Sending…', false);

		loadRecaptcha()
			.then(function (g) {
				return g ? g.execute(cfg.siteKey, { action: 'fm_subscribe' }) : '';
			})
			.then(function (token) {
				var body = new FormData();
				body.append('action', 'fm_subscribe');
				body.append('email', email);
				body.append('token', token || '');
				body.append('fm_website', form.elements.fm_website.value);
				body.append('fm_elapsed', String(Date.now() - openedAt));
				body.append('source', window.location.pathname);
				return fetch(cfg.ajaxUrl, { method: 'POST', body: body, credentials: 'same-origin' });
			})
			.then(function (res) {
				return res.json().catch(function () { return { success: false }; });
			})
			.then(function (json) {
				if (json && json.success) {
					subscribed = true;
					writeStore({ subscribed: true });
					dialog.classList.add('is-done');
					setStatus(json.data.message, false);
					input.removeAttribute('aria-invalid');
					// Close button is the only focusable thing left; move focus
					// there so keyboard users are not stranded on a hidden field.
					dialog.querySelector('.fm-subscribe__close').focus();
				} else {
					var msg = json && json.data && json.data.message;
					setStatus(msg || 'Something went wrong. Please try again.', true);
				}
			})
			.catch(function () {
				setStatus('Could not connect. Please check your connection and try again.', true);
			})
			.then(function () {
				submit.disabled = false;
			});
	});

	// ── Auto open: after `delay` seconds or 50% scroll, whichever first ──
	if (!cfg.auto || suppressed()) return;

	var fired = false;
	function autoOpen() {
		if (fired) return;
		// Do not interrupt the mobile menu or another open dialog; retry soon.
		if (document.body.classList.contains('fm-menu-open') || document.querySelector('dialog[open]')) {
			setTimeout(autoOpen, 3000);
			return;
		}
		fired = true;
		window.removeEventListener('scroll', onScroll);
		open();
	}
	function onScroll() {
		var max = document.documentElement.scrollHeight - window.innerHeight;
		if (max > 0 && window.scrollY / max >= 0.5) autoOpen();
	}

	setTimeout(autoOpen, Math.max(0, parseInt(cfg.delay, 10) || 0) * 1000);
	window.addEventListener('scroll', onScroll, { passive: true });
})();
