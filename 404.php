<?php
/**
 * Index
 *
 * @package Formatcine
 * @file    404.php
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 */

use Timber\{ Timber };

$context = Timber::context();

$context['post'] = array(
	'post_title'   => '404',
	'content' => __( 'Oops! That page can&rsquo;t be found.', 'Formatcine' ),
);

$templates = array( 'index.html.twig' );

Timber::render( $templates, $context );
