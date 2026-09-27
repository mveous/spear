<?php
/**
 * Oxygen_Adapter — Oxygen fully replaces `the_content()` rendering (and,
 * in its "Advanced Frontend Editor" mode, the entire page including
 * header/footer) via its own `template_include` filter registered at very
 * high priority from the plugin itself — it doesn't wait for or need the
 * active theme to step aside, which is why this adapter is close to a
 * no-op by design (matching docs/architecture/06-universal-editor-api.md's
 * own description: "register() is nearly a no-op ... enqueue_assets() is
 * empty"). Spear's own fallback template still renders correctly for every
 * page Oxygen hasn't built, satisfying "never require a builder."
 *
 * sync_design_tokens() is a no-op for the same reason as every other
 * adapter here — see Elementor_Adapter's docblock.
 *
 * @package Spear
 */

namespace Spear\Integrations\Oxygen;

use Spear\Core\Contracts\Editor_Adapter;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Oxygen_Adapter implements Editor_Adapter {

	public function id(): string {
		return 'oxygen';
	}

	public function is_active(): bool {
		return defined( 'CT_VERSION' );
	}

	public function sync_design_tokens( array $tokens ): void {
		// See class docblock.
	}

	public function register(): void {
		// See class docblock — Oxygen already takes over rendering itself
		// on any page it built; nothing for Spear to relinquish explicitly.
	}

	public function enqueue_assets(): void {
		// Intentionally empty — see class docblock and
		// docs/architecture/06-universal-editor-api.md's own note that
		// this method is empty for Oxygen.
	}
}
