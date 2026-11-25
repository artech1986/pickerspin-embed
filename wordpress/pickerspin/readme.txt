=== PickerSpin — Spin the Wheel ===
Contributors: pickerspin
Tags: spin the wheel, random name picker, wheel of names, classroom, giveaway
Requires at least: 5.8
Tested up to: 6.8
Requires PHP: 7.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Embed a free spin-the-wheel random name picker in any post or page. No account, no ads, no tracking.

== Description ==

Adds a spinning wheel to your WordPress site for picking a name, a winner or an option at random.

Teachers use it to call on students, streamers to draw giveaway winners, and everyone else to settle what's for dinner.

The wheel is a 3KB static page hosted on pickerspin.co. This plugin loads no scripts or stylesheets of its own and adds nothing to your page weight beyond the iframe itself.

**Two ways to use it**

1. Paste a pickerspin.co link on its own line — the wheel appears automatically.
2. Use the shortcode: `[pickerspin entries="Alice,Bob,Carla"]`

**Shortcode options**

* `entries` — comma separated list, e.g. `entries="Alice,Bob,Carla"`
* `title` — heading above the wheel
* `theme` — `light`, `dark` or `auto` (default `auto`, follows the visitor's setting)
* `color` — hex colour for the spin button, e.g. `color="#2e7d32"`
* `height` — pixels, default 520
* `credit` — `no` to hide the attribution line

**Fair by design**

The winner is drawn with the browser's Web Crypto API before the wheel starts moving, so the animation reveals a result it cannot change. You can check the distribution yourself at pickerspin.co/randomness.

== Privacy ==

The plugin sets no cookies, stores nothing, and collects no data. When a visitor loads a page containing the wheel, their browser requests the embed from pickerspin.co, which means pickerspin.co receives the request as it would for any embedded content. Nothing is sent about the visitor beyond that ordinary request. Entries you put on the wheel stay in the URL and in the visitor's own browser.

== Installation ==

1. Upload the `pickerspin` folder to `/wp-content/plugins/`, or install through Plugins → Add New.
2. Activate the plugin.
3. Add `[pickerspin]` to any post or page, or paste a pickerspin.co link.

== Frequently Asked Questions ==

= Is it free? =

Yes. No account, no ads, no paid tier for the embed.

= Can I set my own options? =

Yes: `[pickerspin entries="Pizza,Curry,Tacos" title="Dinner"]`

= Does it work in the block editor? =

Yes. Use a Shortcode block, or paste a pickerspin.co URL into a paragraph block on its own line.

= Does it slow my site down? =

The embed is about 3KB and loads lazily, so it is not fetched until it is near the viewport.

= Does it work on mobile? =

Yes. The wheel scales to whatever width you give it.

== Changelog ==

= 1.0.0 =
* First release: oEmbed provider and `[pickerspin]` shortcode.
