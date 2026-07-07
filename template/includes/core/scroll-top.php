<?php
/**
 * Scroll Top
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'wp', {{CONST_PREFIX}}_NS . 'scroll_top', 10, 2 );


/**
 * Scroll to top
 */
function scroll_top():void {
	$global_theme_options = get_option( '{{PFX}}_theme_options' );

	$is_scroll_top_enabled = isset( $global_theme_options['scroll_top'] ) ? $global_theme_options['scroll_top'] : false;

	if ( $is_scroll_top_enabled ) {
		add_filter( 'wp_footer', {{CONST_PREFIX}}_NS . 'render_scroll_top', 10, 2 );
		add_filter( '{{PFX}}_dynamic_theme_css', {{CONST_PREFIX}}_NS . 'scroll_top_inline_css' );
		add_filter( '{{PFX}}_dynamic_theme_js', {{CONST_PREFIX}}_NS . 'scroll_top_js' );
	}
}

/**
 * Render scroll to top
 */
function render_scroll_top():void {
	/** @psalm-suppress UndefinedFunction */ // phpcs:ignore PossiblyFalseArgument, Generic.Commenting.DocComment.MissingShort -- Function exist in helpers.php 
	echo fetch_svg_icon( 'arrow-top', '{{SLUG}}-scroll-top', false ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Required to get svg.json.
}

/**
 * Scroll top inline css.
 */
function scroll_top_inline_css( string $css ): string {

	$css_output = array(
		'.{{SLUG}}-scroll-top'          => array(
			'display'          => 'flex',
			'align-items'      => 'center',
			'justify-content'  => 'center',
			'position'         => 'fixed',
			'right'            => 'var(--wp--preset--spacing--small)',
			'bottom'           => 'var(--wp--preset--spacing--small)',
			'width'            => 'var(--wp--preset--spacing--large)',
			'height'           => 'var(--wp--preset--spacing--large)',
			'background-color' => 'var(--wp--preset--color--foreground)',
			'border-radius'    => 'var(--wp--custom--border-radius--full)',
			'cursor'           => 'pointer',
			'transform'        => 'scale(0)',
			'transition'       => '.2s',

		),

		'.{{SLUG}}-scroll-top svg path' => array(
			'stroke' => 'var(--wp--preset--color--background)',
		),
	);

	$css .= parse_css( $css_output );

	return $css;
}


/**
 * Scroll top inline js.
 */
function scroll_top_js( string $js ): string {
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

	const scrollTop = document.querySelector('.{{SLUG}}-scroll-top');
	docReady(function() {
		scrollTop.addEventListener('click', function() {
			window.scrollTo({top: 0, behavior: 'smooth'});
		})
	});

	window.addEventListener("scroll", function(){
		if( window.scrollY >= 100 ) {
			scrollTop.style.transform  = 'scale(1)';
		} else {
			scrollTop.style.transform  = 'scale(0)';
		}
	}, true);

JS;
	$js       .= $inline_js;
	return $js;
}
