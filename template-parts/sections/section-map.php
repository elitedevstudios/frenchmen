<?php
/**
 * Map Section
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

$map_location = get_theme_mod( 'fm_map_location', 'Pearly Beach, Ocho Rios, Jamaica' );
$map_query    = urlencode( $map_location );
?>
<section class="fm-map" aria-label="<?php echo esc_attr( sprintf( __( 'Map to %s', 'frenchmen' ), $map_location ) ); ?>">
	<div class="fm-map__container">
		<iframe 
			src="https://www.google.com/maps?q=<?php echo esc_attr( $map_query ); ?>&output=embed"
			width="100%" 
			height="450" 
			style="border:0;" 
			allowfullscreen="" 
			loading="lazy" 
			referrerpolicy="no-referrer-when-downgrade"
			title="<?php echo esc_attr( sprintf( __( 'Map to %s', 'frenchmen' ), $map_location ) ); ?>"
		></iframe>
	</div>
</section>
