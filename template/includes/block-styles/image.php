<?php
/**
 * Register Imagge Block Styles.
 * @author {{AUTHOR}}
 */
declare(strict_types=1);

namespace {{NAMESPACE}};

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
register_block_style(
    'core/image',
    array(
        'name' => {{CONST_PREFIX}}_PFX . '-image-custom',
        'label' => __('Custom', '{{SLUG}}'),
        'inline_style' => '
			figure.is-style-' . {{CONST_PREFIX}}_PFX . '-image-custom {
                margin-block-end: -180px!important;
                box-shadow: 0px 8px 60px 0px #000A1A1A;
                position: relative;
                z-index: 1;
			}
		',
    )
);
