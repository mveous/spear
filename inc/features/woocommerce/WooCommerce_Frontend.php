<?php
/**
 * WooCommerce_Frontend — real theme-support declarations plus swapping
 * WooCommerce's default classic-theme content wrapper
 * (`woocommerce_output_content_wrapper`/`_end`, which prints
 * `<div id="primary" class="content-area"><main id="main"
 * class="site-main">`) for Spear's own `<main class="wp-block-group">`
 * markup so shop/product/cart/checkout pages sit inside the same
 * constrained-width wrapper as every block template
 * (templates/index.html etc.) instead of an unstyled classic-theme div.
 * Both the removed and added hooks are WooCommerce's own long-stable
 * theme-integration API (woocommerce.com/document/woocommerce-theming/).
 *
 * @package Spear
 */

namespace Spear\Features\WooCommerce;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WooCommerce_Frontend {

	public static function boot(): void {
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		add_filter( 'loop_shop_columns', [ __CLASS__, 'shop_columns' ] );
		add_filter( 'loop_shop_per_page', [ __CLASS__, 'shop_per_page' ] );

		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
		add_action( 'woocommerce_before_main_content', [ __CLASS__, 'content_wrapper_start' ], 10 );
		add_action( 'woocommerce_after_main_content', [ __CLASS__, 'content_wrapper_end' ], 10 );
	}

	public static function shop_columns( int $columns ): int {
		return (int) get_theme_mod( 'spear_woo_shop_columns', 3 );
	}

	public static function shop_per_page( int $per_page ): int {
		return (int) get_theme_mod( 'spear_woo_shop_per_page', 12 );
	}

	public static function content_wrapper_start(): void {
		echo '<main class="wp-block-group spear-woocommerce">';
	}

	public static function content_wrapper_end(): void {
		echo '</main>';
	}
}
