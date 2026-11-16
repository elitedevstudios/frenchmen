<?php
/**
 * Template Name: Food Court
 * Template Post Type: page
 *
 * @package Frenchmen
 */

defined( 'ABSPATH' ) || exit;

get_header();

/*
 * Frenchmen Weekend 2026 food court menus, one set of station signs per party.
 *
 * Source: the client's printed sign artwork ("Frenchmen weekend 26 signs",
 * supplied 2026-10-15). Station names and items below are transcribed from
 * those signs word for word; they double as each sign's alt text, because the
 * menu itself is baked into the image pixels and is otherwise invisible to
 * screen readers and search. If a sign changes, change the matching items here.
 *
 * Parties are listed in event order (Rise Up -> NiteCap -> Foreplay), matching
 * the homepage. "NiteCap" is the spelling the site and the signs use.
 */
$fm_menu_dir = '2026/10/food-court/';

$parties = array(
	array(
		'slug'     => 'rise-up',
		'name'     => 'Rise Up',
		'stations' => array(
			array( 'The Sunny Side', 'rise-up-the-sunny-side.jpg', array( 'Overnight oats', 'Foska smoothie', 'Elle & Vire yogurts', 'Hungry Jack pancakes and waffles', 'Kisko Freezies' ) ),
			array( 'Sunrise Diner', 'rise-up-sunrise-diner.jpg', array( 'Corn beef fritters', 'Sausage, tomatoes and onions', 'Tostones', 'Hardo bread' ) ),
			array( 'Salt and Pepper Shack', 'rise-up-salt-and-pepper-shack.jpg', array( 'Escoveitch fish fillet', 'BBQ pigs tail', 'Sweet potato salad', 'Fried bammy' ) ),
			array( 'The Dutch Pot', 'rise-up-the-dutch-pot.jpg', array( 'Brown stew chicken', 'Broad bean and pickled herring rundown', 'Boiled dumpling and yam', 'White rice' ) ),
			array( 'The Golden Basket', 'rise-up-the-golden-basket.jpg', array( 'Barbi fried chicken', 'Cabbage and saltfish', 'Festival', 'Tostones' ) ),
			array( 'The Palm Bistro', 'rise-up-the-palm-bistro.jpg', array( 'Jerk shrimp pasta', 'Braised pork in red wine', 'White rice', 'Assorted sauteed vegetables in thyme butter' ) ),
			array( 'Morning Glory', 'rise-up-morning-glory.jpg', array( 'Baked goods', 'Assorted fruits' ) ),
			array( 'Tea', 'rise-up-tea.jpg', array( 'Assorted teas' ) ),
		),
	),
	array(
		'slug'     => 'nitecap',
		'name'     => 'NiteCap',
		'stations' => array(
			array( 'The Golden Palm', 'nitecap-the-golden-palm.jpg', array( 'Grilled chicken, citrus sazón rub', 'Panko crusted fish, mango chutney', 'Potato salad, shrimp, corn and peas', 'Seasoned rice' ) ),
			array( 'Sunset Grill', 'nitecap-sunset-grill.jpg', array( 'Spicy stewed pork, broad beans', 'Red Stripe BBQ chicken', 'Seasoned rice', 'Assorted sauteed veg' ) ),
			array( 'Moonlight Diner', 'nitecap-moonlight-diner.jpg', array( 'Crispy shrimp with remoulade', 'Pasta primavera with spicy coconut sauce', 'Cajun fries', 'Assorted bread basket' ) ),
			array( 'Neon Noodles', 'nitecap-neon-noodles.jpg', array( 'Grilled chicken thighs with sticky Asian glaze', 'Pork katsu', 'Spicy peanut satay noodles', 'Asian cucumber salad' ) ),
			array( 'Chopsticks Cove', 'nitecap-chopsticks-cove.jpg', array( 'Pork katsu', 'Red Stripe BBQ chicken', 'Pasta primavera with spicy coconut sauce', 'Cajun fries' ) ),
			array( 'Midnight Kitchen', 'nitecap-midnight-kitchen.jpg', array( 'Pumpkin beef soup', 'Assorted bread basket' ) ),
		),
	),
	array(
		'slug'     => 'foreplay',
		'name'     => 'Foreplay',
		'stations' => array(
			array( 'Smoke Shack', 'foreplay-smoke-shack.jpg', array( 'Jerk pork', 'Jerk chicken', 'French fries', 'Hardo bread' ) ),
			array( 'The Pepper Pot', 'foreplay-the-pepper-pot.jpg', array( 'Curry goat', 'Coconut curry shrimp', 'White rice', 'Roast breadfruit' ) ),
			array( 'Golden Wok', 'foreplay-golden-wok.jpg', array( 'Pork in spicy black bean sauce', 'Kung pao chicken', 'Shrimp fried rice', 'Vegetable chow mein' ) ),
			array( 'The Breakfast Club', 'foreplay-the-breakfast-club.jpg', array( 'Seafood run down (fish, shrimp, lobster)', 'Fried chicken', 'Roast breadfruit', 'Fried dumpling' ) ),
			array( 'La Dolce Shore', 'foreplay-la-dolce-shore.jpg', array( 'Tortellini in rosé sauce', 'Shrimp scampi', 'Garden salad with red wine vinaigrette', 'Assorted rolls' ) ),
			array( 'Poolside Diner', 'foreplay-poolside-diner.jpg', array( 'Beer battered fish fillet', 'Fried chicken', 'French fries', 'Corn with garlic butter' ) ),
			array( 'The Good Earth', 'foreplay-the-good-earth.jpg', array( 'Curried chick peas', 'Vegetable fritters in harissa honey sauce', 'White rice', 'Garden salad with red wine vinaigrette' ) ),
			array( 'The Tamarind Terrace', 'foreplay-the-tamarind-terrace.jpg', array( 'Shrimp with scotch bonnet rum glaze', 'Sticky tamarind pork', 'Rice and peas', 'Fried plantain' ) ),
			array( 'Comfort Cove', 'foreplay-comfort-cove.jpg', array( 'Hearty seafood soup', 'Chicken soup', 'Bread basket: dinner rolls', 'Bread basket: hard rolls' ) ),
		),
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
		<?php
		/*
		 * Tabs are progressive enhancement: without JS every party panel renders
		 * one after another with its own heading, so nothing is ever unreachable.
		 * The tablist starts [hidden] and the script below reveals it.
		 */
		?>
		<div class="fm-foodcourt__tabs" role="tablist" aria-label="Choose a party" hidden>
			<?php foreach ( $parties as $p_index => $party ) : ?>
				<button type="button" class="fm-foodcourt__tab" role="tab"
					id="fm-tab-<?php echo esc_attr( $party['slug'] ); ?>"
					aria-controls="fm-panel-<?php echo esc_attr( $party['slug'] ); ?>"
					aria-selected="<?php echo 0 === $p_index ? 'true' : 'false'; ?>"
					tabindex="<?php echo 0 === $p_index ? '0' : '-1'; ?>">
					<?php echo esc_html( $party['name'] ); ?>
				</button>
			<?php endforeach; ?>
		</div>

		<?php
		/*
		 * Pick the active party BEFORE the panels are parsed. On live the page
		 * streams in chunks, so if panels start visible and the tab script at the
		 * bottom hides them later, the browser has already begun lazy-loading
		 * every party's signs (measured: all 23 fetched instead of one party's).
		 * This script and style sit above the panels so inactive ones never
		 * render. Without JS, .has-tabs is never added and every panel shows.
		 */
		?>
		<style>
			.fm-foodcourt.has-tabs .fm-foodcourt__panel { display: none; }
			<?php foreach ( $parties as $party ) : ?>
			.fm-foodcourt[data-active="<?php echo esc_attr( $party['slug'] ); ?>"] #fm-panel-<?php echo esc_attr( $party['slug'] ); ?> { display: block; }
			<?php endforeach; ?>
		</style>
		<script>
		( function () {
			var section = document.querySelector( '.fm-foodcourt' );
			var active = location.hash.slice( 1 );
			if ( ! document.getElementById( 'fm-tab-' + active ) ) {
				active = '<?php echo esc_js( $parties[0]['slug'] ); ?>';
			}
			section.classList.add( 'has-tabs' );
			section.setAttribute( 'data-active', active );
		} )();
		</script>

		<?php foreach ( $parties as $party ) : ?>
			<div class="fm-foodcourt__panel" id="fm-panel-<?php echo esc_attr( $party['slug'] ); ?>" role="tabpanel" aria-labelledby="fm-tab-<?php echo esc_attr( $party['slug'] ); ?>">
				<h2 class="fm-foodcourt__party-title"><?php echo esc_html( $party['name'] ); ?> Menu</h2>
				<div class="fm-foodcourt__grid">
					<?php foreach ( $party['stations'] as $index => $station ) : ?>
						<?php
						list( $station_name, $station_file, $station_items ) = $station;
						$station_src = fm_upload( $fm_menu_dir . $station_file );
						$station_alt = $station_name . ' menu: ' . implode( ', ', $station_items ) . '.';
						?>
						<article class="fm-foodcourt__card fm-animate" data-animation="fade-up" data-delay="<?php echo esc_attr( ( $index % 6 ) * 50 ); ?>">
							<a class="fm-foodcourt__card-image" href="<?php echo esc_url( $station_src ); ?>" target="_blank" rel="noopener">
								<?php
								/*
								 * Grid shows a 640px WebP (~50 KB): cards render at most ~344 CSS px,
								 * so 640 covers 2x screens. The 864px original JPEG (~250 KB) is the
								 * <img> fallback and the full-size tap-through. Each "-640.webp" is made
								 * from its JPEG with: cwebp -q 82 -resize 640 0 in.jpg -o in-640.webp
								 */
								?>
								<picture>
									<source type="image/webp" srcset="<?php echo esc_url( fm_upload( $fm_menu_dir . str_replace( '.jpg', '-640.webp', $station_file ) ) ); ?>">
									<img src="<?php echo esc_url( $station_src ); ?>" alt="<?php echo esc_attr( $station_alt ); ?>" width="640" height="1280" loading="lazy" decoding="async">
								</picture>
								<span class="fm-visually-hidden">(opens full-size sign in a new tab)</span>
							</a>
							<h3 class="fm-foodcourt__card-title"><?php echo esc_html( $station_name ); ?></h3>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<script>
( function () {
	var tablist = document.querySelector( '.fm-foodcourt__tabs' );
	if ( ! tablist ) {
		return;
	}
	var tabs = Array.prototype.slice.call( tablist.querySelectorAll( '[role="tab"]' ) );

	function select( tab, focus ) {
		tabs.forEach( function ( t ) {
			var on = t === tab;
			t.setAttribute( 'aria-selected', on ? 'true' : 'false' );
			t.tabIndex = on ? 0 : -1;
			document.getElementById( t.getAttribute( 'aria-controls' ) ).hidden = ! on;
		} );
		// data-active drives the early CSS above; it must track the selection too.
		document.querySelector( '.fm-foodcourt' ).setAttribute( 'data-active', tab.id.replace( 'fm-tab-', '' ) );
		if ( focus ) {
			tab.focus();
		}
		// Keep the chosen party in the URL so a menu can be linked directly.
		if ( history.replaceState ) {
			history.replaceState( null, '', '#' + tab.id.replace( 'fm-tab-', '' ) );
		}
	}

	tabs.forEach( function ( tab, i ) {
		tab.addEventListener( 'click', function () { select( tab, false ); } );
		tab.addEventListener( 'keydown', function ( e ) {
			var next = null;
			if ( 'ArrowRight' === e.key ) { next = tabs[ ( i + 1 ) % tabs.length ]; }
			if ( 'ArrowLeft' === e.key ) { next = tabs[ ( i - 1 + tabs.length ) % tabs.length ]; }
			if ( 'Home' === e.key ) { next = tabs[0]; }
			if ( 'End' === e.key ) { next = tabs[ tabs.length - 1 ]; }
			if ( next ) {
				e.preventDefault();
				select( next, true );
			}
		} );
	} );

	tablist.hidden = false;
	document.querySelector( '.fm-foodcourt' ).classList.add( 'has-tabs' );
	var fromHash = document.getElementById( 'fm-tab-' + location.hash.slice( 1 ) );
	select( fromHash || tabs[0], false );
} )();
</script>

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

.fm-foodcourt__tabs {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: var(--fm-space-sm);
	margin-block-end: var(--fm-space-2xl);
}

.fm-foodcourt__tabs[hidden] {
	display: none;
}

.fm-foodcourt__tab {
	padding: var(--fm-space-sm) var(--fm-space-xl);
	border: 2px solid var(--fm-color-primary);
	border-radius: var(--fm-radius-full);
	background: transparent;
	color: var(--fm-color-text);
	font-family: inherit;
	font-size: var(--fm-font-size-lg);
	font-weight: 700;
	text-transform: uppercase;
	cursor: pointer;
	transition: background-color var(--fm-transition-fast), color var(--fm-transition-fast);
}

.fm-foodcourt__tab[aria-selected="true"] {
	background: var(--fm-color-primary);
	color: var(--fm-color-white);
}

.fm-foodcourt__tab:focus-visible {
	outline: 3px solid var(--fm-color-accent);
	outline-offset: 3px;
}

.fm-foodcourt__panel + .fm-foodcourt__panel {
	margin-block-start: var(--fm-space-4xl);
}

/* With tabs active only one panel shows, so drop the stacking gap and the
   party heading (the selected tab already names the party). */
.fm-foodcourt.has-tabs .fm-foodcourt__panel + .fm-foodcourt__panel {
	margin-block-start: 0;
}

.fm-foodcourt__party-title {
	margin-block-end: var(--fm-space-xl);
	font-size: var(--fm-font-size-3xl);
	font-weight: 900;
	text-align: center;
	text-transform: uppercase;
	color: var(--fm-color-text);
}

.fm-foodcourt.has-tabs .fm-foodcourt__party-title {
	position: absolute;
	inline-size: 1px;
	block-size: 1px;
	overflow: hidden;
	clip-path: inset(50%);
	white-space: nowrap;
}

.fm-foodcourt__card-image {
	display: block;
}

/*
 * Flex, not grid: station counts per party are uneven (8 / 6 / 9), and a
 * centred flex row keeps a short last row centred instead of stranding one
 * sign on the left. 2-up on phones (signs are tall 1:2 portraits and tap
 * through to full size), 4-up from 1024px.
 */
.fm-foodcourt__grid {
	display: flex;
	flex-wrap: wrap;
	justify-content: center;
	gap: var(--fm-space-md);
}

.fm-foodcourt__card {
	flex: 0 0 calc((100% - var(--fm-space-md)) / 2);
}

@media (min-width: 1024px) {
	.fm-foodcourt__grid {
		gap: var(--fm-space-xl);
	}

	.fm-foodcourt__card {
		flex-basis: calc((100% - 3 * var(--fm-space-xl)) / 4);
	}
}

@media (max-width: 479px) {
	.fm-foodcourt__tab {
		padding-inline: var(--fm-space-md);
		font-size: var(--fm-font-size-base);
	}

	/* Scoped to beat the base title rule, which is declared further down. */
	.fm-foodcourt .fm-foodcourt__card-title {
		padding: var(--fm-space-sm);
		font-size: var(--fm-font-size-base);
	}
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
	overflow: hidden;
}

.fm-foodcourt__card-image img {
	inline-size: 100%;
	block-size: auto;
	display: block;
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
