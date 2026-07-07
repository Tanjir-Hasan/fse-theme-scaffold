<?php
/**
 * Require All Extensions
 * @author {{AUTHOR}}
 */

declare(strict_types=1);

namespace {{NAMESPACE}};

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once __DIR__ . '/responsive.php';
require_once __DIR__ . '/sticky-header.php';
require_once __DIR__ . '/metabox.php';
require_once __DIR__ . '/hide-elements.php';
require_once __DIR__ . '/remove-blocks.php';
require_once __DIR__ . '/admin-bar.php';
require_once __DIR__ . '/scroll-top.php';
require_once __DIR__ . '/dynamic-variables.php';
require_once __DIR__ . '/dom.php';
require_once __DIR__ . '/helpers.php';

