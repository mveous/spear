<?php
/**
 * WooCommerce_Customizer — real Free settings plus a locked Pro card
 * (spec §32-style pattern, same as Footer_Customizer/Blog_Customizer).
 *
 * @package Spear
 */

namespace Spear\Features\WooCommerce;

use Spear\Admin\Customize\Locked_Control;
use WP_Customize_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooCommerce_Customizer {

	public static function boot(): void {
		add_action( 'customize_register', [ __CLASS__, 'register' ] );
	}

	public static function register( WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_section(
			'spear_woocommerce',
			[
				'title'    => __( 'WooCommerce', 'spear' ),
				'priority' => 38,
			]
		);

		$wp_customize->add_setting(
			'spear_woo_shop_columns',
			[
				'default'           => 3,
				'sanitize_callback' => [ __CLASS__, 'sanitize_columns' ],
				'transport'         => 'refresh',
			]
		);

		$wp_customize->add_control(
			'spear_woo_shop_columns',
			[
				'type'        => 'number',
				'section'     => 'spear_woocommerce',
				'label'       => __( 'Products per row', 'spear' ),
				'input_attrs' => [ 'min' => 2, 'max' => 5, 'step' => 1 ],
			]
		);

		$wp_customize->add_setting(
			'spear_woo_shop_per_page',
			[
				'default'           => 12,
				'sanitize_callback' => [ __CLASS__, 'sanitize_per_page' ],
				'transport'         => 'refresh',
			]
		);

		$wp_customize->add_control(
			'spear_woo_shop_per_page',
			[
				'type'        => 'number',
				'section'     => 'spear_woocommerce',
				'label'       => __( 'Products per page', 'spear' ),
				'input_attrs' => [ 'min' => 4, 'max' => 48, 'step' => 4 ],
			]
		);

		if ( ! spear_has_feature( 'advanced_woocommerce' ) ) {
			Locked_Control::add( $wp_customize, 'spear_woocommerce', 'advanced_woocommerce' );
		}
	}

	public static function sanitize_columns( $value ): int {
		return max( 2, min( 5, absint( $value ) ) );
	}

	public static function sanitize_per_page( $value ): int {
		return max( 4, min( 48, absint( $value ) ) );
	}
}
