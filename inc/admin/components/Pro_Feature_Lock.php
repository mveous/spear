<?php
/**
 * Pro_Feature_Lock — the one reusable "this is a Pro feature" card (spec §6).
 *
 * Used directly in wp-admin (dashboard, future settings screens) and as the
 * render target of Spear\Admin\Customize\Locked_Control. Renders as static
 * marketing pointing at Spear Pro (a separate theme package, not a license
 * unlock) — never renders the real control it stands in for, never
 * activates anything, never fatals on an unknown feature id — it just
 * prints nothing and logs in debug mode. See
 * docs/architecture/04-feature-registry.md.
 *
 * @package Spear
 */

namespace Spear\Admin\Components;

use Spear\Core\Feature_Registry;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Pro_Feature_Lock {

	public static function render( string $feature_id ): void {
		$feature = Feature_Registry::get( $feature_id );

		if ( null === $feature ) {
			if ( function_exists( '_doing_it_wrong' ) ) {
				_doing_it_wrong(
					__METHOD__,
					sprintf( 'Unknown Spear feature id "%s".', esc_html( $feature_id ) ),
					'0.1.0'
				);
			}
			return;
		}
		?>
		<div class="spear-pro-lock">
			<div class="spear-pro-lock__header">
				<span class="spear-pro-lock__name"><?php echo esc_html( $feature['name'] ); ?></span>
				<span class="spear-pro-lock__badge" aria-hidden="true">&#128274;</span>
			</div>
			<p class="spear-pro-lock__description"><?php echo esc_html( $feature['description'] ); ?></p>
			<a
				class="spear-pro-lock__cta"
				href="<?php echo esc_url( spear_get_upgrade_url( $feature_id ) ); ?>"
				target="_blank"
				rel="noopener noreferrer"
			><?php esc_html_e( 'Get Spear Pro', 'spear' ); ?></a>
		</div>
		<?php
	}

	public static function enqueue_styles(): void {
		if ( ! wp_style_is( 'spear-admin-components', 'registered' ) ) {
			wp_register_style( 'spear-admin-components', false, [], SPEAR_VERSION );
		}
		wp_enqueue_style( 'spear-admin-components' );
		wp_add_inline_style( 'spear-admin-components', self::css() );
	}

	private static function css(): string {
		return '
.spear-pro-lock {
	border: 1px solid var(--spear-color-border, #e2e8f0);
	border-radius: var(--spear-visual-radius, 6px);
	padding: 12px 14px;
	background: var(--spear-color-surface, #f8fafc);
}
.spear-pro-lock__header {
	display: flex;
	align-items: center;
	justify-content: space-between;
	font-weight: 600;
	color: var(--spear-color-heading, #0f172a);
}
.spear-pro-lock__badge {
	font-size: 14px;
}
.spear-pro-lock__description {
	margin: 8px 0 12px;
	font-size: 12px;
	line-height: 1.5;
	color: var(--spear-color-muted, #64748b);
}
.spear-pro-lock__cta {
	display: inline-block;
	padding: 6px 12px;
	border-radius: var(--spear-visual-radius, 6px);
	background: var(--spear-color-primary, #2563eb);
	color: #fff;
	text-decoration: none;
	font-size: 12px;
	font-weight: 600;
}
.spear-pro-lock__cta:hover,
.spear-pro-lock__cta:focus {
	opacity: var(--spear-visual-hover-opacity, 0.85);
	color: #fff;
}
';
	}
}
