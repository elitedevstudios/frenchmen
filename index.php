<?php
/**
 * Main Template File
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'fm-article' ); ?>>
			<header class="fm-article__header">
				<?php the_title( '<h1 class="fm-article__title">', '</h1>' ); ?>
			</header>
			<div class="fm-article__content">
				<?php the_content(); ?>
			</div>
		</article>
		<?php
	endwhile;
else :
	?>
	<section class="fm-no-content">
		<h1><?php esc_html_e( 'Nothing Found', 'frenchmen' ); ?></h1>
		<p><?php esc_html_e( 'It seems we can\'t find what you\'re looking for.', 'frenchmen' ); ?></p>
	</section>
	<?php
endif;

get_footer();
