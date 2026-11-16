<?php
/**
 * Featured Event Section
 *
 * Displays all published fm_event posts, oldest first.
 * 1 event  → full-width cinematic card.
 * 2 events → side-by-side equal cards.
 * 3+       → responsive grid, up to 3 columns per row (3x3 and beyond).
 *
 * Filter `fm_featured_events_limit` to cap how many events render
 * (default -1 = all published events).
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

$global_ticket = get_theme_mod( 'fm_ticket_url', 'https://touchstonelink.com/frenchmen-parties/' );

/** Number of events to display. -1 = all. */
$events_limit = (int) apply_filters( 'fm_featured_events_limit', -1 );

$event_query = new WP_Query(
	array(
		'post_type'      => 'fm_event',
		'post_status'    => 'publish',
		'posts_per_page' => $events_limit,
		'orderby'        => 'date',
		'order'          => 'ASC',
	)
);

if ( ! $event_query->have_posts() ) {
	return;
}

$events = array();
foreach ( $event_query->posts as $post ) {
	$logo_id    = get_post_meta( $post->ID, '_fm_event_logo', true );
	$ticket_url = get_post_meta( $post->ID, '_fm_event_ticket_url', true ) ?: $global_ticket;

	$events[] = array(
		'id'          => $post->ID,
		'title'       => get_the_title( $post ),
		'description' => get_the_excerpt( $post ),
		'date'        => get_post_meta( $post->ID, '_fm_event_date', true ),
		'ticket_url'  => $ticket_url,
		'photo_url'   => get_the_post_thumbnail_url( $post->ID, 'large' ) ?: '',
		'logo_url'    => $logo_id ? wp_get_attachment_image_url( $logo_id, 'medium' ) : '',
	);
}
wp_reset_postdata();

$count = count( $events );

if ( 1 === $count ) {
	$modifier = 'fm-featured--single';
} elseif ( 2 === $count ) {
	$modifier = 'fm-featured--double';
} else {
	$modifier = 'fm-featured--grid';
}

/* Column counts per breakpoint — never more columns than there are events. */
$cols_md = min( 2, $count );
$cols_lg = min( 3, $count );

/*
 * The grid is laid out in half-columns (2 tracks per visible column) so a
 * partially filled last row can be centred by starting it on a half-column.
 */
$grid_style = sprintf(
	'--fm-featured-count:%1$d;--fm-featured-cols-md:%2$d;--fm-featured-cols-lg:%3$d;--fm-featured-tracks-md:%4$d;--fm-featured-tracks-lg:%5$d;',
	$count,
	$cols_md,
	$cols_lg,
	$cols_md * 2,
	$cols_lg * 2
);

/*
 * Index of the first card in a partially filled last row, per breakpoint,
 * plus the half-column track that row should start on to sit centred.
 * -1 means the last row is full, so nothing needs shifting.
 */
$orphans_md    = $count % $cols_md;
$orphans_lg    = $count % $cols_lg;
$row_start_md  = $orphans_md ? $count - $orphans_md : -1;
$row_start_lg  = $orphans_lg ? $count - $orphans_lg : -1;
$track_md      = 1 + ( $cols_md - $orphans_md );
$track_lg      = 1 + ( $cols_lg - $orphans_lg );
?>
<section class="fm-featured <?php echo esc_attr( $modifier ); ?>" style="<?php echo esc_attr( $grid_style ); ?>" aria-label="<?php esc_attr_e( 'Featured Events', 'frenchmen' ); ?>">
	<div class="fm-featured__container">

		<div class="fm-featured__heading fm-animate" data-animation="fade-up">
			<p class="fm-featured__label"><?php esc_html_e( 'On the Radar', 'frenchmen' ); ?></p>
			<h2 class="fm-featured__title">
				<?php echo 1 === $count ? esc_html( $events[0]['title'] ) : esc_html__( 'Upcoming Events', 'frenchmen' ); ?>
			</h2>
		</div>

		<div class="fm-featured__events">
			<?php foreach ( $events as $i => $event ) : ?>
				<?php
				// Stagger within a row only, so later rows don't inherit a long delay.
				$delay = ( $i % max( 1, $cols_lg ) ) * 150;

				// Only the first card of a short last row carries a start track.
				$card_style = '';
				if ( $i === $row_start_md ) {
					$card_style .= '--fm-featured-start-md:' . $track_md . ';';
				}
				if ( $i === $row_start_lg ) {
					$card_style .= '--fm-featured-start-lg:' . $track_lg . ';';
				}
				?>
				<article class="fm-featured__event fm-animate" data-animation="fade-up" data-delay="<?php echo esc_attr( $delay ); ?>"<?php echo $card_style ? ' style="' . esc_attr( $card_style ) . '"' : ''; ?>>

					<div class="fm-featured__event-photo">
						<?php if ( $event['photo_url'] ) : ?>
							<img src="<?php echo esc_url( $event['photo_url'] ); ?>" alt="<?php echo esc_attr( $event['title'] ); ?>" loading="lazy">
						<?php endif; ?>

						<?php if ( $event['logo_url'] ) : ?>
							<div class="fm-featured__event-logo">
								<img src="<?php echo esc_url( $event['logo_url'] ); ?>" alt="<?php echo esc_attr( $event['title'] ); ?>">
							</div>
						<?php endif; ?>
					</div>

					<div class="fm-featured__event-body">
						<?php if ( $event['date'] ) : ?>
							<span class="fm-featured__event-date"><?php echo esc_html( $event['date'] ); ?></span>
						<?php endif; ?>

						<?php if ( 1 !== $count ) : ?>
							<h3 class="fm-featured__event-title"><?php echo esc_html( $event['title'] ); ?></h3>
						<?php endif; ?>

						<?php if ( $event['description'] ) : ?>
							<p class="fm-featured__event-description"><?php echo esc_html( $event['description'] ); ?></p>
						<?php endif; ?>

						<a href="<?php echo esc_url( $event['ticket_url'] ); ?>" class="fm-btn fm-btn--primary" target="_blank" rel="noopener">
							<?php esc_html_e( 'Get Tickets', 'frenchmen' ); ?>
						</a>
					</div>

				</article>
			<?php endforeach; ?>
		</div>

	</div>
</section>
