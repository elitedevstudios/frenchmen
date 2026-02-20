<?php
/**
 * Default Page Template
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'fm-page' ); ?>>
		<header class="fm-page__header">
			<div class="fm-page__header-container">
				<?php the_title( '<h1 class="fm-page__title">', '</h1>' ); ?>
			</div>
		</header>

		<div class="fm-page__content">
			<div class="fm-page__content-container">
				<?php the_content(); ?>
			</div>
		</div>
	</article>
	<?php
endwhile;

get_footer();
