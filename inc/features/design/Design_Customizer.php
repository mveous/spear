<?php
/**
 * Design_Customizer — the 'spear_design' section plus a locked card for
 * `advanced_animation`, same pattern as Typography_Customizer.
 *
 * @package Spear
 */

namespace Spear\Features\Design;

use Spear\Admin\Customize\Locked_Control;
use WP_Customize_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Design_Customizer {

	public static function boot(): void {
		add_action( 'customize_register', [ __CLASS__, 'register' ] );
	}

	public static function register( WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_section(
			'spear_design',
			[
				'title'    => __( 'Design', 'spear' ),
				'priority' => 40,
			]
		);

		if ( ! spear_has_feature( 'advanced_animation' ) ) {
			Locked_Control::add( $wp_customize, 'spear_design', 'advanced_animation' );
		}
	}
}
