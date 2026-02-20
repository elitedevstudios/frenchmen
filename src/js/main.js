/**
 * Frenchmen Theme JavaScript
 *
 * @package Frenchmen
 */

'use strict';

import '../css/main.css';

/**
 * DOM Ready
 */
document.addEventListener('DOMContentLoaded', () => {
	initHeader();
	initMobileMenu();
	initScrollAnimations();
	initCounters();
	initAudioToggle();
	initSmoothScroll();
});

/**
 * Header scroll effects
 */
function initHeader() {
	const header = document.querySelector('.fm-header');
	if (!header) return;

	const scrollThreshold = 50;

	const handleScroll = () => {
		if (window.scrollY > scrollThreshold) {
			header.classList.add('fm-header--scrolled');
		} else {
			header.classList.remove('fm-header--scrolled');
		}
	};

	window.addEventListener('scroll', handleScroll, { passive: true });
	handleScroll();
}

/**
 * Mobile menu toggle
 */
function initMobileMenu() {
	const toggle = document.getElementById('menu-toggle');
	const close = document.getElementById('menu-close');
	const menu = document.getElementById('mobile-menu');

	if (!toggle || !menu) return;

	const openMenu = () => {
		menu.classList.add('fm-mobile-nav--open');
		toggle.setAttribute('aria-expanded', 'true');
		document.body.classList.add('fm-menu-open');
	};

	const closeMenu = () => {
		menu.classList.remove('fm-mobile-nav--open');
		toggle.setAttribute('aria-expanded', 'false');
		document.body.classList.remove('fm-menu-open');
	};

	toggle.addEventListener('click', openMenu);
	
	if (close) {
		close.addEventListener('click', closeMenu);
	}

	// Close on link click
	menu.querySelectorAll('a').forEach(link => {
		link.addEventListener('click', closeMenu);
	});

	// Close on escape key
	document.addEventListener('keydown', (e) => {
		if (e.key === 'Escape' && menu.classList.contains('fm-mobile-nav--open')) {
			closeMenu();
		}
	});
}

/**
 * Scroll-triggered animations using Intersection Observer
 */
function initScrollAnimations() {
	const animatedElements = document.querySelectorAll('.fm-animate');

	if (!animatedElements.length) return;

	const observerOptions = {
		root: null,
		rootMargin: '0px 0px -50px 0px',
		threshold: 0.1
	};

	const observer = new IntersectionObserver((entries) => {
		entries.forEach(entry => {
			if (entry.isIntersecting) {
				entry.target.classList.add('fm-animated');
				observer.unobserve(entry.target);
			}
		});
	}, observerOptions);

	animatedElements.forEach(el => observer.observe(el));
}

/**
 * Animated number counters
 */
function initCounters() {
	const counters = document.querySelectorAll('.fm-stats__number[data-count]');

	if (!counters.length) return;

	const animateCounter = (counter) => {
		const target = parseInt(counter.dataset.count, 10);
		const suffix = counter.dataset.suffix || '';
		const duration = 2000;
		const startTime = performance.now();

		const easeOutQuart = (t) => 1 - Math.pow(1 - t, 4);

		const updateCounter = (currentTime) => {
			const elapsed = currentTime - startTime;
			const progress = Math.min(elapsed / duration, 1);
			const easedProgress = easeOutQuart(progress);
			const currentValue = Math.floor(easedProgress * target);

			counter.textContent = currentValue + suffix;

			if (progress < 1) {
				requestAnimationFrame(updateCounter);
			} else {
				counter.textContent = target + suffix;
			}
		};

		requestAnimationFrame(updateCounter);
	};

	const observerOptions = {
		root: null,
		rootMargin: '0px',
		threshold: 0.5
	};

	const observer = new IntersectionObserver((entries) => {
		entries.forEach(entry => {
			if (entry.isIntersecting) {
				animateCounter(entry.target);
				observer.unobserve(entry.target);
			}
		});
	}, observerOptions);

	counters.forEach(counter => observer.observe(counter));
}

/**
 * Hero video audio toggle
 */
function initAudioToggle() {
	const toggle = document.getElementById('audio-toggle');
	const video = document.getElementById('hero-video');

	if (!toggle || !video) return;

	toggle.addEventListener('click', () => {
		if (video.muted) {
			video.muted = false;
			toggle.classList.add('fm-audio-on');
		} else {
			video.muted = true;
			toggle.classList.remove('fm-audio-on');
		}
	});
}

/**
 * Smooth scroll for anchor links
 */
function initSmoothScroll() {
	document.querySelectorAll('a[href^="#"]').forEach(anchor => {
		anchor.addEventListener('click', function(e) {
			const targetId = this.getAttribute('href');
			
			if (targetId === '#') return;

			const target = document.querySelector(targetId);
			
			if (target) {
				e.preventDefault();
				
				const headerHeight = document.querySelector('.fm-header')?.offsetHeight || 0;
				const targetPosition = target.getBoundingClientRect().top + window.scrollY - headerHeight;

				window.scrollTo({
					top: targetPosition,
					behavior: 'smooth'
				});
			}
		});
	});
}
