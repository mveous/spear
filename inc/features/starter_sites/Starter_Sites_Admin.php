<?php
/**
 * Starter_Sites_Admin — the Appearance > Starter Sites wp-admin screen.
 * A wp-api-fetch page talking to Starter_Sites_REST_Controller — fetches
 * the catalog from GET /spear/v1/starter-sites (locked Pro entries included with
 * `locked: true`, per 10-rest-api.md) and imports via
 * POST /spear/v1/starter-sites/{id}/import.
 *
 * @package Spear
 */

namespace Spear\Features\Starter_Sites;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Starter_Sites_Admin {

	const MENU_SLUG = 'spear-starter-sites';

	public static function boot(): void {
		add_action( 'admin_menu', [ __CLASS__, 'register_menu' ] );
		add_action( 'admin_enqueue_scripts', [ __CLASS__, 'enqueue' ] );
	}

	public static function register_menu(): void {
		add_theme_page(
			__( 'Starter Sites', 'spear' ),
			__( 'Starter Sites', 'spear' ),
			'manage_options',
			self::MENU_SLUG,
			[ __CLASS__, 'render' ]
		);
	}

	public static function enqueue( string $hook ): void {
		if ( 'appearance_page_' . self::MENU_SLUG !== $hook ) {
			return;
		}

		wp_enqueue_script( 'wp-api-fetch' );
		wp_register_script( 'spear-starter-sites-admin', false, [ 'wp-api-fetch' ], SPEAR_VERSION, true );
		wp_add_inline_script(
			'spear-starter-sites-admin',
			'window.spearUpgradeUrl = ' . wp_json_encode( spear_get_upgrade_url( 'starter_sites' ) ) . ';',
			'before'
		);
		wp_enqueue_script( 'spear-starter-sites-admin' );
		wp_add_inline_script( 'spear-starter-sites-admin', self::inline_script() );
	}

	public static function render(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Starter Sites', 'spear' ); ?></h1>
			<p><?php esc_html_e( 'Import a complete starter site in one click. This creates new pages — it never deletes existing content.', 'spear' ); ?></p>
			<p id="spear-starter-sites-message"></p>
			<div id="spear-starter-sites-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;margin-top:16px;">
				<p><?php esc_html_e( 'Loading…', 'spear' ); ?></p>
			</div>
		</div>
		<?php
	}

	private static function inline_script(): string {
		return <<<'JS'
( function ( wp ) {
	var apiFetch = wp.apiFetch;
	var grid      = document.getElementById( 'spear-starter-sites-grid' );
	var messageEl = document.getElementById( 'spear-starter-sites-message' );

	function escapeHtml( text ) {
		var div = document.createElement( 'div' );
		div.textContent = text || '';
		return div.innerHTML;
	}

	function renderCard( site ) {
		var card = document.createElement( 'div' );
		card.style.cssText = 'border:1px solid #dcdcde;border-radius:4px;padding:16px;background:#fff;';

		var actionHtml = site.locked
			? '<p><em>' + escapeHtml( 'Available with Spear Pro.' ) + '</em> <a href="' + escapeHtml( window.spearUpgradeUrl ) + '">' + escapeHtml( 'Upgrade to Pro' ) + '</a></p>'
			: '<button type="button" class="button button-primary" data-site-id="' + escapeHtml( site.id ) + '">' + escapeHtml( 'Import' ) + '</button>';

		card.innerHTML = '<h2 style="margin-top:0;">' + escapeHtml( site.name ) + '</h2>'
			+ '<p>' + escapeHtml( site.description ) + '</p>'
			+ actionHtml;

		return card;
	}

	function load() {
		apiFetch( { path: '/spear/v1/starter-sites' } ).then( function ( sites ) {
			grid.innerHTML = '';
			sites.forEach( function ( site ) {
				grid.appendChild( renderCard( site ) );
			} );
		} ).catch( function () {
			grid.textContent = 'Unable to load starter sites.';
		} );
	}

	grid.addEventListener( 'click', function ( e ) {
		var button = e.target.closest( '[data-site-id]' );
		if ( ! button ) {
			return;
		}
		messageEl.textContent = '';
		button.disabled = true;
		apiFetch( {
			path: '/spear/v1/starter-sites/' + button.getAttribute( 'data-site-id' ) + '/import',
			method: 'POST'
		} ).then( function () {
			messageEl.textContent = 'Starter site imported.';
		} ).catch( function ( error ) {
			messageEl.textContent = ( error && error.message ) || 'Import failed.';
			button.disabled = false;
		} );
	} );

	load();
} )( window.wp );
JS;
	}
}
