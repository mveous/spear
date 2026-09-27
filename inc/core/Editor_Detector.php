<?php
/**
 * Editor_Detector — which registered adapters are actually active.
 *
 * More than one can be true at once (e.g. Elementor on some post types,
 * Gutenberg on others) — Spear does not assume editor exclusivity. See
 * docs/architecture/06-universal-editor-api.md.
 *
 * @package Spear
 */

namespace Spear\Core;

use Spear\Core\Contracts\Editor_Adapter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Editor_Detector {

	/**
	 * @return array<string, Editor_Adapter>
	 */
	public static function active_adapters(): array {
		return array_filter(
			Editor_Registry::all(),
			static fn( Editor_Adapter $adapter ): bool => $adapter->is_active()
		);
	}
}
