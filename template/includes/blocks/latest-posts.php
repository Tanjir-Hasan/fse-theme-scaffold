<?php
/**
 * Latest post block.
 * @author {{AUTHOR}}
 */

declare( strict_types=1 );

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'render_block_core/latest-posts', {{CONST_PREFIX}}_NS . 'render_latest_post_block', 10, 2 );

/**
 * Modifies front end HTML output of block.
 */
function render_latest_post_block( string $html, array $block ): string {
  
	if ( isset( $block['attrs']['displayFeaturedImage'] ) && true === $block['attrs']['displayFeaturedImage'] ) {
		$dom     = dom( $html );
		$element = get_dom_element( '*', $dom );
	
		if ( ! $element ) {
			return $html;
		}
	
		$classes = $element->getAttribute( 'class' );
		$element->setAttribute( 'class', $classes . ' {{SLUG}}-has-featured-image' );
		$html = $dom->saveHTML();
	}
	
	return $html;
}
