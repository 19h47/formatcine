<?php // phpcs:ignore
/**
 * Bootstraps WordPress theme related functions, most importantly enqueuing javascript and styles.
 *
 * @package WordPress
 * @subpackage Formatcine
 */

namespace FormatCine;

use FormatCine\{ Core, Api, Custom, Setup, Plugins };

/**
 * Init
 */
class Init {

	/**
	 * Store all the classes inside an array
	 *
	 * @return array Full list of classes
	 */
	public static function get_services() : array {
		return array(
			Core\AdultTraining::class,
			Core\AdultTrainingCategory::class,
			Core\Country::class,
			Core\Director::class,
			Core\Movie::class,
			Core\Page::class,
			Core\Post::class,
			Core\Programming::class,
			Core\SchoolClass::class,
			Core\SchoolTraining::class,
			Core\Season::class,
			Api\Customizer\Contact::class,
			Custom\Admin::class,
			Custom\Extras::class,
			Setup\Enqueue::class,
			Setup\Menus::class,
			Setup\Supports::class,
			Setup\Textdomain::class,
			Setup\Theme::class,
			Setup\WordPress::class,
			Plugins\ACF::class,
			// Plugins\SetGlanceItems::class,
		);
	}


	/**
	 * Loop through the classes, initialize them, and call the run() method if it exists
	 *
	 * @return void
	 */
	public static function run_services() : void {
		foreach ( self::get_services() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'run' ) ) {
				$service->run();
			}
		}
	}


	/**
	 * Initialize the class
	 *
	 * @param  string $class class name from the services array.
	 * @return object
	 */
	private static function instantiate( string $class ) : object {
		return new $class();
	}
}
