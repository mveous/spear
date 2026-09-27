<?php
/**
 * Beaver_Builder_Adapter — Beaver Builder is deliberately theme-agnostic by
 * design (it works against the_content() on any theme with no required
 * opt-in flags), so there's no equivalent of Elementor's Theme Builder
 * location registration to wire up here.
 *
 * Verified this round against the real, free Beaver Builder Lite plugin
 * source (downloaded from wordpress.org/plugins/beaver-builder-lite-version/):
 *
 * - The doc's "avoid duplicate row/column CSS" ask turns out to be a
 *   non-issue rather than something to implement: grepping Spear's own
 *   `style.css` and every `inc/` file for `fl-row`/`fl-col` (BB's real,
 *   confirmed CSS classes — `css/fl-builder-layout.css`) turns up zero
 *   matches. Spear's block-theme output never uses those class names (or
 *   any generic `.row`/`.col`), so there is no real collision to guard
 *   against — recorded here so a future contributor doesn't re-open this
 *   as a TODO without re-checking first.
 * - The real conflict is the same one Divi_Adapter and Elementor_Adapter
 *   already solve: Spear's `main.wp-block-group` max-width constraint
 *   fights BB's own full-width rows. `\FLBuilderModel::is_builder_enabled(
 *   $post_id )` (real, static, `classes/class-fl-builder-model.php`) is
 *   the correct per-post "is this page rendered with BB" check — distinct
 *   from `is_builder_active()`, which the same file shows checks whether
 *   the *live editing UI* is currently open, not whether the page's normal
 *   front-end render uses a BB layout.
 *
 * sync_design_tokens() is a no-op for the same reason as every other
 * adapter here — see Elementor_Adapter's docblock. Beaver Builder Lite's
 * own color/typography settings weren't inspected for a token-sync target
 * this round; deepening that is separate follow-up work, not attempted.
 *
 * @package Spear
 */

namespace Spear\Integrations\Beaver_Builder;

use Spear\Core\Contracts\Editor_Adapter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Beaver_Builder_Adapter implements Editor_Adapter {

	public function id(): string {
		return 'beaver_builder';
	}

	public function is_active(): bool {
		return class_exists( '\FLBuilder' );
	}

	public function sync_design_tokens( array $tokens ): void {
		// See class docblock.
	}

	public function register(): void {
		// See class docblock — nothing to declare yet.
	}

	public function enqueue_assets(): void {
		if ( ! is_singular() || ! class_exists( '\FLBuilderModel' ) || ! method_exists( '\FLBuilderModel', 'is_builder_enabled' ) ) {
			return;
		}

		if ( ! \FLBuilderModel::is_builder_enabled( get_the_ID() ) ) {
			return;
		}

		if ( ! wp_style_is( 'spear-tokens', 'registered' ) ) {
			return;
		}

		wp_add_inline_style(
			'spear-tokens',
			'
body.single-post main.wp-block-group,
body.page main.wp-block-group {
	max-width: none;
	padding-left: 0;
	padding-right: 0;
}
'
		);
	}
}
