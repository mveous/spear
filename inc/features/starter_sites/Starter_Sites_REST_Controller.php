<?php
/**
 * Starter_Sites_REST_Controller — spear/v1/starter-sites* routes
 * (docs/architecture/10-rest-api.md).
 *
 * Replaces an earlier admin-post.php-based importer that deviated from the
 * locked route table — 10-rest-api.md specifies GET /starter-sites (public
 * catalog) and POST /starter-sites/{id}/import (edit_theme_options + nonce)
 * as REST routes, not a classic form post. Starter_Sites_Admin now talks to
 * these routes via wp-api-fetch.
 *
 * @package Spear
 */

namespace Spear\Features\Starter_Sites;

use Spear\Core\Starter_Site_Registry;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Starter_Sites_REST_Controller {

	const NAMESPACE = 'spear/v1';

	public static function boot(): void {
		add_action( 'rest_api_init', [ __CLASS__, 'register_routes' ] );
	}

	public static function register_routes(): void {
		register_rest_route(
			self::NAMESPACE,
			'/starter-sites',
			[
				'methods'             => 'GET',
				'callback'            => [ __CLASS__, 'index' ],
				'permission_callback' => '__return_true',
			]
		);

		register_rest_route(
			self::NAMESPACE,
			'/starter-sites/(?P<id>[a-z0-9\-]+)/import',
			[
				'methods'             => 'POST',
				'callback'            => [ __CLASS__, 'import' ],
				'permission_callback' => [ __CLASS__, 'permission' ],
			]
		);
	}

	public static function permission(): bool {
		return current_user_can( 'edit_theme_options' );
	}

	/**
	 * Only importable (free) starter sites are listed.
	 */
	public static function index(): WP_REST_Response {
		$catalog = [];

		foreach ( Starter_Site_Registry::all() as $site ) {
			if ( ! Starter_Sites_Importer::is_importable( $site ) ) {
				continue;
			}

			$entry = [
				'id'          => $site['id'] ?? '',
				'name'        => $site['name'] ?? '',
				'description' => $site['description'] ?? '',
				'plan'        => $site['plan'] ?? 'free',
				'pages'       => $site['pages'] ?? [],
			];

			$catalog[] = $entry;
		}

		return new WP_REST_Response( $catalog, 200 );
	}

	public static function import( WP_REST_Request $request ) {
		$site_id = (string) $request->get_param( 'id' );
		$site    = Starter_Site_Registry::get( $site_id );

		if ( null === $site ) {
			return new WP_Error( 'spear_starter_site_not_found', __( 'Unknown starter site.', 'spear' ), [ 'status' => 404 ] );
		}

		if ( ! Starter_Sites_Importer::is_importable( $site ) ) {
			return new WP_Error( 'spear_feature_not_entitled', __( 'This starter site is not available.', 'spear' ), [ 'status' => 403 ] );
		}

		$front_page_id = Starter_Sites_Importer::import( $site );

		return new WP_REST_Response(
			[
				'success'       => true,
				'front_page_id' => $front_page_id,
			],
			200
		);
	}
}
