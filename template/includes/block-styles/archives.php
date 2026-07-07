<?php
/**
 * Register archive Styles.
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

${{PFX}}_parent_class = '.is-style-' . {{CONST_PREFIX}}_PFX . '-archives-minimal';

register_block_style(
    'core/archives',
    array(
        'name' => {{CONST_PREFIX}}_PFX . '-archives-minimal',
        'label' => __('Minimal', '{{SLUG}}'),
        'inline_style' => '

            ' . ${{PFX}}_parent_class . ' {
				padding: 0;
				list-style: none;
            }

			' . ${{PFX}}_parent_class . ' .cat-item {
				font-size: var(--wp--preset--font-size--small);
				margin-bottom: var(--wp--preset--spacing--xx-small);
            }
			
			' . ${{PFX}}_parent_class . '.wp-block-archives-dropdown select {
				padding-' . rtl_css('left') . ': var(--wp--preset--spacing--x-small);
				padding-' . rtl_css('right') . ': var(--wp--preset--spacing--large);
				padding-top: var(--wp--preset--spacing--x-small);
				padding-bottom: var(--wp--preset--spacing--x-small);
				border: 1px solid var(--wp--preset--color--outline);
				border-radius: var(--wp--custom--border-radius--small);
				font-weight: var(--wp--custom--font-weight--regular);
				font-size: var(--wp--preset--font-size--small);
				color: var(--wp--preset--color--heading);
				background-color: var(--wp--preset--color--background);
				width: 100%;
				height: 60px;
				appearance: none;
            }

			' . ${{PFX}}_parent_class . '.wp-block-archives-dropdown select:focus-visible {
				outline-color: var(--wp--preset--color--heading);
			}

			' . ${{PFX}}_parent_class . '.wp-block-archives-dropdown {
				position: relative;
			}

			' . ${{PFX}}_parent_class . '.wp-block-archives-dropdown:after {
				content: "\e900";
				position: absolute;
				font-family: "Figtree" !important;
				font-size: var(--wp--preset--font-size--medium);
				' . rtl_css('right') . ': 25px;
				top: 50%;
				transform: translateY(-50%);
				pointer-events: none;
				-webkit-font-smoothing: antialiased;
				-moz-osx-font-smoothing: grayscale;
			}
		',
    )
);
