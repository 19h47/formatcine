<?php
/**
 * Front page
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 * @file    front-page.php
 * @package frmtcn
 */

if ( ! class_exists( 'Timber' ) ) {
	echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
	return;
}


$context          = Timber::get_context();
$context['post']  = new TimberPost();
$context['posts'] = Timber::get_posts(
	array(
		'post_type'     => 'post',
		'post_status'   => 'publish',
		'meta_key'      => 'event_date',
		'orderby'       => 'meta_value',
		'order'         => 'ASC',
		'post_per_page' => 6,
	)
);

$context['events']['categories'] = get_terms( array( 'taxonomy' => 'category' ) );

$templates = array( 'pages/front-page.html.twig' );

Timber::render( $templates, $context );
