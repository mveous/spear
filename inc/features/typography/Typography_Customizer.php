<?php
/**
 * Typography_Customizer — the 'spear_typography' section plus locked cards
 * for its Pro features, same skip-if-entitled pattern as
 * Header_Customizer::LOCKED_FEATURES.
 *
 * @package Spear
 */

namespace Spear\Features\Typography;

use Spear\Admin\Customize\Locked_Control;
use WP_Customize_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Typography_Customizer {

	const LOCKED_FEATURES = [ 'custom_fonts', 'advanced_typography' ];

	public static function boot(): void {
		add_action( 'customize_register', [ __CLASS__, 'register' ] );
	}

	public static function register( WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_section(
			'spear_typography',
			[
				'title'    => __( 'Typography', 'spear' ),
				'priority' => 36,
			]
		);

		foreach ( self::LOCKED_FEATURES as $feature_id ) {
			// Entitled features get their real control from their own Pro
			// module instead (registered in this same 'spear_typography'
			// section) — see inc/pro/typography/*_Customizer.php.
			if ( spear_has_feature( $feature_id ) ) {
				continue;
			}
			Locked_Control::add( $wp_customize, 'spear_typography', $feature_id );
		}
	}
}
