<?php
/**
 * Header_Module — the always-on free header feature area.
 *
 * @package Spear
 */

namespace Spear\Features\Header;

use Spear\Core\Contracts\Feature_Provider;
use Spear\Core\Contracts\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Header_Module implements Module, Feature_Provider {

	public function id(): string {
		return 'header';
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
		Header_Customizer::boot();
		Header_Frontend::boot();
	}

	public function register_features(): array {
		return [
			[
				'id'          => 'header_basic',
				'name'        => __( 'Basic Header', 'spear' ),
				'description' => __( 'Logo, navigation, and a single header layout.', 'spear' ),
				'category'    => 'header',
				'plan'        => 'free',
			],
		];
	}
}
