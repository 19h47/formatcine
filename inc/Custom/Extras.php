<?php // phpcs:ignore
/**
 * Extras
 *
 * @package FormatCine
 */

namespace FormatCine\Custom;

/**
 * Extras.
 */
class Extras {
	/**
	 * Run default hooks and actions for WordPress
	 *
	 * @return void
	 */
	public function run() : void {
		add_filter( 'body_class', array( $this, 'body_class' ) );
	}


	/**
	 * Adds custom classes to the array of body classes.
	 *
	 * Displays the class names for the body element.
	 *
	 * @param array $classes Space-separated string or array of class names to add to the class list.
	 *
	 * @return $classes array
	 */
	public function body_class( $classes ) : array {
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
}
