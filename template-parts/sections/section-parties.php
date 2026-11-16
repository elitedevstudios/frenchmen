<?php
/**
 * Parties Section
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

$categories = fm_get_party_categories();

if ( empty( $categories ) ) {
	return;
}
?>
<section class="fm-parties" id="events" aria-label="<?php esc_attr_e( 'Frenchmen Party Groups', 'frenchmen' ); ?>">
	<div class="fm-parties__container">
		<?php foreach ( $categories as $category ) : ?>
			<div class="fm-parties__category fm-animate" data-animation="fade-up">

				<?php if ( $category['logo'] ) : ?>
					<div class="fm-parties__cat-logo">
						<img src="<?php echo esc_url( $category['logo'] ); ?>" alt="<?php echo esc_attr( $category['name'] ); ?>" loading="lazy">
					</div>
					<?php if ( $category['description'] ) : ?>
						<p class="fm-parties__cat-tagline"><?php echo esc_html( $category['description'] ); ?></p>
					<?php endif; ?>
				<?php else : ?>
					<div class="fm-parties__cat-header">
						<h2 class="fm-parties__cat-title"><?php echo esc_html( $category['name'] ); ?></h2>
						<?php if ( $category['description'] ) : ?>
							<p class="fm-parties__cat-description"><?php echo esc_html( $category['description'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $category['parties'] ) ) : ?>
					<div class="fm-parties__event-logos">
						<?php foreach ( $category['parties'] as $party ) : ?>
							<div class="fm-parties__event <?php echo $party['upcoming'] ? 'fm-parties__event--upcoming' : ''; ?>">
								<?php if ( $party['upcoming'] ) : ?>
									<span class="fm-parties__upcoming-badge"><?php echo esc_html( $party['badge_text'] ); ?></span>
								<?php endif; ?>
								<?php if ( $party['logo'] ) : ?>
									<img src="<?php echo esc_url( $party['logo'] ); ?>" alt="<?php echo esc_attr( $party['name'] ); ?>" class="fm-parties__event-logo" loading="lazy">
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

			</div>
		<?php endforeach; ?>
	</div>
</section>
