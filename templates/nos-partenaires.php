<?php
/**
 * Template Name: Nos partenaires
 *
 * @package Formatcine
 */

$context         = Timber::get_context();
$context['post'] = new TimberPost();

$templates = array( 'pages/nos-partenaires.html.twig' );

Timber::render( $templates, $context );
