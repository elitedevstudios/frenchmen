<?php
/**
 * Stats Section
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

$stats = fm_get_stats();
?>
<section class="fm-stats" aria-label="<?php esc_attr_e( 'Key Stats', 'frenchmen' ); ?>">
	<div class="fm-stats__container">
		<?php foreach ( $stats as $index => $stat ) : ?>
			<div class="fm-stats__item fm-animate" data-animation="zoom-in" data-delay="<?php echo esc_attr( $index * 100 ); ?>">
				<span class="fm-stats__number" data-count="<?php echo esc_attr( $stat['number'] ); ?>" data-suffix="<?php echo esc_attr( $stat['suffix'] ); ?>">
					0<?php echo esc_html( $stat['suffix'] ); ?>
				</span>
				<span class="fm-stats__label"><?php echo esc_html( $stat['label'] ); ?></span>
			</div>
		<?php endforeach; ?>
	</div>
</section>
