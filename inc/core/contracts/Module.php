<?php
/**
 * Module contract.
 *
 * Every loadable unit of the theme (a feature, an editor integration, a Pro
 * module) implements this so the Module_Manager can discover, order, and
 * conditionally boot it without knowing its concrete type.
 *
 * @package Spear
 */

namespace Spear\Core\Contracts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Module {

	/**
	 * Unique, stable module identifier (e.g. `woocommerce`, `elementor`, `pro-mega-menu`).
	 */
	public function id(): string;

	/**
	 * IDs of other modules that must be booted before this one.
	 *
	 * @return string[]
	 */
	public function dependencies(): array;

	/**
	 * Whether this module's environment requirements are met (plugin active,
	 * PHP extension present, etc). Module_Manager will not boot the module,
	 * and will not error, if this returns false.
	 */
	public function is_available(): bool;

	/**
	 * Whether this module requires an entitlement beyond "available", and if
	 * so which feature id gates it. Return null for modules with no gate
	 * (all Free modules, and Pro modules gated purely by is_available()).
	 */
	public function required_feature(): ?string;

	/**
	 * Register hooks, assets, blocks, etc. Called once, only when
	 * is_available() is true AND required_feature() (if any) is entitled.
	 */
	public function boot(): void;
}
