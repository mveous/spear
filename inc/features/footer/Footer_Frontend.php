<?php
/**
 * Footer_Frontend — turns the Customizer settings into real output.
 *
 * The copyright text is made dynamic via a render_block filter keyed to a
 * className we control (parts/footer.html tags the paragraph with
 * "spear-footer-copyright") rather than sniffing block context — reliable
 * regardless of where WordCore changes how template-part rendering context
 * is exposed.
 *
 * @package Spear
 */

namespace Spear\Features\Footer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Footer_Frontend {

	public static function boot(): void {
		add_filter( 'body_class', [ __CLASS__, 'body_class' ] );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'inline_style' ], 11 );
		add_filter( 'render_block', [ __CLASS__, 'filter_copyright' ], 10, 2 );
	}

	public static function body_class( array $classes ): array {
		$classes[] = 'spear-footer-layout-' . get_theme_mod( 'spear_footer_layout', 'row' );
		return $classes;
	}

	public static function inline_style(): void {
		if ( ! wp_style_is( 'spear-tokens', 'registered' ) ) {
			return;
		}

		wp_add_inline_style(
			'spear-tokens',
			'
body.spear-footer-layout-stacked footer.wp-block-group.is-layout-flex {
	flex-direction: column;
	align-items: flex-start;
	gap: 0.75rem;
}
'
		);
	}

	public static function filter_copyright( string $block_content, array $block ): string {
		if ( 'core/paragraph' !== ( $block['blockName'] ?? '' ) ) {
			return $block_content;
		}

		$class_name = $block['attrs']['className'] ?? '';
		if ( false === strpos( $class_name, 'spear-footer-copyright' ) ) {
			return $block_content;
		}

		$template = get_theme_mod( 'spear_footer_copyright', Footer_Customizer::DEFAULT_COPYRIGHT );
		$text     = strtr(
			$template,
			[
				'{year}'      => gmdate( 'Y' ),
				'{site_name}' => get_bloginfo( 'name' ),
			]
		);

		return sprintf( '<p class="spear-footer-copyright">%s</p>', esc_html( $text ) );
	}
}
