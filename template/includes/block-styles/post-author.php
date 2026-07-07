<?php
/**
 * Register post author block style.
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
${{PFX}}_parent_class = '.is-style-' . {{CONST_PREFIX}}_PFX . '-post-author-simple';

register_block_style(
    'core/post-author',
    array(
        'name' => {{CONST_PREFIX}}_PFX . '-post-author-simple',
        'label' => __('Simple', '{{SLUG}}'),
        'inline_style' => '
        
        ' . ${{PFX}}_parent_class . ' {
            flex-wrap: inherit;
        }

        ' . ${{PFX}}_parent_class . ' .wp-block-post-author__avatar  {
            margin-' . rtl_css('right') . ': 1.8em;
        }

        ' . ${{PFX}}_parent_class . ' .avatar  {
                width: 60px;
                height: 60px;
                object-fit: cover;
                border-radius: var(--wp--custom--border-radius--full);
			}

            ' . ${{PFX}}_parent_class . ' .wp-block-post-author__name {
                font-size: var(--wp--preset--font-size--medium);
                font-weight: var(--wp--custom--font-weight--semi-bold);
                color: var(--wp--preset--color--heading);
                line-height: var(--wp--custom--line-height--initial);
                text-transform: capitalize;
                width: 100%;
			}

            ' . ${{PFX}}_parent_class . ' .wp-block-post-author__bio {
                margin-top: 10px;
                font-size: var(--wp--preset--font-size--small);
			}

            ' . ${{PFX}}_parent_class . ' .wp-block-post-author__content {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                flex-direction: column;
                justify-content: center;
                flex-basis: inherit;
                flex-grow: inherit;
			}
		',
    )
);
