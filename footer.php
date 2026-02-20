<?php
/**
 * Theme Footer
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

$socials = fm_get_social_links();
?>
</main><!-- #content -->

<footer class="fm-footer" id="colophon">
	<div class="fm-footer__container">
		<div class="fm-footer__top">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fm-footer__logo" aria-label="<?php esc_attr_e( 'Home', 'frenchmen' ); ?>">
				<img src="<?php echo esc_url( fm_upload( '2025/08/frenchmen-logo-300x300-1.png' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>">
			</a>

			<nav class="fm-footer__nav" aria-label="<?php esc_attr_e( 'Footer Navigation', 'frenchmen' ); ?>">
				<a href="#events" class="fm-footer__link">Events</a>
				<a href="#about" class="fm-footer__link">About</a>
				<a href="#gallery" class="fm-footer__link">Gallery</a>
				<a href="#contact" class="fm-footer__link">Contact</a>
			</nav>

			<div class="fm-footer__socials">
				<?php foreach ( $socials as $social ) : ?>
					<a href="<?php echo esc_url( $social['url'] ); ?>" class="fm-footer__social-link" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $social['label'] ); ?>">
						<i class="fa-brands fa-<?php echo esc_attr( $social['icon'] ); ?>"></i>
					</a>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="fm-footer__bottom">
			<nav class="fm-footer__legal-nav">
				<a href="#events" class="fm-footer__legal-link">Events</a>
				<a href="#about" class="fm-footer__legal-link">About</a>
				<a href="#gallery" class="fm-footer__legal-link">Gallery</a>
				<a href="#contact" class="fm-footer__legal-link">Contact</a>
				<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>" class="fm-footer__legal-link">Privacy Policy</a>
			</nav>
			<p class="fm-footer__copyright">
				&copy; <?php echo esc_html( date( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.
			</p>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
