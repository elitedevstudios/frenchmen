<?php
/**
 * Contact Section
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

$email   = get_theme_mod( 'fm_contact_email', 'concierge@frenchmenparty.com' );
$socials = fm_get_social_links();
?>
<section class="fm-contact" id="contact" aria-label="<?php esc_attr_e( 'Contact Frenchmen', 'frenchmen' ); ?>">
	<div class="fm-contact__container">
		<div class="fm-contact__content fm-animate" data-animation="fade-up">
			<h2 class="fm-contact__title">Stay Connected</h2>
			<p class="fm-contact__subtitle">VIP requests, inquiries, collabs — and the latest vibes in your inbox.</p>
		</div>

		<div class="fm-contact__info fm-animate" data-animation="fade-up" data-delay="100">
			<a href="mailto:<?php echo esc_attr( $email ); ?>" class="fm-contact__email">
				<i class="fa-solid fa-envelope"></i>
				<?php echo esc_html( $email ); ?>
			</a>
		</div>

		<nav class="fm-contact__socials fm-animate" data-animation="fade-up" data-delay="200" aria-label="<?php esc_attr_e( 'Social Links', 'frenchmen' ); ?>">
			<?php foreach ( $socials as $social ) : ?>
				<a href="<?php echo esc_url( $social['url'] ); ?>" class="fm-contact__social-link" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $social['label'] ); ?>">
					<i class="fa-brands fa-<?php echo esc_attr( $social['icon'] ); ?>"></i>
				</a>
			<?php endforeach; ?>
		</nav>
	</div>
</section>
