<?php
/**
 * /front-page
 *
 * @package  	WordPress
 * @subpackage  jveb
 * @author   	Jérémy Levron levronjeremy@19h47.fr
 */


if ( ! class_exists( 'Timber' ) ) {
	echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
	return;
}


$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;
$context['posts'] = Timber::get_posts(
	array( 
		'post_type' 	=> 'post', 
		'post_status'	=> 'publish',
		'meta_key'		=> 'event_date',
		'orderby'		=> 'meta_value',
		'order'			=> 'ASC',
		'post_per_page'	=> 6
	)
);

$context['events']['categories'] = get_terms( array( 'taxonomy' => 'category' ) );


$templates = array( 'pages/front-page.twig' );


Timber::render( $templates, $context );