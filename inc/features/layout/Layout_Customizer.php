<?php
/**
 * Layout_Customizer — the 'spear_layout' section plus locked cards for its
 * Pro features, same shape as Typography_Customizer.
 *
 * @package Spear
 */

namespace Spear\Features\Layout;

use Spear\Admin\Customize\Locked_Control;
use WP_Customize_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Layout_Customizer {

	const LOCKED_FEATURES = [ 'advanced_spacing', 'advanced_responsive' ];

	public static function boot(): void {
		add_action( 'customize_register', [ __CLASS__, 'register' ] );
	}

	public static function register( WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_section(
			'spear_layout',
			[
				'title'    => __( 'Layout', 'spear' ),
				'priority' => 37,
			]
		);

		foreach ( self::LOCKED_FEATURES as $feature_id ) {
			if ( spear_has_feature( $feature_id ) ) {
				continue;
			}
			Locked_Control::add( $wp_customize, 'spear_layout', $feature_id );
		}
	}
}
