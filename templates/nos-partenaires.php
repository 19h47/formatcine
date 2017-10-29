<?php
/**
 * Template Name: Nos partenaires
 */
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$templates = array( 'pages/nos-partenaires.twig' );

Timber::render( $templates, $context );