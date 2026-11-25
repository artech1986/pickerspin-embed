# PickerSpin embed

A spinning wheel you can put on any web page with one iframe. Use it to pick a
name, draw a giveaway winner or settle a decision. It is a single static HTML
file, about 20 KB, with no framework, no cookies, no ads and no tracking.

This repository holds the source of the embed served at
`https://pickerspin.co/embed/wheel/`, the WordPress plugin, and examples. The
full app is at [PickerSpin](https://pickerspin.co/).

## Quick start

Paste this into any page that accepts HTML:

```html
<iframe
  src="https://pickerspin.co/embed/wheel/?entries=Alice,Bob,Carla&title=Pick%20one"
  width="100%" height="520"
  style="border:0;border-radius:12px;max-width:420px"
  loading="lazy" title="PickerSpin wheel"></iframe>
<p>Wheel by <a href="https://pickerspin.co/">PickerSpin</a></p>
```

The credit line is optional. If you keep it, please keep the link text as
"PickerSpin".

## Options

Set the options as URL parameters on the iframe `src`.

| Parameter | Example | What it does |
|---|---|---|
| `entries` | `entries=Pizza,Curry,Tacos` | Comma separated options on the wheel. URL encode spaces and symbols |
| `title` | `title=Dinner` | Heading above the wheel |
| `theme` | `theme=dark` | `light`, `dark` or `auto` (the default, which follows the visitor) |
| `color` | `color=2e7d32` | Hex colour for the spin button, without `#` |
| `duration` | `duration=8` | Spin length in seconds, 2 to 20 |
| `remove` | `remove=1` | Take each winner off the wheel, for draws with no repeats |
| `obs` | `obs=1` | Stream overlay mode: transparent background, no button, large result banner. See [examples/obs-overlay.md](examples/obs-overlay.md) |
| `sound` | `sound=0` | Mute the ticks in overlay mode |
| `button` | `button=1` | Show the button in overlay mode |

## Reading the result from your page

After every spin the wheel posts a message to the page that contains it:

```js
window.addEventListener('message', (e) => {
  if (e.origin !== 'https://pickerspin.co') return;
  if (e.data.type === 'pickerspin:result') {
    console.log(e.data.winner, e.data.index);
  }
  if (e.data.type === 'pickerspin:height') {
    // the wheel's content height in pixels, for sizing the iframe
  }
});
```

A full page is in [examples/listen-for-result.html](examples/listen-for-result.html).

## Paste a link instead (oEmbed)

pickerspin.co is an [oEmbed](https://oembed.com/) provider. In WordPress,
Ghost, Discourse and other platforms that support oEmbed discovery, paste a
wheel link on its own line and it turns into a working wheel:

```
https://pickerspin.co/wheel/secret-santa/
```

The endpoint is `https://pickerspin.co/oembed?url=<page>&format=json`.

## WordPress plugin

[`wordpress/pickerspin`](wordpress/pickerspin) adds a `[pickerspin]` shortcode
and registers the oEmbed provider, so pasted links work even where discovery
is turned off. It loads no scripts or styles of its own.

```
[pickerspin entries="Alice,Bob,Carla" title="Who goes first?" theme="light"]
```

Install it by zipping the `pickerspin` folder and uploading it in Plugins, Add
New, Upload Plugin, or download the ready-made
[pickerspin-wordpress-plugin.zip](https://pickerspin.co/pickerspin-wordpress-plugin.zip).

## How the winner is picked

The winner is drawn with `crypto.getRandomValues()`, the browser's
cryptographically secure random generator, before the wheel starts to move.
The animation then turns the wheel to that result, so the spin cannot change
the outcome and every option has the same chance. You can run a live
distribution test at [pickerspin.co/randomness](https://pickerspin.co/randomness/).

## Self-hosting

`embed/wheel/index.html` has no dependencies. Copy it to any static host and
point your iframe at it. The credit link inside the wheel points to
pickerspin.co; you may change it on your own copy.

## Platform guides

- [WordPress](https://pickerspin.co/embed/wordpress/)
- [Google Sites](https://pickerspin.co/embed/google-sites/)
- [All embed options](https://pickerspin.co/embed/)

## Licence

- The embed and the examples are under the [MIT licence](LICENSE).
- The WordPress plugin is under [GPL 2.0 or later](wordpress/pickerspin/LICENSE),
  as WordPress requires.

Issues and pull requests are welcome.
