<?php // phpcs:ignore
/**
 * College In CinemaPost
 *
 * PHP version 7.3.8
 *
 * @package Formatcine
 */

namespace Formatcine\Models;

use Timber\{ Timber, Post };
use DateTime;

/**
 * College In Cinema Post
 */
class CollegeInCinemaPost extends Post {

	/**
	 * Season
	 */
	public function season() {
		return get_field( 'season', $this->id );
	}

	/**
	 * Programmings
	 */
	public function programmings() : array {
		$programmings = Timber::get_posts(
			array(
				'post_type'   => 'programming',
				'post_status' => 'publish',
				'meta_query'  => array(  // phpcs:ignore
					'relation'            => 'AND',
					'quarter_clause'      => array(
						'key' => 'quarter',
					),
					'school_class_clause' => array(
						'key' => 'school_class',
					),
				),
				'orderby'     => array(
					'school_class_clause' => 'ASC',
					'quarter_clause'      => 'ASC',
				),
				'tax_query'   => array(  // phpcs:ignore
					array(
						'taxonomy' => 'season',
						'field'    => 'term_id',
						'terms'    => $this->season() ? $this->season()->term_id : null,
					),
				),
			),
			'Formatcine\Models\ProgrammingPost'
		);

		return $programmings;
	}
}
