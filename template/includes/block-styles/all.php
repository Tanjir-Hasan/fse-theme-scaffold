<?php
/**
 * Require All Utilities
 * @author {{AUTHOR}}
 */

declare( strict_types=1 );

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once __DIR__ . '/post-terms.php';	
require_once __DIR__ . '/search.php';
require_once __DIR__ . '/button.php';
require_once __DIR__ . '/separator.php';
require_once __DIR__ . '/latest-posts.php';
require_once __DIR__ . '/categories.php';
require_once __DIR__ . '/tag-cloud.php';
require_once __DIR__ . '/latest-comments.php';
require_once __DIR__ . '/archives.php';
require_once __DIR__ . '/post-author.php';
require_once __DIR__ . '/image.php';
require_once __DIR__ . '/heading.php';
require_once __DIR__ . '/paragraph.php';
require_once __DIR__ . '/group.php';
