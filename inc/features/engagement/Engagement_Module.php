<?php
/**
 * Engagement_Module — owns the 'spear_engagement' Customizer section.
 * Same shape as Typography_Module/Layout_Module (no free feature exists in
 * this category — `popup_builder` is Pro-only).
 *
 * @package Spear
 */

namespace Spear\Features\Engagement;

use Spear\Core\Contracts\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Engagement_Module implements Module {

	public function id(): string {
		return 'engagement';
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
		Engagement_Customizer::boot();
	}
}
