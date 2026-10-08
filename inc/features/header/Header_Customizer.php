<?php
/**
 * Header_Customizer — real Free settings plus Free settings (spec §31).
 *
 * @package Spear
 */

namespace Spear\Features\Header;

use WP_Customize_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Header_Customizer {

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
	}

	public static function sanitize_layout( string $value ): string {
		return in_array( $value, [ 'left', 'center' ], true ) ? $value : 'left';
	}

	public static function sanitize_container( string $value ): string {
		return in_array( $value, [ 'contained', 'full-width' ], true ) ? $value : 'contained';
	}
}
