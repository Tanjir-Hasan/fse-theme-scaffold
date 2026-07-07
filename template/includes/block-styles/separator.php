<?php
/**
 * Register separator block styles.
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

register_block_style(
    'core/separator',
    array(
        'name' => {{CONST_PREFIX}}_PFX . '-separator-wide-thin-line',
        'label' => __('Wide Thin Line', '{{SLUG}}'),
        'inline_style' => '
        .is-style-' . {{CONST_PREFIX}}_PFX . '-separator-wide-thin-line.wp-block-separator:not(.is-style-wide):not(.is-style-dots){
                max-width: var(--wp--style--global--content-size);
                width: 100%;
                border-width: 1px;
			}
		',
    )
);

