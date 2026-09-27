<?php
/**
 * Beaver_Builder_Module — registers Beaver_Builder_Adapter with
 * Editor_Registry. Same shape as Elementor_Module.
 *
 * @package Spear
 */

namespace Spear\Integrations\Beaver_Builder;

use Spear\Core\Contracts\Module;
use Spear\Core\Editor_Registry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Beaver_Builder_Module implements Module {

	public function id(): string {
		return 'beaver_builder';
	}

	public function dependencies(): array {
		return [];
	}

	public function is_available(): bool {
		return class_exists( '\FLBuilder' );
	}

	public function required_feature(): ?string {
		return null;
	}

	public function boot(): void {
		$adapter = new Beaver_Builder_Adapter();
		Editor_Registry::register( $adapter );
		$adapter->register();
		add_action( 'wp_enqueue_scripts', [ $adapter, 'enqueue_assets' ], 20 );
	}
}
