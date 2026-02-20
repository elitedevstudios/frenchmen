<?php
/**
 * Front Page Template
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

get_header();

// Load all home page sections
get_template_part( 'template-parts/sections/section', 'hero' );
get_template_part( 'template-parts/sections/section', 'about' );
get_template_part( 'template-parts/sections/section', 'stats' );
get_template_part( 'template-parts/sections/section', 'parties' );
get_template_part( 'template-parts/sections/section', 'featured-event' );
get_template_part( 'template-parts/sections/section', 'radio' );
get_template_part( 'template-parts/sections/section', 'map' );
get_template_part( 'template-parts/sections/section', 'gallery' );
get_template_part( 'template-parts/sections/section', 'cta' );
get_template_part( 'template-parts/sections/section', 'contact' );

get_footer();
