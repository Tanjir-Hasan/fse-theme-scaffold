<?php
/**
 * Post author block.
 *
 * @package {{THEME_NAME}}
 * @author {{AUTHOR}}
 * @since 1.0.0
 */

declare( strict_types=1 );

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'render_block_core/post-author', {{CONST_PREFIX}}_NS . 'render_post_author_block', 10, 2 );


/**
 * Modifies front end HTML output of block.
 */
function render_post_author_block( string $html, array $block ): string {
	$post_id = get_the_ID();
	if ( isset( $block['blockName'] ) && 'core/post-author' === $block['blockName'] ) {
	
		if ( ! get_the_author_meta( 'description', $post_id ) ) {
			add_filter( '{{PFX}}_dynamic_theme_css', {{CONST_PREFIX}}_NS . 'remove_author_bio' );
		}

		add_filter( '{{PFX}}_dynamic_theme_css', {{CONST_PREFIX}}_NS . 'post_author_inline_css' );
	}
	return $html;
}


/**
 * Load Inline Css.
 */
function post_author_inline_css( string $css ): string {

	$css_output = array(
		'.wp-block-post-author__bio' => array(
			'font-size' => 'inherit',
		),
	);

	$css .= parse_css( $css_output );
	return $css;
}

/**
 * Remove author bio.
 */
function remove_author_bio( string $css ): string {
	$css_output = array(
		'.is-style-{{SLUG}}-post-author-simple .wp-block-post-author__bio' => array(
			'display' => 'none',
		),
	);

	$css .= parse_css( $css_output );
	return $css;

}
