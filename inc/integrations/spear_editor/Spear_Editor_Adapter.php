<?php
/**
 * Spear_Editor_Adapter — Spear Editor is "just another adapter" from the
 * theme's point of view (06-universal-editor-api.md, "Spear Editor as
 * just another adapter"): registered and detected exactly like Elementor
 * or Divi, not special-cased. sync_design_tokens() is a no-op for the
 * same reason every other adapter's is — Design_Tokens::enqueue() already
 * puts every --spear-* custom property on :root unconditionally, and
 * spear-editor/'s own SpearEditor\Core\Feature_Manager reads this theme's
 * spear_has_feature() by direct PHP call when both packages are active,
 * so there's no REST round-trip token sync to build here either — the
 * "direct PHP function call... since both packages can be active on the
 * same install" the doc describes is that Feature_Manager delegation, not
 * a call this adapter needs to make.
 *
 * @package Spear
 */

namespace Spear\Integrations\Spear_Editor;

use Spear\Core\Contracts\Editor_Adapter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Spear_Editor_Adapter implements Editor_Adapter {

	public function id(): string {
		return 'spear-editor';
	}

	public function is_active(): bool {
		return defined( 'SPEAR_EDITOR_VERSION' );
	}

	public function sync_design_tokens( array $tokens ): void {
		// See class docblock.
	}

	public function register(): void {
		// Nothing to declare yet — Spear Editor doesn't have a page-
		// rendering takeover mode analogous to a page builder's (it
		// renders through Document_Renderer into the_content() per
		// 07-spear-editor.md's "Persistence" section), so there's no
		// structural conflict to register around the way Elementor's
		// Theme Builder locations are.
	}

	public function enqueue_assets(): void {
		// Nothing yet — Spear Editor's own canvas assets are enqueued by
		// the plugin itself, not the theme; this stays empty until the
		// theme has something Spear-Editor-specific to add (matches
		// Gutenberg_Adapter's own currently-empty enqueue_assets()).
	}
}
