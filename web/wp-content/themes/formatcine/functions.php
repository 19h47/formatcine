<?php
/**
 * Format'ciné functions and definitions
 *
 * @see https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Formatcine
 * @since   1.0.0
 */

// Autoloader.
require_once get_template_directory() . '/vendor/autoload.php';

use Formatcine\App as App;

$app = new App( 'Formatciné', wp_get_theme()->Version ); // phpcs:ignore
