<?php
/**
 * Hero Section
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

$hero_video    = fm_upload( '2026/02/blocko.mp4' );
$hero_icon_id  = get_theme_mod( 'fm_hero_icon', '' );
$hero_icon_url = $hero_icon_id ? wp_get_attachment_image_url( $hero_icon_id, 'full' ) : fm_upload( '2025/08/Blocko.png' );
$hero_title    = get_theme_mod( 'fm_hero_title', 'BlockO' );
$hero_subtitle = get_theme_mod( 'fm_hero_subtitle', 'Frenchmen Soca Season' );
$ticket_url    = get_theme_mod( 'fm_ticket_url', 'https://touchstonelink.com/frenchmen-parties/' );
?>
<section class="fm-hero" id="hero" aria-label="<?php esc_attr_e( 'Frenchmen Hero', 'frenchmen' ); ?>">
	<div class="fm-hero__video-container">
		<video class="fm-hero__video" autoplay muted loop playsinline id="hero-video">
			<source src="<?php echo esc_url( $hero_video ); ?>" type="video/mp4">
		</video>
		<div class="fm-hero__overlay"></div>
	</div>

	<div class="fm-hero__content">
		<span class="fm-hero__subtitle fm-animate" data-animation="fade-down"><?php echo esc_html( $hero_subtitle ); ?></span>
		<h1 class="fm-hero__title fm-animate" data-animation="fade-up" data-delay="200">
			<img src="<?php echo esc_url( $hero_icon_url ); ?>" alt="<?php echo esc_attr( $hero_title ); ?>" class="fm-hero__title-logo">
		</h1>
		<div class="fm-hero__actions fm-animate" data-animation="fade-up" data-delay="400">
			<a href="<?php echo esc_url( $ticket_url ); ?>" class="fm-btn fm-btn--primary fm-btn--lg fm-btn--pulse" target="_blank" rel="noopener">
				Get Tickets
			</a>
		</div>
	</div>

	<button class="fm-hero__audio-toggle" id="audio-toggle" aria-label="<?php esc_attr_e( 'Toggle Audio', 'frenchmen' ); ?>">
		<span class="fm-hero__audio-icon fm-hero__audio-icon--muted">🔇</span>
		<span class="fm-hero__audio-icon fm-hero__audio-icon--unmuted">🔊</span>
	</button>

	<div class="fm-hero__scroll-indicator">
		<span class="fm-hero__scroll-text">Scroll</span>
		<div class="fm-hero__scroll-line"></div>
	</div>
</section>
