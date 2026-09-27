<?php
/**
 * Feature_Registry — metadata for every feature, free and Pro alike.
 *
 * Seeded from config/feature-registry.php, then extended by any booted or
 * unbooted module implementing Feature_Provider via the
 * `spear_register_features` action (unbooted matters: a Pro module that
 * Module_Manager declined to boot must still contribute its metadata so a
 * locked ProFeatureLock card can render). See
 * docs/architecture/04-feature-registry.md.
 *
 * @package Spear
 */

namespace Spear\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Feature_Registry {

	/** @var array<string, array<string, string>> */
	private static array $features = [];

	private static bool $booted = false;

	public static function boot(): void {
		if ( self::$booted ) {
			return;
		}

		self::$booted = true;

		$baseline = SPEAR_THEME_DIR . '/config/feature-registry.php';
		if ( file_exists( $baseline ) ) {
			foreach ( (array) require $baseline as $feature ) {
				self::register( $feature );
			}
		}

		/**
		 * Fires once, after the baseline feature list is loaded. Feature
		 * Providers register additional/overriding entries here.
		 */
		do_action( 'spear_register_features' );
	}

	/**
	 * @param array{id: string, name: string, description: string, category: string, plan: string} $feature
	 */
	public static function register( array $feature ): void {
		if ( empty( $feature['id'] ) ) {
			return;
		}
		self::$features[ $feature['id'] ] = $feature;
	}

	public static function get( string $feature_id ): ?array {
		self::boot();
		return self::$features[ $feature_id ] ?? null;
	}

	/**
	 * @return array<string, array<string, string>>
	 */
	public static function all(): array {
		self::boot();
		return self::$features;
	}
}
