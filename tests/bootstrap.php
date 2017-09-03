<?php

/**
 * PHPUnit bootstrap file
 *
 * @package GrottoPress\WordPress\Form
 * @since 0.1.0
 *
 * @author GrottoPress <info@grottopress.com>
 * @author N Atta Kus Adusei
 */

declare ( strict_types = 1 );

/**
 * Autoloader
 *
 * @since 0.1.0
 */
require_once \dirname( __DIR__ ) . '/vendor/autoload.php';

$_tests_dir = \getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

/**
 * Give access to tests_add_filter() function.
 */
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin being tested.
 */
function _manually_load_plugin() {
	require \dirname( __DIR__ ) . '/src/field.php';
}
\tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

/**
 * Start up the WP testing environment.
 */
require $_tests_dir . '/includes/bootstrap.php';
