<?php
/**
 * Template Name: Collège au cinéma 37
 *
 * @package Formatcine
 */

use FormatCine\Models\{ CollegeInCinemaPost };

$context         = Timber::get_context();
$context['post'] = new CollegeInCinemaPost();

$templates = array( 'pages/college-au-cinema-37.html.twig' );

Timber::render( $templates, $context );
