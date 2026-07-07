<?php
/**
 * Register post terms block styles.
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

register_block_style(
    'core/post-terms',
    array(
        'name' => {{CONST_PREFIX}}_PFX . '-post-terms-pill',
        'label' => __('Pill', '{{SLUG}}'),
        'inline_style' => '
			.wp-block-post-terms.is-style-' . {{CONST_PREFIX}}_PFX . '-post-terms-pill a {
				display: inline-block;
				font-size: var(--wp--preset--font-size--x-small);
				padding: 6px 12px;
				border-radius: var(--wp--custom--border-radius--full);
				color: var(--wp--preset--color--body);
				background-color: var(--wp--preset--color--outline);
				margin-' . rtl_css('right') . ': var(--wp--preset--spacing--xx-small);
				margin-top: var(--wp--preset--spacing--xxx-small);
				margin-bottom: var(--wp--preset--spacing--xxx-small);
				line-height: var(--wp--custom--line-height--initial);
			}

			.is-style-' . {{CONST_PREFIX}}_PFX . '-post-terms-pill .wp-block-post-terms__separator {
				display: none;
			}
		',
    )
);
register_block_style(
    'core/post-terms',
    array(
        'name' => {{CONST_PREFIX}}_PFX . '-tag-cloud-button-terms',
        'label' => __('Button', '{{SLUG}}'),
        'inline_style' => '
            .is-style-' . {{CONST_PREFIX}}_PFX . '-tag-cloud-button-terms a {
                 background: var(--wp--preset--color--tertiary);
                 padding: var(--wp--preset--spacing--30);
                font-size: var(--wp--preset--font-size--small);
                color: var(--wp--preset--color--black);
				margin-' . rtl_css('right') . ': var(--wp--preset--spacing--xx-small);
				margin-top: var(--wp--preset--spacing--xxx-small);
                margin-bottom: var(--wp--preset--spacing--xxx-small);
				line-height: var(--wp--custom--line-height--initial);
				border-radius: 8px;
            }
		',
    )
);
