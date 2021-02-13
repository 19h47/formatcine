<?php
/**
 * Index
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @file    index.php
 * @package Formatcine
 */

use Timber\{ Timber };

$filenames = array( 'index.html.twig' );

$data         = Timber::context();
$data['post'] = Timber::get_post();

Timber::render( $filenames, $data );
