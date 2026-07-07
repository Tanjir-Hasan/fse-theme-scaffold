<?php
/**
 * Navigation submenu block.
 * @author {{AUTHOR}}
 */

declare( strict_types=1 );

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'render_block_core/navigation-submenu', {{CONST_PREFIX}}_NS . 'render_navigation_submenu_block', 10, 2 );


/**
 * Modifies front end HTML output of block.
 */
function render_navigation_submenu_block( string $html, array $block ): string {

	if ( isset( $block['blockName'] ) && 'core/navigation-submenu' === $block['blockName'] ) {
		add_filter( '{{PFX}}_dynamic_theme_css', {{CONST_PREFIX}}_NS . 'navigation_submenu_inline_css' );
	}
	return $html;
}


/**
 * Load Inline Css.
 *
 * @since 1.0.0
 * @param string $css Inline CSS.
 * @return string
 */
function navigation_submenu_inline_css( string $css ): string {

	$css_output = array(
		'.wp-block-navigation-item.has-child .wp-block-navigation-item.has-child' => array(
			'color' => 'inherit !important',
		),
	);

	$css .= parse_css( $css_output );
	return $css;
}
