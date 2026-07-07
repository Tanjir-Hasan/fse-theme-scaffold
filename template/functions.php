<?php
/**
 * Functions and definitions
 *
 * @package {{THEME_NAME}}
 * @author {{AUTHOR}}
 * @since 0.0.1
 */

declare( strict_types=1 );

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

const {{CONST_PREFIX}}_VER  = '0.0.2';
const {{CONST_PREFIX}}_SLUG = '{{SLUG}}';
const {{CONST_PREFIX}}_NAME = '{{THEME_NAME}}';
const {{CONST_PREFIX}}_PFX  = '{{PFX}}';
const {{CONST_PREFIX}}_LOC  = '{{LOC}}';
const {{CONST_PREFIX}}_NS   = __NAMESPACE__ . '\\';
const {{CONST_PREFIX}}_DS   = DIRECTORY_SEPARATOR;
const {{CONST_PREFIX}}_DIR  = __DIR__ . {{CONST_PREFIX}}_DS;


/**
 * Load theme translations
 *
 * @return void
 * @since 1.0.5
 */
add_action('init', function() {
    load_theme_textdomain('{{SLUG}}', false, get_template_directory() . '/languages');

    /**
     * Setup base {{SLUG}} functions
     */
    require_once {{CONST_PREFIX}}_DIR . 'includes/scripts.php';
    require_once {{CONST_PREFIX}}_DIR . 'includes/blocks/all.php';
    require_once {{CONST_PREFIX}}_DIR . 'includes/block-styles/all.php';
    /**
     * Admin functions
     */

    require_once {{CONST_PREFIX}}_DIR . 'includes/admin/settings.php';

});

require_once {{CONST_PREFIX}}_DIR . 'includes/core/all.php';



