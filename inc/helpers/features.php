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

if ( ! function_exists( 'spear_get_upgrade_url' ) ) {
	/**
	 * A static, versioned URL pointing at the Spear Pro purchase/pricing
	 * page, optionally tagged with the feature id that triggered it (for
	 * contextual landing pages). Spear Pro is a separate theme package —
	 * this is a marketing link, never an in-admin license/upgrade flow.
	 * Filterable so a real deployment can point this at its own pricing
	 * page without touching code.
	 *
	 * @see docs/architecture/04-feature-registry.md
	 */
	function spear_get_upgrade_url( string $feature_id = '' ): string {
		$url = 'https://spear.example/pricing';

		if ( '' !== $feature_id ) {
			$url = add_query_arg( 'feature', $feature_id, $url );
		}

		return apply_filters( 'spear_upgrade_url', $url, $feature_id );
	}
}
