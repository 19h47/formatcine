<?php // phpcs:ignore
/**
 * Movie post
 *
 * PHP version 7.3.8
 *
 * @package formatcine
 */

namespace Formatcine\Models;

use Timber\{ Post };

/**
 * Movie post
 */
class MoviePost extends Post {

	/**
	 * Release year
	 */
	public function release_year() : string {
		return get_field( 'release_year', $this->id );
	}

	/**
	 * Running time
	 */
	public function running_time() : string {
		return get_field( 'running_time', $this->id );
	}


	/**
	 * Version
	 */
	public function version() : array {
		return get_field( 'version', $this->id );
	}

	/**
	 * Directors
	 *
	 * @return array
	 */
	public function directors() : array {
		$directors = array();
		$fields    = get_field( 'director', $this->id );

		foreach ( $fields as $key => $value ) {
			array_push( $directors, $value->name );
		}

		return $directors;
	}


	/**
	 * Countries
	 *
	 * @return array
	 */
	public function countries() : array {
		$countries = array();
		$fields    = get_field( 'country', $this->id );

		foreach ( $fields as $key => $value ) {
			array_push( $countries, $value->name );
		}

		return $countries;
	}


	/**
	 * Meta
	 */
	public function facts() : string {
		$facts = array();

		if ( $this->countries() ) {
			array_push( $facts, implode( '-', $this->countries() ) );
		}

		if ( $this->release_year() ) {
			array_push( $facts, $this->release_year() );
		}

		if ( $this->running_time() ) {
			array_push( $facts, $this->running_time() );
		}

		if ( $this->version() ) {
			array_push( $facts, implode( '-', $this->version() ) );
		}

		return implode( '&nbsp;|&nbsp;', $facts );
	}
}
