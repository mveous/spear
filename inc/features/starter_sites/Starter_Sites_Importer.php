<?php
/**
 * Starter_Sites_Importer — creates real WP pages from a starter site's
 * block patterns and sets the first page as the site's front page. Called
 * from Starter_Sites_REST_Controller::import() (POST
 * /spear/v1/starter-sites/{id}/import, per docs/architecture/10-rest-api.md)
 * — this class holds only the import logic, not route registration, so it
 * stays independently testable.
 *
 * @package Spear
 */

namespace Spear\Features\Starter_Sites;

use WP_Block_Patterns_Registry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Starter_Sites_Importer {

	public static function is_importable( array $site ): bool {
		if ( 'free' === ( $site['plan'] ?? 'free' ) ) {
			return true;
		}
		return spear_has_feature( 'premium_templates' );
	}

	/**
	 * @return int The new front page's post ID, or 0 if no page was set as
	 *   the front page (e.g. every pattern in the definition failed to
	 *   resolve).
	 */
	public static function import( array $site ): int {
		$front_page_id = 0;

		foreach ( (array) ( $site['pages'] ?? [] ) as $index => $page ) {
			$pattern = self::pattern_content( $page['pattern'] ?? '' );
			if ( null === $pattern ) {
				continue;
			}

			$post_id = wp_insert_post(
				[
					'post_title'   => $page['title'] ?? '',
					'post_content' => $pattern,
					'post_status'  => 'publish',
					'post_type'    => 'page',
				]
			);

			if ( 0 === $index && $post_id && ! is_wp_error( $post_id ) ) {
				$front_page_id = $post_id;
			}
		}

		if ( $front_page_id ) {
			update_option( 'show_on_front', 'page' );
			update_option( 'page_on_front', $front_page_id );
		}

		return $front_page_id;
	}

	private static function pattern_content( string $pattern_name ): ?string {
		if ( '' === $pattern_name || ! class_exists( WP_Block_Patterns_Registry::class ) ) {
			return null;
		}

		$pattern = WP_Block_Patterns_Registry::get_instance()->get_registered( $pattern_name );

		if ( ! empty( $pattern['content'] ) ) {
			return $pattern['content'];
		}

		// Theme pattern files may be registered lazily with only a path.
		if ( ! empty( $pattern['filePath'] ) && is_readable( $pattern['filePath'] ) ) {
			ob_start();
			include $pattern['filePath'];
			return ob_get_clean();
		}

		return null;
	}
}
