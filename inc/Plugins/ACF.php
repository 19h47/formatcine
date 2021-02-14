<?php // phpcs:ignore
/**
 * ACF
 *
 * @package WordPress
 * @subpackage Formatcine
 */

namespace FormatCine\Plugins;

use WP_Post;

/**
 * WordPress
 */
class ACF {
	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_filter( 'acf/prepare_field/name=event_color', array( $this, 'change_acf_event_color_picker' ) );
		add_filter( 'acf/prepare_field/name=page_color_main', array( $this, 'change_acf_page_color_picker' ) );
		add_filter( 'acf/prepare_field/name=page_color_secondary', array( $this, 'change_acf_page_color_picker' ) );
	}


	/**
	 * Change ACF color picker for pot
	 *
	 * @param arr $field Field.
	 * @return $field
	 */
	public function change_acf_event_color_picker( $field ) {

		?>
		<script>
			acf.add_filter('color_picker_args', function(args, $field) {

				// do something to args
				args.palettes = ['#6666d5', '#343471'];

				// return
				return args;
			});

		</script>
		<?php

		return $field;
	}


	/**
	 * Change ACF color picker for post
	 *
	 * @param arr $field Field.
	 * @return $field
	 */
	public function change_acf_page_color_picker( $field ) {
		?>
		<script>
			acf.add_filter('color_picker_args', function(args, $field) {

				// do something to args
				args.palettes = [
					'#6666d5',
					'#343471',
					'#55cdb9',
					'#009696',
					'#965fb4',
					'#6E3278',
					'#ffc80a',
					'#FF960A',
					'#e6d7eb',
					'#d2f0eb'
				];

				// return
				return args;
			});
		</script>
		<?php

		return $field;
	}
}

