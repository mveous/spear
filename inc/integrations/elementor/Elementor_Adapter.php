<?php
/**
 * Elementor_Adapter — registers Spear as an Elementor Theme Builder host
 * (header/footer locations) so a Pro Elementor user can override Spear's
 * own header/footer for the pages they choose to, without Spear needing to
 * detect or suppress anything itself — Elementor only overrides rendering
 * for a location once a template is actually assigned to it, so Spear's own
 * fallback header/footer (docs/architecture/06-universal-editor-api.md
 * rule #2: "Never require a builder") keeps rendering everywhere else.
 *
 * Verified this round against the real, free Elementor plugin source
 * (downloaded from wordpress.org/plugins/elementor/ — Elementor Pro isn't
 * freely distributable, so only what's below could be checked against real
 * code, not guessed):
 *
 * - `elementor/theme/register_locations` does **not** appear anywhere in
 *   free Elementor's codebase — Theme Builder (and this action) is an
 *   Elementor **Pro** feature, which isn't freely distributable so its
 *   source couldn't be checked directly this round, and this session's
 *   attempt to reach Elementor's public developer docs for independent
 *   confirmation of the hook name also failed (fetch error, not
 *   guessed around). Treat `register_theme_locations()` below with the
 *   same not-executable-verified caveat it always had — the one new,
 *   confirmed fact is that it's absent from the free codebase, so it's
 *   inert without Pro, not merely unverified.
 * - `\Elementor\Core\Base\Document::is_built_with_elementor()` (real,
 *   `core/base/document.php`) and `\Elementor\Plugin::$instance->documents
 *   ->get( $post_id )` (real, `core/documents-manager.php`, returns
 *   `false` for an invalid post — guarded below) are both confirmed real
 *   in the free plugin, so `enqueue_assets()`'s dequeue logic is no longer
 *   a guess.
 *
 * sync_design_tokens() stays a no-op, now for a more specific reason than
 * "unverified": free Elementor's real Global Colors/Variables storage
 * (`modules/design-system-sync/classes/variables-provider.php`) reads
 * through `Plugin::$instance->kits_manager->get_active_kit()` into an
 * internal `Variables_Repository`/`Variables_Service` pair with its own
 * batch-processing and legacy v3-sync-id scheme — genuinely internal
 * plumbing with no public extension point for a third party to write
 * named token swatches into, not merely undocumented. Confirms the
 * original deferral was the right call rather than settling it.
 *
 * @package Spear
 */

namespace Spear\Integrations\Elementor;

use Spear\Core\Contracts\Editor_Adapter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Elementor_Adapter implements Editor_Adapter {

	public function id(): string {
		return 'elementor';
	}

	public function is_active(): bool {
		return (bool) did_action( 'elementor/loaded' );
	}

	public function sync_design_tokens( array $tokens ): void {
		// See class docblock — the global :root custom properties already
		// cover this; nothing to do here.
	}

	public function register(): void {
		add_action( 'elementor/theme/register_locations', [ $this, 'register_theme_locations' ] );
	}

	/**
	 * @param mixed $elementor_theme_manager Elementor Pro's location manager,
	 *   passed by Elementor's own 'elementor/theme/register_locations'
	 *   action — typed as mixed rather than a concrete class to avoid a
	 *   hard dependency on an Elementor Pro class that doesn't exist when
	 *   only free Elementor (no Theme Builder) is active.
	 */
	public function register_theme_locations( $elementor_theme_manager ): void {
		if ( ! is_object( $elementor_theme_manager ) || ! method_exists( $elementor_theme_manager, 'register_location' ) ) {
			return;
		}
		$elementor_theme_manager->register_location( 'header' );
		$elementor_theme_manager->register_location( 'footer' );
	}

	/**
	 * Spear's `main.wp-block-group` carries a max-width constraint
	 * (theme.json's `layout:{type:"constrained"}`) that fights Elementor's
	 * own full-width sections the same way it fights Divi's — see
	 * Divi_Adapter's docblock for the general shape of this conflict; the
	 * dequeue check here uses the real, source-verified Elementor API this
	 * class's own docblock describes rather than a guessed-at meta key.
	 */
	public function enqueue_assets(): void {
		if ( ! is_singular() || ! class_exists( '\Elementor\Plugin' ) ) {
			return;
		}

		$document = \Elementor\Plugin::$instance->documents->get( get_the_ID() );
		if ( ! $document || ! method_exists( $document, 'is_built_with_elementor' ) || ! $document->is_built_with_elementor() ) {
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
