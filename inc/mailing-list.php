<?php
/**
 * Mailing List: "Get updates on the next event" popup.
 *
 * Self-contained module:
 *   - Constant Contact inline form inside the popup (client request
 *     2026-11-18), signups go straight to their CC list "Website Form"
 *   - built-in single-email form as FALLBACK, used only if the CC form ID is
 *     cleared in settings
 *   - fm_subscriber post type (admin-only) that stores one post per email
 *     from the built-in form
 *   - Mailing List > Settings page (popup copy, timing, reCAPTCHA v3 keys)
 *   - admin-ajax endpoint `fm_subscribe` with layered spam protection
 *   - CSV export of the list
 *   - popup markup printed in wp_footer
 *
 * WHY THE ASSETS ARE NOT IN THE VITE BUILD: assets/css/style.css and
 * assets/js/main.js are compiled together from src/. Rebuilding them would
 * ship unrelated local-only work along with this feature, so the popup has
 * its own hand-written files in assets/mailing-list/ that load on their own.
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

const FM_ML_OPTION    = 'fm_mailing_list';
const FM_ML_POST_TYPE = 'fm_subscriber';

/**
 * Settings with defaults. The heading default is the client's own wording.
 *
 * @return array
 */
function fm_ml_settings() {
	$defaults = array(
		'enabled'          => 1,
		'heading'          => 'Get updates on the next event',
		'text'             => '',
		'button'           => 'Subscribe',
		'success'          => "You're on the list.",
		'delay'            => 12,
		'dismiss_days'     => 14,
		'recaptcha_site'   => '',
		'recaptcha_secret' => '',
		'recaptcha_min'    => 0.5,
		// Constant Contact "Active Forms" account key (`_ctct_m`) and the inline
		// form ID, from the client's CC embed code. Both are public values that
		// CC prints into every page that hosts the form; not secrets.
		'ctct_account'     => '91c91408bfb9a1598fff1209202fb8ad',
		'ctct_form'        => '7195b2de-da32-4238-a1d5-74e87349a1d4',
	);
	$saved = get_option( FM_ML_OPTION, array() );
	return wp_parse_args( is_array( $saved ) ? $saved : array(), $defaults );
}

/**
 * Constant Contact mode: both CC values present. CC then owns the list, the
 * fields and spam protection (it runs its own invisible reCAPTCHA v2).
 */
function fm_ml_ctct_enabled() {
	$s = fm_ml_settings();
	return '' !== $s['ctct_account'] && '' !== $s['ctct_form'];
}

/**
 * reCAPTCHA is on only when BOTH keys are saved. Until then the form runs on
 * honeypot + timing + rate limit, so it works the day it ships.
 */
function fm_ml_recaptcha_enabled() {
	$s = fm_ml_settings();
	return '' !== $s['recaptcha_site'] && '' !== $s['recaptcha_secret'];
}

// ─── Post type ───────────────────────────────────────────────────────────────

/**
 * Subscribers are personal data, so every capability maps to manage_options
 * (administrators only). Editors and authors never see the list.
 * create_posts is blocked: rows only come from the public form, which keeps
 * the "signed up" date and source honest.
 */
function fm_ml_register_post_type() {
	$admin = 'manage_options';
	register_post_type(
		FM_ML_POST_TYPE,
		array(
			'labels'          => array(
				'name'               => __( 'Mailing List', 'frenchmen' ),
				'singular_name'      => __( 'Subscriber', 'frenchmen' ),
				'menu_name'          => __( 'Mailing List', 'frenchmen' ),
				'all_items'          => __( 'Subscribers', 'frenchmen' ),
				'edit_item'          => __( 'Subscriber', 'frenchmen' ),
				'search_items'       => __( 'Search subscribers', 'frenchmen' ),
				'not_found'          => __( 'No subscribers yet', 'frenchmen' ),
				'not_found_in_trash' => __( 'No subscribers in trash', 'frenchmen' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'show_in_rest'    => false,
			'menu_icon'       => 'dashicons-email-alt',
			'menu_position'   => 26,
			'supports'        => array( 'title' ),
			'map_meta_cap'    => false,
			'capabilities'    => array(
				'edit_post'              => $admin,
				'read_post'              => $admin,
				'delete_post'            => $admin,
				'edit_posts'             => $admin,
				'edit_others_posts'      => $admin,
				'edit_published_posts'   => $admin,
				'publish_posts'          => $admin,
				'read_private_posts'     => $admin,
				'delete_posts'           => $admin,
				'delete_others_posts'    => $admin,
				'delete_published_posts' => $admin,
				'create_posts'           => 'do_not_allow',
			),
			'has_archive'     => false,
			'rewrite'         => false,
			'query_var'       => false,
		)
	);
}
add_action( 'init', 'fm_ml_register_post_type' );

/**
 * List columns: Email (title), Signed up, Source page.
 */
function fm_ml_columns( $columns ) {
	return array(
		'cb'        => $columns['cb'],
		'title'     => __( 'Email', 'frenchmen' ),
		'fm_date'   => __( 'Signed up', 'frenchmen' ),
		'fm_source' => __( 'Signed up on', 'frenchmen' ),
	);
}
add_filter( 'manage_' . FM_ML_POST_TYPE . '_posts_columns', 'fm_ml_columns' );

function fm_ml_column_values( $column, $post_id ) {
	if ( 'fm_date' === $column ) {
		echo esc_html( get_the_date( 'M j, Y g:i a', $post_id ) );
	} elseif ( 'fm_source' === $column ) {
		echo esc_html( get_post_meta( $post_id, '_fm_sub_source', true ) ?: '/' );
	}
}
add_action( 'manage_' . FM_ML_POST_TYPE . '_posts_custom_column', 'fm_ml_column_values', 10, 2 );

/**
 * Hide "Edit" and "Quick Edit" row actions: an email is not something an
 * admin should silently rewrite. Trash stays (acts as unsubscribe).
 */
function fm_ml_row_actions( $actions, $post ) {
	if ( FM_ML_POST_TYPE === $post->post_type ) {
		unset( $actions['edit'], $actions['inline hide-if-no-js'], $actions['view'] );
	}
	return $actions;
}
add_filter( 'post_row_actions', 'fm_ml_row_actions', 10, 2 );

/**
 * Export button beside the list filters.
 */
function fm_ml_export_button( $which ) {
	$screen = get_current_screen();
	if ( 'top' !== $which || ! $screen || 'edit-' . FM_ML_POST_TYPE !== $screen->id ) {
		return;
	}
	$url = wp_nonce_url( admin_url( 'admin-post.php?action=fm_ml_export' ), 'fm_ml_export' );
	printf(
		'<div class="alignleft actions"><a href="%s" class="button button-primary">%s</a></div>',
		esc_url( $url ),
		esc_html__( 'Export CSV', 'frenchmen' )
	);
}
add_action( 'manage_posts_extra_tablenav', 'fm_ml_export_button' );

/**
 * Stream every published subscriber as CSV.
 *
 * Values that start with = + - @ (or tab/CR) get a leading apostrophe, so a
 * crafted "email" cannot run as a formula when the file is opened in Excel or
 * Sheets (CSV injection). is_email() accepts some of those characters.
 */
function fm_ml_export_csv() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Not allowed.', 'frenchmen' ), 403 );
	}
	check_admin_referer( 'fm_ml_export' );

	$ids = get_posts(
		array(
			'post_type'      => FM_ML_POST_TYPE,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'ASC',
			'fields'         => 'ids',
			'no_found_rows'  => true,
		)
	);

	$safe = static function ( $value ) {
		$value = (string) $value;
		return preg_match( '/^[=+\-@\t\r]/', $value ) ? "'" . $value : $value;
	};

	nocache_headers();
	header( 'Content-Type: text/csv; charset=utf-8' );
	header( 'Content-Disposition: attachment; filename="frenchmen-mailing-list-' . gmdate( 'Y-m-d' ) . '.csv"' );

	$out = fopen( 'php://output', 'w' );
	fwrite( $out, "\xEF\xBB\xBF" ); // UTF-8 BOM so Excel reads accents correctly.
	fputcsv( $out, array( 'email', 'signed_up', 'signed_up_on' ) );
	foreach ( $ids as $id ) {
		fputcsv(
			$out,
			array(
				$safe( get_the_title( $id ) ),
				get_the_date( 'Y-m-d H:i:s', $id ),
				$safe( get_post_meta( $id, '_fm_sub_source', true ) ?: '/' ),
			)
		);
	}
	fclose( $out );
	exit;
}
add_action( 'admin_post_fm_ml_export', 'fm_ml_export_csv' );

// ─── Settings page ───────────────────────────────────────────────────────────

function fm_ml_settings_menu() {
	add_submenu_page(
		'edit.php?post_type=' . FM_ML_POST_TYPE,
		__( 'Mailing List Settings', 'frenchmen' ),
		__( 'Settings', 'frenchmen' ),
		'manage_options',
		'fm-mailing-list',
		'fm_ml_settings_page'
	);
}
add_action( 'admin_menu', 'fm_ml_settings_menu' );

function fm_ml_register_setting() {
	register_setting(
		'fm_mailing_list',
		FM_ML_OPTION,
		array(
			'type'              => 'array',
			'sanitize_callback' => 'fm_ml_sanitize_settings',
		)
	);
}
add_action( 'admin_init', 'fm_ml_register_setting' );

/**
 * The secret key field is rendered empty (never echoed back into the page).
 * Leaving it blank on save keeps the stored secret; ticking "remove" clears it.
 */
function fm_ml_sanitize_settings( $input ) {
	$old = fm_ml_settings();
	$in  = is_array( $input ) ? $input : array();

	$secret = isset( $in['recaptcha_secret'] ) ? trim( sanitize_text_field( $in['recaptcha_secret'] ) ) : '';
	if ( '' === $secret ) {
		$secret = $old['recaptcha_secret'];
	}
	if ( ! empty( $in['recaptcha_secret_clear'] ) ) {
		$secret = '';
	}

	return array(
		'enabled'          => empty( $in['enabled'] ) ? 0 : 1,
		'heading'          => sanitize_text_field( $in['heading'] ?? '' ),
		'text'             => sanitize_textarea_field( $in['text'] ?? '' ),
		'button'           => sanitize_text_field( $in['button'] ?? '' ) ?: 'Subscribe',
		'success'          => sanitize_text_field( $in['success'] ?? '' ) ?: "You're on the list.",
		'delay'            => max( 0, min( 120, (int) ( $in['delay'] ?? 12 ) ) ),
		'dismiss_days'     => max( 0, min( 365, (int) ( $in['dismiss_days'] ?? 14 ) ) ),
		'recaptcha_site'   => trim( sanitize_text_field( $in['recaptcha_site'] ?? '' ) ),
		'recaptcha_secret' => $secret,
		'recaptcha_min'    => max( 0.1, min( 0.9, round( (float) ( $in['recaptcha_min'] ?? 0.5 ), 1 ) ) ),
		// Validate the exact format; a malformed value keeps the old one. (Stripping
		// bad characters instead was tried and silently produced a wrong-but-valid-
		// looking ID, which breaks the form with no error.) Empty = switch off.
		'ctct_account'     => fm_ml_valid_id( $in['ctct_account'] ?? '', '/^[a-f0-9]{32}$/i', $old['ctct_account'], 'account key' ),
		'ctct_form'        => fm_ml_valid_id( $in['ctct_form'] ?? '', '/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/i', $old['ctct_form'], 'form ID' ),
	);
}

/**
 * Return $value if empty or matching $pattern; otherwise keep $old and flag it.
 */
function fm_ml_valid_id( $value, $pattern, $old, $label ) {
	$value = trim( (string) $value );
	if ( '' === $value || preg_match( $pattern, $value ) ) {
		return strtolower( $value );
	}
	add_settings_error(
		FM_ML_OPTION,
		'fm_ml_bad_' . sanitize_key( $label ),
		/* translators: %s: field name */
		sprintf( __( 'That Constant Contact %s does not look right, so the previous value was kept.', 'frenchmen' ), $label )
	);
	return $old;
}

function fm_ml_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$s    = fm_ml_settings();
	$name = FM_ML_OPTION;
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Mailing List Settings', 'frenchmen' ); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'fm_mailing_list' ); ?>

			<h2><?php esc_html_e( 'Popup', 'frenchmen' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Show popup', 'frenchmen' ); ?></th>
					<td><label><input type="checkbox" name="<?php echo esc_attr( $name ); ?>[enabled]" value="1" <?php checked( $s['enabled'], 1 ); ?>> <?php esc_html_e( 'Open the popup automatically', 'frenchmen' ); ?></label>
					<p class="description"><?php esc_html_e( 'Unticked, the popup only opens from the "Get event updates" link in the footer.', 'frenchmen' ); ?></p></td>
				</tr>
				<tr>
					<th scope="row"><label for="fm-ml-heading"><?php esc_html_e( 'Heading', 'frenchmen' ); ?></label></th>
					<td><input id="fm-ml-heading" class="regular-text" type="text" name="<?php echo esc_attr( $name ); ?>[heading]" value="<?php echo esc_attr( $s['heading'] ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="fm-ml-text"><?php esc_html_e( 'Text under heading', 'frenchmen' ); ?></label></th>
					<td><textarea id="fm-ml-text" class="large-text" rows="2" name="<?php echo esc_attr( $name ); ?>[text]"><?php echo esc_textarea( $s['text'] ); ?></textarea>
					<p class="description"><?php esc_html_e( 'Optional. Leave empty to show the heading only.', 'frenchmen' ); ?></p></td>
				</tr>
				<tr>
					<th scope="row"><label for="fm-ml-button"><?php esc_html_e( 'Button label', 'frenchmen' ); ?></label></th>
					<td><input id="fm-ml-button" type="text" name="<?php echo esc_attr( $name ); ?>[button]" value="<?php echo esc_attr( $s['button'] ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="fm-ml-success"><?php esc_html_e( 'Thank-you message', 'frenchmen' ); ?></label></th>
					<td><input id="fm-ml-success" class="regular-text" type="text" name="<?php echo esc_attr( $name ); ?>[success]" value="<?php echo esc_attr( $s['success'] ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="fm-ml-delay"><?php esc_html_e( 'Open after (seconds)', 'frenchmen' ); ?></label></th>
					<td><input id="fm-ml-delay" type="number" min="0" max="120" name="<?php echo esc_attr( $name ); ?>[delay]" value="<?php echo esc_attr( $s['delay'] ); ?>">
					<p class="description"><?php esc_html_e( 'Or when the visitor scrolls halfway down the page, whichever comes first.', 'frenchmen' ); ?></p></td>
				</tr>
				<tr>
					<th scope="row"><label for="fm-ml-dismiss"><?php esc_html_e( 'After closing, hide for (days)', 'frenchmen' ); ?></label></th>
					<td><input id="fm-ml-dismiss" type="number" min="0" max="365" name="<?php echo esc_attr( $name ); ?>[dismiss_days]" value="<?php echo esc_attr( $s['dismiss_days'] ); ?>">
					<p class="description"><?php esc_html_e( 'Visitors who subscribe never see it open automatically again.', 'frenchmen' ); ?></p></td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Constant Contact form', 'frenchmen' ); ?></h2>
			<p><?php
				printf(
					/* translators: %s: status */
					esc_html__( 'Status: %s', 'frenchmen' ),
					fm_ml_ctct_enabled()
						? '<strong style="color:#008a20">' . esc_html__( 'On. The popup shows the Constant Contact form and signups go to Constant Contact.', 'frenchmen' ) . '</strong>'
						: '<strong>' . esc_html__( 'Off. The popup uses the built-in email form below.', 'frenchmen' ) . '</strong>'
				);
			?></p>
			<p class="description"><?php esc_html_e( 'Fields, list and thank-you message for this form are edited in Constant Contact (Sign-up Forms). The popup heading above still shows.', 'frenchmen' ); ?></p>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="fm-ml-ctct-account"><?php esc_html_e( 'Account key (_ctct_m)', 'frenchmen' ); ?></label></th>
					<td><input id="fm-ml-ctct-account" class="regular-text code" type="text" name="<?php echo esc_attr( $name ); ?>[ctct_account]" value="<?php echo esc_attr( $s['ctct_account'] ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="fm-ml-ctct-form"><?php esc_html_e( 'Inline form ID', 'frenchmen' ); ?></label></th>
					<td><input id="fm-ml-ctct-form" class="regular-text code" type="text" name="<?php echo esc_attr( $name ); ?>[ctct_form]" value="<?php echo esc_attr( $s['ctct_form'] ); ?>">
					<p class="description"><?php esc_html_e( 'Clear this to switch back to the built-in form.', 'frenchmen' ); ?></p></td>
				</tr>
			</table>

			<h2><?php esc_html_e( 'Built-in form: Google reCAPTCHA v3', 'frenchmen' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Only used when the Constant Contact form is off.', 'frenchmen' ); ?></p>
			<p><?php
				printf(
					/* translators: %s: status */
					esc_html__( 'Status: %s', 'frenchmen' ),
					fm_ml_recaptcha_enabled()
						? '<strong style="color:#008a20">' . esc_html__( 'On', 'frenchmen' ) . '</strong>'
						: '<strong style="color:#b32d2e">' . esc_html__( 'Off (add both keys to turn on)', 'frenchmen' ) . '</strong>'
				);
			?></p>
			<p class="description"><?php esc_html_e( 'Create v3 keys at google.com/recaptcha/admin for frenchmenparty.com. The form also uses a hidden trap field, a fill-time check and a per-visitor rate limit, with or without reCAPTCHA.', 'frenchmen' ); ?></p>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="fm-ml-site"><?php esc_html_e( 'Site key', 'frenchmen' ); ?></label></th>
					<td><input id="fm-ml-site" class="regular-text code" type="text" autocomplete="off" name="<?php echo esc_attr( $name ); ?>[recaptcha_site]" value="<?php echo esc_attr( $s['recaptcha_site'] ); ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="fm-ml-secret"><?php esc_html_e( 'Secret key', 'frenchmen' ); ?></label></th>
					<td>
						<input id="fm-ml-secret" class="regular-text code" type="password" autocomplete="new-password" name="<?php echo esc_attr( $name ); ?>[recaptcha_secret]" value="" placeholder="<?php echo $s['recaptcha_secret'] ? esc_attr__( 'Saved (leave blank to keep)', 'frenchmen' ) : ''; ?>">
						<?php if ( $s['recaptcha_secret'] ) : ?>
							<p><label><input type="checkbox" name="<?php echo esc_attr( $name ); ?>[recaptcha_secret_clear]" value="1"> <?php esc_html_e( 'Remove saved secret key', 'frenchmen' ); ?></label></p>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="fm-ml-min"><?php esc_html_e( 'Minimum score', 'frenchmen' ); ?></label></th>
					<td><input id="fm-ml-min" type="number" min="0.1" max="0.9" step="0.1" name="<?php echo esc_attr( $name ); ?>[recaptcha_min]" value="<?php echo esc_attr( $s['recaptcha_min'] ); ?>">
					<p class="description"><?php esc_html_e( '0.5 is Google\'s recommended starting point. Raise it if spam gets through; lower it if real people are blocked.', 'frenchmen' ); ?></p></td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

// ─── Subscribe endpoint ──────────────────────────────────────────────────────

/**
 * Client IP for rate limiting only (never stored).
 *
 * Cloudways puts Varnish/nginx in front of PHP, so REMOTE_ADDR can be the
 * proxy's loopback address for every visitor. In that case we use the first
 * X-Forwarded-For hop. It is spoofable, which is acceptable here: it only
 * decides whose bucket an attempt counts against, and reCAPTCHA plus the
 * honeypot do the real filtering.
 */
function fm_ml_client_ip() {
	$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$public = filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE );
	if ( ! $public && ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$first = trim( explode( ',', sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) )[0] );
		if ( filter_var( $first, FILTER_VALIDATE_IP ) ) {
			$ip = $first;
		}
	}
	return $ip;
}

/**
 * Verify a reCAPTCHA v3 token. Fails CLOSED: if Google cannot be reached we
 * reject rather than let unverified posts in, since spam protection was the
 * explicit requirement. The visitor is told to try again.
 *
 * @return true|string True or an error code.
 */
function fm_ml_verify_recaptcha( $token ) {
	if ( '' === $token ) {
		return 'captcha_missing';
	}
	$s   = fm_ml_settings();
	$res = wp_remote_post(
		'https://www.google.com/recaptcha/api/siteverify',
		array(
			'timeout' => 8,
			'body'    => array(
				'secret'   => $s['recaptcha_secret'],
				'response' => $token,
			),
		)
	);
	if ( is_wp_error( $res ) ) {
		return 'captcha_unreachable';
	}
	$body = json_decode( wp_remote_retrieve_body( $res ), true );
	if ( empty( $body['success'] ) ) {
		return 'captcha_failed';
	}
	// Action must match what the JS requested, or a token minted for another
	// form/site could be replayed here.
	if ( ( $body['action'] ?? '' ) !== 'fm_subscribe' ) {
		return 'captcha_action';
	}
	if ( (float) ( $body['score'] ?? 0 ) < (float) $s['recaptcha_min'] ) {
		return 'captcha_low_score';
	}
	return true;
}

/**
 * Handle a signup.
 *
 * NO WP NONCE, ON PURPOSE: Breeze caches the page HTML, so a nonce printed into
 * it goes stale after ~12-24h and would silently break the form for every
 * visitor served the cached page. For logged-out visitors a nonce is a shared
 * token anyway, not real CSRF protection, and the worst a forged request can
 * do is add an email someone could type in themselves. Spam is handled by the
 * layers below instead.
 */
function fm_ml_handle_subscribe() {
	$fail = static function ( $code, $message, $status = 400 ) {
		wp_send_json_error( array( 'code' => $code, 'message' => $message ), $status );
	};
	$generic = __( 'Something went wrong. Please try again.', 'frenchmen' );

	// 1. Rate limit: 5 attempts per IP per 10 minutes, counted before any
	//    other check so bots probing the endpoint are throttled too.
	$key   = 'fm_ml_rl_' . md5( wp_salt( 'nonce' ) . fm_ml_client_ip() );
	$count = (int) get_transient( $key );
	if ( $count >= 5 ) {
		$fail( 'rate_limited', __( 'Too many attempts. Please wait a few minutes and try again.', 'frenchmen' ), 429 );
	}
	set_transient( $key, $count + 1, 10 * MINUTE_IN_SECONDS );

	// 2. Honeypot: humans never see or fill this field. Pretend success so the
	//    bot has no signal to adapt to; nothing is saved.
	if ( ! empty( $_POST['fm_website'] ) ) {
		wp_send_json_success( array( 'message' => fm_ml_settings()['success'] ) );
	}

	// 3. Timing: JS reports how long the popup was open. Under 2s is a script.
	$elapsed = isset( $_POST['fm_elapsed'] ) ? (int) $_POST['fm_elapsed'] : 0;
	if ( $elapsed < 2000 ) {
		$fail( 'too_fast', $generic );
	}

	// 4. Email.
	$raw   = isset( $_POST['email'] ) ? wp_unslash( $_POST['email'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitized next line.
	$email = strtolower( sanitize_email( $raw ) );
	if ( '' === $email || strlen( $email ) > 254 || ! is_email( $email ) ) {
		$fail( 'invalid_email', __( 'Please enter a valid email address.', 'frenchmen' ) );
	}

	// 5. reCAPTCHA v3 (only once keys are configured).
	if ( fm_ml_recaptcha_enabled() ) {
		$token  = isset( $_POST['token'] ) ? sanitize_text_field( wp_unslash( $_POST['token'] ) ) : '';
		$result = fm_ml_verify_recaptcha( $token );
		if ( true !== $result ) {
			$fail( $result, $generic, 403 );
		}
	}

	// 6. Save. A repeat signup gets the same success reply as a new one, so the
	//    form cannot be used to check whether an address is on the list.
	$existing = get_posts(
		array(
			'post_type'      => FM_ML_POST_TYPE,
			'post_status'    => array( 'publish', 'trash' ),
			'title'          => $email,
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
		)
	);

	if ( $existing ) {
		// Trashed = removed by an admin. Signing up again is a fresh opt-in.
		if ( 'trash' === get_post_status( $existing[0] ) ) {
			wp_untrash_post( $existing[0] );
			wp_update_post( array( 'ID' => $existing[0], 'post_status' => 'publish' ) );
		}
	} else {
		$source = isset( $_POST['source'] ) ? wp_parse_url( esc_url_raw( wp_unslash( $_POST['source'] ) ), PHP_URL_PATH ) : '';
		$id     = wp_insert_post(
			array(
				'post_type'   => FM_ML_POST_TYPE,
				'post_status' => 'publish',
				'post_title'  => $email,
			),
			true
		);
		if ( is_wp_error( $id ) ) {
			$fail( 'save_failed', $generic, 500 );
		}
		update_post_meta( $id, '_fm_sub_source', $source ? substr( $source, 0, 200 ) : '/' );
	}

	wp_send_json_success( array( 'message' => fm_ml_settings()['success'] ) );
}
add_action( 'wp_ajax_fm_subscribe', 'fm_ml_handle_subscribe' );
add_action( 'wp_ajax_nopriv_fm_subscribe', 'fm_ml_handle_subscribe' );

// ─── Front end ───────────────────────────────────────────────────────────────

function fm_ml_enqueue() {
	$s   = fm_ml_settings();
	$css = FM_THEME_DIR . '/assets/mailing-list/subscribe.css';
	$js  = FM_THEME_DIR . '/assets/mailing-list/subscribe.js';

	// filemtime as version so a deploy busts browser + Breeze caches without
	// touching FM_THEME_VERSION (which would also re-version style.css).
	wp_enqueue_style( 'fm-subscribe', FM_THEME_URI . '/assets/mailing-list/subscribe.css', array(), (string) filemtime( $css ) );
	wp_enqueue_script(
		'fm-subscribe',
		FM_THEME_URI . '/assets/mailing-list/subscribe.js',
		array(),
		(string) filemtime( $js ),
		array(
			'strategy'  => 'defer',
			'in_footer' => true,
		)
	);
	wp_localize_script(
		'fm-subscribe',
		'fmSubscribe',
		array(
			'ajaxUrl'     => admin_url( 'admin-ajax.php' ),
			'auto'        => (int) $s['enabled'],
			'delay'       => (int) $s['delay'],
			'dismissDays' => (int) $s['dismiss_days'],
			// Site key is public by design; the secret never leaves the server.
			'siteKey'     => ( ! fm_ml_ctct_enabled() && fm_ml_recaptcha_enabled() ) ? $s['recaptcha_site'] : '',
			'ctctAccount' => fm_ml_ctct_enabled() ? $s['ctct_account'] : '',
			'ctctScript'  => 'https://static.ctctcdn.com/js/signup-form-widget/current/signup-form-widget.min.js',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'fm_ml_enqueue' );

/**
 * Popup markup. Native <dialog> + showModal() gives focus trapping, Escape to
 * close and inert background for free, which is more robust than a hand-made
 * modal.
 */
function fm_ml_render_popup() {
	$s = fm_ml_settings();
	?>
	<?php
	/*
	 * Opened NON-modal (dialog.show(), not showModal()). Constant Contact's
	 * invisible reCAPTCHA appends its image challenge to <body>; a modal
	 * dialog makes everything outside it inert, so that challenge would be
	 * unclickable and real people could never finish signing up. Modal
	 * behaviour (backdrop, focus trap, Escape, scroll lock) is done in
	 * subscribe.js instead.
	 */
	?>
	<div class="fm-subscribe-backdrop" data-fm-subscribe-close hidden></div>
	<dialog class="fm-subscribe" id="fm-subscribe" aria-labelledby="fm-subscribe-title" aria-modal="true">
		<div class="fm-subscribe__panel">
			<button type="button" class="fm-subscribe__close" data-fm-subscribe-close aria-label="<?php esc_attr_e( 'Close', 'frenchmen' ); ?>">
				<svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true" focusable="false"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
			</button>

			<h2 class="fm-subscribe__title" id="fm-subscribe-title"><?php echo esc_html( $s['heading'] ); ?></h2>
			<?php if ( $s['text'] ) : ?>
				<p class="fm-subscribe__text"><?php echo esc_html( $s['text'] ); ?></p>
			<?php endif; ?>

			<?php if ( fm_ml_ctct_enabled() ) : ?>
				<?php
				/*
				 * Constant Contact inline form. The CC script is injected by
				 * subscribe.js on first open (not on every page view), finds this
				 * div and renders the form into it.
				 */
				?>
				<div class="fm-subscribe__ctct">
					<div class="ctct-inline-form" data-form-id="<?php echo esc_attr( $s['ctct_form'] ); ?>"></div>
					<p class="fm-subscribe__status" role="status" aria-live="polite"></p>
				</div>
			<?php else : ?>
				<form class="fm-subscribe__form" novalidate>
					<label class="screen-reader-text" for="fm-subscribe-email"><?php esc_html_e( 'Email address', 'frenchmen' ); ?></label>
					<div class="fm-subscribe__row">
						<input class="fm-subscribe__input" id="fm-subscribe-email" type="email" name="email" required maxlength="254" autocomplete="email" inputmode="email" placeholder="<?php esc_attr_e( 'Your email', 'frenchmen' ); ?>" aria-describedby="fm-subscribe-status">
						<button class="fm-btn fm-btn--primary fm-subscribe__submit" type="submit"><?php echo esc_html( $s['button'] ); ?></button>
					</div>

					<?php /* Honeypot: off-screen, unfocusable, ignored by password managers. */ ?>
					<div class="fm-subscribe__hp" aria-hidden="true">
						<label for="fm-subscribe-website">Website</label>
						<input id="fm-subscribe-website" type="text" name="fm_website" tabindex="-1" autocomplete="off">
					</div>

					<p class="fm-subscribe__status" id="fm-subscribe-status" role="status" aria-live="polite"></p>
				</form>

			<?php endif; ?>

			<?php if ( fm_ml_ctct_enabled() || fm_ml_recaptcha_enabled() ) : ?>
				<?php /* Google requires this notice when the floating badge is hidden (CC's form uses reCAPTCHA too). */ ?>
				<p class="fm-subscribe__legal">
					This site is protected by reCAPTCHA and the Google
					<a href="https://policies.google.com/privacy" target="_blank" rel="noopener">Privacy Policy</a> and
					<a href="https://policies.google.com/terms" target="_blank" rel="noopener">Terms of Service</a> apply.
				</p>
			<?php endif; ?>
		</div>
	</dialog>
	<?php
}
add_action( 'wp_footer', 'fm_ml_render_popup', 5 );
