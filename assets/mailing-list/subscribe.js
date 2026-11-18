/**
 * Mailing list popup.
 *
 * Hand-written (not built by Vite); see the note at the top of
 * inc/mailing-list.php. Config comes from wp_localize_script as `fmSubscribe`.
 *
 * Two modes, chosen server-side:
 *   - Constant Contact (cfg.ctctAccount set): CC's widget renders its inline
 *     form into .ctct-inline-form and submits straight to CC.
 *   - Built-in (fallback): our single-email form posts to admin-ajax.
 */
(function () {
	'use strict';

	var cfg = window.fmSubscribe;
	var dialog = document.getElementById('fm-subscribe');
	if (!cfg || !dialog || typeof dialog.show !== 'function') return;

	var backdrop = document.querySelector('.fm-subscribe-backdrop');
	var form = dialog.querySelector('form.fm-subscribe__form');
	var status = dialog.querySelector('.fm-subscribe__status');
	var ctctMode = !!cfg.ctctAccount;
	var STORE = 'fmSubscribe';
	var openedAt = 0;
	var lastFocus = null;
	var subscribed = false;
	var recaptchaPromise = null;
	var ctctLoaded = false;

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
	function markSubscribed() {
		if (subscribed) return;
		subscribed = true;
		writeStore({ subscribed: true });
		dialog.classList.add('is-done');
	}

	function setStatus(msg, isError) {
		if (!status) return;
		status.textContent = msg;
		status.classList.toggle('is-error', !!isError);
	}

	// ── Focus helpers (we open non-modal, so we trap focus ourselves) ──
	function focusables() {
		return Array.prototype.filter.call(
			dialog.querySelectorAll('a[href], button:not([disabled]), input:not([disabled]):not([tabindex="-1"]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'),
			function (el) { return el.offsetParent !== null || el === document.activeElement; }
		);
	}
	function focusFirstField() {
		var field = dialog.querySelector('.ctct-form-element, .fm-subscribe__input');
		(field || dialog.querySelector('.fm-subscribe__close')).focus();
	}

	function onKeydown(e) {
		if (!dialog.open) return;
		if (e.key === 'Escape') {
			e.preventDefault();
			close();
			return;
		}
		if (e.key !== 'Tab') return;
		var items = focusables();
		if (!items.length) return;
		var first = items[0];
		var last = items[items.length - 1];
		if (!dialog.contains(document.activeElement)) {
			e.preventDefault();
			first.focus();
		} else if (e.shiftKey && document.activeElement === first) {
			e.preventDefault();
			last.focus();
		} else if (!e.shiftKey && document.activeElement === last) {
			e.preventDefault();
			first.focus();
		}
	}

	// ── Constant Contact ──
	// Script is injected on first open only, so most page views never load
	// CC's widget or the Google reCAPTCHA it pulls in.
	function loadCtct() {
		if (ctctLoaded) return;
		ctctLoaded = true;
		window._ctct_m = cfg.ctctAccount;
		var s = document.createElement('script');
		s.id = 'signupScript';
		s.src = cfg.ctctScript;
		s.async = true;
		s.onerror = function () {
			ctctLoaded = false;
			setStatus('The sign-up form could not load. Please try again later.', true);
		};
		document.body.appendChild(s);

		var slot = dialog.querySelector('.ctct-inline-form');
		var watch = new MutationObserver(function () {
			var success = slot.querySelector('.ctct-form-success');
			if (success && success.style.display !== 'none') {
				markSubscribed();
				success.setAttribute('tabindex', '-1');
				success.focus();
			}
			if (slot.querySelector('form.ctct-form-custom') && !slot.dataset.ready) {
				slot.dataset.ready = '1';
				setStatus('', false);
				if (dialog.open && dialog.contains(document.activeElement) === false) focusFirstField();
				if (dialog.open && document.activeElement === dialog.querySelector('.fm-subscribe__close')) focusFirstField();
			}
		});
		watch.observe(slot, { childList: true, subtree: true, attributes: true, attributeFilter: ['style'] });

		// Ad/tracker blockers sometimes block ctctcdn.com. Say so instead of
		// showing an empty box.
		setTimeout(function () {
			if (!slot.querySelector('form.ctct-form-custom')) {
				setStatus('The sign-up form could not load. Please try again later.', true);
			}
		}, 10000);
	}

	// ── Built-in form: reCAPTCHA v3, loaded on first open ──
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

	// ── Open / close ──
	function open() {
		if (dialog.open) return;
		lastFocus = document.activeElement;
		dialog.show();
		if (backdrop) backdrop.hidden = false;
		document.documentElement.classList.add('fm-subscribe-open');
		document.addEventListener('keydown', onKeydown);
		openedAt = Date.now();
		if (ctctMode) {
			loadCtct();
		} else {
			loadRecaptcha().catch(function () { /* surfaced on submit */ });
		}
		focusFirstField();
	}

	function close() {
		if (!dialog.open) return;
		dialog.close();
	}

	dialog.addEventListener('close', function () {
		if (backdrop) backdrop.hidden = true;
		document.documentElement.classList.remove('fm-subscribe-open');
		document.removeEventListener('keydown', onKeydown);
		// Remember a dismissal so the popup does not nag on every page view.
		if (!subscribed) {
			var days = parseInt(cfg.dismissDays, 10) || 0;
			if (days > 0) writeStore({ until: Date.now() + days * 864e5 });
		}
		// Auto-open has no trigger to return to (lastFocus is <body>, which
		// can't take focus), so focus would stay on a hidden element inside the
		// closed dialog. Blur it so keyboard users restart from the page.
		if (lastFocus && lastFocus !== document.body && typeof lastFocus.focus === 'function') {
			lastFocus.focus();
		} else if (dialog.contains(document.activeElement)) {
			document.activeElement.blur();
		}
	});

	document.querySelectorAll('[data-fm-subscribe-close]').forEach(function (b) {
		b.addEventListener('click', close);
	});

	document.querySelectorAll('[data-fm-subscribe-open]').forEach(function (el) {
		el.addEventListener('click', function (e) {
			e.preventDefault();
			open();
		});
	});

	// ── Built-in form submit ──
	if (form) {
		var input = form.querySelector('#fm-subscribe-email');
		var submit = form.querySelector('.fm-subscribe__submit');

		form.addEventListener('submit', function (e) {
			e.preventDefault();
			var email = input.value.trim();
			if (!email || !input.checkValidity()) {
				setStatus('Please enter a valid email address.', true);
				input.setAttribute('aria-invalid', 'true');
				input.focus();
				return;
			}
			input.setAttribute('aria-invalid', 'false');
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
						markSubscribed();
						setStatus(json.data.message, false);
						input.removeAttribute('aria-invalid');
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
	}

	// ── Auto open: after `delay` seconds or 50% scroll, whichever first ──
	if (!parseInt(cfg.auto, 10) || suppressed()) return;

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
