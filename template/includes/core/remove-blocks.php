<?php
/**
 * Remove blocks functions
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

add_filter( 'render_block', {{CONST_PREFIX}}_NS . 'render_remove_blocks', 10, 2 );

/**
 *  Render function.
 */
function render_remove_blocks( string $block_content, array $block ):string {
	/** @psalm-suppress UndefinedFunction */ // phpcs:ignore PossiblyFalseArgument, Generic.Commenting.DocComment.MissingShort -- Function exist in helpers.php
	$post_id = front_post_ID();

	// condition for page and post title.
	/** @psalm-suppress UndefinedFunction */ // phpcs:ignore PossiblyFalseArgument, Generic.Commenting.DocComment.MissingShort -- Function exist in helpers.php
	if ( $post_id && is_page_title( $post_id ) && isset( $block['attrs']['className'] ) && ( '{{SLUG}}-block-page-banner-group' === $block['attrs']['className'] || '{{SLUG}}-block-post-banner-group' === $block['attrs']['className'] || '{{SLUG}}-block-post-title' === $block['attrs']['className'] || '{{SLUG}}-block-page-title' === $block['attrs']['className'] ) ) {
		return '';
	}

	// condition for page and post featured image.
	/** @psalm-suppress UndefinedFunction */ // phpcs:ignore PossiblyFalseArgument, Generic.Commenting.DocComment.MissingShort -- Function exist in helpers.php
	if ( $post_id && ! has_post_thumbnail( $post_id ) && isset( $block['attrs']['className'] ) && '{{SLUG}}-block-featured-image' === $block['attrs']['className'] ) {
		return '';
	}

	// condition for page and post comments.
	if ( ! comments_open() && isset( $block['attrs']['className'] ) && '{{SLUG}}-block-comment-group' === $block['attrs']['className'] ) {
		return '';
	}

	return $block_content;
}
