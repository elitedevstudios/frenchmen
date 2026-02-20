<?php
/**
 * Theme Setup
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function fm_theme_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Register navigation menus.
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'frenchmen' ),
			'footer'  => esc_html__( 'Footer Menu', 'frenchmen' ),
		)
	);

	// Switch default core markup to output valid HTML5.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add support for custom logo.
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 100,
			'width'       => 300,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Add support for wide alignment.
	add_theme_support( 'align-wide' );
}
add_action( 'after_setup_theme', 'fm_theme_setup' );

/**
 * Set the content width in pixels.
 */
function fm_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'fm_content_width', 1200 );
}
add_action( 'after_setup_theme', 'fm_content_width', 0 );
