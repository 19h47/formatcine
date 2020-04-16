<?php
/**
 * Post template
 *
 * @package Formatcine
 */

add_filter( 'body_class', 'custom_body_class' );

/**
 * Custom body class
 *
 * @param array $classes Array of body classes.
 *
 * @return array $classes
 */
function custom_body_class( array $classes ) : array {

	// Home.
	if ( is_front_page() ) {
		$classes[] = 'Front-page';
	}

	// Category.
	if ( is_category() ) {
		$classes[] = 'Category';
	}

	// Single post.
	if ( is_singular( 'post' ) ) {
		$classes[] = 'Single';
	}

	if ( is_page() ) {
		$classes[] = 'Page';
	}

	return $classes;
}
