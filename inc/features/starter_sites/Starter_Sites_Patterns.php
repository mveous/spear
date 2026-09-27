<?php
/**
 * Starter_Sites_Patterns — registers the free starter site's block
 * patterns via WordPress core's own pattern registry (`register_block_
 * pattern`, `register_block_pattern_category`, both core since WP 5.5),
 * so Starter_Sites_Importer can later fetch their content by name through
 * `WP_Block_Patterns_Registry::get_instance()->get_registered()`.
 *
 * @package Spear
 */

namespace Spear\Features\Starter_Sites;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Starter_Sites_Patterns {

	const CATEGORY = 'spear-starter-sites';

	public static function boot(): void {
		add_action( 'init', [ __CLASS__, 'register' ] );
	}

	public static function register(): void {
		if ( ! function_exists( 'register_block_pattern_category' ) ) {
			return;
		}

		register_block_pattern_category(
			self::CATEGORY,
			[ 'label' => __( 'Spear Starter Sites', 'spear' ) ]
		);

		register_block_pattern(
			'spear/simple-business-hero',
			[
				'title'      => __( 'Simple Business — Hero', 'spear' ),
				'categories' => [ self::CATEGORY ],
				'content'    => self::hero_content(),
			]
		);

		register_block_pattern(
			'spear/simple-business-about',
			[
				'title'      => __( 'Simple Business — About', 'spear' ),
				'categories' => [ self::CATEGORY ],
				'content'    => self::about_content(),
			]
		);

		register_block_pattern(
			'spear/simple-business-contact',
			[
				'title'      => __( 'Simple Business — Contact', 'spear' ),
				'categories' => [ self::CATEGORY ],
				'content'    => self::contact_content(),
			]
		);
	}

	private static function hero_content(): string {
		return '<!-- wp:cover {"overlayColor":"secondary","minHeight":60,"minHeightUnit":"vh"} -->
<div class="wp-block-cover" style="min-height:60vh">
<span aria-hidden="true" class="wp-block-cover__background has-secondary-background-color has-background-dim"></span>
<div class="wp-block-cover__inner-container">
<!-- wp:heading {"textAlign":"center","level":1,"textColor":"background"} -->
<h1 class="wp-block-heading has-text-align-center has-background-color has-text-color">' . esc_html__( 'Welcome to Your New Site', 'spear' ) . '</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","textColor":"background"} -->
<p class="has-text-align-center has-background-color has-text-color">' . esc_html__( 'A starting point built with Spear — replace this with your own message.', 'spear' ) . '</p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button">' . esc_html__( 'Get Started', 'spear' ) . '</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
</div>
<!-- /wp:cover -->';
	}

	private static function about_content(): string {
		return '<!-- wp:columns -->
<div class="wp-block-columns">
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:heading -->
<h2 class="wp-block-heading">' . esc_html__( 'About Us', 'spear' ) . '</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>' . esc_html__( 'Tell your story here. Replace this placeholder text with your own about-page content.', 'spear' ) . '</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:column -->
<!-- wp:column -->
<div class="wp-block-column">
<!-- wp:image {"sizeSlug":"large"} -->
<figure class="wp-block-image size-large"></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->';
	}

	private static function contact_content(): string {
		return '<!-- wp:heading -->
<h2 class="wp-block-heading">' . esc_html__( 'Contact', 'spear' ) . '</h2>
<!-- /wp:heading -->
<!-- wp:paragraph -->
<p>' . esc_html__( 'Get in touch — replace this with your contact details or a contact form block.', 'spear' ) . '</p>
<!-- /wp:paragraph -->';
	}
}
