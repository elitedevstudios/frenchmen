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
					We are the Caribbean's ultimate all-inclusive party experience—pure vibes and nonstop energy, all year long. We kick things off with <strong>Climax</strong>, our legendary New Year's Day celebration—an ultra-premium way to launch the year in style. Then the heat builds with our carnival celebration <strong>Frenchmen Soca Season</strong>: weekly Lymes to keep the vibes flowing, the sunrise breakfast-inclusive cooler fete Rise Up on the beach, and the high-energy BlockO street party. And when October comes, it's time for <strong>Frenchmen Weekend</strong>—the ultimate all-inclusive party weekend. From Rise Up at sunrise, to the late-night turn-up at NiteCap, all leading to the epic finale at Foreplay. From first light on the beach to fireworks in the sky, Frenchmen is where the party never stops—and neither will you.
				</p>
			</div>
			<div class="fm-about__images fm-animate" data-animation="fade-left" data-delay="200">
				<div class="fm-about__image-grid">
					<img src="<?php echo esc_url( fm_upload( '2025/09/Frenchmen-Image-2025-09-17-at-11.08.23.jpeg' ) ); ?>" alt="Frenchmen Party" class="fm-about__image fm-about__image--1" loading="lazy">
					<img src="<?php echo esc_url( fm_upload( '2025/09/Frenchmen-Image-2025-09-17-at-11.08.24-1.jpeg' ) ); ?>" alt="Frenchmen Party" class="fm-about__image fm-about__image--2" loading="lazy">
					<img src="<?php echo esc_url( fm_upload( '2025/09/Frenchmen-Image-2025-09-17-at-11.08.25.jpeg' ) ); ?>" alt="Frenchmen Party" class="fm-about__image fm-about__image--3" loading="lazy">
					<img src="<?php echo esc_url( fm_upload( '2025/09/Frenchmen-Image-2025-09-17-at-11.08.26-5.jpeg' ) ); ?>" alt="Frenchmen Party" class="fm-about__image fm-about__image--4" loading="lazy">
				</div>
			</div>
		</div>
	</div>
</section>
