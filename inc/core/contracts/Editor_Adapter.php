<?php
/**
 * Editor_Adapter contract — the Universal Editor API.
 *
 * Spear\Core never talks to Elementor, Divi, Bricks, etc. directly. Each
 * builder integration under inc/integrations/{builder}/ implements this and
 * registers itself with Editor_Registry; Editor_Detector decides which
 * adapters actually boot.
 *
 * @package Spear
 */

namespace Spear\Core\Contracts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Editor_Adapter {

	/**
	 * Adapter id, e.g. 'gutenberg', 'elementor', 'divi', 'spear-editor'.
	 */
	public function id(): string;

	/**
	 * Whether the target editor/builder is installed and active. Gutenberg's
	 * adapter always returns true (it ships with WordPress core).
	 */
	public function is_active(): bool;

	/**
	 * Map Spear Design System tokens into the builder's own global-style
	 * mechanism (theme.json for Gutenberg, Elementor's Kit, etc), so colors/
	 * typography/spacing stay consistent across whichever editor is used.
	 */
	public function sync_design_tokens( array $tokens ): void;

	/**
	 * Register hooks specific to this builder (compatibility fixes, template
	 * support flags, etc). Called only when is_active() is true.
	 */
	public function register(): void;

	/**
	 * Enqueue any assets this adapter needs. Called only when is_active()
	 * is true and only in the relevant context (frontend/editor/admin).
	 */
	public function enqueue_assets(): void;
}
