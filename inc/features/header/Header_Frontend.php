<?php
/**
 * Header_Frontend — turns the Customizer settings into real output.
 *
 * Appends inline CSS to the same 'spear-tokens' handle Design_Tokens
 * registers (docs/architecture/05-design-system.md), rather than
 * registering a new stylesheet, so header/footer/blog styling stays in one
 * request-scoped <style> block instead of many small ones.
 *
 * @package Spear
 */

namespace Spear\Features\Header;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Header_Frontend {

	public static function boot(): void {
		add_filter( 'body_class', [ __CLASS__, 'body_class' ] );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'inline_style' ], 11 );
	}

	public static function body_class( array $classes ): array {
		$classes[] = 'spear-header-layout-' . get_theme_mod( 'spear_header_layout', 'left' );
		$classes[] = 'spear-header-' . get_theme_mod( 'spear_header_container', 'contained' );
		return $classes;
	}

	public static function inline_style(): void {
		if ( ! wp_style_is( 'spear-tokens', 'registered' ) ) {
			return;
		}

		wp_add_inline_style(
			'spear-tokens',
			'
body.spear-header-layout-center header.wp-block-group.is-layout-flex {
	flex-direction: column;
	align-items: center;
	justify-content: center;
	gap: 0.5rem;
}
body.spear-header-full-width header.wp-block-group {
	max-width: none;
}
'
		);
	}
}
