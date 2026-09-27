<?php
/**
 * WPBakery_Adapter — detection only. WPBakery Page Builder renders its
 * shortcodes inline within the_content() and never takes over header,
 * footer, or overall page structure the way Elementor/Oxygen/Bricks can,
 * so there's no structural conflict for Spear to guard against — the
 * classic-editor content path just needs the_content() left unfiltered,
 * which Spear already does (no content filters registered anywhere in
 * this theme).
 *
 * sync_design_tokens() is a no-op for the same reason as every other
 * adapter here — see Elementor_Adapter's docblock.
 *
 * @package Spear
 */

namespace Spear\Integrations\WPBakery;

use Spear\Core\Contracts\Editor_Adapter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPBakery_Adapter implements Editor_Adapter {

	public function id(): string {
		return 'wpbakery';
	}

	public function is_active(): bool {
		return defined( 'WPB_VF_VERSION' );
	}

	public function sync_design_tokens( array $tokens ): void {
		// See class docblock.
	}

	public function register(): void {
		// See class docblock — nothing to declare.
	}

	public function enqueue_assets(): void {
		// See class docblock — nothing to override.
	}
}
