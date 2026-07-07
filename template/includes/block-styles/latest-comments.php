<?php
/**
 * Register latest comments styles.
 * @author {{AUTHOR}}
 */

declare( strict_types=1 );

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

${{PFX}}_parent_class = '.is-style-' . {{CONST_PREFIX}}_PFX . '-latest-comments-simple';

register_block_style(
	'core/latest-comments',
	array(
		'name'         => {{CONST_PREFIX}}_PFX . '-latest-comments-simple',
		'label'        => __( 'Simple', '{{SLUG}}' ),
		'inline_style' => '

            ' . ${{PFX}}_parent_class . ' {
                padding: 0;
            }

            ' . ${{PFX}}_parent_class . ' .wp-block-latest-comments__comment-avatar{
                width: 24px;
                height: 24px;
            }

            ' . ${{PFX}}_parent_class . '.has-avatars .wp-block-latest-comments__comment .wp-block-latest-comments__comment-meta, ' . ${{PFX}}_parent_class . '.has-avatars .wp-block-latest-comments__comment .wp-block-latest-comments__comment-excerpt {
               margin-' . rtl_css( 'left' ) . ': 35px;
            }

            ' . ${{PFX}}_parent_class . ' .wp-block-latest-comments__comment .wp-block-latest-comments__comment-meta {
                font-size: var(--wp--preset--font-size--small);
                color: var(--wp--preset--color--neutral);
                font-weight: var(--wp--custom--font-weight--regular);
            }

            ' . ${{PFX}}_parent_class . ' .wp-block-latest-comments__comment .wp-block-latest-comments__comment-meta .wp-block-latest-comments__comment-date{
                font-size: var(--wp--preset--font-size--x-small);
                font-weight: var(--wp--custom--font-weight--regular);
                margin-top: 0.36em;
            }

            ' . ${{PFX}}_parent_class . ' .wp-block-latest-comments__comment .wp-block-latest-comments__comment-excerpt p{
                font-size: var(--wp--preset--font-size--x-small);
                font-weight: var(--wp--custom--font-weight--regular);
            }
            
		',
	) 
);
