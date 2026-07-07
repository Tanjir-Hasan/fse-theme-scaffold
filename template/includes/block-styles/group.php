<?php
/**
 * Register Group Block Styles.
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
        'name'         => {{CONST_PREFIX}}_PFX . '-paragraph-button-color',
        'label'        => __( 'Button Color', '{{SLUG}}' ),
        'inline_style' => '
			p.is-style-' . {{CONST_PREFIX}}_PFX . '-paragraph-button-color {
			     background: var(--wp--preset--color--tertiary);
                 padding: var(--wp--preset--spacing--30);
                font-size: var(--wp--preset--font-size--small);
                color: var(--wp--preset--color--heading);              display: inline;
			}  
		',
    )
);