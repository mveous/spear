<?php
/**
 * Design_Tokens — reads config/design-tokens.php and compiles it to CSS
 * custom properties at runtime (wp_add_inline_style, no filesystem writes).
 *
 * A future Design System admin screen (Phase 3) can write a static
 * assets/css/tokens.css instead for a small perf win; nothing downstream
 * needs to change when that happens, since consumers only ever read the
 * resulting --spear-* custom properties, not this class's internals. See
 * docs/architecture/05-design-system.md.
 *
 * @package Spear
 */

namespace Spear\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Design_Tokens {

	private static ?array $tokens = null;

	public static function get(): array {
		if ( null === self::$tokens ) {
			$file        = SPEAR_THEME_DIR . '/config/design-tokens.php';
			$tokens      = file_exists( $file ) ? (array) require $file : [];
			self::$tokens = (array) apply_filters( 'spear_design_tokens', $tokens );
		}
		return self::$tokens;
	}

	public static function get_breakpoints(): array {
		$tokens = self::get();
		return $tokens['breakpoints'] ?? [];
	}

	public static function css_variables(): string {
		$lines = [];
		foreach ( self::get() as $category => $values ) {
			if ( 'breakpoints' === $category || ! is_array( $values ) ) {
				continue;
			}
			foreach ( $values as $token => $value ) {
				$lines[] = sprintf( '  --spear-%s-%s: %s;', $category, $token, $value );
			}
		}
		return ":root {\n" . implode( "\n", $lines ) . "\n}\n";
	}

	public static function enqueue(): void {
		if ( ! wp_style_is( 'spear-tokens', 'registered' ) ) {
			wp_register_style( 'spear-tokens', false, [], SPEAR_VERSION );
		}
		wp_enqueue_style( 'spear-tokens' );
		wp_add_inline_style( 'spear-tokens', self::css_variables() );
	}
}
