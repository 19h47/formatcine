<?php // phpcs:ignore
/**
 * College In CinemaPost
 *
 * PHP version 8.0.0
 *
 * @package WordPress
 * @subpackage Formatcine
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
			'FormatCine\Models\ProgrammingPost'
		);

		return $programmings;
	}

	/**
	 * School training
	 *
	 * @return array
	 */
	public function school_trainings() : array {
		return Timber::get_posts(
			array(
				'post_type'     => 'school_training',
				'post_status'   => 'publish',
				'meta_key'      => 'formation_date', // phpcs:ignore
				'orderby'       => 'meta_value',
				'order'         => 'ASC',
				'post_per_page' => 6,
				'tax_query'     => array( // phpcs:ignore
					array(
						'taxonomy' => 'season',
						'field'    => 'term_id',
						'terms'    => $this->season() ? $this->season()->term_id : null,
					),
				),
			),
			'FormatCine\Models\SchoolTrainingPost'
		);
	}

	/**
	 * School classes
	 *
	 * @return array
	 */
	public function school_classes() : array {
		$terms = get_terms(
			array(
				'taxonomy'   => 'school_class',
				'hide_empty' => false,
				'meta_key'   => 'term_order', // phpcs:ignore
				'orderby'    => 'meta_value',
			)
		);

		$school_classes = array(
			'sixieme-cinquieme'   => array(
				'term_ids' => array(),
				'names'    => array(),
			),
			'quatrieme-troisieme' => array(
				'term_ids' => array(),
				'names'    => array(),
			),
		);

		foreach ( $terms as $school_class ) {
			if ( 'sixieme' === $school_class->slug || 'cinquieme' === $school_class->slug ) {
				array_push( $school_classes['sixieme-cinquieme']['term_ids'], $school_class->term_id );
				array_push( $school_classes['sixieme-cinquieme']['names'], $school_class->name );
			}

			if ( 'quatrieme' === $school_class->slug || 'troisieme' === $school_class->slug ) {
				array_push( $school_classes['quatrieme-troisieme']['term_ids'], $school_class->term_id );
				array_push( $school_classes['quatrieme-troisieme']['names'], $school_class->name );
			}
		}

		return $school_classes;
	}
}
