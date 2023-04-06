<?php
/**
 * Page
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 * @file    page.php
 * @package Formatcine
 */

use Timber\{ Timber };

$filenames = array( 'index.html.twig' );

$data         = Timber::get_context();
$data['post'] = Timber::get_post();

// Page video.
if ( is_page( 171 ) || is_page( 183 ) ) {
	array_unshift( $filenames, 'pages/video.html.twig' );
}

Timber::render( $filenames, $data );
