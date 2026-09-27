<?php
/**
 * Oxygen_Module — registers Oxygen_Adapter with Editor_Registry. Same
 * shape as Elementor_Module.
 *
 * @package Spear
 */

namespace Spear\Integrations\Oxygen;

use Spear\Core\Contracts\Module;
use Spear\Core\Editor_Registry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Oxygen_Module implements Module {

	public function id(): string {
		return 'oxygen';
	}

	public function dependencies(): array {
		return [];
	}

	public function is_available(): bool {
		return defined( 'CT_VERSION' );
	}

	public function required_feature(): ?string {
		return null;
	}

	public function boot(): void {
		$adapter = new Oxygen_Adapter();
		Editor_Registry::register( $adapter );
		$adapter->register();
		add_action( 'wp_enqueue_scripts', [ $adapter, 'enqueue_assets' ], 20 );
	}
}
