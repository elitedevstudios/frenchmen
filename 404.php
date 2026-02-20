<?php
/**
 * 404 Page Template
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<section class="fm-404">
	<div class="fm-404__container">
		<h1 class="fm-404__title">404</h1>
		<p class="fm-404__message">Looks like this party moved somewhere else.</p>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="fm-btn fm-btn--primary">
			Back to Home
		</a>
	</div>
</section>

<style>
.fm-404 {
	display: flex;
	align-items: center;
	justify-content: center;
	min-block-size: 80vh;
	text-align: center;
	padding: var(--fm-space-2xl);
}

.fm-404__container {
	max-inline-size: 500px;
}

.fm-404__title {
	font-size: clamp(6rem, 20vw, 12rem);
	font-weight: 900;
	color: var(--fm-color-primary);
	line-height: 1;
	margin-block-end: var(--fm-space-md);
}

.fm-404__message {
	font-size: var(--fm-font-size-xl);
	color: var(--fm-color-text-light);
	margin-block-end: var(--fm-space-xl);
}
</style>

<?php
get_footer();
