<?php
/**
 * Editor_Registry — every registered Editor_Adapter, active or not.
 *
 * Populated by each builder integration's Module::boot() (see
 * docs/architecture/06-universal-editor-api.md); Editor_Detector filters
 * this down to the adapters that are actually active on this request.
 *
 * @package Spear
 */

namespace Spear\Core;

use Spear\Core\Contracts\Editor_Adapter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Editor_Registry {

	/** @var array<string, Editor_Adapter> */
	private static array $adapters = [];

	public static function register( Editor_Adapter $adapter ): void {
		self::$adapters[ $adapter->id() ] = $adapter;
	}

	public static function get( string $id ): ?Editor_Adapter {
		return self::$adapters[ $id ] ?? null;
	}

	/**
	 * @return array<string, Editor_Adapter>
	 */
	public static function all(): array {
		return self::$adapters;
	}
}
