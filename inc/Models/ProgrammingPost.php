<?php // phpcs:ignore
/**
 * Programming post
 *
 * PHP version 8.0.0
 *
 * @package WordPress
 * @subpackage Formatcine
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
		return Timber::get_post( get_field( 'movie', $this->id ), 'FormatCine\Models\MoviePost' );
	}


	/**
	 * Current school classes
	 */
	public function current_school_classes() : array {
		$current_school_classes = array();
		$fields                 = get_field( 'school_class', $this->id );

		foreach ( $fields as $field ) {
			array_push( $current_school_classes, $field->slug );
		}

		return $current_school_classes;
	}
}
