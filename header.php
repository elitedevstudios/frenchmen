<?php
/**
 * Theme Header
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

$ticket_url = get_theme_mod( 'fm_ticket_url', 'https://touchstonelink.com/frenchmen-parties/' );
$socials    = fm_get_social_links();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#content">
	<?php esc_html_e( 'Skip to content', 'frenchmen' ); ?>
</a>

<header class="fm-header" id="masthead">
	<div class="fm-header__container">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fm-header__logo" aria-label="<?php esc_attr_e( 'Home', 'frenchmen' ); ?>">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<img src="<?php echo esc_url( fm_upload( '2025/08/frenchmen-logo-300x300-1.png' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>" class="fm-header__logo-img">
			<?php endif; ?>
		</a>

		<nav class="fm-nav" id="site-navigation" aria-label="<?php esc_attr_e( 'Primary Navigation', 'frenchmen' ); ?>">
			<ul class="fm-nav__list">
				<li class="fm-nav__item">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fm-nav__link">Home</a>
				</li>
				<li class="fm-nav__item">
					<a href="<?php echo esc_url( home_url( '/#about' ) ); ?>" class="fm-nav__link">About</a>
				</li>
				<li class="fm-nav__item">
					<a href="<?php echo esc_url( home_url( '/#events' ) ); ?>" class="fm-nav__link">Events</a>
				</li>
				<li class="fm-nav__item">
					<a href="<?php echo esc_url( home_url( '/food-court-menu/' ) ); ?>" class="fm-nav__link">Food Court Menu</a>
				</li>
				<li class="fm-nav__item">
					<a href="<?php echo esc_url( home_url( '/#gallery' ) ); ?>" class="fm-nav__link">Gallery</a>
				</li>
				<li class="fm-nav__item">
					<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" class="fm-nav__link">Contact</a>
				</li>
			</ul>
		</nav>

		<div class="fm-header__actions">
			<a href="<?php echo esc_url( $ticket_url ); ?>" class="fm-btn fm-btn--primary" target="_blank" rel="noopener">
				Get Tickets
			</a>
			<div class="fm-header__socials">
				<?php foreach ( $socials as $social ) : ?>
					<a href="<?php echo esc_url( $social['url'] ); ?>" class="fm-header__social-link" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $social['label'] ); ?>">
						<i class="fa-brands fa-<?php echo esc_attr( $social['icon'] ); ?>"></i>
					</a>
				<?php endforeach; ?>
			</div>
		</div>

		<button class="fm-header__toggle" id="menu-toggle" aria-controls="mobile-menu" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle Menu', 'frenchmen' ); ?>">
			<span class="fm-header__toggle-bar"></span>
			<span class="fm-header__toggle-bar"></span>
			<span class="fm-header__toggle-bar"></span>
		</button>
	</div>

	<!-- Mobile Menu -->
	<nav class="fm-mobile-nav" id="mobile-menu" aria-label="<?php esc_attr_e( 'Mobile Navigation', 'frenchmen' ); ?>">
		<button class="fm-mobile-nav__close" id="menu-close" aria-label="<?php esc_attr_e( 'Close Menu', 'frenchmen' ); ?>">
			<span>&times;</span>
		</button>
		<ul class="fm-mobile-nav__list">
			<li class="fm-mobile-nav__item">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fm-mobile-nav__link">Home</a>
			</li>
			<li class="fm-mobile-nav__item">
				<a href="<?php echo esc_url( home_url( '/#about' ) ); ?>" class="fm-mobile-nav__link">About</a>
			</li>
			<li class="fm-mobile-nav__item">
				<a href="<?php echo esc_url( home_url( '/#events' ) ); ?>" class="fm-mobile-nav__link">Events</a>
			</li>
			<li class="fm-mobile-nav__item">
				<a href="<?php echo esc_url( home_url( '/#gallery' ) ); ?>" class="fm-mobile-nav__link">Gallery</a>
			</li>
			<li class="fm-mobile-nav__item">
				<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" class="fm-mobile-nav__link">Contact</a>
			</li>
		</ul>
		<a href="<?php echo esc_url( $ticket_url ); ?>" class="fm-btn fm-btn--primary fm-mobile-nav__cta" target="_blank" rel="noopener">
			Get Tickets
		</a>
		<div class="fm-mobile-nav__socials">
			<?php foreach ( $socials as $social ) : ?>
				<a href="<?php echo esc_url( $social['url'] ); ?>" class="fm-mobile-nav__social-link" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $social['label'] ); ?>">
					<i class="fa-brands fa-<?php echo esc_attr( $social['icon'] ); ?>"></i>
				</a>
			<?php endforeach; ?>
		</div>
	</nav>
</header>

<main id="content" class="fm-main">
