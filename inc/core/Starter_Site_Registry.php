<?php
/**
 * Starter_Site_Registry — every registered starter-site definition, free
 * and Pro alike. Same shape as Feature_Registry: modules contribute
 * entries via the `spear_register_starter_sites` action rather than
 * editing this file, and a Pro module that isn't entitled still
 * contributes its metadata so Starter_Sites_Admin can render a locked
 * card for it.
 *
 * A definition is:
 * array{
 *   id: string,
 *   name: string,
 *   description: string,
 *   plan: 'free'|'pro',
 *   pages: array<array{title: string, pattern: string}>,
 * }
 * `pattern` is a registered block pattern name (see Starter_Sites_Patterns),
 * `pages` is applied in order — the first page becomes the site's front page.
 *
 * @package Spear
 */

namespace Spear\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Starter_Site_Registry {

	/** @var array<string, array> */
	private static array $sites = [];

	private static bool $booted = false;

	public static function boot(): void {
		if ( self::$booted ) {
			return;
		}
		self::$booted = true;

		do_action( 'spear_register_starter_sites' );
	}

	public static function register( array $site ): void {
		if ( empty( $site['id'] ) ) {
			return;
		}
		self::$sites[ $site['id'] ] = $site;
	}

	public static function get( string $id ): ?array {
		self::boot();
		return self::$sites[ $id ] ?? null;
	}

	/**
	 * @return array<string, array>
	 */
	public static function all(): array {
		self::boot();
		return self::$sites;
	}
}
