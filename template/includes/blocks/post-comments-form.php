<?php
/**
 * Post comments form block.
 * @author {{AUTHOR}}
 */

declare( strict_types=1 );

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'render_block_core/post-comments-form', {{CONST_PREFIX}}_NS . 'render_post_comments_form_block', 10, 2 );


/**
 * Modifies front end HTML output of block.
 */
function render_post_comments_form_block( string $html, array $block ): string {

	if ( isset( $block['blockName'] ) && 'core/post-comments-form' === $block['blockName'] ) {
		add_filter( '{{PFX}}_dynamic_theme_css', {{CONST_PREFIX}}_NS . 'post_comments_form_inline_css' );
	}
	return $html;
}


/**
 * Load Inline Css.
 */
function post_comments_form_inline_css( string $css ): string {

	$css_output = array(
		'.comment-form-comment textarea'               => array(
			'position' => 'relative',
			'z-index'  => '1',
		),

		'.comment-form-comment textarea:focus-visible' => array(
			'outline-color' => 'var(--wp--preset--color--heading)',
		),
	);

	$css .= parse_css( $css_output );
	return $css;
}
