<?php
/**
 * Title: Footer
 * Slug: {{SLUG}}/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 */
?>
<!-- wp:group {"tagName":"footer","align":"wide","backgroundColor":"surface","style":{"spacing":{"padding":{"top":"var:preset|spacing|large","bottom":"var:preset|spacing|large"}}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
<footer class="wp-block-group alignwide has-surface-background-color has-background" style="padding-top:var(--wp--preset--spacing--large);padding-bottom:var(--wp--preset--spacing--large)">

	<!-- wp:paragraph -->
	<p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.</p>
	<!-- /wp:paragraph -->

	<!-- wp:social-links {"iconColor":"heading","layout":{"type":"flex"}} -->
	<ul class="wp-block-social-links has-icon-color">
		<!-- wp:social-link {"url":"#","service":"facebook"} /-->
		<!-- wp:social-link {"url":"#","service":"instagram"} /-->
		<!-- wp:social-link {"url":"#","service":"x"} /-->
	</ul>
	<!-- /wp:social-links -->

</footer>
<!-- /wp:group -->
