<?php
/**
 * Starter_Sites_Module — the always-on free starter-sites feature area.
 * Owns the admin screen and importer (both needed regardless of plan —
 * Pro starter sites use the same import mechanism, just gated per-site by
 * Starter_Sites_Importer::is_importable()) plus the one free starter site
 * definition and its patterns.
 *
 * Also registers the *metadata* (id/name/description) for the two Pro
 * starter sites, unconditionally, the same way config/feature-registry.php's
 * static baseline lists every feature — free and Pro — upfront regardless
 * of entitlement. This is deliberate, not scope creep: Premium_Templates_
 * Module only boots (and only registers the actual pattern *content* for
 * those two sites) when entitled, but Starter_Sites_Admin needs the
 * metadata unconditionally so it can render a locked card for them —
 * exactly the gap Sticky_Header_Module's own docblock note about
 * "still contribute its metadata so a locked card can render" describes,
 * just solved here at the registry level since starter sites don't have
 * an equivalent of Module_Manager's automatic Feature_Provider wiring.
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
		Starter_Sites_Patterns::boot();
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

		// Metadata only — see class docblock. Pattern content for these two
		// is registered by Premium_Templates_Patterns, only when entitled.
		Starter_Site_Registry::register(
			[
				'id'          => 'agency-portfolio',
				'name'        => __( 'Agency Portfolio', 'spear' ),
				'description' => __( 'A four-page starter: Home, Services, Portfolio, and Contact.', 'spear' ),
				'plan'        => 'pro',
				'pages'       => [
					[ 'title' => __( 'Home', 'spear' ), 'pattern' => 'spear/agency-portfolio-hero' ],
					[ 'title' => __( 'Services', 'spear' ), 'pattern' => 'spear/agency-portfolio-services' ],
					[ 'title' => __( 'Portfolio', 'spear' ), 'pattern' => 'spear/agency-portfolio-portfolio' ],
					[ 'title' => __( 'Contact', 'spear' ), 'pattern' => 'spear/simple-business-contact' ],
				],
			]
		);

		Starter_Site_Registry::register(
			[
				'id'          => 'saas-landing',
				'name'        => __( 'SaaS Landing', 'spear' ),
				'description' => __( 'A two-page starter: a feature-focused landing page and Pricing.', 'spear' ),
				'plan'        => 'pro',
				'pages'       => [
					[ 'title' => __( 'Home', 'spear' ), 'pattern' => 'spear/saas-landing-hero' ],
					[ 'title' => __( 'Pricing', 'spear' ), 'pattern' => 'spear/saas-landing-pricing' ],
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
