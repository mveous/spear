<?php
/**
 * Spear\ class autoloader.
 *
 * Maps `Spear\Foo\Bar_Baz` to `inc/foo/Bar_Baz.php` — namespace segments are
 * lowercased into directory names (matching the lowercase inc/ tree in
 * docs/architecture/01-folder-structure.md), the final segment keeps its
 * exact case as the filename, matching the class name exactly.
 *
 * @package Spear
 */

namespace Spear\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Autoloader {

	const PREFIX = 'Spear\\';

	public static function register(): void {
		spl_autoload_register( [ __CLASS__, 'autoload' ] );
	}

	public static function autoload( string $class ): void {
		if ( 0 !== strncmp( $class, self::PREFIX, strlen( self::PREFIX ) ) ) {
			return;
		}

		$relative   = substr( $class, strlen( self::PREFIX ) );
		$segments   = explode( '\\', $relative );
		$file_name  = array_pop( $segments ) . '.php';
		$directory  = strtolower( implode( '/', $segments ) );
		$path       = SPEAR_THEME_DIR . '/inc/' . ( $directory ? $directory . '/' : '' ) . $file_name;

		if ( file_exists( $path ) ) {
			require $path;
		}
	}
}
