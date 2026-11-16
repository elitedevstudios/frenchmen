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
 * Get party events data from fm_party CPT.
 *
 * Falls back to empty array if no parties have been created yet.
 *
 * @return array Flat list of party data for the parties section template.
 */
function fm_get_party_events() {
	$query = new WP_Query(
		array(
			'post_type'      => 'fm_party',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'meta_key'       => '_fm_party_order',
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
		)
	);

	if ( ! $query->have_posts() ) {
		return array();
	}

	$parties = array();
	foreach ( $query->posts as $post ) {
		$logo_id    = get_post_meta( $post->ID, '_fm_party_logo', true );
		$logo_url   = $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '';
		$upcoming   = get_post_meta( $post->ID, '_fm_party_upcoming', true );
		$badge_text = get_post_meta( $post->ID, '_fm_party_badge_text', true );

		$parties[] = array(
			'id'         => $post->ID,
			'name'       => get_the_title( $post ),
			'logo'       => $logo_url,
			'upcoming'   => (bool) $upcoming,
			'badge_text' => $badge_text ?: 'Upcoming',
		);
	}

	wp_reset_postdata();

	return $parties;
}

/**
 * Get party categories with their nested parties.
 *
 * Returns categories ordered by _fm_pcat_order. Each category contains
 * a 'parties' array of the same shape as fm_get_party_events() items.
 *
 * @return array Nested array of categories → parties.
 */
function fm_get_party_categories() {
	$cat_query = new WP_Query(
		array(
			'post_type'      => 'fm_party_category',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'meta_key'       => '_fm_pcat_order',
			'orderby'        => 'meta_value_num',
			'order'          => 'ASC',
		)
	);

	if ( ! $cat_query->have_posts() ) {
		wp_reset_postdata();
		return array();
	}

	$categories = array();

	foreach ( $cat_query->posts as $cat_post ) {
		$logo_id = get_post_meta( $cat_post->ID, '_fm_pcat_logo', true );

		$party_query = new WP_Query(
			array(
				'post_type'      => 'fm_party',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'meta_key'       => '_fm_party_order',
				'orderby'        => 'meta_value_num',
				'order'          => 'ASC',
				'meta_query'     => array(
					array(
						'key'   => '_fm_party_category_id',
						'value' => $cat_post->ID,
					),
				),
			)
		);

		$parties = array();
		if ( $party_query->have_posts() ) {
			foreach ( $party_query->posts as $party_post ) {
				$party_logo_id = get_post_meta( $party_post->ID, '_fm_party_logo', true );
				$upcoming      = get_post_meta( $party_post->ID, '_fm_party_upcoming', true );
				$badge_text    = get_post_meta( $party_post->ID, '_fm_party_badge_text', true );

				$parties[] = array(
					'id'         => $party_post->ID,
					'name'       => get_the_title( $party_post ),
					'logo'       => $party_logo_id ? wp_get_attachment_image_url( $party_logo_id, 'full' ) : '',
					'upcoming'   => (bool) $upcoming,
					'badge_text' => $badge_text ?: 'Upcoming',
				);
			}
		}
		wp_reset_postdata();

		$categories[] = array(
			'id'          => $cat_post->ID,
			'name'        => get_the_title( $cat_post ),
			'description' => get_post_meta( $cat_post->ID, '_fm_pcat_description', true ),
			'logo'        => $logo_id ? wp_get_attachment_image_url( $logo_id, 'full' ) : '',
			'parties'     => $parties,
		);
	}

	wp_reset_postdata();

	return $categories;
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
