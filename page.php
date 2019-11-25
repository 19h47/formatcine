<?php
/**
 * Page
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 * @file    page.php
 * @package Formatcine
 */

use Timber\{ Timber, Post };


$context           = Timber::get_context();
$context['post']   = new Post();
$context['parent'] = new Post( $post->post_parent );

$templates = array( 'index.html.twig' );

// Page video.
if ( is_page( 171 ) || is_page( 183 ) ) {
	array_unshift( $templates, 'pages/video.html.twig' );
}

Timber::render( $templates, $context );
