<?php
/**
 * Register Latest post Styles.
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
${{PFX}}_parent_class = '.is-style-' . {{CONST_PREFIX}}_PFX . '-latest-posts-simple';

register_block_style(
    'core/latest-posts',
    array(
        'name' => {{CONST_PREFIX}}_PFX . '-latest-posts-simple',
        'label' => __('Simple', '{{SLUG}}'),
        'inline_style' => '
            ' . ${{PFX}}_parent_class . ' {
                color: var(--wp--preset--color--neutral);
            }
            
            ' . ${{PFX}}_parent_class . ' > li {
                margin-bottom: var(--wp--preset--spacing--x-small);
            }

            ' . ${{PFX}}_parent_class . '.{{SLUG}}-has-featured-image > li {
                position: relative;
                padding-' . rtl_css('right') . ': 75px;
            }


            ' . ${{PFX}}_parent_class . ' .wp-block-latest-posts__featured-image {
                position: absolute;
                ' . rtl_css('right') . ': 0;
            }

            ' . ${{PFX}}_parent_class . ' .wp-block-latest-posts__featured-image img {
                object-fit: cover;
                width: 56px;
                height: 56px;
            }

            ' . ${{PFX}}_parent_class . ' a {
                display: block;
                color: var(--wp--preset--color--heading);
                font-size: var(--wp--preset--font-size--small);
                font-weight: var(--wp--custom--font-weight--medium);
            }

            ' . ${{PFX}}_parent_class . ' .wp-block-latest-posts__post-author,' . ${{PFX}}_parent_class . ' .wp-block-latest-posts__post-date {
                display: inline-block;
                font-size: var(--wp--preset--font-size--x-small);
                font-weight: var(--wp--custom--font-weight--regular);
            }

            ' . ${{PFX}}_parent_class . ' .wp-block-latest-posts__post-author + time:before {
                content:"·";
                padding-' . rtl_css('right') . ': 5px;
                padding-' . rtl_css('left') . ': 5px;
                color: var(--wp--preset--color--neutral);
            }

            ' . ${{PFX}}_parent_class . ' .wp-block-latest-posts__post-excerpt {
                font-size: var(--wp--preset--font-size--x-small);
                font-weight: var(--wp--custom--font-weight--regular);
                margin-top: 0.2em;
            }
		',
    )
);
