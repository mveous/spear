<?php
/**
 * Header_Customizer — real Free settings plus locked Pro cards (spec §31).
 *
 * @package Spear
 */

namespace Spear\Features\Header;

use Spear\Admin\Customize\Locked_Control;
use WP_Customize_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Header_Customizer {

	const LOCKED_FEATURES = [
		'sticky_header',
		'transparent_header',
		'mega_menu',
		'advanced_header',
		'header_layouts',
	];

	public static function boot(): void {
		add_action( 'customize_register', [ __CLASS__, 'register' ] );
	}

	public static function register( WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_section(
			'spear_header',
			[
				'title'    => __( 'Header', 'spear' ),
				'priority' => 30,
			]
		);

		$wp_customize->add_setting(
			'spear_header_layout',
			[
				'default'           => 'left',
				'sanitize_callback' => [ __CLASS__, 'sanitize_layout' ],
				'transport'         => 'refresh',
			]
		);
		$wp_customize->add_control(
			'spear_header_layout',
			[
				'type'    => 'select',
				'section' => 'spear_header',
				'label'   => __( 'Header Layout', 'spear' ),
				'choices' => [
					'left'   => __( 'Logo left, navigation right', 'spear' ),
					'center' => __( 'Logo centered, navigation below', 'spear' ),
				],
			]
		);

		$wp_customize->add_setting(
			'spear_header_container',
			[
				'default'           => 'contained',
				'sanitize_callback' => [ __CLASS__, 'sanitize_container' ],
				'transport'         => 'refresh',
			]
		);
		$wp_customize->add_control(
			'spear_header_container',
			[
				'type'    => 'select',
				'section' => 'spear_header',
				'label'   => __( 'Header Width', 'spear' ),
				'choices' => [
					'contained'  => __( 'Contained', 'spear' ),
					'full-width' => __( 'Full width', 'spear' ),
				],
			]
		);

		$wp_customize->add_section(
			'spear_header_pro',
			[
				'title'       => __( 'Header — Pro Features', 'spear' ),
				'priority'    => 31,
				'description' => __( 'Available with Spear Pro.', 'spear' ),
			]
		);

		foreach ( self::LOCKED_FEATURES as $feature_id ) {
			// Entitled features get their real control from their own Pro
			// module instead (registered in the main 'spear_header'
			// section, not here) — see inc/pro/header/Sticky_Header_Customizer.php
			// for the reference implementation.
			if ( spear_has_feature( $feature_id ) ) {
				continue;
			}
			Locked_Control::add( $wp_customize, 'spear_header_pro', $feature_id );
		}
	}

	public static function sanitize_layout( string $value ): string {
		return in_array( $value, [ 'left', 'center' ], true ) ? $value : 'left';
	}

	public static function sanitize_container( string $value ): string {
		return in_array( $value, [ 'contained', 'full-width' ], true ) ? $value : 'contained';
	}
}
