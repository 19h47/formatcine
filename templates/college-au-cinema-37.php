<?php
/**
 * Template Name: Collège au cinéma 37
 */
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$templates = array( 'pages/college-au-cinema-37.twig' );

Timber::render( $templates, $context );