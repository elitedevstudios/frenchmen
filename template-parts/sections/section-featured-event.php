<?php
/**
 * Featured Event Section
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

$ticket_url = get_theme_mod( 'fm_ticket_url', 'https://touchstonelink.com/frenchmen-parties/' );
?>
<section class="fm-featured" aria-label="<?php esc_attr_e( 'Featured Event', 'frenchmen' ); ?>">
	<div class="fm-featured__container">
		<div class="fm-featured__header fm-animate" data-animation="fade-up">
			<h2 class="fm-featured__title">Frenchmen BlockO</h2>
			<p class="fm-featured__subtitle">The ultimate carnival street party!</p>
		</div>

		<div class="fm-featured__content">
			<div class="fm-featured__card fm-animate" data-animation="fade-right">
				<div class="fm-featured__card-logo">
					<img src="<?php echo esc_url( fm_upload( '2025/08/Blocko.png' ) ); ?>" alt="BlockO" loading="lazy">
				</div>
				<p class="fm-featured__card-description">
					Drink-inclusive carnival street fete, igniting FM Soca Season with high-energy vibes and nonstop music. BlockO is where the road comes alive with pure Caribbean energy.
				</p>
				<div class="fm-featured__card-actions">
					<a href="<?php echo esc_url( $ticket_url ); ?>" class="fm-btn fm-btn--primary" target="_blank" rel="noopener">
						Get Tickets
					</a>
					<a href="https://www.facebook.com/media/set/?set=a.1129631432539318&type=3" class="fm-btn fm-btn--outline" target="_blank" rel="noopener">
						View Album
					</a>
				</div>
			</div>

			<div class="fm-featured__image fm-animate" data-animation="fade-left" data-delay="200">
				<img src="<?php echo esc_url( fm_upload( '2025/08/495147578_1129622175873577_161671484664751743_n.jpg' ) ); ?>" alt="Frenchmen BlockO" loading="lazy">
			</div>
		</div>
	</div>
</section>
