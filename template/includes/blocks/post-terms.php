<?php
/**
 * Post post terms block.
 * @author {{AUTHOR}}
 */

declare( strict_types=1 );

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'render_block_core/post-terms', {{CONST_PREFIX}}_NS . 'render_post_terms_block', 10, 2 );


/**
 * Modifies front end HTML output of block.
 */
function render_post_terms_block( string $html, array $block ): string {

	if ( isset( $block['blockName'] ) && 'core/post-terms' === $block['blockName'] ) {
		add_filter( '{{PFX}}_dynamic_theme_css', {{CONST_PREFIX}}_NS . 'post_terms_inline_css' );
	}
	return $html;
}


/**
 * Load Inline Css.
 */
function post_terms_inline_css( string $css ): string {

	$css_output = array(
		'.wp-block-post-terms a' => array(
			'color' => 'inherit',
		),
	);

	$css .= parse_css( $css_output );
	return $css;
}
