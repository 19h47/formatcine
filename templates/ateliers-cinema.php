<?php
/**
 * Template Name: Ateliers Cinéma
 */
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$templates = array( 'pages/ateliers-cinema.twig' );

Timber::render( $templates, $context );