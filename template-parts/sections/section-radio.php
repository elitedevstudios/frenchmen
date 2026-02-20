<?php
/**
 * Radio Section
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="fm-radio" aria-label="<?php esc_attr_e( 'Frenchmen Radio', 'frenchmen' ); ?>">
	<div class="fm-radio__background">
		<div class="fm-radio__wave fm-radio__wave--1"></div>
		<div class="fm-radio__wave fm-radio__wave--2"></div>
		<div class="fm-radio__wave fm-radio__wave--3"></div>
	</div>

	<div class="fm-radio__container">
		<div class="fm-radio__header fm-animate" data-animation="fade-up">
			<h2 class="fm-radio__title">Frenchmen Radio</h2>
			<p class="fm-radio__subtitle">High quality mixes for your listening pleasure.</p>
		</div>

		<div class="fm-radio__player fm-animate" data-animation="fade-up" data-delay="200">
			<iframe 
				width="100%" 
				height="300" 
				scrolling="no" 
				frameborder="no" 
				allow="autoplay" 
				src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/users/frenchmenparty&color=%23f5c518&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true&visual=true"
				title="Frenchmen Radio SoundCloud Player"
			></iframe>
		</div>
	</div>
</section>
