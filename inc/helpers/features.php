<?php
/**
 * Global helper functions. Kept to thin wrappers only — all logic lives in
 * the Spear\Core classes these call. Not autoloaded (functions can't be);
 * required directly from functions.php.
 *
 * @package Spear
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'spear_has_feature' ) ) {
	/**
	 * Whether the current site is entitled to a given feature.
	 *
	 * @see docs/architecture/04-feature-registry.md
	 */
	function spear_has_feature( string $feature_id ): bool {
		return \Spear\Core\Feature_Manager::instance()->has_feature( $feature_id );
	}
}

if ( ! function_exists( 'spear_get_design_tokens' ) ) {
	/**
	 * The compiled Spear Design System token set.
	 *
	 * @see docs/architecture/05-design-system.md
	 */
	function spear_get_design_tokens(): array {
		return \Spear\Core\Design_Tokens::get();
	}
}
