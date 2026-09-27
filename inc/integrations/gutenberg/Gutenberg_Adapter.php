<?php
/**
 * Gutenberg_Adapter — the always-active baseline Editor_Adapter.
 *
 * @package Spear
 */

namespace Spear\Integrations\Gutenberg;

use Spear\Core\Contracts\Editor_Adapter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gutenberg_Adapter implements Editor_Adapter {

	public function id(): string {
		return 'gutenberg';
	}

	public function is_active(): bool {
		return true;
	}

	public function sync_design_tokens( array $tokens ): void {
		// theme.json is already the compiled output for Gutenberg
		// (docs/architecture/05-design-system.md) — nothing to push at
		// runtime beyond the CSS custom properties Design_Tokens enqueues
		// for every context regardless of active editor.
	}

	public function register(): void {
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'editor-styles' );
		add_theme_support( 'appearance-tools' );
	}

	public function enqueue_assets(): void {
		// No Gutenberg-specific assets yet — patterns/block-editor sidebar
		// panels land in the Gutenberg phase (docs/architecture/00-overview.md
		// phase plan), not the foundation phase.
	}
}
