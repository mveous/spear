<?php
/**
 * Blog_Frontend — turns the Customizer settings into real output.
 *
 * Featured image and date visibility use the same className + render_block
 * pattern as Footer_Frontend's copyright — templates/index.html and
 * templates/archive.html tag those two blocks with
 * "spear-blog-featured-image" / "spear-blog-post-date" so the filter only
 * ever touches the instances Spear itself renders in the blog loop, never
 * every post-featured-image/post-date block site-wide (e.g. on single.html).
 *
 * @package Spear
 */

namespace Spear\Features\Blog;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Blog_Frontend {

	public static function boot(): void {
		add_filter( 'excerpt_length', [ __CLASS__, 'excerpt_length' ] );
		add_filter( 'render_block', [ __CLASS__, 'filter_toggleable_blocks' ], 10, 2 );
	}

	public static function excerpt_length( int $length ): int {
		return (int) get_theme_mod( 'spear_blog_excerpt_length', 30 );
	}

	public static function filter_toggleable_blocks( string $block_content, array $block ): string {
		$block_name = $block['blockName'] ?? '';
		$class_name = $block['attrs']['className'] ?? '';

		if (
			'core/post-featured-image' === $block_name
			&& false !== strpos( $class_name, 'spear-blog-featured-image' )
			&& ! get_theme_mod( 'spear_blog_show_featured_image', true )
		) {
			return '';
		}

		if (
			'core/post-date' === $block_name
			&& false !== strpos( $class_name, 'spear-blog-post-date' )
			&& ! get_theme_mod( 'spear_blog_show_date', true )
		) {
			return '';
		}

		return $block_content;
	}
}
