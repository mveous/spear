<?php
/**
 * Blog_Customizer — real Free settings (spec §33).
 *
 * @package Spear
 */

namespace Spear\Features\Blog;

use WP_Customize_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Blog_Customizer {

	public static function boot(): void {
		add_action( 'customize_register', [ __CLASS__, 'register' ] );
	}

	public static function register( WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_section(
			'spear_blog',
			[
				'title'    => __( 'Blog', 'spear' ),
				'priority' => 34,
			]
		);

		$wp_customize->add_setting(
			'spear_blog_excerpt_length',
			[
				'default'           => 30,
				'sanitize_callback' => [ __CLASS__, 'sanitize_excerpt_length' ],
				'transport'         => 'refresh',
			]
		);
		$wp_customize->add_control(
			'spear_blog_excerpt_length',
			[
				'type'        => 'number',
				'section'     => 'spear_blog',
				'label'       => __( 'Excerpt Length (words)', 'spear' ),
				'input_attrs' => [
					'min'  => 10,
					'max'  => 100,
					'step' => 1,
				],
			]
		);

		$wp_customize->add_setting(
			'spear_blog_show_featured_image',
			[
				'default'           => true,
				'sanitize_callback' => 'rest_sanitize_boolean',
				'transport'         => 'refresh',
			]
		);
		$wp_customize->add_control(
			'spear_blog_show_featured_image',
			[
				'type'    => 'checkbox',
				'section' => 'spear_blog',
				'label'   => __( 'Show featured image in blog listing', 'spear' ),
			]
		);

		$wp_customize->add_setting(
			'spear_blog_show_date',
			[
				'default'           => true,
				'sanitize_callback' => 'rest_sanitize_boolean',
				'transport'         => 'refresh',
			]
		);
		$wp_customize->add_control(
			'spear_blog_show_date',
			[
				'type'    => 'checkbox',
				'section' => 'spear_blog',
				'label'   => __( 'Show post date in blog listing', 'spear' ),
			]
		);
	}

	public static function sanitize_excerpt_length( $value ): int {
		return max( 10, min( 100, absint( $value ) ) );
	}
}
