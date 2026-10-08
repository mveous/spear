<?php
/**
 * Module_Manager — conditional boot for every optional unit of the theme.
 *
 * See docs/architecture/02-module-system.md for the full design. Boot is a
 * recursive dependency resolution rather than a single linear pass, so
 * registration order never matters — a module can depend on one registered
 * after it.
 *
 * @package Spear
 */

namespace Spear\Core;

use Spear\Core\Contracts\Feature_Provider;
use Spear\Core\Contracts\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Module_Manager {

	/** @var array<string, Module> */
	private array $modules = [];

	/** @var array<string, bool> */
	private array $booted = [];

	/**
	 * Registers a module. If it also implements Feature_Provider, its
	 * features are hooked into Feature_Registry via the
	 * `spear_register_features` action regardless of whether the module
	 * ends up booting — a Pro module Module_Manager declines to boot must
	 * still contribute its metadata so a locked card can render (see
	 * docs/architecture/04-feature-registry.md). This only queues the
	 * callback; register() must run before Feature_Registry::boot() fires
	 * the action for it to have any effect.
	 */
	public function register( Module $module ): void {
		$this->modules[ $module->id() ] = $module;

		if ( $module instanceof Feature_Provider ) {
			add_action(
				'spear_register_features',
				static function () use ( $module ): void {
					foreach ( $module->register_features() as $feature ) {
						Feature_Registry::register( $feature );
					}
				}
			);
		}
	}

	/**
	 * @param Module[] $modules
	 */
	public function register_many( array $modules ): void {
		foreach ( $modules as $module ) {
			$this->register( $module );
		}
	}

	public function boot_all(): void {
		foreach ( $this->modules as $module ) {
			$this->boot( $module );
		}
	}

	public function is_booted( string $module_id ): bool {
		return ! empty( $this->booted[ $module_id ] );
	}

	private function boot( Module $module ): bool {
		$id = $module->id();

		if ( array_key_exists( $id, $this->booted ) ) {
			return $this->booted[ $id ];
		}

		// Prevent infinite recursion on a circular dependency declaration.
		$this->booted[ $id ] = false;

		if ( ! $module->is_available() ) {
			return false;
		}

		foreach ( $module->dependencies() as $dependency_id ) {
			if ( ! isset( $this->modules[ $dependency_id ] ) || ! $this->boot( $this->modules[ $dependency_id ] ) ) {
				return false;
			}
		}

		$required_feature = $module->required_feature();
		if ( $required_feature && ! Feature_Manager::instance()->has_feature( $required_feature ) ) {
			return false;
		}

		$module->boot();
		$this->booted[ $id ] = true;

		return true;
	}
}
