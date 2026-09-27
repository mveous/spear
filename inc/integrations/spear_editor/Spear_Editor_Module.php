<?php
/**
 * Spear_Editor_Module — registers Spear_Editor_Adapter with
 * Editor_Registry. Same shape as Elementor_Module.
 *
 * @package Spear
 */

namespace Spear\Integrations\Spear_Editor;

use Spear\Core\Contracts\Module;
use Spear\Core\Editor_Registry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Spear_Editor_Module implements Module {

	public function id(): string {
		return 'spear-editor';
	}

	public function dependencies(): array {
		return [];
	}

	public function is_available(): bool {
		return defined( 'SPEAR_EDITOR_VERSION' );
	}

	public function required_feature(): ?string {
		return null;
	}

	public function boot(): void {
		$adapter = new Spear_Editor_Adapter();
		Editor_Registry::register( $adapter );
		$adapter->register();
		add_action( 'wp_enqueue_scripts', [ $adapter, 'enqueue_assets' ], 20 );
	}
}
