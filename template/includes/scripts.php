<?php
/**
 * Load Scripts
 */

declare( strict_types=1 );

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Enqueue Frontend Scripts.
 */
function enqueue_frontend_scripts(): void {
	if ( false === apply_filters( '{{PFX}}_enqueue_frontend_scripts', true ) ) {
		return;
	}

	$file_prefix = defined( '{{CONST_PREFIX}}_DEBUG' ) && {{CONST_PREFIX}}_DEBUG ? '' : '.min';

	$js_uri = get_uri() . 'assets/js/';


	$css_uri = get_uri() . 'assets/css/';
	/* RTL */
	if ( is_rtl() ) {
		$file_prefix .= '-rtl';
	}

	/* Load Theme Styles*/
	wp_enqueue_style( {{CONST_PREFIX}}_SLUG, $css_uri . 'style' . $file_prefix . '.css', array(), {{CONST_PREFIX}}_VER );

	/** @psalm-suppress UndefinedFunction */ // phpcs:ignore PossiblyFalseArgument, Generic.Commenting.DocComment.MissingShort -- Function exist in helpers.php
	if ( wp_version_compare( '6.2.99', '<=' ) ) {
		wp_enqueue_style( {{CONST_PREFIX}}_SLUG . '-duotone', $css_uri . 'duotone' . $file_prefix . '.css', array(), {{CONST_PREFIX}}_VER );
	}

	wp_enqueue_style( {{CONST_PREFIX}}_SLUG . '-gutenberg', $css_uri . 'gutenberg' . $file_prefix . '.css', array(), {{CONST_PREFIX}}_VER );

	${{PFX}}_inline_css = apply_filters( '{{PFX}}_dynamic_theme_css', '' );
	if ( ${{PFX}}_inline_css ) {
		wp_add_inline_style( {{CONST_PREFIX}}_SLUG, ${{PFX}}_inline_css );
	}

	/* Load Theme Scripts*/
	wp_register_script( {{CONST_PREFIX}}_SLUG, $js_uri . 'script.js', [], {{CONST_PREFIX}}_VER, true );

	wp_enqueue_script( {{CONST_PREFIX}}_SLUG );

	${{PFX}}_inline_js = apply_filters( '{{PFX}}_dynamic_theme_js', '' );

	if ( ${{PFX}}_inline_js ) {
		wp_add_inline_script( {{CONST_PREFIX}}_SLUG, ${{PFX}}_inline_js );
	}
	// Remove default WP block styles
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'classic-theme-styles' );

	// Remove theme's editor-only css from frontend (gutenberg/duotone are enqueued above and belong on the frontend).
	wp_dequeue_style( '{{SLUG}}-editor' );
	wp_dequeue_style( '{{SLUG}}-gutenberg-editor' );
}

add_action( 'wp_enqueue_scripts', {{CONST_PREFIX}}_NS . 'enqueue_frontend_scripts' );

/**
 * Register a build/*.js entry (produced by `npm run build`, see webpack.config.js)
 * together with the matching build/*.asset.php dependency manifest that
 * @wordpress/scripts generates automatically. No-ops (with an admin notice)
 * if the build hasn't been run yet.
 */
function register_built_script( string $handle, string $entry, array $extra_deps = array() ): bool {
	$asset_file = {{CONST_PREFIX}}_DIR . 'build/' . $entry . '.asset.php';

	if ( ! file_exists( $asset_file ) ) {
		add_action(
			'admin_notices',
			function () use ( $entry ) {
				printf(
					'<div class="notice notice-warning"><p>%s</p></div>',
					esc_html(
						sprintf(
							/* translators: %s: JS entry file name, e.g. "editor" */
							__( '{{THEME_NAME}}: run `npm install && npm run build` to compile assets/%s.js.', '{{SLUG}}' ),
							$entry
						)
					)
				);
			}
		);
		return false;
	}

	$asset = include $asset_file;

	wp_register_script(
		$handle,
		get_uri() . 'build/' . $entry . '.js',
		array_unique( array_merge( $asset['dependencies'], $extra_deps ) ),
		$asset['version'],
		true
	);
	wp_enqueue_script( $handle );

	return true;
}

/**
 * Enqueue Editor Scripts.
 */
function enqueue_editor_scripts(): void {
	if ( false === apply_filters( '{{PFX}}_enqueue_editor_scripts', true ) ) {
		return;
	}

	$file_prefix = defined( '{{CONST_PREFIX}}_DEBUG' ) && {{CONST_PREFIX}}_DEBUG ? '' : '.min';

	$css_uri = get_uri() . 'assets/css/';

	/* RTL */
	if ( is_rtl() ) {
		$file_prefix .= '-rtl';
	}

	wp_enqueue_style( {{CONST_PREFIX}}_SLUG . '-gutenberg-editor', $css_uri . 'gutenberg-editor' . $file_prefix . '.css', array(), {{CONST_PREFIX}}_VER );

	$editor_registered = register_built_script( {{CONST_PREFIX}}_SLUG . '-editor', 'editor' );

	if ( isset( $GLOBALS['pagenow'] ) && 'site-editor.php' === $GLOBALS['pagenow'] ) {
		register_built_script( {{CONST_PREFIX}}_SLUG . '-settings', 'settings' );
	}

	if ( $editor_registered ) {
		$editor_script_data = localize_editor_script();
		if ( is_array( $editor_script_data ) ) {
			wp_localize_script(
				{{CONST_PREFIX}}_SLUG . '-editor',
				{{CONST_PREFIX}}_LOC,
				$editor_script_data
			);
		}
	}
}

add_action( 'enqueue_block_editor_assets', {{CONST_PREFIX}}_NS . 'enqueue_editor_scripts' );

/**
 * Enqueue Block Assets.
 */
function enqueue_block_assets(): void {
	$file_prefix = defined( '{{CONST_PREFIX}}_DEBUG' ) && {{CONST_PREFIX}}_DEBUG ? '' : '.min';

	$css_uri = get_uri() . 'assets/css/';

	/* RTL */
	if ( is_rtl() ) {
		$file_prefix .= '-rtl';
	}

	// Enqueue editor styles for post and page.
	wp_enqueue_style( {{CONST_PREFIX}}_SLUG . '-editor', $css_uri . 'editor' . $file_prefix . '.css', array(), {{CONST_PREFIX}}_VER );
}

add_action( 'enqueue_block_assets', {{CONST_PREFIX}}_NS . 'enqueue_block_assets' );

/**
 * Localize Editor Script.
 */
function localize_editor_script() {

	/** @psalm-suppress UndefinedFunction */ // phpcs:ignore PossiblyFalseArgument, Generic.Commenting.DocComment.MissingShort -- Function exist in helpers.php
	$version_compare = wp_version_compare( '6.2.99', '>' );
	$screen          = get_current_screen();
	$screen_id       = isset( $screen->id ) ? $screen->id : '';
	return apply_filters(
		'{{PFX}}_editor_localize',
		array(
			'get_screen_id'                 => $screen_id,
			'disable_sections'              => get_disable_section_fields(),
			'nonce'                         => wp_create_nonce( 'wp_rest' ),
			'{{PFX}}_wp_version_higher_6_3' => $version_compare,
			'{{PFX}}_wp_version_higher_6_5' => is_wp_version_compatible( '6.5' ),
		)
	);
}

/**
 * Enqueue Editor Scripts.
 */
function enqueue_editor_block_styles(): void {

	// Disable Core Block Patterns.
	remove_theme_support( 'core-block-patterns' );

	$file_prefix = defined( '{{CONST_PREFIX}}_DEBUG' ) && {{CONST_PREFIX}}_DEBUG ? '' : '.min';

	$css_uri = get_uri() . 'assets/css/';

	// Add support for block styles.
	add_theme_support( 'wp-block-styles' );

	// Enqueue editor styles.
	/** @psalm-suppress UndefinedFunction */ // phpcs:ignore PossiblyFalseArgument, Generic.Commenting.DocComment.MissingShort -- Function exist in helpers.php
	if ( wp_version_compare( '6.2.99', '<=' ) ) {
		add_editor_style( $css_uri . 'duotone' . $file_prefix . '.css' );
	}

	add_editor_style( $css_uri . 'editor' . $file_prefix . '.css' );

	add_editor_style( $css_uri . 'gutenberg' . $file_prefix . '.css' );

}

add_action( 'after_setup_theme', {{CONST_PREFIX}}_NS . 'enqueue_editor_block_styles' );



/**
 * Enqueue Editor Scripts.
 */
function {{PFX}}_setup(): void {
	/*
	* Make theme available for translation.
	* Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/twentyfifteen
	* If you're building a theme based on {{SLUG}}, use a find and replace
	* to change '{{SLUG}}' to the name of your theme in all the template files
	*/
	load_theme_textdomain( '{{SLUG}}', get_uri() . 'languages' );
}

add_action( 'after_setup_theme', {{CONST_PREFIX}}_NS . '{{PFX}}_setup' );



/**
 * Pattern categories.
 */
function pattern_categories(): void {

	register_block_pattern_category(
		'pages',
		array( 'label' => esc_html__( 'Pages', '{{SLUG}}' ) )
	);

	register_block_pattern_category(
		'contact',
		array( 'label' => esc_html__( 'Contact', '{{SLUG}}' ) )
	);

	register_block_pattern_category(
		'pricing',
		array( 'label' => esc_html__( 'Pricing', '{{SLUG}}' ) )
	);

}

add_action( 'init', {{CONST_PREFIX}}_NS . 'pattern_categories' );
