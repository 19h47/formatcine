<?php
/**
 * Index
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @file    index.php
 * @package Formatcine
 */

use Timber\{ Timber, Post };

$context         = Timber::get_context();
$context['post'] = new Post();

$templates = array( 'index.html.twig' );

Timber::render( $templates, $context );
