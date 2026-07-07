<?php
/**
 * Responsive Support for Gutenburg Blocks
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


add_filter( 'render_block', {{CONST_PREFIX}}_NS . 'render_responsive_blocks', 10, 2 );

/**
 *  Render Responsive Blocks.
 */
function render_responsive_blocks( string $block_content, array $block ):string { 
	$responsive_classes = '';

	if ( isset( $block['attrs']['{{CONST_PREFIX}}HideDesktop'] ) && true === $block['attrs']['{{CONST_PREFIX}}HideDesktop'] ) {
		$responsive_classes .= ' {{SLUG}}-hide-desktop';
	}

	if ( isset( $block['attrs']['{{CONST_PREFIX}}HideTab'] ) && true === $block['attrs']['{{CONST_PREFIX}}HideTab'] ) {
		$responsive_classes .= ' {{SLUG}}-hide-tablet';
	}

	if ( isset( $block['attrs']['{{CONST_PREFIX}}HideMob'] ) && true === $block['attrs']['{{CONST_PREFIX}}HideMob'] ) {
		$responsive_classes .= ' {{SLUG}}-hide-mobile';
	}

	$dom        = dom( $block_content );
	$first_item = get_dom_element( '*', $dom );

	if ( ! $first_item ) {
		return $block_content;
	}

	$classes = $first_item->getAttribute( 'class' );

	if ( $responsive_classes ) {
		$first_item->setAttribute( 'class', $classes . $responsive_classes );
		$block_content = $dom->saveHTML();
	}

	add_filter( '{{PFX}}_dynamic_theme_css', {{CONST_PREFIX}}_NS . 'responsive_blocks_inline_css' );

	return $block_content;
}

/**
 * Responsive Blocks Inline CSS.
 */
function responsive_blocks_inline_css( $css ): string {

	$css_desktop_output = array(
		'.{{SLUG}}-hide-desktop' => array(
			'display' => 'none !important',
		),
	);

	$css .= parse_css( $css_desktop_output, '1025', '' );

	$css_tablet_output = array(
		'.{{SLUG}}-hide-tablet' => array(
			'display' => 'none !important ',
		),
	);

	$css .= parse_css( $css_tablet_output, '768', '1024' );

	$css_mobile_output = array(
		'.{{SLUG}}-hide-mobile' => array(
			'display' => 'none !important',
		),
	);

	$css .= parse_css( $css_mobile_output, '', '767' );

	return $css;
}

// Disable {{SLUG}} plugin responsive controls.
add_filter( 'enable_responsive_condition_for_core', '__return_false' );
