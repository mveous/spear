<?php
/**
 * Spear Design Tokens — single source of truth.
 *
 * Compiled by Spear\Core\Design_Tokens into CSS custom properties, and read
 * by theme.json (kept in sync by hand until Phase 3's Design System admin
 * screen can write theme.json directly). See docs/architecture/05-design-system.md.
 *
 * Naming rule: every leaf becomes `--spear-{top-level-key}-{path}`, e.g.
 * color.primary -> --spear-color-primary, typography.size-h1 -> --spear-typography-size-h1.
 * `breakpoints` is the one exception — it's consumed server-side/JS-side for
 * responsive prop resolution, not emitted as a CSS custom property.
 *
 * @package Spear
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return [
	'color'      => [
		'primary'    => '#2563eb',
		'secondary'  => '#0f172a',
		'accent'     => '#f59e0b',
		'background' => '#ffffff',
		'surface'    => '#f8fafc',
		'text'       => '#1e293b',
		'heading'    => '#0f172a',
		'muted'      => '#64748b',
		'border'     => '#e2e8f0',
		'success'    => '#16a34a',
		'warning'    => '#f59e0b',
		'error'      => '#dc2626',
		'info'       => '#0ea5e9',
	],
	'typography' => [
		'font-body'              => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
		'font-heading'           => '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
		'size-h1'                => '2.5rem',
		'size-h2'                => '2rem',
		'size-h3'                => '1.75rem',
		'size-h4'                => '1.5rem',
		'size-h5'                => '1.25rem',
		'size-h6'                => '1rem',
		'size-body'              => '1rem',
		'size-small'             => '0.875rem',
		'size-caption'           => '0.75rem',
		'size-button'            => '1rem',
		'line-height-heading'    => '1.2',
		'line-height-body'       => '1.6',
		'letter-spacing-heading' => '-0.02em',
		'letter-spacing-body'    => 'normal',
	],
	'layout'     => [
		'container-width' => '1200px',
		'content-width'   => '720px',
		'wide-width'      => '1000px',
		'spacing-section' => '5rem',
		'gap-column'      => '2rem',
		'gap-grid'        => '1.5rem',
	],
	'visual'     => [
		'radius'        => '0.5rem',
		'border-width'  => '1px',
		'shadow-sm'     => '0 1px 2px 0 rgba(15, 23, 42, 0.06)',
		'shadow-md'     => '0 4px 6px -1px rgba(15, 23, 42, 0.1)',
		'shadow-lg'     => '0 10px 15px -3px rgba(15, 23, 42, 0.1)',
		'transition'    => '150ms ease',
		'hover-opacity' => '0.85',
	],
	'component'  => [
		'button-radius' => 'var(--spear-visual-radius)',
		'card-radius'   => 'var(--spear-visual-radius)',
		'card-shadow'   => 'var(--spear-visual-shadow-sm)',
		'input-radius'  => 'var(--spear-visual-radius)',
		'input-border'  => 'var(--spear-color-border)',
	],
	'breakpoints' => [
		'mobile' => 599,
		'tablet' => 781,
	],
];
