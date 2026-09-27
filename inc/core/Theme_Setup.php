<?php
/**
 * Generic WordPress theme setup — unconditional, runs on every install
 * regardless of entitlement. Editor-specific supports (align-wide,
 * appearance-tools, etc.) live in the Gutenberg adapter instead, since
 * those are Editor_Adapter concerns, not core theme concerns. See
 * docs/architecture/06-universal-editor-api.md.
 *
 * @package Spear
 */

namespace Spear\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Theme_Setup {

	public static function boot(): void {
		add_action( 'after_setup_theme', [ __CLASS__, 'setup' ] );
	}

	public static function setup(): void {
		load_theme_textdomain( 'spear', SPEAR_THEME_DIR . '/languages' );

		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support(
			'html5',
			[ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ]
		);

		register_nav_menus(
			[
				'primary' => __( 'Primary Menu', 'spear' ),
				'footer'  => __( 'Footer Menu', 'spear' ),
			]
		);
	}
}
