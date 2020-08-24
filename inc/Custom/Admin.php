<?php // phpcs:ignore
/**
 * Class Admin
 *
 * @package FormatCine
 */

namespace FormatCine\Custom;

/**
 * Admin class
 *
 * @author  Jérémy Levron <jeremyjeremy@19h47.fr> (http://19h47.fr)
 */
class Admin {

	/**
	 * Run default hooks and actions for WordPress
	 *
	 * @return void
	 */
	public function run() : void {
		add_filter( 'admin_footer_text', array( $this, 'set_admin_footer_text' ) );
		add_filter( 'upload_mimes', array( $this, 'upload_mimes_svg' ) );
	}

	/**
	 * Set custom footer text
	 *
	 * @see https://developer.wordpress.org/reference/hooks/admin_footer_text/
	 * @author Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
	 * @access public
	 */
	public function set_admin_footer_text() {
		return __( 'Thank you for creating with <a href="http://www.19h47.fr/" target="_blank">19h47</a> and <a href="http://www.mokacreation.com/" target="_blank">Moka Création</a>. ✌️', 'formatcine' );
	}

	/**
	 * Updload mimes SVG
	 *
	 * @param arr $mimes Array of mimes types.
	 * @return $mimes
	 * @access public
	 */
	public function upload_mimes_svg( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';

		return $mimes;
	}
}
