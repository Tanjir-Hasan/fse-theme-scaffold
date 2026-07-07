<?php
/**
 * Register Paragraph Block Styles.
 * @author {{AUTHOR}}
 */

declare( strict_types=1 );

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

register_block_style(
    'core/paragraph',
    array(
        'name'         => {{CONST_PREFIX}}_PFX . '-paragraph-bottom-line',
        'label'        => __( 'Bottom Line', '{{SLUG}}' ),
        'inline_style' => '
			p.is-style-' . {{CONST_PREFIX}}_PFX . '-paragraph-bottom-line::after {
			  content: "";
                position: absolute;
                width: 100px;
                height: 2px;
                background: var(--wp--preset--color--foreground);
                bottom: 0;
                left: 0;
			}
			p.is-style-' . {{CONST_PREFIX}}_PFX . '-paragraph-bottom-line {
                position: relative
			}
		',
    ),
);

register_block_style(
    'core/paragraph',

    array(
        'name'         => {{CONST_PREFIX}}_PFX . '-paragraph-button-color',
        'label'        => __( 'Button Color', '{{SLUG}}' ),
        'inline_style' => '
			p.is-style-' . {{CONST_PREFIX}}_PFX . '-paragraph-button-color {
			     background: var(--wp--preset--color--tertiary);
                 padding: var(--wp--preset--spacing--20) var(--wp--preset--spacing--30);
                font-size: var(--wp--preset--font-size--small);
                color: var(--wp--preset--color--heading);    
                display: inline;
                border-radius: 8px;
			}
		',
    )
);