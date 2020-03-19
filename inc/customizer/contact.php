<?php
/**
 * Contact
 *
 * @package Formatcine
 */

add_action( 'customize_register', 'frmtcn_customize_contact' );

/**
 * Contact
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 */
function frmtcn_customize_contact( $wp_customize ) {

	// Add contact section.
	$wp_customize->add_section(
		'contact',
		array(
			'title'       => __( 'Contact details', 'frmtcn' ),
			'description' => __( 'Contact details settings', 'frmtcn' ),
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
			'label'       => __( 'Address', 'frmtcn' ),
			'description' => __( 'Indicate postal address', 'frmtcn' ),
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
			'label'       => __( 'Email addresses', 'frmtcn' ),
			'description' => __( 'Indicate the site contact email addresses separated by commas', 'frmtcn' ),
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
			'label'       => __( 'Phone number', 'frmtcn' ),
			'description' => __( 'Indicate telephone number', 'frmtcn' ),
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
			'label'       => __( 'Facebook', 'frmtcn' ),
			'description' => __( 'Indicate the URL of the Facebook account', 'frmtcn' ),
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
			'label'       => __( 'Twitter', 'frmtcn' ),
			'description' => __( 'Indicate the URL of the Twitter account', 'frmtcn' ),
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
			'label'       => __( 'Instagram', 'frmtcn' ),
			'description' => __( 'Indicate the URL of the Instagram account', 'frmtcn' ),
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
			'label'       => __( 'Pinterest', 'frmtcn' ),
			'description' => __( 'Indicate the URL of the Pinterest account', 'frmtcn' ),
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
			'label'       => __( 'YouTube', 'frmtcn' ),
			'description' => __( 'Indicate the URL of the YouTube account', 'frmtcn' ),
			'section'     => 'contact',
			'settings'    => 'youtube',
		)
	);
}
