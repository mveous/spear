<?php
/**
 * Typography_Module — owns the 'spear_typography' Customizer section.
 *
 * Unlike Header/Footer/Blog_Module, there's no free typography feature in
 * config/feature-registry.php — every typography feature is Pro
 * (`custom_fonts`, `advanced_typography`). This module still always boots
 * (so the section and its locked cards exist even fully unlicensed) but
 * isn't a Feature_Provider itself, exactly like Gutenberg_Module.
 *
 * @package Spear
 */

namespace Spear\Features\Typography;

use Spear\Core\Contracts\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Typography_Module implements Module {

	public function id(): string {
		return 'typography';
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
