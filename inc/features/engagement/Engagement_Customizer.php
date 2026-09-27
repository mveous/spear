<?php
/**
 * Engagement_Customizer — the 'spear_engagement' section plus a locked
 * card for `popup_builder`, same pattern as Typography_Customizer.
 *
 * @package Spear
 */

namespace Spear\Features\Engagement;

use Spear\Admin\Customize\Locked_Control;
use WP_Customize_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Engagement_Customizer {

	public static function boot(): void {
		add_action( 'customize_register', [ __CLASS__, 'register' ] );
	}

	public static function register( WP_Customize_Manager $wp_customize ): void {
		$wp_customize->add_section(
			'spear_engagement',
			[
				'title'    => __( 'Engagement', 'spear' ),
				'priority' => 39,
			]
		);

		if ( ! spear_has_feature( 'popup_builder' ) ) {
			Locked_Control::add( $wp_customize, 'spear_engagement', 'popup_builder' );
		}
	}
}
