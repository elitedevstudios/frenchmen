<?php
/**
 * Map Section
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="fm-map" aria-label="<?php esc_attr_e( 'Map to Pearly Beach Ocho Rios', 'frenchmen' ); ?>">
	<div class="fm-map__container">
		<iframe 
			src="https://www.google.com/maps?q=Pearly+Beach,+Ocho+Rios,+Jamaica&output=embed"
			width="100%" 
			height="450" 
			style="border:0;" 
			allowfullscreen="" 
			loading="lazy" 
			referrerpolicy="no-referrer-when-downgrade"
			title="Map to Pearly Beach, Jamaica"
		></iframe>
	</div>
</section>
