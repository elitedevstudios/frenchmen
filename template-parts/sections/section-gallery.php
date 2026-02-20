<?php
/**
 * Gallery Section
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

$albums = fm_get_gallery_albums();
?>
<section class="fm-gallery" id="gallery" aria-label="<?php esc_attr_e( 'Frenchmen Photo Albums', 'frenchmen' ); ?>">
	<div class="fm-gallery__container">
		<div class="fm-gallery__header fm-animate" data-animation="fade-up">
			<h2 class="fm-gallery__title">Check the Vibes</h2>
			<p class="fm-gallery__subtitle">Relive the energy. Choose your vibe. Dive into the albums.</p>
		</div>

		<div class="fm-gallery__grid">
			<?php foreach ( $albums as $index => $album ) : ?>
				<article class="fm-gallery__card fm-animate" data-animation="fade-up" data-delay="<?php echo esc_attr( $index * 100 ); ?>">
					<div class="fm-gallery__card-image">
						<img src="<?php echo esc_url( $album['image'] ); ?>" alt="<?php echo esc_attr( $album['title'] ); ?> album preview" loading="lazy">
						<div class="fm-gallery__card-overlay">
							<a href="<?php echo esc_url( $album['album_url'] ); ?>" class="fm-gallery__card-link" target="_blank" rel="noopener">
								<i class="fa-solid fa-images"></i>
								<span>View Album</span>
							</a>
						</div>
					</div>
					<div class="fm-gallery__card-content">
						<img src="<?php echo esc_url( $album['logo'] ); ?>" alt="<?php echo esc_attr( $album['title'] ); ?>" class="fm-gallery__card-logo" loading="lazy">
						<p class="fm-gallery__card-description"><?php echo esc_html( $album['description'] ); ?></p>
						<a href="<?php echo esc_url( $album['album_url'] ); ?>" class="fm-btn fm-btn--text" target="_blank" rel="noopener">
							View Album <i class="fa-solid fa-arrow-right"></i>
						</a>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
