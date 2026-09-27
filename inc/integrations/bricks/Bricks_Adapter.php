<?php
/**
 * Bricks_Adapter — detection only at this phase. Bricks fully replaces
 * page rendering wherever it's used, the same way Oxygen does, so it needs
 * no theme-side compatibility flags to coexist. The doc's other concrete
 * ask here — "disable Spear's own block/pattern assets on
 * Bricks-templated pages" — has nothing to disable yet: Spear's block
 * patterns (feature id `gutenberg_patterns`) don't have a module of their
 * own built yet either. Revisit enqueue_assets() once that phase lands
 * rather than guessing at Bricks' per-post "built with Bricks" meta key
 * now (it isn't stable enough across Bricks versions to hardcode without
 * testing against a real install).
 *
 * sync_design_tokens() is a no-op for the same reason as every other
 * adapter here — see Elementor_Adapter's docblock.
 *
 * @package Spear
 */

namespace Spear\Integrations\Bricks;

use Spear\Core\Contracts\Editor_Adapter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Bricks_Adapter implements Editor_Adapter {

	public function id(): string {
		return 'bricks';
	}

	public function is_active(): bool {
		return class_exists( '\Bricks\Bricks' );
	}

	public function sync_design_tokens( array $tokens ): void {
		// See class docblock.
	}

	public function register(): void {
		// See class docblock — nothing to declare yet.
	}

	public function enqueue_assets(): void {
		// See class docblock — nothing to disable yet.
	}
}
