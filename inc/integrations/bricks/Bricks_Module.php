<?php
/**
 * Bricks_Module — registers Bricks_Adapter with Editor_Registry. Same
 * shape as Elementor_Module.
 *
 * @package Spear
 */

namespace Spear\Integrations\Bricks;

use Spear\Core\Contracts\Module;
use Spear\Core\Editor_Registry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Bricks_Module implements Module {

	public function id(): string {
		return 'bricks';
	}

	public function dependencies(): array {
		return [];
	}

	public function is_available(): bool {
		return class_exists( '\Bricks\Bricks' );
	}

	public function required_feature(): ?string {
		return null;
	}

	public function boot(): void {
		$adapter = new Bricks_Adapter();
		Editor_Registry::register( $adapter );
		$adapter->register();
		add_action( 'wp_enqueue_scripts', [ $adapter, 'enqueue_assets' ], 20 );
	}
}
