<?php
/**
 * Locked_Control — a Customizer control that renders Pro_Feature_Lock
 * instead of an input.
 *
 * add() is the shared entry point every feature module's Customizer
 * registrar uses to add one locked Pro card — it registers a real (but
 * inert — no input ever renders, so it can never actually change) setting,
 * because WP_Customize_Manager::add_control() requires a bound setting.
 *
 * @package Spear
 */

namespace Spear\Admin\Customize;

use Spear\Admin\Components\Pro_Feature_Lock;
use WP_Customize_Control;
use WP_Customize_Manager;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Locked_Control extends WP_Customize_Control {

	public $type = 'spear-pro-lock';

	public string $spear_feature_id = '';

	public function render_content(): void {
		if ( '' !== $this->spear_feature_id ) {
			Pro_Feature_Lock::render( $this->spear_feature_id );
		}
	}

	public static function add( WP_Customize_Manager $wp_customize, string $section, string $feature_id ): void {
		$setting_id = 'spear_locked_' . $feature_id;

		$wp_customize->add_setting(
			$setting_id,
			[ 'sanitize_callback' => '__return_empty_string' ]
		);

		$control                   = new self( $wp_customize, $setting_id, [ 'section' => $section ] );
		$control->spear_feature_id = $feature_id;

		$wp_customize->add_control( $control );
	}
}
