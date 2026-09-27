<?php
/**
 * Divi_Adapter — the one concrete conflict this integration addresses:
 * Divi Builder wraps its own full-width sections in `.et_pb_section`
 * markup that expects to own the page's horizontal width, which fights
 * Spear's `layout:{type:"constrained"}` wrapper (theme.json) around
 * `<main>`. `et_pb_is_pagebuilder_used()` is Divi's own documented
 * per-post "is this page built with the Divi Builder" check, so this only
 * ever fires on pages actually built with it.
 *
 * sync_design_tokens() is a no-op — see Elementor_Adapter's docblock for
 * why (Design_Tokens::enqueue() already covers the global-CSS-variable
 * case regardless of active editor); pushing Spear's tokens into Divi's own
 * color-picker presets would need testing against a real Divi install.
 *
 * @package Spear
 */

namespace Spear\Integrations\Divi;

use Spear\Core\Contracts\Editor_Adapter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Divi_Adapter implements Editor_Adapter {

	public function id(): string {
		return 'divi';
	}

	public function is_active(): bool {
		return defined( 'ET_CORE_VERSION' );
	}

	public function sync_design_tokens( array $tokens ): void {
		// See class docblock.
	}

	public function register(): void {
		// No theme-support flags to declare — Divi Builder works against
		// the_content() directly and needs no opt-in from the theme.
	}

	public function enqueue_assets(): void {
		if ( ! is_singular() || ! function_exists( 'et_pb_is_pagebuilder_used' ) ) {
			return;
		}

		if ( ! et_pb_is_pagebuilder_used( get_the_ID() ) ) {
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
