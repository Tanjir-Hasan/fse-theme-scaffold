<?php
/**
 * Meta Box
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'init', {{CONST_PREFIX}}_NS . 'register_meta_settings' );

/**
 * Register Post Meta options for react based fields.
 *
 * @since 0.0.1
 * @return void
 */
function register_meta_settings():void {
	register_post_meta(
		'',
		'_{{PFX}}_meta_header_display',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'boolean',
			'auth_callback' => '__return_true',
		)
	);

	register_post_meta(
		'',
		'_{{PFX}}_meta_footer_display',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'boolean',
			'auth_callback' => '__return_true',
		)
	);

	register_post_meta(
		'',
		'_{{PFX}}_meta_site_title_display',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'boolean',
			'auth_callback' => '__return_true',
		)
	);

	register_post_meta(
		'',
		'_{{PFX}}_meta_sticky_header',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'boolean',
			'auth_callback' => '__return_true',
		)
	);

	register_post_meta(
		'',
		'_{{PFX}}_meta_transparent_header',
		array(
			'show_in_rest'  => true,
			'single'        => true,
			'type'          => 'boolean',
			'auth_callback' => '__return_true',
		)
	);
}
