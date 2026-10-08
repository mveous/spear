<?php
/**
 * Layout_Module — owns the 'spear_layout' Customizer section. Same shape
 * as Typography_Module (no free layout feature exists in
 * config/feature-registry.php — both `advanced_spacing` and
 * `advanced_responsive` are Pro-only).
 *
 * @package Spear
 */

namespace Spear\Features\Layout;

use Spear\Core\Contracts\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Layout_Module implements Module {

	public function id(): string {
		return 'layout';
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
	}
}
