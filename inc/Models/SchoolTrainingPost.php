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
class SchoolTrainingPost extends Post {

	/**
	 * Movies
	 */
	public function movies() : array {
		return Timber::get_posts( get_field( 'movies', $this->id ), 'FormatCine\Models\MoviePost' );
	}

	/**
	 * Directors
	 *
	 * @return array
	 */
	public function directors() : string {
		$directors = array();
		$array     = array();

		foreach ( $this->movies() as $movie ) {
			foreach ( $movie->directors as $key => $name ) {
				array_push( $directors, $name );
			}
		}

		foreach ( $directors as $key => $name ) {
			if ( array_key_last( $directors ) === $key && array_key_first( $directors ) !== $key ) {
				array_push( $array, __( 'and', 'formatcine' ) . '&nbsp;' . $name );
			} elseif ( count( $directors ) > 2 ) {
				array_push( $array, $name . ',&nbsp;' );
			} else {
				array_push( $array, $name );
			}
		}

		return implode( ' ', $array );
	}
}
