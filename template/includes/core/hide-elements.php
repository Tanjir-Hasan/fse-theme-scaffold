<?php
/**
 * Hide Elements
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'render_block', {{CONST_PREFIX}}_NS . 'hide_elements', 10, 2 );

/**
 * Hide Elements.
 */
function hide_elements( string $block_content, array $block ): string {
	$post_id = front_post_ID();

	if ( get_post_meta( $post_id, '_{{PFX}}_meta_header_display', true ) ) {

		if ( isset( $block['attrs']['slug'] ) && 'header' === $block['attrs']['slug'] ) {
			return '';
		}
	}

	if ( get_post_meta( $post_id, '_{{PFX}}_meta_footer_display', true ) ) {

		if ( isset( $block['attrs']['slug'] ) && 'footer' === $block['attrs']['slug'] ) {
			return '';
		}
	}

	return $block_content;
}


/**
 * Get disable section fields.
 */
function get_disable_section_fields():array {
	${{PFX}}_page_meta_elements = array(
		array(
			'key'   => '_{{PFX}}_meta_header_display',
			'label' => __( 'Disable Header', '{{SLUG}}' ),
		),
		array(
			'key'   => '_{{PFX}}_meta_footer_display',
			'label' => __( 'Disable Footer', '{{SLUG}}' ),
		),
	);

	return ${{PFX}}_page_meta_elements;
}
