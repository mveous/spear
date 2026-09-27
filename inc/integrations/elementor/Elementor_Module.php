<?php
/**
 * Elementor_Module — registers Elementor_Adapter with Editor_Registry.
 * is_available() mirrors the adapter's own is_active() check (both read
 * Elementor's 'elementor/loaded' action), per the pattern documented in
 * docs/architecture/06-universal-editor-api.md: adapters register
 * themselves as Modules first, so Module_Manager only ever boots (and thus
 * only ever calls register()/hooks enqueue_assets()) when the builder is
 * actually present — never a hard dependency (spec §52, invariant #3).
 *
 * @package Spear
 */

namespace Spear\Integrations\Elementor;

use Spear\Core\Contracts\Module;
use Spear\Core\Editor_Registry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Elementor_Module implements Module {

	public function id(): string {
		return 'elementor';
	}

	public function dependencies(): array {
		return [];
	}

	public function is_available(): bool {
		return (bool) did_action( 'elementor/loaded' );
	}

	public function required_feature(): ?string {
		return null;
	}

	public function boot(): void {
		$adapter = new Elementor_Adapter();
		Editor_Registry::register( $adapter );
		$adapter->register();
		add_action( 'wp_enqueue_scripts', [ $adapter, 'enqueue_assets' ], 20 );
	}
}
