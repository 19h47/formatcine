<?php // phpcs:ignore
/**
 * Programming post
 *
 * PHP version 7.3.8
 *
 * @package formatcine
 */

namespace Formatcine\Models;

use Timber\{ Post, Timber };

/**
 * Movie post
 */
class ProgrammingPost extends Post {

	/**
	 * Movie
	 *
	 * @return object
	 */
	public function movie() : object {
		return Timber::get_post( get_field( 'movie', $this->id ), 'Formatcine\Models\MoviePost' );
	}


	/**
	 *
	 */
	public function current_school_classes() : array {
		$current_school_classes = array();
		$fields = get_field( 'school_class', $this->id );

		foreach ( $fields as $field ) {
			array_push( $current_school_classes, $field->slug );
			# code...
		}

		return $current_school_classes;
	}
}
