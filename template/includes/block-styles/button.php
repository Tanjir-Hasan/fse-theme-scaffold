<?php
/**
 * Register Button Block Styles.
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

register_block_style(
    'core/button',
    array(
        'name' => {{CONST_PREFIX}}_PFX . '-button-secondary',
        'label' => __('Secondary', '{{SLUG}}'),
        'inline_style' => '
			div.is-style-' . {{CONST_PREFIX}}_PFX . '-button-secondary .wp-element-button {
                color: var(--wp--preset--color--primary);
				background: var(--wp--preset--color--surface);
			}

            div.is-style-' . {{CONST_PREFIX}}_PFX . '-button-secondary .wp-element-button:hover {
                color: var(--wp--preset--color--body);
				background: var(--wp--preset--color--surface);
			}
		',
    )
);

register_block_style(
    'core/button',
    array(
        'name' => {{CONST_PREFIX}}_PFX . '-button-inverse',
        'label' => __('Inverse', '{{SLUG}}'),
        'inline_style' => '
			div.is-style-' . {{CONST_PREFIX}}_PFX . '-button-inverse .wp-element-button {
                color: #0166FE;
				background: #fff;
			}

            div.is-style-' . {{CONST_PREFIX}}_PFX . '-button-inverse .wp-element-button:hover {
                color: red;
				background: #fff;
			}
		',
    )
);
