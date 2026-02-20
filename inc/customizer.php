<?php
/**
 * Theme Customizer
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add postMessage support for site title and description.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function fm_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	// Hero Section
	$wp_customize->add_section(
		'fm_hero_section',
		array(
			'title'    => __( 'Hero Section', 'frenchmen' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'fm_hero_video',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'fm_hero_video',
		array(
			'label'       => __( 'Hero Video URL', 'frenchmen' ),
			'description' => __( 'Enter the URL of the hero background video.', 'frenchmen' ),
			'section'     => 'fm_hero_section',
			'type'        => 'url',
		)
	);

	$wp_customize->add_setting(
		'fm_hero_title',
		array(
			'default'           => 'BlockO',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'fm_hero_title',
		array(
			'label'   => __( 'Hero Title', 'frenchmen' ),
			'section' => 'fm_hero_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'fm_hero_subtitle',
		array(
			'default'           => 'Frenchmen Soca Season',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'fm_hero_subtitle',
		array(
			'label'   => __( 'Hero Subtitle', 'frenchmen' ),
			'section' => 'fm_hero_section',
			'type'    => 'text',
		)
	);

	// Ticket Links
	$wp_customize->add_section(
		'fm_tickets_section',
		array(
			'title'    => __( 'Ticket Links', 'frenchmen' ),
			'priority' => 35,
		)
	);

	$wp_customize->add_setting(
		'fm_ticket_url',
		array(
			'default'           => 'https://touchstonelink.com/frenchmen-parties/',
			'sanitize_callback' => 'esc_url_raw',
		)
	);

	$wp_customize->add_control(
		'fm_ticket_url',
		array(
			'label'   => __( 'Main Ticket URL', 'frenchmen' ),
			'section' => 'fm_tickets_section',
			'type'    => 'url',
		)
	);

	// Contact Section
	$wp_customize->add_section(
		'fm_contact_section',
		array(
			'title'    => __( 'Contact Info', 'frenchmen' ),
			'priority' => 40,
		)
	);

	$wp_customize->add_setting(
		'fm_contact_email',
		array(
			'default'           => 'concierge@frenchmenparty.com',
			'sanitize_callback' => 'sanitize_email',
		)
	);

	$wp_customize->add_control(
		'fm_contact_email',
		array(
			'label'   => __( 'Contact Email', 'frenchmen' ),
			'section' => 'fm_contact_section',
			'type'    => 'email',
		)
	);
}
add_action( 'customize_register', 'fm_customize_register' );
