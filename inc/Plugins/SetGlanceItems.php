<?php // phpcs:ignore
/**
 * Set glance items
 *
 * @package WordPress
 * @subpackage Formatcine
 */

namespace FormatCine\Plugins;

use Set_Glance_Items;

/**
 * WordPress
 */
class SetGlanceItems {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		new Set_Glance_Items(
			array(
				array(
					'name' => 'country',
					'code' => '\f11d',
				),
				array(
					'name' => 'school_class',
					'code' => '\f118',
				),
				array(
					'name' => 'director',
					'code' => '\f234',
				),
				array(
					'name' => 'season',
					'code' => '\f469',
				),
				array(
					'name' => 'adult_training_category',
					'code' => '\f118',
				),
			),
			array(
				array(
					'name' => 'movie',
					'code' => '\f524',
				),
				array(
					'name' => 'programming',
					'code' => '\f508',
				),
				array(
					'name' => 'school_training',
					'code' => '\f118',
				),
				array(
					'name' => 'adult_training',
					'code' => '\f118',
				),
			)
		);
	}
}

