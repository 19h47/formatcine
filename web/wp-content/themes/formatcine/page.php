<?php
/**
 * Page
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 * @file    page.php
 * @package Formatcine
 */

if ( ! class_exists( 'Timber' ) ) {
	echo 'Timber not activated. Make sure you activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
	return;
}


$context           = Timber::get_context();
$context['post']   = new TimberPost();
$context['parent'] = new TimberPost( $post->post_parent );

$templates = array( 'index.html.twig' );

// Page video.
if ( is_page( 171 ) || is_page( 183 ) ) {
	array_unshift( $templates, 'pages/video.html.twig' );
}


Timber::render( $templates, $context );
