<?php
/**
 * Register tag cloud styles.
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

    register_block_style(
        'core/tag-cloud',
        array(
            'name' => {{CONST_PREFIX}}_PFX . '-tag-cloud-pill',
            'label' => __('Pill', '{{SLUG}}'),
            'inline_style' => '
            .is-style-' . {{CONST_PREFIX}}_PFX . '-tag-cloud-pill .tag-cloud-link {
                font-size: var(--wp--preset--font-size--x-small) !Important;
                padding: 6px 12px;
				border-radius: var(--wp--custom--border-radius--full);
				color: var(--wp--preset--color--body);
				background-color: var(--wp--preset--color--outline);
				margin-' . rtl_css('right') . ': var(--wp--preset--spacing--xx-small);
				margin-top: var(--wp--preset--spacing--xxx-small);
                margin-bottom: var(--wp--preset--spacing--xxx-small);
				line-height: var(--wp--custom--line-height--initial);
            }
		',
        )
    );
    register_block_style(
        'core/tag-cloud',
        array(
            'name' => {{CONST_PREFIX}}_PFX . '-tag-cloud-button',
            'label' => __('Button', '{{SLUG}}'),
            'inline_style' => '
            .is-style-' . {{CONST_PREFIX}}_PFX . '-tag-cloud-button .tag-cloud-link {
                 background: var(--wp--preset--color--tertiary);
                 padding: var(--wp--preset--spacing--30);
                font-size: var(--wp--preset--font-size--small);
                color: var(--wp--preset--color--heading); 
				margin-' . rtl_css('right') . ': var(--wp--preset--spacing--xx-small);
				margin-top: var(--wp--preset--spacing--xxx-small);
                margin-bottom: var(--wp--preset--spacing--xxx-small);
				line-height: var(--wp--custom--line-height--initial);
            }
		',
        )
    );
