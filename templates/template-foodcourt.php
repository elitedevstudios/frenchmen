<?php
/**
 * Template Name: Food Court
 * Template Post Type: page
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

get_header();

$vendors = array(
	array(
		'name'  => 'Bazaar',
		'image' => fm_upload( '2025/12/BAZAAR.jpg' ),
	),
	array(
		'name'  => 'Boston Jerk',
		'image' => fm_upload( '2025/12/BOSTON-JERK.jpg' ),
	),
	array(
		'name'  => 'Carvery',
		'image' => fm_upload( '2025/12/CARVERY.jpg' ),
	),
	array(
		'name'  => 'Fisherman',
		'image' => fm_upload( '2025/12/FISHERMAN.jpg' ),
	),
	array(
		'name'  => 'Island Spice',
		'image' => fm_upload( '2025/12/ISLAND-SPICE.jpg' ),
	),
	array(
		'name'  => 'Kashbash',
		'image' => fm_upload( '2025/12/KASHBASH.jpg' ),
	),
	array(
		'name'  => 'Lotus',
		'image' => fm_upload( '2025/12/LOTUS.jpg' ),
	),
	array(
		'name'  => 'Mama',
		'image' => fm_upload( '2025/12/MAMA.jpg' ),
	),
	array(
		'name'  => 'Red Lantern',
		'image' => fm_upload( '2025/12/red-lantern.jpg' ),
	),
	array(
		'name'  => 'Sora',
		'image' => fm_upload( '2025/12/sora.jpg' ),
	),
	array(
		'name'  => 'Soup Shack',
		'image' => fm_upload( '2025/12/soup-shack.jpg' ),
	),
	array(
		'name'  => 'Sweet',
		'image' => fm_upload( '2025/12/sweet.jpg' ),
	),
	array(
		'name'  => 'Under Di Sea',
		'image' => fm_upload( '2025/12/UNDER-DI-SEA.jpg' ),
	),
	array(
		'name'  => 'Vital Ital',
		'image' => fm_upload( '2025/12/vital-ital.jpg' ),
	),
);
?>

<section class="fm-foodcourt-hero">
	<div class="fm-foodcourt-hero__container">
		<h1 class="fm-foodcourt-hero__title fm-animate" data-animation="fade-up">Food Court</h1>
		<p class="fm-foodcourt-hero__subtitle fm-animate" data-animation="fade-up" data-delay="100">
			Explore the flavors of the Caribbean
		</p>
	</div>
</section>

<section class="fm-foodcourt">
	<div class="fm-foodcourt__container">
		<div class="fm-foodcourt__grid">
			<?php foreach ( $vendors as $index => $vendor ) : ?>
				<article class="fm-foodcourt__card fm-animate" data-animation="fade-up" data-delay="<?php echo esc_attr( ( $index % 6 ) * 50 ); ?>">
					<div class="fm-foodcourt__card-image">
						<img src="<?php echo esc_url( $vendor['image'] ); ?>" alt="<?php echo esc_attr( $vendor['name'] ); ?>" loading="lazy">
					</div>
					<h3 class="fm-foodcourt__card-title"><?php echo esc_html( $vendor['name'] ); ?></h3>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<style>
.fm-foodcourt-hero {
	padding-block: var(--fm-space-5xl);
	background: linear-gradient(135deg, var(--fm-color-primary-dark), var(--fm-color-secondary));
	text-align: center;
}

.fm-foodcourt-hero__container {
	max-inline-size: var(--fm-container-max);
	margin-inline: auto;
	padding-inline: var(--fm-container-padding);
}

.fm-foodcourt-hero__title {
	font-size: var(--fm-font-size-5xl);
	font-weight: 900;
	text-transform: uppercase;
	color: var(--fm-color-white);
}

.fm-foodcourt-hero__subtitle {
	margin-block-start: var(--fm-space-md);
	font-size: var(--fm-font-size-xl);
	color: oklch(100% 0 0 / 0.8);
}

.fm-foodcourt {
	padding-block: var(--fm-space-5xl);
	background-color: var(--fm-color-bg);
}

.fm-foodcourt__container {
	max-inline-size: var(--fm-container-wide);
	margin-inline: auto;
	padding-inline: var(--fm-container-padding);
}

.fm-foodcourt__grid {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
	gap: var(--fm-space-xl);
}

.fm-foodcourt__card {
	background-color: var(--fm-color-white);
	border-radius: var(--fm-radius-xl);
	overflow: hidden;
	box-shadow: var(--fm-shadow-md);
	transition: 
		transform var(--fm-transition-base),
		box-shadow var(--fm-transition-base);
}

.fm-foodcourt__card:hover {
	transform: translateY(-10px);
	box-shadow: var(--fm-shadow-xl);
}

.fm-foodcourt__card-image {
	aspect-ratio: 1;
	overflow: hidden;
}

.fm-foodcourt__card-image img {
	inline-size: 100%;
	block-size: 100%;
	object-fit: cover;
	transition: transform var(--fm-transition-slow);
}

.fm-foodcourt__card:hover .fm-foodcourt__card-image img {
	transform: scale(1.1);
}

.fm-foodcourt__card-title {
	padding: var(--fm-space-lg);
	font-size: var(--fm-font-size-lg);
	font-weight: 700;
	text-align: center;
	color: var(--fm-color-text);
}
</style>

<?php
get_footer();
