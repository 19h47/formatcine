<?php
/**
 * /index
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
$context['parent'] = new TimberPost( $post->post_parent );

$templates = array( 'index.twig' );

// Page video
if ( is_page( 171 ) || is_page( 183 ) ) {
	array_unshift( $templates, 'pages/video.twig' );
}


Timber::render( $templates, $context );