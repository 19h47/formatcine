<?php // phpcs:ignore
/**
 * Contact
 *
 * @category Customizer
 * @package WordPress
 * @subpackage Formatcine
 * @author   Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace FormatCine\Api\Customizer;

use WP_Customize_Manager;

/**
 * Contact
 */
class Contact {

	/**
	 * Runs initialization tasks.
	 *
	 * @return void
	 */
	public function run() {
		add_action( 'customize_register', array( $this, 'register' ), 10, 1 );
	}


	/**
	 * Register
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	public function register( WP_Customize_Manager $wp_customize ) {
		// Add contact section.
		$wp_customize->add_section(
			'contact',
			array(
				'title'       => __( 'Contact details', 'formatcine' ),
				'description' => __( 'Contact details settings', 'formatcine' ),
			)
		);

		// Add Contact settings and controls in related section.
		$wp_customize->add_setting(
			'address',
			array(
				'type'      => 'option',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'address',
			array(
				'label'       => __( 'Address', 'formatcine' ),
				'description' => __( 'Indicate postal address', 'formatcine' ),
				'type'        => 'textarea',
				'section'     => 'contact',
				'settings'    => 'address',
			)
		);

		// Email address.
		$wp_customize->add_setting(
			'email_addresses',
			array(
				'type'      => 'option',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'email_addresses',
			array(
				'label'       => __( 'Email addresses', 'formatcine' ),
				'description' => __( 'Indicate the site contact email addresses separated by commas', 'formatcine' ),
				'section'     => 'contact',
				'settings'    => 'email_addresses',
			)
		);

		// Phone.
		$wp_customize->add_setting(
			'phone',
			array(
				'type'      => 'option',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'phone',
			array(
				'label'       => __( 'Phone number', 'formatcine' ),
				'description' => __( 'Indicate telephone number', 'formatcine' ),
				'section'     => 'contact',
				'settings'    => 'phone',
			)
		);

		// Facebook.
		$wp_customize->add_setting(
			'facebook',
			array(
				'type'      => 'option',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'facebook',
			array(
				'label'       => __( 'Facebook', 'formatcine' ),
				'description' => __( 'Indicate the URL of the Facebook account', 'formatcine' ),
				'section'     => 'contact',
				'settings'    => 'facebook',
			)
		);

		// Twitter.
		$wp_customize->add_setting(
			'twitter',
			array(
				'type'      => 'option',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'twitter',
			array(
				'label'       => __( 'Twitter', 'formatcine' ),
				'description' => __( 'Indicate the URL of the Twitter account', 'formatcine' ),
				'section'     => 'contact',
				'settings'    => 'twitter',
			)
		);

		// Instagram.
		$wp_customize->add_setting(
			'instagram',
			array(
				'type'      => 'option',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'instagram',
			array(
				'label'       => __( 'Instagram', 'formatcine' ),
				'description' => __( 'Indicate the URL of the Instagram account', 'formatcine' ),
				'section'     => 'contact',
				'settings'    => 'instagram',
			)
		);

		// Pinterest.
		$wp_customize->add_setting(
			'pinterest',
			array(
				'type'      => 'option',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'pinterest',
			array(
				'label'       => __( 'Pinterest', 'formatcine' ),
				'description' => __( 'Indicate the URL of the Pinterest account', 'formatcine' ),
				'section'     => 'contact',
				'settings'    => 'pinterest',
			)
		);

		// YouTube.
		$wp_customize->add_setting(
			'youtube',
			array(
				'type'      => 'option',
				'transport' => 'postMessage',
			)
		);

		$wp_customize->add_control(
			'youtube',
			array(
				'label'       => __( 'YouTube', 'formatcine' ),
				'description' => __( 'Indicate the URL of the YouTube account', 'formatcine' ),
				'section'     => 'contact',
				'settings'    => 'youtube',
			)
		);
	}
}
