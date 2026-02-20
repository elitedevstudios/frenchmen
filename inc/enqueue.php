<?php
/**
 * Enqueue Scripts and Styles
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enqueue theme styles and scripts.
 */
function fm_enqueue_assets() {
	// Main stylesheet
	wp_enqueue_style(
		'fm-style',
		FM_THEME_URI . '/assets/css/style.css',
		array(),
		FM_THEME_VERSION
	);

	// FontAwesome CDN (free version)
	wp_enqueue_style(
		'fontawesome',
		'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
		array(),
		'6.5.1'
	);

	// Main JavaScript
	wp_enqueue_script(
		'fm-main',
		FM_THEME_URI . '/assets/js/main.js',
		array(),
		FM_THEME_VERSION,
		array(
			'strategy' => 'defer',
			'in_footer' => true,
		)
	);

	// Pass data to JavaScript
	wp_localize_script(
		'fm-main',
		'fmData',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'fm_nonce' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'fm_enqueue_assets' );

/**
 * Add preconnect for external resources.
 */
function fm_resource_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://kit.fontawesome.com',
			'crossorigin',
		);
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
			'crossorigin',
		);
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'fm_resource_hints', 10, 2 );

/**
 * Add Google Fonts.
 */
function fm_enqueue_fonts() {
	wp_enqueue_style(
		'fm-google-fonts',
		'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600&display=swap',
		array(),
		null
	);
}
add_action( 'wp_enqueue_scripts', 'fm_enqueue_fonts' );
