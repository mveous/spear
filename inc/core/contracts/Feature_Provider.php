<?php
/**
 * Feature_Provider contract.
 *
 * Any Module (free or Pro) that introduces user-facing features implements
 * this so Feature_Registry can collect their metadata at boot without a
 * central file enumerating every feature by hand.
 *
 * @package Spear
 */

namespace Spear\Core\Contracts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Feature_Provider {

	/**
	 * Feature definitions contributed by this module.
	 *
	 * Each entry: [
	 *   'id'          => string   unique, e.g. 'mega_menu',
	 *   'name'        => string   translatable label,
	 *   'description' => string   translatable one-liner for locked cards,
	 *   'category'    => string   e.g. 'header', 'footer', 'editor', 'ai',
	 *   'plan'        => string   'free' | 'pro',
	 * ]
	 *
	 * @return array<int, array<string, string>>
	 */
	public function register_features(): array;
}
