<?php
/**
 * Feature_Manager — Spear Free's entitlement resolver.
 *
 * Every Pro-vs-Free branch in the codebase goes through has_feature() (via
 * the spear_has_feature() helper in inc/helpers/features.php). Spear Free
 * has no license/entitlement system — Pro features are shipped as a
 * separate theme package (Spear Pro), not unlocked in place — so every
 * 'pro' feature permanently resolves to false here. See
 * docs/architecture/03-free-pro-and-licensing.md and
 * docs/architecture/04-feature-registry.md.
 *
 * @package Spear
 */

namespace Spear\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Feature_Manager {

	private static ?self $instance = null;

	public static function instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function has_feature( string $feature_id ): bool {
		$feature = Feature_Registry::get( $feature_id );

		if ( null === $feature ) {
			if ( function_exists( '_doing_it_wrong' ) ) {
				_doing_it_wrong(
					__METHOD__,
					sprintf( 'Unknown Spear feature id "%s".', esc_html( $feature_id ) ),
					'0.1.0'
				);
			}
			return false;
		}

		$enabled = 'free' === $feature['plan'];

		return (bool) apply_filters( "spear_feature_enabled_{$feature_id}", $enabled, $feature );
	}
}
