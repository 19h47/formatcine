<?php
/**
 * Template Name: Ateliers Cinéma
 *
 * @package frmtcn
 */

$context         = Timber::get_context();
$context['post'] = new TimberPost();

$templates = array( 'pages/ateliers-cinema.html.twig' );

Timber::render( $templates, $context );
