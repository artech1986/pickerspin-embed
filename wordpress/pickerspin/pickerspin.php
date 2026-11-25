<?php
/**
 * Plugin Name:       PickerSpin — Spin the Wheel
 * Plugin URI:        https://pickerspin.co/embed
 * Description:       Embed a free spin-the-wheel random name picker in any post or page. No account, no ads, no tracking. Use the [pickerspin] shortcode or paste a pickerspin.co link.
 * Version:           1.0.0
 * Requires at least: 5.8
 * Requires PHP:      7.2
 * Author:            PickerSpin
 * Author URI:        https://pickerspin.co/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       pickerspin
 *
 * The embed itself is a static 3KB page on pickerspin.co. This plugin only
 * makes it reachable two ways WordPress users expect: pasting a link, and a
 * shortcode. It loads no scripts or styles of its own.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'PICKERSPIN_SITE', 'https://pickerspin.co' );

/**
 * Register the oEmbed provider.
 *
 * WordPress would find our endpoint through discovery anyway, but registering
 * it explicitly skips that extra fetch and, more importantly, keeps working on
 * sites where discovery is disabled for security.
 */
function pickerspin_register_provider() {
	wp_oembed_add_provider(
		'#https?://(www\.)?pickerspin\.co/.*#i',
		PICKERSPIN_SITE . '/oembed',
		true
	);
}
add_action( 'init', 'pickerspin_register_provider' );

/**
 * [pickerspin] shortcode.
 *
 * Attributes:
 *   entries — comma separated, e.g. entries="Alice,Bob,Carla"
 *   title   — heading shown above the wheel
 *   theme   — light | dark | auto (default auto, follows the visitor)
 *   color   — hex for the spin button, e.g. color="#2e7d32"
 *   height  — pixels, default 520
 *   credit  — "no" to hide the attribution line
 */
function pickerspin_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'entries' => '',
			'title'   => '',
			'theme'   => 'auto',
			'color'   => '',
			'height'  => '520',
			'credit'  => 'yes',
		),
		$atts,
		'pickerspin'
	);

	$query = array();
	if ( '' !== $atts['entries'] ) {
		$query['entries'] = $atts['entries'];
	}
	if ( '' !== $atts['title'] ) {
		$query['title'] = $atts['title'];
	}
	// "auto" is already the embed's default, so sending it only creates a second
	// URL for the CDN to cache separately.
	if ( in_array( $atts['theme'], array( 'light', 'dark' ), true ) ) {
		$query['theme'] = $atts['theme'];
	}
	// Only accept a plain hex colour; anything else is dropped rather than
	// passed through into a URL.
	if ( preg_match( '/^#?[0-9a-fA-F]{6}$/', $atts['color'] ) ) {
		$query['color'] = ltrim( $atts['color'], '#' );
	}

	$src    = PICKERSPIN_SITE . '/embed/wheel/';
	if ( ! empty( $query ) ) {
		$src .= '?' . http_build_query( $query );
	}
	$height = max( 320, min( 900, absint( $atts['height'] ) ) );

	$html = sprintf(
		'<iframe src="%s" width="100%%" height="%d" style="border:0;border-radius:12px;max-width:420px" loading="lazy" title="%s"></iframe>',
		esc_url( $src ),
		$height,
		esc_attr__( 'PickerSpin Wheel', 'pickerspin' )
	);

	// The credit sits outside the iframe deliberately — a link inside the frame
	// belongs to the embed document, not to this page.
	if ( 'no' !== $atts['credit'] ) {
		// Branded anchor deliberately. A keyword-rich anchor repeated across every
		// site running this plugin is the widget-link pattern Google treats as
		// link spam.
		$html .= sprintf(
			'<p style="font:14px system-ui,sans-serif;max-width:420px">%s <a href="%s">PickerSpin</a></p>',
			esc_html__( 'Wheel by', 'pickerspin' ),
			esc_url( PICKERSPIN_SITE . '/' )
		);
	}

	return $html;
}
add_shortcode( 'pickerspin', 'pickerspin_shortcode' );
