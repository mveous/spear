<?php
/**
 * Footer_Module — the always-on free footer feature area.
 *
 * @package Spear
 */

namespace Spear\Features\Footer;

use Spear\Core\Contracts\Feature_Provider;
use Spear\Core\Contracts\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Footer_Module implements Module, Feature_Provider {

	public function id(): string {
		return 'footer';
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
		Footer_Customizer::boot();
		Footer_Frontend::boot();
	}

	public function register_features(): array {
		return [
			[
				'id'          => 'footer_basic',
				'name'        => __( 'Basic Footer', 'spear' ),
				'description' => __( 'A single footer layout with widgets and navigation.', 'spear' ),
				'category'    => 'footer',
				'plan'        => 'free',
			],
		];
	}
}
