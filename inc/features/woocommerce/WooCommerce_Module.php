<?php
/**
 * WooCommerce_Module — the always-on free WooCommerce compatibility layer.
 * Only boots when WooCommerce is actually installed (`class_exists`
 * detection, same pattern as the Universal Editor API's builder adapters
 * in inc/integrations/*) — never a hard dependency (spec §52).
 *
 * @package Spear
 */

namespace Spear\Features\WooCommerce;

use Spear\Core\Contracts\Feature_Provider;
use Spear\Core\Contracts\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooCommerce_Module implements Module, Feature_Provider {

	public function id(): string {
		return 'woocommerce';
	}

	public function dependencies(): array {
		return [];
	}

	public function is_available(): bool {
		return class_exists( 'WooCommerce' );
	}

	public function required_feature(): ?string {
		return null;
	}

	public function boot(): void {
		WooCommerce_Customizer::boot();
		WooCommerce_Frontend::boot();
	}

	public function register_features(): array {
		return [
			[
				'id'          => 'woocommerce_basic',
				'name'        => __( 'WooCommerce Compatibility', 'spear' ),
				'description' => __( 'Styled shop, product, cart, and checkout templates.', 'spear' ),
				'category'    => 'woocommerce',
				'plan'        => 'free',
			],
		];
	}
}
