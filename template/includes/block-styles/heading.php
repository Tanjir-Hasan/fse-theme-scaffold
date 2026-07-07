<?php
/**
 * Register Heading Block Styles.
 * @author {{AUTHOR}}
 */

declare( strict_types=1 );

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

register_block_style(
    'core/heading',
    array(
        'name'         => {{CONST_PREFIX}}_PFX . '-heading-jalsa',
        'label'        => __( 'Jalsa', '{{SLUG}}' ),
        'inline_style' => '
			h2.is-style-' . {{CONST_PREFIX}}_PFX . '-heading-jalsa {
                color: var(--wp--preset--color--outline);
                font-size: var(--wp--preset--font-size--xxxxx-large);
                font-weight: var(--wp--custom--font-weight--semi-bold);
			}
		',
    )
);

register_block_style(
    'core/heading',

    array(
        'name'         => {{CONST_PREFIX}}_PFX . '-heading-button-color',
        'label'        => __( 'Button Color', '{{SLUG}}' ),
        'inline_style' => '
			h2.is-style-' . {{CONST_PREFIX}}_PFX . '-heading-button-color {
			     background: var(--wp--preset--color--tertiary);
                 padding: var(--wp--preset--spacing--30);
                font-size: var(--wp--preset--font-size--small);
                color: var(--wp--preset--color--heading);              
                display: inline;
			}  
		',
    )
);
