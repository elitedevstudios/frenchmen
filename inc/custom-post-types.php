<?php
/**
 * Custom Post Types — Parties & Events
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

// ─── Register CPTs ────────────────────────────────────────────────────────────

/**
 * Register fm_party and fm_event custom post types.
 */
function fm_register_post_types() {

	// Parties
	register_post_type(
		'fm_party',
		array(
			'label'           => __( 'Parties', 'frenchmen' ),
			'labels'          => array(
				'name'               => __( 'Parties', 'frenchmen' ),
				'singular_name'      => __( 'Party', 'frenchmen' ),
				'add_new'            => __( 'Add Party', 'frenchmen' ),
				'add_new_item'       => __( 'Add New Party', 'frenchmen' ),
				'edit_item'          => __( 'Edit Party', 'frenchmen' ),
				'new_item'           => __( 'New Party', 'frenchmen' ),
				'view_item'          => __( 'View Party', 'frenchmen' ),
				'search_items'       => __( 'Search Parties', 'frenchmen' ),
				'not_found'          => __( 'No parties found', 'frenchmen' ),
				'not_found_in_trash' => __( 'No parties found in trash', 'frenchmen' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'show_in_rest'    => false,
			'menu_icon'       => 'dashicons-groups',
			'supports'        => array( 'title', 'thumbnail' ),
			'capability_type' => 'post',
			'has_archive'     => false,
		)
	);

	// Party Categories
	register_post_type(
		'fm_party_category',
		array(
			'label'           => __( 'Party Categories', 'frenchmen' ),
			'labels'          => array(
				'name'               => __( 'Party Categories', 'frenchmen' ),
				'singular_name'      => __( 'Party Category', 'frenchmen' ),
				'add_new'            => __( 'Add Category', 'frenchmen' ),
				'add_new_item'       => __( 'Add New Party Category', 'frenchmen' ),
				'edit_item'          => __( 'Edit Party Category', 'frenchmen' ),
				'new_item'           => __( 'New Party Category', 'frenchmen' ),
				'search_items'       => __( 'Search Party Categories', 'frenchmen' ),
				'not_found'          => __( 'No party categories found', 'frenchmen' ),
				'not_found_in_trash' => __( 'No party categories found in trash', 'frenchmen' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'show_in_rest'    => false,
			'menu_icon'       => 'dashicons-category',
			'supports'        => array( 'title' ),
			'capability_type' => 'post',
			'has_archive'     => false,
		)
	);

	// Events
	register_post_type(
		'fm_event',
		array(
			'label'           => __( 'Events', 'frenchmen' ),
			'labels'          => array(
				'name'               => __( 'Events', 'frenchmen' ),
				'singular_name'      => __( 'Event', 'frenchmen' ),
				'add_new'            => __( 'Add Event', 'frenchmen' ),
				'add_new_item'       => __( 'Add New Event', 'frenchmen' ),
				'edit_item'          => __( 'Edit Event', 'frenchmen' ),
				'new_item'           => __( 'New Event', 'frenchmen' ),
				'view_item'          => __( 'View Event', 'frenchmen' ),
				'search_items'       => __( 'Search Events', 'frenchmen' ),
				'not_found'          => __( 'No events found', 'frenchmen' ),
				'not_found_in_trash' => __( 'No events found in trash', 'frenchmen' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'show_in_rest'    => false,
			'menu_icon'       => 'dashicons-calendar-alt',
			'supports'        => array( 'title', 'editor', 'thumbnail' ),
			'capability_type' => 'post',
			'has_archive'     => false,
		)
	);
}
add_action( 'init', 'fm_register_post_types' );

// ─── Party Meta Box ───────────────────────────────────────────────────────────

/**
 * Register meta box for fm_party.
 */
function fm_party_meta_box() {
	add_meta_box(
		'fm_party_details',
		__( 'Party Details', 'frenchmen' ),
		'fm_party_meta_box_html',
		'fm_party',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'fm_party_meta_box' );

/**
 * Render fm_party meta box HTML.
 *
 * @param WP_Post $post Current post object.
 */
function fm_party_meta_box_html( $post ) {
	wp_nonce_field( 'fm_party_save', 'fm_party_nonce' );

	$logo_id     = get_post_meta( $post->ID, '_fm_party_logo', true );
	$logo_url    = $logo_id ? wp_get_attachment_image_url( $logo_id, 'thumbnail' ) : '';
	$order       = get_post_meta( $post->ID, '_fm_party_order', true );
	$upcoming    = get_post_meta( $post->ID, '_fm_party_upcoming', true );
	$badge_text  = get_post_meta( $post->ID, '_fm_party_badge_text', true );
	$category_id = (int) get_post_meta( $post->ID, '_fm_party_category_id', true );
	if ( '' === $badge_text ) {
		$badge_text = 'Upcoming';
	}

	$categories = get_posts( array(
		'post_type'      => 'fm_party_category',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
	) );
	?>
	<style>
		.fm-meta-row { margin-bottom: 16px; }
		.fm-meta-row label { display: block; font-weight: 600; margin-bottom: 4px; }
		.fm-meta-row input[type="text"],
		.fm-meta-row input[type="number"],
		.fm-meta-row select { width: 100%; max-width: 300px; }
		.fm-logo-preview { margin-top: 8px; }
		.fm-logo-preview img { max-width: 120px; height: auto; border: 1px solid #ddd; border-radius: 4px; display: block; margin-bottom: 8px; }
	</style>

	<div class="fm-meta-row">
		<label for="fm_party_logo"><?php esc_html_e( 'Party Logo', 'frenchmen' ); ?></label>
		<div class="fm-logo-preview" id="fm_party_logo_preview">
			<?php if ( $logo_url ) : ?>
				<img src="<?php echo esc_url( $logo_url ); ?>" alt="">
			<?php endif; ?>
		</div>
		<input type="hidden" name="fm_party_logo" id="fm_party_logo" value="<?php echo esc_attr( $logo_id ); ?>">
		<button type="button" class="button" id="fm_party_logo_btn"><?php esc_html_e( 'Select Logo', 'frenchmen' ); ?></button>
		<?php if ( $logo_id ) : ?>
			<button type="button" class="button" id="fm_party_logo_remove"><?php esc_html_e( 'Remove', 'frenchmen' ); ?></button>
		<?php else : ?>
			<button type="button" class="button" id="fm_party_logo_remove" style="display:none;"><?php esc_html_e( 'Remove', 'frenchmen' ); ?></button>
		<?php endif; ?>
	</div>

	<div class="fm-meta-row">
		<label for="fm_party_category_id"><?php esc_html_e( 'Category', 'frenchmen' ); ?></label>
		<select name="fm_party_category_id" id="fm_party_category_id">
			<option value="0"><?php esc_html_e( '— No Category —', 'frenchmen' ); ?></option>
			<?php foreach ( $categories as $cat ) : ?>
				<option value="<?php echo esc_attr( $cat->ID ); ?>" <?php selected( $category_id, $cat->ID ); ?>>
					<?php echo esc_html( get_the_title( $cat ) ); ?>
				</option>
			<?php endforeach; ?>
		</select>
		<p class="description"><?php esc_html_e( 'Assign this party to a category group shown on the front end.', 'frenchmen' ); ?></p>
	</div>

	<div class="fm-meta-row">
		<label for="fm_party_order"><?php esc_html_e( 'Display Order', 'frenchmen' ); ?></label>
		<input type="number" name="fm_party_order" id="fm_party_order" value="<?php echo esc_attr( $order ); ?>" min="0" step="1">
		<p class="description"><?php esc_html_e( 'Lower numbers appear first.', 'frenchmen' ); ?></p>
	</div>

	<div class="fm-meta-row">
		<label>
			<input type="checkbox" name="fm_party_upcoming" id="fm_party_upcoming" value="1" <?php checked( $upcoming, '1' ); ?>>
			<?php esc_html_e( 'Mark as Upcoming', 'frenchmen' ); ?>
		</label>
	</div>

	<div class="fm-meta-row">
		<label for="fm_party_badge_text"><?php esc_html_e( 'Badge Text', 'frenchmen' ); ?></label>
		<input type="text" name="fm_party_badge_text" id="fm_party_badge_text" value="<?php echo esc_attr( $badge_text ); ?>" placeholder="Upcoming">
		<p class="description"><?php esc_html_e( 'Text shown on the badge when "Mark as Upcoming" is checked.', 'frenchmen' ); ?></p>
	</div>

	<script>
	jQuery( function( $ ) {
		var frame;
		$( '#fm_party_logo_btn' ).on( 'click', function() {
			if ( frame ) { frame.open(); return; }
			frame = wp.media({ title: '<?php esc_html_e( 'Select Party Logo', 'frenchmen' ); ?>', button: { text: '<?php esc_html_e( 'Use this image', 'frenchmen' ); ?>' }, multiple: false });
			frame.on( 'select', function() {
				var attachment = frame.state().get( 'selection' ).first().toJSON();
				$( '#fm_party_logo' ).val( attachment.id );
				var src = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
				$( '#fm_party_logo_preview' ).html( '<img src="' + src + '" alt="">' );
				$( '#fm_party_logo_remove' ).show();
			});
			frame.open();
		});
		$( '#fm_party_logo_remove' ).on( 'click', function() {
			$( '#fm_party_logo' ).val( '' );
			$( '#fm_party_logo_preview' ).html( '' );
			$( this ).hide();
		});
	});
	</script>
	<?php
}

/**
 * Save fm_party meta box data.
 *
 * @param int $post_id Post ID.
 */
function fm_party_meta_save( $post_id ) {
	if ( ! isset( $_POST['fm_party_nonce'] ) || ! wp_verify_nonce( $_POST['fm_party_nonce'], 'fm_party_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, '_fm_party_logo', absint( $_POST['fm_party_logo'] ?? 0 ) );
	update_post_meta( $post_id, '_fm_party_order', absint( $_POST['fm_party_order'] ?? 0 ) );
	update_post_meta( $post_id, '_fm_party_upcoming', isset( $_POST['fm_party_upcoming'] ) ? '1' : '' );
	update_post_meta( $post_id, '_fm_party_badge_text', sanitize_text_field( $_POST['fm_party_badge_text'] ?? 'Upcoming' ) );
	update_post_meta( $post_id, '_fm_party_category_id', absint( $_POST['fm_party_category_id'] ?? 0 ) );
}
add_action( 'save_post_fm_party', 'fm_party_meta_save' );

// ─── Party Admin Columns ──────────────────────────────────────────────────────

/**
 * Add custom columns to fm_party list table.
 *
 * @param array $columns Default columns.
 * @return array Modified columns.
 */
function fm_party_admin_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['fm_logo']     = __( 'Logo', 'frenchmen' );
			$new['fm_category'] = __( 'Category', 'frenchmen' );
			$new['fm_order']    = __( 'Order', 'frenchmen' );
			$new['fm_upcoming'] = __( 'Upcoming', 'frenchmen' );
		}
	}
	return $new;
}
add_filter( 'manage_fm_party_posts_columns', 'fm_party_admin_columns' );

/**
 * Render custom column values for fm_party list table.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function fm_party_admin_column_values( $column, $post_id ) {
	switch ( $column ) {
		case 'fm_logo':
			$logo_id = get_post_meta( $post_id, '_fm_party_logo', true );
			if ( $logo_id ) {
				echo wp_get_attachment_image( $logo_id, array( 50, 50 ) );
			} else {
				echo '—';
			}
			break;
		case 'fm_category':
			$cat_id = (int) get_post_meta( $post_id, '_fm_party_category_id', true );
			echo $cat_id ? esc_html( get_the_title( $cat_id ) ) : '—';
			break;
		case 'fm_order':
			echo esc_html( get_post_meta( $post_id, '_fm_party_order', true ) ?: '—' );
			break;
		case 'fm_upcoming':
			echo get_post_meta( $post_id, '_fm_party_upcoming', true ) ? '✓' : '—';
			break;
	}
}
add_action( 'manage_fm_party_posts_custom_column', 'fm_party_admin_column_values', 10, 2 );

// ─── Event Meta Box ───────────────────────────────────────────────────────────

/**
 * Register meta box for fm_event.
 */
function fm_event_meta_box() {
	add_meta_box(
		'fm_event_details',
		__( 'Event Details', 'frenchmen' ),
		'fm_event_meta_box_html',
		'fm_event',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'fm_event_meta_box' );

/**
 * Render fm_event meta box HTML.
 *
 * @param WP_Post $post Current post object.
 */
function fm_event_meta_box_html( $post ) {
	wp_nonce_field( 'fm_event_save', 'fm_event_nonce' );

	$event_date   = get_post_meta( $post->ID, '_fm_event_date', true );
	$ticket_url   = get_post_meta( $post->ID, '_fm_event_ticket_url', true );
	$logo_id      = get_post_meta( $post->ID, '_fm_event_logo', true );
	$logo_url     = $logo_id ? wp_get_attachment_image_url( $logo_id, 'thumbnail' ) : '';
	$order        = get_post_meta( $post->ID, '_fm_event_order', true );
	?>
	<style>
		.fm-meta-row { margin-bottom: 16px; }
		.fm-meta-row label { display: block; font-weight: 600; margin-bottom: 4px; }
		.fm-meta-row input[type="text"],
		.fm-meta-row input[type="url"],
		.fm-meta-row input[type="number"] { width: 100%; max-width: 400px; }
		.fm-logo-preview { margin-top: 8px; }
		.fm-logo-preview img { max-width: 120px; height: auto; border: 1px solid #ddd; border-radius: 4px; display: block; margin-bottom: 8px; }
	</style>

	<div class="fm-meta-row">
		<label for="fm_event_logo"><?php esc_html_e( 'Party Logo', 'frenchmen' ); ?></label>
		<p class="description"><?php esc_html_e( 'Logo shown as a circular badge on the event card (e.g. Rise Up logo, BlockO logo).', 'frenchmen' ); ?></p>
		<div class="fm-logo-preview" id="fm_event_logo_preview">
			<?php if ( $logo_url ) : ?>
				<img src="<?php echo esc_url( $logo_url ); ?>" alt="">
			<?php endif; ?>
		</div>
		<input type="hidden" name="fm_event_logo" id="fm_event_logo" value="<?php echo esc_attr( $logo_id ); ?>">
		<button type="button" class="button" id="fm_event_logo_btn"><?php esc_html_e( 'Select Logo', 'frenchmen' ); ?></button>
		<button type="button" class="button" id="fm_event_logo_remove" <?php echo $logo_id ? '' : 'style="display:none;"'; ?>><?php esc_html_e( 'Remove', 'frenchmen' ); ?></button>
	</div>

	<div class="fm-meta-row">
		<label for="fm_event_date"><?php esc_html_e( 'Event Date (Display Text)', 'frenchmen' ); ?></label>
		<input type="text" name="fm_event_date" id="fm_event_date" value="<?php echo esc_attr( $event_date ); ?>" placeholder="e.g. April 4, 2026">
		<p class="description"><?php esc_html_e( 'Shown as a date badge on the event card (e.g. "April 4, 2026", "Carnival Saturday").', 'frenchmen' ); ?></p>
	</div>

	<div class="fm-meta-row">
		<label for="fm_event_ticket_url"><?php esc_html_e( 'Ticket Link', 'frenchmen' ); ?></label>
		<input type="url" name="fm_event_ticket_url" id="fm_event_ticket_url" value="<?php echo esc_attr( $ticket_url ); ?>" placeholder="https://...">
		<p class="description"><?php esc_html_e( 'URL for the "Get Tickets" button. Leave blank to use the global ticket link.', 'frenchmen' ); ?></p>
	</div>

	<div class="fm-meta-row">
		<label for="fm_event_order"><?php esc_html_e( 'Display Order', 'frenchmen' ); ?></label>
		<input type="number" name="fm_event_order" id="fm_event_order" value="<?php echo esc_attr( $order ); ?>" min="0" step="1" style="max-width:120px;">
		<p class="description"><?php esc_html_e( 'Lower numbers appear first. Controls order when two events are shown side by side.', 'frenchmen' ); ?></p>
	</div>

	<p class="description"><?php esc_html_e( 'Set the Featured Image above to use as the event photo. Use the post excerpt for the event description.', 'frenchmen' ); ?></p>

	<script>
	jQuery( function( $ ) {
		var frame;
		$( '#fm_event_logo_btn' ).on( 'click', function() {
			if ( frame ) { frame.open(); return; }
			frame = wp.media({ title: '<?php esc_html_e( 'Select Party Logo', 'frenchmen' ); ?>', button: { text: '<?php esc_html_e( 'Use this image', 'frenchmen' ); ?>' }, multiple: false });
			frame.on( 'select', function() {
				var attachment = frame.state().get( 'selection' ).first().toJSON();
				$( '#fm_event_logo' ).val( attachment.id );
				var src = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
				$( '#fm_event_logo_preview' ).html( '<img src="' + src + '" alt="">' );
				$( '#fm_event_logo_remove' ).show();
			});
			frame.open();
		});
		$( '#fm_event_logo_remove' ).on( 'click', function() {
			$( '#fm_event_logo' ).val( '' );
			$( '#fm_event_logo_preview' ).html( '' );
			$( this ).hide();
		});
	});
	</script>
	<?php
}

/**
 * Save fm_event meta box data.
 *
 * @param int $post_id Post ID.
 */
function fm_event_meta_save( $post_id ) {
	if ( ! isset( $_POST['fm_event_nonce'] ) || ! wp_verify_nonce( $_POST['fm_event_nonce'], 'fm_event_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, '_fm_event_logo', absint( $_POST['fm_event_logo'] ?? 0 ) );
	update_post_meta( $post_id, '_fm_event_date', sanitize_text_field( $_POST['fm_event_date'] ?? '' ) );
	update_post_meta( $post_id, '_fm_event_ticket_url', esc_url_raw( $_POST['fm_event_ticket_url'] ?? '' ) );
	update_post_meta( $post_id, '_fm_event_order', absint( $_POST['fm_event_order'] ?? 0 ) );
}
add_action( 'save_post_fm_event', 'fm_event_meta_save' );

// ─── Party Category Meta Box ──────────────────────────────────────────────────

/**
 * Register meta box for fm_party_category.
 */
function fm_party_category_meta_box() {
	add_meta_box(
		'fm_party_category_details',
		__( 'Category Details', 'frenchmen' ),
		'fm_party_category_meta_box_html',
		'fm_party_category',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'fm_party_category_meta_box' );

/**
 * Render fm_party_category meta box HTML.
 *
 * @param WP_Post $post Current post object.
 */
function fm_party_category_meta_box_html( $post ) {
	wp_nonce_field( 'fm_pcat_save', 'fm_pcat_nonce' );

	$logo_id     = get_post_meta( $post->ID, '_fm_pcat_logo', true );
	$logo_url    = $logo_id ? wp_get_attachment_image_url( $logo_id, 'thumbnail' ) : '';
	$description = get_post_meta( $post->ID, '_fm_pcat_description', true );
	$order       = get_post_meta( $post->ID, '_fm_pcat_order', true );
	?>
	<style>
		.fm-meta-row { margin-bottom: 16px; }
		.fm-meta-row label { display: block; font-weight: 600; margin-bottom: 4px; }
		.fm-meta-row input[type="text"],
		.fm-meta-row input[type="number"] { width: 100%; max-width: 400px; }
		.fm-logo-preview { margin-top: 8px; }
		.fm-logo-preview img { max-width: 160px; height: auto; border: 1px solid #ddd; border-radius: 4px; display: block; margin-bottom: 8px; }
	</style>

	<div class="fm-meta-row">
		<label for="fm_pcat_logo"><?php esc_html_e( 'Category Logo', 'frenchmen' ); ?></label>
		<p class="description"><?php esc_html_e( 'Large brand logo displayed above the event cards (e.g. "Frenchmen Soca Season" logo).', 'frenchmen' ); ?></p>
		<div class="fm-logo-preview" id="fm_pcat_logo_preview">
			<?php if ( $logo_url ) : ?>
				<img src="<?php echo esc_url( $logo_url ); ?>" alt="">
			<?php endif; ?>
		</div>
		<input type="hidden" name="fm_pcat_logo" id="fm_pcat_logo" value="<?php echo esc_attr( $logo_id ); ?>">
		<button type="button" class="button" id="fm_pcat_logo_btn"><?php esc_html_e( 'Select Logo', 'frenchmen' ); ?></button>
		<button type="button" class="button" id="fm_pcat_logo_remove" <?php echo $logo_id ? '' : 'style="display:none;"'; ?>><?php esc_html_e( 'Remove', 'frenchmen' ); ?></button>
	</div>

	<div class="fm-meta-row">
		<label for="fm_pcat_description"><?php esc_html_e( 'Tagline / Description', 'frenchmen' ); ?></label>
		<input type="text" name="fm_pcat_description" id="fm_pcat_description" value="<?php echo esc_attr( $description ); ?>" placeholder="<?php esc_attr_e( 'e.g. Carnival energy all season.', 'frenchmen' ); ?>">
		<p class="description"><?php esc_html_e( 'Short tagline shown beneath the category title on the front end.', 'frenchmen' ); ?></p>
	</div>

	<div class="fm-meta-row">
		<label for="fm_pcat_order"><?php esc_html_e( 'Display Order', 'frenchmen' ); ?></label>
		<input type="number" name="fm_pcat_order" id="fm_pcat_order" value="<?php echo esc_attr( $order ); ?>" min="0" step="1">
		<p class="description"><?php esc_html_e( 'Lower numbers appear first on the page. Change to reorder categories each season.', 'frenchmen' ); ?></p>
	</div>

	<script>
	jQuery( function( $ ) {
		var frame;
		$( '#fm_pcat_logo_btn' ).on( 'click', function() {
			if ( frame ) { frame.open(); return; }
			frame = wp.media({ title: '<?php esc_html_e( 'Select Category Logo', 'frenchmen' ); ?>', button: { text: '<?php esc_html_e( 'Use this image', 'frenchmen' ); ?>' }, multiple: false });
			frame.on( 'select', function() {
				var attachment = frame.state().get( 'selection' ).first().toJSON();
				$( '#fm_pcat_logo' ).val( attachment.id );
				var src = attachment.sizes && attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
				$( '#fm_pcat_logo_preview' ).html( '<img src="' + src + '" alt="">' );
				$( '#fm_pcat_logo_remove' ).show();
			});
			frame.open();
		});
		$( '#fm_pcat_logo_remove' ).on( 'click', function() {
			$( '#fm_pcat_logo' ).val( '' );
			$( '#fm_pcat_logo_preview' ).html( '' );
			$( this ).hide();
		});
	});
	</script>
	<?php
}

/**
 * Save fm_party_category meta box data.
 *
 * @param int $post_id Post ID.
 */
function fm_party_category_meta_save( $post_id ) {
	if ( ! isset( $_POST['fm_pcat_nonce'] ) || ! wp_verify_nonce( $_POST['fm_pcat_nonce'], 'fm_pcat_save' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	update_post_meta( $post_id, '_fm_pcat_logo', absint( $_POST['fm_pcat_logo'] ?? 0 ) );
	update_post_meta( $post_id, '_fm_pcat_description', sanitize_text_field( $_POST['fm_pcat_description'] ?? '' ) );
	update_post_meta( $post_id, '_fm_pcat_order', absint( $_POST['fm_pcat_order'] ?? 0 ) );
}
add_action( 'save_post_fm_party_category', 'fm_party_category_meta_save' );

// ─── Party Category Admin Columns ─────────────────────────────────────────────

/**
 * Add custom columns to fm_party_category list table.
 *
 * @param array $columns Default columns.
 * @return array Modified columns.
 */
function fm_pcat_admin_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['fm_pcat_logo']  = __( 'Logo', 'frenchmen' );
			$new['fm_pcat_order'] = __( 'Order', 'frenchmen' );
			$new['fm_pcat_desc']  = __( 'Tagline', 'frenchmen' );
		}
	}
	return $new;
}
add_filter( 'manage_fm_party_category_posts_columns', 'fm_pcat_admin_columns' );

/**
 * Render custom column values for fm_party_category list table.
 *
 * @param string $column  Column key.
 * @param int    $post_id Post ID.
 */
function fm_pcat_admin_column_values( $column, $post_id ) {
	switch ( $column ) {
		case 'fm_pcat_logo':
			$logo_id = get_post_meta( $post_id, '_fm_pcat_logo', true );
			if ( $logo_id ) {
				echo wp_get_attachment_image( $logo_id, array( 80, 40 ) );
			} else {
				echo '—';
			}
			break;
		case 'fm_pcat_order':
			echo esc_html( get_post_meta( $post_id, '_fm_pcat_order', true ) ?: '—' );
			break;
		case 'fm_pcat_desc':
			echo esc_html( get_post_meta( $post_id, '_fm_pcat_description', true ) ?: '—' );
			break;
	}
}
add_action( 'manage_fm_party_category_posts_custom_column', 'fm_pcat_admin_column_values', 10, 2 );
