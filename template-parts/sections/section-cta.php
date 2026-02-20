<?php
/**
 * CTA Section
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

$ticket_url = get_theme_mod( 'fm_ticket_url', 'https://touchstonelink.com/frenchmen-parties/' );
?>
<section class="fm-cta" aria-label="<?php esc_attr_e( 'Call to Action', 'frenchmen' ); ?>">
	<div class="fm-cta__background" style="background-image: url('<?php echo esc_url( fm_upload( '2025/10/climax-1.jpg' ) ); ?>');">
		<div class="fm-cta__overlay"></div>
	</div>

	<div class="fm-cta__container">
		<h2 class="fm-cta__title fm-animate" data-animation="zoom-in">
			Super Early Birds<br>Available
		</h2>
		<a href="<?php echo esc_url( $ticket_url ); ?>" class="fm-btn fm-btn--primary fm-btn--lg fm-btn--pulse fm-animate" data-animation="fade-up" data-delay="200" target="_blank" rel="noopener">
			Get Tickets
		</a>
	</div>
</section>
