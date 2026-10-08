<?php
/**
 * Spear theme bootstrap.
 *
 * Wiring only — autoload registration, kernel boot, module registration.
 * No feature logic lives here (spec §11: "Do NOT put everything into
 * functions.php"). See docs/architecture/00-overview.md.
 *
 * @package Spear
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Spear\Core\Design_Tokens;
use Spear\Core\Feature_Registry;
use Spear\Core\Module_Manager;
use Spear\Core\Theme_Setup;
use Spear\Features\Blog\Blog_Module;
use Spear\Features\Design\Design_Module;
use Spear\Features\Engagement\Engagement_Module;
use Spear\Features\Footer\Footer_Module;
use Spear\Features\Header\Header_Module;
use Spear\Features\Layout\Layout_Module;
use Spear\Features\Starter_Sites\Starter_Sites_Module;
use Spear\Features\Typography\Typography_Module;
use Spear\Features\WooCommerce\WooCommerce_Module;
use Spear\Integrations\Beaver_Builder\Beaver_Builder_Module;
use Spear\Integrations\Bricks\Bricks_Module;
use Spear\Integrations\Divi\Divi_Module;
use Spear\Integrations\Elementor\Elementor_Module;
use Spear\Integrations\Gutenberg\Gutenberg_Module;
use Spear\Integrations\Oxygen\Oxygen_Module;
use Spear\Integrations\Spear_Editor\Spear_Editor_Module;
use Spear\Integrations\WPBakery\WPBakery_Module;
use Spear\REST\Theme_REST_Controller;

define( 'SPEAR_VERSION', '0.1.0' );
define( 'SPEAR_THEME_DIR', get_template_directory() );
define( 'SPEAR_THEME_URI', get_template_directory_uri() );

require SPEAR_THEME_DIR . '/inc/core/Autoloader.php';
\Spear\Core\Autoloader::register();

require SPEAR_THEME_DIR . '/inc/helpers/features.php';

Theme_Setup::boot();

// Spear Free has no license/entitlement system — every 'pro' feature in
// the registry permanently resolves to false (Feature_Manager::has_feature()),
// so Pro-only features are simply absent from this theme
// (docs/architecture/03-free-pro-and-licensing.md).
Theme_REST_Controller::boot();

add_action(
	'after_setup_theme',
	static function (): void {
		$modules = new Module_Manager();
		$modules->register( new Gutenberg_Module() );
		$modules->register( new Elementor_Module() );
		$modules->register( new Divi_Module() );
		$modules->register( new Bricks_Module() );
		$modules->register( new Beaver_Builder_Module() );
		$modules->register( new WPBakery_Module() );
		$modules->register( new Oxygen_Module() );
		$modules->register( new Spear_Editor_Module() );
		$modules->register( new Header_Module() );
		$modules->register( new Footer_Module() );
		$modules->register( new Blog_Module() );
		$modules->register( new Typography_Module() );
		$modules->register( new Layout_Module() );
		$modules->register( new Engagement_Module() );
		$modules->register( new Design_Module() );
		$modules->register( new WooCommerce_Module() );
		$modules->register( new Starter_Sites_Module() );

		/**
		 * Fires after core modules are registered, before Feature_Registry
		 * boots and before boot_all(). Later phases (and Pro) hook their
		 * own modules in here rather than editing this file — must run
		 * before Feature_Registry::boot() so Feature_Provider modules can
		 * still contribute metadata (see Module_Manager::register()).
		 */
		do_action( 'spear_register_modules', $modules );

		Feature_Registry::boot();
		$modules->boot_all();
	},
	20
);

add_action( 'wp_enqueue_scripts', [ Design_Tokens::class, 'enqueue' ] );
add_action( 'enqueue_block_editor_assets', [ Design_Tokens::class, 'enqueue' ] );
