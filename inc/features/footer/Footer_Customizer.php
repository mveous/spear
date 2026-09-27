<?php
/**
 * Footer_Customizer — real Free settings plus a locked Pro card (spec §32).
 *
 * @package Spear
 */

namespace Spear\Features\Footer;

use Spear\Admin\Customize\Locked_Control;
use WP_Customize_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Footer_Customizer {

	const DEFAULT_COPYRIGHT = '© {year} {site_name}. All rights reserved.';

	public static function boot(): void {
		add_action( 'customize_register', [ __CLASS__, 'register' ] );
	}

	public static function register( WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_section(
			'spear_footer',
			[
				'title'    => __( 'Footer', 'spear' ),
				'priority' => 32,
			]
		);

		$wp_customize->add_setting(
			'spear_footer_copyright',
			[
				'default'           => self::DEFAULT_COPYRIGHT,
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'refresh',
			]
		);
		$wp_customize->add_control(
			'spear_footer_copyright',
			[
				'type'        => 'text',
				'section'     => 'spear_footer',
				'label'       => __( 'Copyright Text', 'spear' ),
				'description' => __( 'Use {year} and {site_name} as placeholders.', 'spear' ),
			]
		);

		$wp_customize->add_setting(
			'spear_footer_layout',
			[
				'default'           => 'row',
				'sanitize_callback' => [ __CLASS__, 'sanitize_layout' ],
				'transport'         => 'refresh',
			]
		);
		$wp_customize->add_control(
			'spear_footer_layout',
			[
				'type'    => 'select',
				'section' => 'spear_footer',
				'label'   => __( 'Footer Layout', 'spear' ),
				'choices' => [
					'row'     => __( 'Side by side', 'spear' ),
					'stacked' => __( 'Stacked', 'spear' ),
				],
			]
		);

		$wp_customize->add_section(
			'spear_footer_pro',
			[
				'title'       => __( 'Footer — Pro Features', 'spear' ),
				'priority'    => 33,
				'description' => __( 'Available with Spear Pro.', 'spear' ),
			]
		);

		// Entitled sites get the real control from Advanced_Footer_Customizer
		// instead (registered in the main 'spear_footer' section, not here).
		if ( ! spear_has_feature( 'advanced_footer' ) ) {
			Locked_Control::add( $wp_customize, 'spear_footer_pro', 'advanced_footer' );
		}
	}

	public static function sanitize_layout( string $value ): string {
		return in_array( $value, [ 'row', 'stacked' ], true ) ? $value : 'row';
	}
}
