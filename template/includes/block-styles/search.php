<?php
/**
 * Register Search Block Styles.
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
${{PFX}}_parent_class = '.is-style-' . {{CONST_PREFIX}}_PFX . '-search-minimal';

register_block_style(
    'core/search',
    array(
        'name' => {{CONST_PREFIX}}_PFX . '-search-minimal',
        'label' => __('Minimal', '{{SLUG}}'),
        'inline_style' => '
            ' . ${{PFX}}_parent_class . '.wp-block-search__button-inside .wp-block-search__button {
                color: var(--wp--preset--color--heading);
                background-color: var(--wp--preset--color--background);
                border-radius: 0;
                margin: 0;
                padding: var(--wp--preset--spacing--xx-small) var(--wp--preset--spacing--xx-small);
            }

            ' . ${{PFX}}_parent_class . '.wp-block-search__button-inside .wp-block-search__button:hover {
                color: var(--wp--preset--color--heading);
                background-color: var(--wp--preset--color--background);
            }

            ' . ${{PFX}}_parent_class . '.wp-block-search__button-inside .wp-block-search__inside-wrapper {
                padding: 4px;
                border: 1px solid var(--wp--preset--color--outline);
                border-radius: var(--wp--custom--border-radius--small);
                background-color: var(--wp--preset--color--background);
            }

            ' . ${{PFX}}_parent_class . ' .wp-block-search__input {
                padding-left: var(--wp--preset--spacing--xx-small);
                color: var(--wp--preset--color--heading);
                background-color: var(--wp--preset--color--background);
                border-radius: 0;
                border: 0;
            }

            ' . ${{PFX}}_parent_class . '.wp-block-search__button-outside .wp-block-search__input, .wp-block-search__no-button .wp-block-search__input{
                border: 1px solid var(--wp--preset--color--outline);
                border-radius: var(--wp--custom--border-radius--small);
            }
        ',
    )
);
