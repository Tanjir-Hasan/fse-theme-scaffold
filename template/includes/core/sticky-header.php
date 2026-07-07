<?php
/**
 * Header functions
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'render_block', {{CONST_PREFIX}}_NS . 'render_header', 10, 2 );

/**
 * Header render function.
 */
function render_header( string $block_content, array $block ):string {
	$post_id = front_post_ID();

	$sticky_header_condition = $post_id
		? get_post_meta( $post_id, '_{{PFX}}_meta_sticky_header', true ) || ( $block['attrs']['{{CONST_PREFIX}}StickyHeader'] ?? false )
		: ( $block['attrs']['{{CONST_PREFIX}}StickyHeader'] ?? false );

	$transparent_header_condition = $post_id
		? get_post_meta( $post_id, '_{{PFX}}_meta_transparent_header', true ) || ( $block['attrs']['{{CONST_PREFIX}}TransparentHeader'] ?? false )
		: ( $block['attrs']['{{CONST_PREFIX}}TransparentHeader'] ?? false );

	/** @psalm-suppress PossiblyFalseArgument */ // phpcs:ignore PossiblyFalseArgument, Generic.Commenting.DocComment.MissingShort
	$not_transparent_header_condition = ! ( isset( $block['attrs']['{{CONST_PREFIX}}TransparentHeader'] ) ) || ( isset( $block['attrs']['{{CONST_PREFIX}}TransparentHeader'] ) && false === $block['attrs']['{{CONST_PREFIX}}TransparentHeader'] ) || ( get_post_meta( $post_id, '_{{PFX}}_meta_transparent_header', true ) );

	if ( $sticky_header_condition && ! get_post_meta( $post_id, '_{{PFX}}_meta_transparent_header', true ) ) {

		$dom    = dom( $block_content );
		$header = get_dom_element( 'header', $dom );

		if ( ! $header ) {
			return $block_content;
		}

		$classes = $header->getAttribute( 'class' );
		$header->setAttribute( 'class', $classes . ' {{SLUG}}-sticky-header' );

		$block_content = $dom->saveHTML();

		add_filter( '{{PFX}}_dynamic_theme_css', {{CONST_PREFIX}}_NS . 'header_sticky_inline_css' );

		if ( $not_transparent_header_condition ) {
			add_filter( '{{PFX}}_dynamic_theme_js', {{CONST_PREFIX}}_NS . 'header_sticky_inline_js' );
			add_filter( '{{PFX}}_dynamic_theme_css', {{CONST_PREFIX}}_NS . 'header_shadow_inline_css' );
		}
	}

	if ( $transparent_header_condition && ! get_post_meta( $post_id, '_{{PFX}}_meta_sticky_header', true ) ) {
		
		$dom    = dom( $block_content );
		$header = get_dom_element( 'header', $dom );

		if ( ! $header ) {
			return $block_content;
		}

		$classes = $header->getAttribute( 'class' );
		$header->setAttribute( 'class', $classes . ' {{SLUG}}-transparent-header' );

		$block_content = $dom->saveHTML();

		add_filter( '{{PFX}}_dynamic_theme_css', {{CONST_PREFIX}}_NS . 'header_transparent_inline_css' );
	}

	if ( $sticky_header_condition || $transparent_header_condition ) {
		add_filter( '{{PFX}}_dynamic_theme_js', {{CONST_PREFIX}}_NS . 'header_wp_admin_bar_spacing_js' );
	}

	return $block_content;
}

/**
 * Load header inline css.
 */
function header_shadow_inline_css( string $css ): string {

	$css_output = array(
		'.{{SLUG}}-sticky-header.{{SLUG}}-sticky-header-active' => array(
			'box-shadow' => '0px 8px 24px -8px rgba(0, 0, 0, 0.08)',
			'transition' => '.2s ease-in-out',
		),
	);
	$css       .= parse_css( $css_output );
	return $css;
}

/**
 * Load header inline css.
 *
 * @since 0.0.1
 * @param string $css Inline CSS.
 * @return string
 */
function header_sticky_inline_css( string $css ): string {

	// Sticky header option.
	$css_output = array(
		'.{{SLUG}}-sticky-header' => array(
			'position' => 'fixed',
			'top'      => '0',
			'left'     => '0',
			'width'    => '100%',
			'z-index'  => '999',
		),
	);
	$css       .= parse_css( $css_output );
	return $css;
}

/**
 * Load header inline js.
 */
function header_sticky_inline_js( string $js ): string {
	$inline_js = <<<JS

	function docReady(fn) {
		// see if DOM is already available
		if (document.readyState === "complete" || document.readyState === "interactive") {
			// call on next available tick
			setTimeout(fn, 1);
		} else {
			document.addEventListener("DOMContentLoaded", fn);
		}
	}

	function stickyHeaderSpacing() {
		// Sticky header option.
		const header = document.querySelector( '.{{SLUG}}-sticky-header' );
		const body = document.querySelector( 'body' );
		if( header ) {

			const height = header.offsetHeight;

			if( height ) {
				body.style.paddingTop = parseFloat( height ) + 'px';
			}
		}
	}

	docReady(function() {
		stickyHeaderSpacing();
	});

	window.addEventListener("scroll", function(){
		const header = document.querySelector( '.{{SLUG}}-sticky-header' );

		if( header ) {
			if( window.scrollY >= 10 ) {
				header.classList.add('{{SLUG}}-sticky-header-active');
			} else {
				header.classList.remove('{{SLUG}}-sticky-header-active');
			}	
		}
	
	});

	window.addEventListener('resize', function(event) {
		stickyHeaderSpacing();
	}, true);
JS;
	$js       .= $inline_js;
	return $js;
}

/**
 * Load transparent header inline css.
 */
function header_transparent_inline_css( string $css ): string {

	$css_output = array(
		'.wp-site-blocks'                           => array(
			'position' => 'relative',
		),

		'.{{SLUG}}-transparent-header'                   => array(
			'position' => 'absolute',
			'top'      => '0',
			'left'     => '0',
			'width'    => '100%',
			'z-index'  => '999',
		),

		'.{{SLUG}}-transparent-header > .has-background' => array(
			'background' => 'transparent !important',
		),
	);
	$css .= parse_css( $css_output );
	return $css;
}


/**
 * Load header wp_admin_bar spacing inline js.
 */
function header_wp_admin_bar_spacing_js( string $js ): string {
	$inline_js = <<<JS
	function docReady(fn) {
		// see if DOM is already available
		if (document.readyState === "complete" || document.readyState === "interactive") {
			// call on next available tick
			setTimeout(fn, 1);
		} else {
			document.addEventListener("DOMContentLoaded", fn);
		}
	}

	function wpAdminPaddingOffset() {
		const wpAdminBar = document.querySelector('#wpadminbar');
		const header = document.querySelector( 'header' );


		if( header && wpAdminBar && ! header.classList.contains('{{SLUG}}-transparent-header') ) {
			header.style.top = wpAdminBar.offsetHeight + 'px';
		}
	}

	docReady(function() {
		wpAdminPaddingOffset();
	});

	window.addEventListener('resize', function(event) {
		wpAdminPaddingOffset();
	}, true);

JS;
	$js       .= $inline_js;
	return $js;
}
