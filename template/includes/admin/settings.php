<?php
/**
 * Admin Global settings route.
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_action( 'rest_api_init', {{CONST_PREFIX}}_NS . 'create_rest_routes' );

/**
 * Creating rest routes
 */
function create_rest_routes():void {
	register_rest_route(
		{{CONST_PREFIX}}_PFX . '/v1',
		'/global_settings',
		array(
			array(
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => {{CONST_PREFIX}}_NS . '{{PFX}}_get_global_settings',
				'permission_callback' => function () {
					return true;
				},
			),
			array(
				'methods'             => \WP_REST_Server::EDITABLE,
				'callback'            => {{CONST_PREFIX}}_NS . '{{PFX}}_update_global_settings',
				'permission_callback' => function () {
					return current_user_can( 'edit_theme_options' );
				},
			),
		)
	);
}

/**
 * Get configs
 */
function {{PFX}}_get_global_settings( \WP_REST_Request $request ) {
	$settings = get_option( '{{PFX}}_theme_options' );

	return rest_ensure_response( $settings );  
}



/**
 * Set configs
 */
function {{PFX}}_update_global_settings( \WP_REST_Request $request ) {

	$fields = isset( $request['setting'] ) ? $request['setting'] : array();

	if ( ! empty( $fields ) ) {
		update_option( '{{PFX}}_theme_options', $fields );
	}

	return rest_ensure_response( 'success' );  

}
