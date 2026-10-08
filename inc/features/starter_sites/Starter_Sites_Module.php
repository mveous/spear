<?php
/**
 * Starter_Sites_Module — the starter-sites feature area. Owns the admin
 * screen and importer plus the free starter site definition. Its pattern
 * content lives in the theme's patterns/ directory.
 *
 * @package Spear
 */

namespace Spear\Features\Starter_Sites;

use Spear\Core\Contracts\Feature_Provider;
use Spear\Core\Contracts\Module;
use Spear\Core\Starter_Site_Registry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Starter_Sites_Module implements Module, Feature_Provider {

	public function id(): string {
		return 'starter-sites';
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
		Starter_Sites_Admin::boot();
		Starter_Sites_REST_Controller::boot();

		add_action( 'spear_register_starter_sites', [ __CLASS__, 'register_starter_site' ] );
	}

	public static function register_starter_site(): void {
		Starter_Site_Registry::register(
			[
				'id'          => 'simple-business',
				'name'        => __( 'Simple Business', 'spear' ),
				'description' => __( 'A three-page starter: Home, About, and Contact.', 'spear' ),
				'plan'        => 'free',
				'pages'       => [
					[ 'title' => __( 'Home', 'spear' ), 'pattern' => 'spear/simple-business-hero' ],
					[ 'title' => __( 'About', 'spear' ), 'pattern' => 'spear/simple-business-about' ],
					[ 'title' => __( 'Contact', 'spear' ), 'pattern' => 'spear/simple-business-contact' ],
				],
			]
		);
	}

	public function register_features(): array {
		return [
			[
				'id'          => 'starter_sites_free',
				'name'        => __( 'Free Starter Sites', 'spear' ),
				'description' => __( 'Import complete free starter sites in one click.', 'spear' ),
				'category'    => 'starter-sites',
				'plan'        => 'free',
			],
		];
	}
}
