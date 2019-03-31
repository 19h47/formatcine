<?php
/**
 * Template Name: Formations pour les enseignants
 *
 * @package frmtcn
 */

$context           = Timber::get_context();
$context['post']   = new TimberPost();
$context['parent'] = new TimberPost( $post->post_parent );

$context['adult_trainings'] = Timber::get_posts(
	array(
		'post_type'   => 'adult_training',
		'post_status' => 'publish',
		'tax_query'   => array(
			array(
				'taxonomy' => 'adult_training_category',
				'field'    => 'term_id',
				'terms'    => 35,
			),
		),
	)
);

// Comments.
$ids = array();
foreach ( $context['adult_trainings'] as $adult_training ) {
	$ids[] = $adult_training->id;
}

$args = array(
	'post_type' => array( 'adult_training' ),
	'post__in'  => $ids,
);

$context['comments'] = get_comments( $args );

$templates = array( 'pages/formations-pour-les-enseignants.html.twig' );

Timber::render( $templates, $context );
