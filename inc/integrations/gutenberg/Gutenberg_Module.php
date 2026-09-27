<?php
/**
 * Gutenberg_Module — registers the Gutenberg adapter with Editor_Registry.
 *
 * Always available (Gutenberg ships with WordPress core); this is what
 * guarantees Editor_Detector::active_adapters() is never empty. See
 * docs/architecture/06-universal-editor-api.md.
 *
 * @package Spear
 */

namespace Spear\Integrations\Gutenberg;

use Spear\Core\Contracts\Module;
use Spear\Core\Editor_Registry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Gutenberg_Module implements Module {

	public function id(): string {
		return 'gutenberg';
	}

	public function dependencies(): array {
		return [];
	}

	public function is_available(): bool {
		return true;
	}

	public function required_feature(): ?string {
		return null;
	}

	public function boot(): void {
		$adapter = new Gutenberg_Adapter();
		Editor_Registry::register( $adapter );
		$adapter->register();
	}
}
