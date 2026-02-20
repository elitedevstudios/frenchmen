<?php
/**
 * Template Functions
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get theme asset URL.
 *
 * @param string $path Asset path relative to theme.
 * @return string Full URL to asset.
 */
function fm_asset( $path ) {
	return FM_THEME_URI . '/' . ltrim( $path, '/' );
}

/**
 * Get upload URL (relative for migration compatibility).
 *
 * @param string $path Path relative to uploads directory.
 * @return string Relative URL to upload.
 */
function fm_upload( $path ) {
	return '/wp-content/uploads/' . ltrim( $path, '/' );
}

/**
 * Output SVG icon.
 *
 * @param string $name Icon name.
 * @param string $class Additional CSS classes.
 */
function fm_icon( $name, $class = '' ) {
	$class = $class ? 'fm-icon ' . $class : 'fm-icon';
	printf( '<i class="fa-brands fa-%s %s" aria-hidden="true"></i>', esc_attr( $name ), esc_attr( $class ) );
}

/**
 * Get social links.
 *
 * @return array Social media links.
 */
function fm_get_social_links() {
	return array(
		'instagram' => array(
			'url'   => 'https://www.instagram.com/frenchmenparty/',
			'icon'  => 'instagram',
			'label' => 'Instagram',
		),
		'facebook'  => array(
			'url'   => 'https://www.facebook.com/frenchmenparty/',
			'icon'  => 'facebook-f',
			'label' => 'Facebook',
		),
	);
}

/**
 * Get party events data.
 *
 * @return array Party events organized by category.
 */
function fm_get_party_events() {
	return array(
		'new_years'   => array(
			'title'       => "Frenchmen New Year's",
			'description' => 'Ring in the new year the Frenchmen way.',
			'main_logo'   => fm_upload( '2025/09/climax.png' ),
			'events'      => array(
				array(
					'name' => 'Climax',
					'logo' => fm_upload( '2025/09/climax.png' ),
				),
			),
		),
		'soca_season' => array(
			'title'       => 'Frenchmen Soca Season',
			'description' => 'Carnival energy all season.',
			'main_logo'   => fm_upload( '2025/08/soca-season-logo.png' ),
			'events'      => array(
				array(
					'name'     => 'BlockO',
					'logo'     => fm_upload( '2025/08/Blocko.png' ),
					'upcoming' => true,
				),
				array(
					'name' => 'Rise Up',
					'logo' => fm_upload( '2025/08/Rise-Up.png' ),
				),
				array(
					'name' => 'Lyme',
					'logo' => fm_upload( '2025/09/fm-lyme-logo.png' ),
				),
			),
		),
		'weekend'     => array(
			'title'       => 'Frenchmen Weekend',
			'description' => 'One weekend. Three events. Nonstop energy.',
			'main_logo'   => fm_upload( '2025/08/frenchmen-weekend.png' ),
			'events'      => array(
				array(
					'name' => 'Rise Up',
					'logo' => fm_upload( '2025/08/Rise-Up.png' ),
				),
				array(
					'name' => 'Nitecap',
					'logo' => fm_upload( '2025/08/nitecap.png' ),
				),
				array(
					'name' => 'Foreplay',
					'logo' => fm_upload( '2025/08/foreplay.png' ),
				),
			),
		),
	);
}

/**
 * Get gallery albums data.
 *
 * @return array Gallery albums.
 */
function fm_get_gallery_albums() {
	return array(
		array(
			'title'       => 'Rise Up',
			'description' => 'Sunrise, coolers, feet in the sand. Start the weekend right.',
			'image'       => fm_upload( '2025/08/riseup.jpg' ),
			'logo'        => fm_upload( '2025/08/Rise-Up.png' ),
			'album_url'   => 'https://www.facebook.com/media/set/?set=a.976870767815386&type=3',
		),
		array(
			'title'       => 'Nitecap',
			'description' => 'Sleek late-night moods with premium all-inclusive energy.',
			'image'       => fm_upload( '2025/08/nightcap.jpg' ),
			'logo'        => fm_upload( '2025/08/nitecap.png' ),
			'album_url'   => 'https://www.facebook.com/media/set/?set=a.976993921136404&type=3',
		),
		array(
			'title'       => 'Foreplay',
			'description' => 'The weekend finale. Golden glow, fireworks, and non-stop vibes.',
			'image'       => fm_upload( '2025/09/foreplay.jpeg' ),
			'logo'        => fm_upload( '2025/08/foreplay.png' ),
			'album_url'   => 'https://www.facebook.com/media/set/?set=a.977019401133856&type=3',
		),
		array(
			'title'       => 'BlockO',
			'description' => 'Drink-inclusive carnival street fete, igniting FM Soca Season with high-energy vibes.',
			'image'       => fm_upload( '2025/08/495147578_1129622175873577_161671484664751743_n.jpg' ),
			'logo'        => fm_upload( '2025/08/Blocko.png' ),
			'album_url'   => 'https://www.facebook.com/media/set/?set=a.1129631432539318&type=3',
		),
		array(
			'title'       => 'Lyme',
			'description' => 'Fetes to kick off FM Soca Season with good vibes, food, and drinks.',
			'image'       => fm_upload( '2025/09/lyme.jpg' ),
			'logo'        => fm_upload( '2025/09/fm-lyme-logo.png' ),
			'album_url'   => 'https://www.facebook.com/media/set/?set=a.1123271839841944&type=3',
		),
		array(
			'title'       => 'Climax',
			'description' => 'The only place to be on January 1st is Frenchmen Climax.',
			'image'       => fm_upload( '2025/10/climax-1.jpg' ),
			'logo'        => fm_upload( '2025/09/climax.png' ),
			'album_url'   => 'https://www.facebook.com/media/set/?set=a.1030153635820432&type=3',
		),
	);
}

/**
 * Get stats data.
 *
 * @return array Stats for counter animation.
 */
function fm_get_stats() {
	return array(
		array(
			'number' => 25,
			'suffix' => '+',
			'label'  => 'Years of Parties',
		),
		array(
			'number' => 6,
			'suffix' => '',
			'label'  => 'Signature Events',
		),
		array(
			'number' => 1,
			'suffix' => '',
			'label'  => 'Unmistakable Vibe',
		),
	);
}
