<?php
/**
 * Post Feature image Block.
 * @author {{AUTHOR}}
 */

declare( strict_types=1 );

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'render_block_core/post-featured-image', {{CONST_PREFIX}}_NS . 'render_featured_image_block', 10, 2 );

/**
 * Modifies front end HTML output of block.
 */
function render_featured_image_block( string $html, array $block ): string {
	if ( ! $html && ! ( is_single() || is_page() ) && isset( $block['attrs'] ) ) {
		$html = render_image_placeholder( $html, $block['attrs'] );
		add_filter( '{{PFX}}_dynamic_theme_css', {{CONST_PREFIX}}_NS . 'post_featured_image_inline_css' );
	}
	return $html;
}


/**
 * Load Inline Css.
 */
function post_featured_image_inline_css( string $css ): string {

	$css_output = array(
		'.is-placeholder' => array(
			'position'        => 'relative',
			'width'           => '100%',
			'height'          => 'auto',
			'display'         => 'flex',
			'align-items'     => 'center',
			'justify-content' => 'center',
			'background'      => 'var(--wp--preset--color--surface)',
			'border'          => '0',
		),
	);

	$css .= parse_css( $css_output );
	return $css;
}
