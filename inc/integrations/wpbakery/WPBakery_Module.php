<?php
/**
 * WPBakery_Module — registers WPBakery_Adapter with Editor_Registry. Same
 * shape as Elementor_Module.
 *
 * @package Spear
 */

namespace Spear\Integrations\WPBakery;

use Spear\Core\Contracts\Module;
use Spear\Core\Editor_Registry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WPBakery_Module implements Module {

	public function id(): string {
		return 'wpbakery';
	}

	public function dependencies(): array {
		return [];
	}

	public function is_available(): bool {
		return defined( 'WPB_VF_VERSION' );
	}

	public function required_feature(): ?string {
		return null;
	}

	public function boot(): void {
		$adapter = new WPBakery_Adapter();
		Editor_Registry::register( $adapter );
		$adapter->register();
		add_action( 'wp_enqueue_scripts', [ $adapter, 'enqueue_assets' ], 20 );
	}
}
