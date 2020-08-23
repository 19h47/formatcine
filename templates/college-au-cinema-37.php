<?php
/**
 * Template Name: Collège au cinéma 37
 *
 * @package Formatcine
 */

use Formatcine\Models\{ CollegeInCinemaPost };

$season = get_field( 'season', $post );

$context                     = Timber::get_context();
$context['post']             = new CollegeInCinemaPost();
$context['season']           = $season;
$context['school_trainings'] = Timber::get_posts(
	array(
		'post_type'     => 'school_training',
		'post_status'   => 'publish',
		'meta_key'      => 'formation_date', // phpcs:ignore
		'orderby'       => 'meta_value',
		'order'         => 'ASC',
		'post_per_page' => 6,
		'tax_query'     => array( // phpcs:ignore
			array(
				'taxonomy' => 'season',
				'field'    => 'term_id',
				'terms'    => $season ? $season->term_id : null,
			),
		),
	)
);

// School classes.
$school_classes = get_terms(
	array(
		'taxonomy'   => 'school_class',
		'hide_empty' => false,
		'meta_key'   => 'term_order', // phpcs:ignore
		'orderby'    => 'meta_value',
	)
);

$context['school_classes'] = array(
	'sixieme-cinquieme'   => array(
		'term_ids' => array(),
		'names'    => array(),
	),
	'quatrieme-troisieme' => array(
		'term_ids' => array(),
		'names'    => array(),
	),
);

foreach ( $school_classes as $school_class ) {

	if ( 'sixieme' === $school_class->slug || 'cinquieme' === $school_class->slug ) {
		array_push( $context['school_classes']['sixieme-cinquieme']['term_ids'], $school_class->term_id );
		array_push( $context['school_classes']['sixieme-cinquieme']['names'], $school_class->name );
	}

	if ( 'quatrieme' === $school_class->slug || 'troisieme' === $school_class->slug ) {
		array_push( $context['school_classes']['quatrieme-troisieme']['term_ids'], $school_class->term_id );
		array_push( $context['school_classes']['quatrieme-troisieme']['names'], $school_class->name );
	}
}


$templates = array( 'pages/college-au-cinema-37.html.twig' );


Timber::render( $templates, $context );
