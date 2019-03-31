<?php
/**
 * Template Name: Nos partenaires
 *
 * @package frmtcn
 */

$context         = Timber::get_context();
$context['post'] = new TimberPost();

$templates = array( 'pages/nos-partenaires.html.twig' );

Timber::render( $templates, $context );
