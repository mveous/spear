<?php
/**
 * Title: Simple Business — Hero
 * Slug: spear/simple-business-hero
 * Categories: banner
 * Inserter: true
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<!-- wp:cover {"overlayColor":"secondary","minHeight":60,"minHeightUnit":"vh"} -->
<div class="wp-block-cover" style="min-height:60vh">
<span aria-hidden="true" class="wp-block-cover__background has-secondary-background-color has-background-dim"></span>
<div class="wp-block-cover__inner-container">
<!-- wp:heading {"textAlign":"center","level":1,"textColor":"background"} -->
<h1 class="wp-block-heading has-text-align-center has-background-color has-text-color"><?php echo esc_html__( 'Welcome to Your New Site', 'spear' ); ?></h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","textColor":"background"} -->
<p class="has-text-align-center has-background-color has-text-color"><?php echo esc_html__( 'A starting point built with Spear — replace this with your own message.', 'spear' ); ?></p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button"><?php echo esc_html__( 'Get Started', 'spear' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
</div>
<!-- /wp:cover -->
