<?php
/**
 * Theme_REST_Controller — spear/v1/design-tokens and spear/v1/entitlements
 * (docs/architecture/10-rest-api.md). Cross-cutting routes not owned by any
 * single feature module, so booted directly from functions.php rather than
 * through Module_Manager.
 *
 * @package Spear
 */

namespace Spear\REST;

use Spear\Core\Feature_Registry;
use WP_REST_Response;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Theme_REST_Controller {

	const NAMESPACE = 'spear/v1';

	public static function boot(): void {
		add_action( 'rest_api_init', [ __CLASS__, 'register_routes' ] );
	}

	public static function register_routes(): void {
		register_rest_route(
			self::NAMESPACE,
			'/design-tokens',
			[
				'methods'             => 'GET',
				'callback'            => [ __CLASS__, 'design_tokens' ],
				'permission_callback' => '__return_true',
			]
		);

		register_rest_route(
			self::NAMESPACE,
			'/entitlements',
			[
				'methods'             => 'GET',
				'callback'            => [ __CLASS__, 'entitlements' ],
				'permission_callback' => [ __CLASS__, 'entitlements_permission' ],
			]
		);
	}

	public static function design_tokens(): WP_REST_Response {
		return new WP_REST_Response( spear_get_design_tokens(), 200 );
	}

	public static function entitlements_permission(): bool {
		return is_user_logged_in() && current_user_can( 'edit_theme_options' );
	}

	/**
	 * Capability flags only — { feature_id: bool } — never raw license
	 * data (key, plan, expiry). See 09-security-and-performance.md.
	 */
	public static function entitlements(): WP_REST_Response {
		$flags = [];

		foreach ( Feature_Registry::all() as $feature_id => $feature ) {
			$flags[ $feature_id ] = spear_has_feature( $feature_id );
		}

		return new WP_REST_Response( $flags, 200 );
	}
}
