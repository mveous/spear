<?php
/**
 * Spear Feature Registry — static baseline.
 *
 * Loaded by Spear\Core\Feature_Registry::boot() before any Feature_Provider
 * module runs, so the admin dashboard's feature grid (and every locked
 * ProFeatureLock card) has a complete list from the very first request, on
 * a fresh install, before Pro is ever licensed. See
 * docs/architecture/04-feature-registry.md for the source table.
 *
 * @package Spear
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return [
	[
		'id'          => 'header_basic',
		'name'        => __( 'Basic Header', 'spear' ),
		'description' => __( 'Logo, navigation, and a single header layout.', 'spear' ),
		'category'    => 'header',
		'plan'        => 'free',
	],
	[
		'id'          => 'footer_basic',
		'name'        => __( 'Basic Footer', 'spear' ),
		'description' => __( 'A single footer layout with widgets and navigation.', 'spear' ),
		'category'    => 'footer',
		'plan'        => 'free',
	],
	[
		'id'          => 'blog_basic',
		'name'        => __( 'Blog Layouts', 'spear' ),
		'description' => __( 'Standard archive and single post layouts.', 'spear' ),
		'category'    => 'blog',
		'plan'        => 'free',
	],
	[
		'id'          => 'woocommerce_basic',
		'name'        => __( 'WooCommerce Compatibility', 'spear' ),
		'description' => __( 'Styled shop, product, cart, and checkout templates.', 'spear' ),
		'category'    => 'woocommerce',
		'plan'        => 'free',
	],
	[
		'id'          => 'starter_sites_free',
		'name'        => __( 'Free Starter Sites', 'spear' ),
		'description' => __( 'Import complete free starter sites in one click.', 'spear' ),
		'category'    => 'starter-sites',
		'plan'        => 'free',
	],
	[
		'id'          => 'gutenberg_patterns',
		'name'        => __( 'Block Patterns', 'spear' ),
		'description' => __( 'Ready-made block patterns for common page sections.', 'spear' ),
		'category'    => 'gutenberg',
		'plan'        => 'free',
	],
	[
		'id'          => 'sticky_header',
		'name'        => __( 'Sticky Header', 'spear' ),
		'description' => __( 'Keep the header visible as visitors scroll.', 'spear' ),
		'category'    => 'header',
		'plan'        => 'pro',
	],
	[
		'id'          => 'transparent_header',
		'name'        => __( 'Transparent Header', 'spear' ),
		'description' => __( 'A see-through header that overlays your hero section.', 'spear' ),
		'category'    => 'header',
		'plan'        => 'pro',
	],
	[
		'id'          => 'mega_menu',
		'name'        => __( 'Mega Menu', 'spear' ),
		'description' => __( 'Create advanced mega menus with columns, icons, images and CTA buttons.', 'spear' ),
		'category'    => 'header',
		'plan'        => 'pro',
	],
	[
		'id'          => 'advanced_header',
		'name'        => __( 'Advanced Header Builder', 'spear' ),
		'description' => __( 'A dedicated visual builder for header layouts.', 'spear' ),
		'category'    => 'header',
		'plan'        => 'pro',
	],
	[
		'id'          => 'header_layouts',
		'name'        => __( 'Multiple Header Layouts', 'spear' ),
		'description' => __( 'Choose from several pre-built header layouts, per page.', 'spear' ),
		'category'    => 'header',
		'plan'        => 'pro',
	],
	[
		'id'          => 'advanced_footer',
		'name'        => __( 'Advanced Footer Builder', 'spear' ),
		'description' => __( 'A dedicated visual builder for footer layouts.', 'spear' ),
		'category'    => 'footer',
		'plan'        => 'pro',
	],
	[
		'id'          => 'custom_fonts',
		'name'        => __( 'Custom Font Uploads', 'spear' ),
		'description' => __( 'Upload and use your own font files.', 'spear' ),
		'category'    => 'typography',
		'plan'        => 'pro',
	],
	[
		'id'          => 'advanced_typography',
		'name'        => __( 'Advanced Typography Controls', 'spear' ),
		'description' => __( 'Fine-grained control over every text element.', 'spear' ),
		'category'    => 'typography',
		'plan'        => 'pro',
	],
	[
		'id'          => 'advanced_spacing',
		'name'        => __( 'Advanced Spacing Controls', 'spear' ),
		'description' => __( 'Per-side, per-breakpoint spacing controls.', 'spear' ),
		'category'    => 'layout',
		'plan'        => 'pro',
	],
	[
		'id'          => 'advanced_responsive',
		'name'        => __( 'Advanced Responsive Controls', 'spear' ),
		'description' => __( 'Independent tablet and mobile overrides for every setting.', 'spear' ),
		'category'    => 'layout',
		'plan'        => 'pro',
	],
	[
		'id'          => 'advanced_blog',
		'name'        => __( 'Advanced Blog Layouts', 'spear' ),
		'description' => __( 'Additional archive layouts, grids, and card styles.', 'spear' ),
		'category'    => 'blog',
		'plan'        => 'pro',
	],
	[
		'id'          => 'advanced_woocommerce',
		'name'        => __( 'Advanced WooCommerce', 'spear' ),
		'description' => __( 'Product badges, quick view, and advanced shop layouts.', 'spear' ),
		'category'    => 'woocommerce',
		'plan'        => 'pro',
	],
	[
		'id'          => 'popup_builder',
		'name'        => __( 'Popup Builder', 'spear' ),
		'description' => __( 'Build and trigger popups without a separate plugin.', 'spear' ),
		'category'    => 'engagement',
		'plan'        => 'pro',
	],
	[
		'id'          => 'advanced_animation',
		'name'        => __( 'Advanced Animation', 'spear' ),
		'description' => __( 'Scroll and hover animations for any element.', 'spear' ),
		'category'    => 'design',
		'plan'        => 'pro',
	],
	[
		'id'          => 'premium_templates',
		'name'        => __( 'Premium Templates', 'spear' ),
		'description' => __( 'Access the full premium starter-site library.', 'spear' ),
		'category'    => 'starter-sites',
		'plan'        => 'pro',
	],
	[
		'id'          => 'cloud_templates',
		'name'        => __( 'Cloud Template Library', 'spear' ),
		'description' => __( 'Browse and import an ever-growing cloud template library.', 'spear' ),
		'category'    => 'starter-sites',
		'plan'        => 'pro',
	],
	[
		'id'          => 'spear_editor_pro',
		'name'        => __( 'Spear Editor Pro', 'spear' ),
		'description' => __( 'Advanced layout, animation, dynamic content, and premium components in Spear Editor.', 'spear' ),
		'category'    => 'editor',
		'plan'        => 'pro',
	],
	[
		'id'          => 'spear_ai',
		'name'        => __( 'Spear AI', 'spear' ),
		'description' => __( 'Generate complete pages from a text prompt.', 'spear' ),
		'category'    => 'editor',
		'plan'        => 'pro',
	],
	[
		'id'          => 'figma_import',
		'name'        => __( 'Figma Import', 'spear' ),
		'description' => __( 'Turn a Figma design into an editable Spear Editor page.', 'spear' ),
		'category'    => 'editor',
		'plan'        => 'pro',
	],
	[
		'id'          => 'ai_code_import',
		'name'        => __( 'AI Code Import', 'spear' ),
		'description' => __( 'Paste HTML, CSS, or JS and convert it into editable components.', 'spear' ),
		'category'    => 'editor',
		'plan'        => 'pro',
	],
];
