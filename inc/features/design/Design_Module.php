<?php
/**
 * Design_Module — owns the 'spear_design' Customizer section. Same shape
 * as Typography_Module/Layout_Module (no free feature exists in this
 * category — `advanced_animation` is Pro-only).
 *
 * @package Spear
 */

namespace Spear\Features\Design;

use Spear\Core\Contracts\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Design_Module implements Module {

	public function id(): string {
		return 'design';
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
		Design_Customizer::boot();
	}
}
