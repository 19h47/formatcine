<?php // phpcs:ignore
/**
 * Enqueue
 *
 * @package FormatCine
 */

namespace FormatCine\Setup;

use FormatCine\Core\{ Transients };
use Timber\{ Timber };
use Dotenv\{ Dotenv };

$dotenv = Dotenv::createImmutable( get_template_directory() );
$dotenv->load();

/**
 * Enqueue
 */
class Enqueue {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() : void {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue scripts
	 *
	 * @access public
	 * @return void
	 * @since  1.0.0
	 */
	public function enqueue_scripts() : void {
		// Remove wp-embed script from WordPress.
		wp_deregister_script( 'wp-embed' );

		wp_register_script( // phpcs:ignore
			get_theme_name() . '-main',
			get_template_directory_uri() . '/' . get_theme_manifest()['main.js'],
			array( 'jquery' ),
			null,
			true
		);

		wp_localize_script(
			get_theme_name() . '-main',
			'wp',
			array(
				'template_directory_uri' => get_template_directory_uri(),
				'base_url'               => site_url(),
				'home_url'               => home_url( '/' ),
				'ajax_url'               => admin_url( 'admin-ajax.php' ),
				'current_url'            => get_permalink(),
				'nonce'                  => wp_create_nonce( 'security' ),
			)
		);

		wp_enqueue_script( // phpcs:ignore
			'feature',
			'//cdnjs.cloudflare.com/ajax/libs/feature.js/1.1.0/feature.min.js',
			array(),
			null,
			false
		);
		wp_add_inline_script(
			'feature',
			'document.documentElement.className=document.documentElement.className.replace("no-js","js"),feature.touch&&!navigator.userAgent.match(/Trident\/(6|7)\./)&&(document.documentElement.className=document.documentElement.className.replace("no-touch","touch"));'
		);

		wp_enqueue_script( get_theme_name() . '-main' );
	}


	/**
	 * Enqueue styles.
	 *
	 * @access public
	 * @return void
	 * @since  1.0.0
	 */
	public function enqueue_style() : void {
		wp_dequeue_style( 'wp-block-library' );

		// Theme stylesheet.
		wp_register_style( // phpcs:ignore
			get_theme_name() . '-global',
			get_template_directory_uri() . '/' . get_theme_manifest()['main.css'],
			array(),
			null,
		);

		wp_enqueue_style( get_theme_name() . '-global' );
	}
}
