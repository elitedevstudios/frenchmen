<?php
/**
 * About Section
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="fm-about" id="about" aria-label="<?php esc_attr_e( 'About Frenchmen', 'frenchmen' ); ?>">
	<div class="fm-about__container">
		<div class="fm-about__content">
			<div class="fm-about__text">
				<h2 class="fm-about__title fm-animate" data-animation="fade-up">
					About<br>Frenchmen
				</h2>
				<p class="fm-about__description fm-animate" data-animation="fade-up" data-delay="100">
					We are the Caribbean's ultimate all-inclusive party experience: pure vibes and nonstop energy, all year long. We kick things off with <strong>Climax</strong>, our legendary New Year's Day celebration and an ultra-premium way to launch the year in style. Then the heat builds with our carnival celebration <strong>Frenchmen Soca Season</strong>: weekly Lymes to keep the vibes flowing, the sunrise breakfast-inclusive cooler fete Rise Up on the beach, and the high-energy BlockO street party. And when October comes, it's time for <strong>Frenchmen Weekend</strong>, the ultimate all-inclusive party weekend. From Rise Up at sunrise, to the late-night turn-up at NiteCap, all leading to the epic finale at Foreplay. From first light on the beach to fireworks in the sky, Frenchmen is where the party never stops, and neither will you.
				</p>
			</div>
			<div class="fm-about__images fm-animate" data-animation="fade-left" data-delay="200">
				<?php
				/*
				 * Client request 2026-11-16: About grid shows Climax photos (was generic
				 * 2025 party shots). Sources are the climax-*.jpg already in the media
				 * library; we point at WP's scaled copies, not the 2 MB originals.
				 * Slots 1 and 3 render ~260px square, so 1024w is ample at 2x.
				 * Slot 2 spans two rows (~535px tall), so it gets the 1536w copy, and
				 * the fireworks shot goes there because its subject survives a tall
				 * centre crop of a landscape frame. Slot 4 is display:none in about.css.
				 */
				?>
				<div class="fm-about__image-grid">
					<img src="<?php echo esc_url( fm_upload( '2025/10/climax-3-1024x683.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Guests posing at Frenchmen Climax', 'frenchmen' ); ?>" class="fm-about__image fm-about__image--1" loading="lazy">
					<img src="<?php echo esc_url( fm_upload( '2025/10/climax-4-1536x1024.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Fireworks over the crowd at Frenchmen Climax', 'frenchmen' ); ?>" class="fm-about__image fm-about__image--2" loading="lazy">
					<img src="<?php echo esc_url( fm_upload( '2025/09/climax-1024x745.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Friends in front of the Frenchmen screen at Climax', 'frenchmen' ); ?>" class="fm-about__image fm-about__image--3" loading="lazy">
					<img src="<?php echo esc_url( fm_upload( '2025/10/climax-1-1024x683.jpg' ) ); ?>" alt="<?php esc_attr_e( 'Guests dressed up at Frenchmen Climax', 'frenchmen' ); ?>" class="fm-about__image fm-about__image--4" loading="lazy">
				</div>
			</div>
		</div>
	</div>
</section>
