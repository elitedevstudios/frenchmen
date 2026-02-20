<?php
/**
 * Parties Section
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

$parties = fm_get_party_events();
?>
<section class="fm-parties" id="events" aria-label="<?php esc_attr_e( 'Frenchmen Party Groups', 'frenchmen' ); ?>">
	<div class="fm-parties__container">
		<?php foreach ( $parties as $key => $category ) : ?>
			<div class="fm-parties__category fm-animate" data-animation="fade-up">
				<div class="fm-parties__header">
					<h3 class="fm-parties__title"><?php echo esc_html( $category['title'] ); ?></h3>
					<p class="fm-parties__description"><?php echo esc_html( $category['description'] ); ?></p>
				</div>

				<div class="fm-parties__logos">
					<?php if ( ! empty( $category['main_logo'] ) ) : ?>
						<div class="fm-parties__main-logo">
							<img src="<?php echo esc_url( $category['main_logo'] ); ?>" alt="<?php echo esc_attr( $category['title'] ); ?>" loading="lazy">
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $category['events'] ) ) : ?>
						<div class="fm-parties__event-logos">
							<?php foreach ( $category['events'] as $event ) : ?>
								<div class="fm-parties__event <?php echo ! empty( $event['upcoming'] ) ? 'fm-parties__event--upcoming' : ''; ?>">
									<?php if ( ! empty( $event['upcoming'] ) ) : ?>
										<span class="fm-parties__upcoming-badge">Upcoming</span>
									<?php endif; ?>
									<img src="<?php echo esc_url( $event['logo'] ); ?>" alt="<?php echo esc_attr( $event['name'] ); ?>" class="fm-parties__event-logo" loading="lazy">
								</div>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>
