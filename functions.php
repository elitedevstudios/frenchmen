<?php
/**
 * Frenchmen Theme Functions
 *
 * @package Frenchmen
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Theme constants
 */
define( 'FM_THEME_VERSION', '1.0.0' );
define( 'FM_THEME_DIR', get_template_directory() );
define( 'FM_THEME_URI', get_template_directory_uri() );

/**
 * Include theme files
 */
require_once FM_THEME_DIR . '/inc/theme-setup.php';
require_once FM_THEME_DIR . '/inc/enqueue.php';
require_once FM_THEME_DIR . '/inc/template-functions.php';
require_once FM_THEME_DIR . '/inc/customizer.php';
