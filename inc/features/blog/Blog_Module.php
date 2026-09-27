<?php
/**
 * Blog_Module — the always-on free blog feature area.
 *
 * @package Spear
 */

namespace Spear\Features\Blog;

use Spear\Core\Contracts\Feature_Provider;
use Spear\Core\Contracts\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Blog_Module implements Module, Feature_Provider {

	public function id(): string {
		return 'blog';
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
		Blog_Customizer::boot();
		Blog_Frontend::boot();
	}

	public function register_features(): array {
		return [
			[
				'id'          => 'blog_basic',
				'name'        => __( 'Blog Layouts', 'spear' ),
				'description' => __( 'Standard archive and single post layouts.', 'spear' ),
				'category'    => 'blog',
				'plan'        => 'free',
			],
		];
	}
}
