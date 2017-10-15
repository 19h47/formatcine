<?php
/**
 * Template Name: Collège au cinéma 37
 */
$context = Timber::get_context();
$post = new TimberPost();
$context['post'] = $post;

$season = get_field( 'season', $post );

$context['season'] = $season;

$context['school_trainings'] = Timber::get_posts(
	array( 
		'post_type' 	=> 'school_training', 
		'post_status'	=> 'publish',
		'meta_key'		=> 'formation_date',
		'orderby'		=> 'meta_value',
		'order'			=> 'ASC',
		'post_per_page'	=> 6,
		'tax_query' 	=> array(
			array(
				'taxonomy'	=> 'season',
				'field'    	=> 'term_id',
				'terms'    	=> $season->term_id
			),
		),
	)
);


// School classes
$school_classes = get_terms( array( 'taxonomy' => 'school_class', 'hide_empty' => false ) );

$context['school_classes'] = array( 
	'sixieme-cinquieme' 	=> array(
		'term_ids'	=> array(),
		'names'		=> array()
	),
	'quatrieme-troisieme'	=> array(
		'term_ids'	=> array(),
		'names'		=> array()
	) 
);

foreach ( $school_classes as $school_class) {
	
	if ( $school_class->slug === 'sixieme' || $school_class->slug === 'cinquieme') {
		array_push($context['school_classes']['sixieme-cinquieme']['term_ids'], $school_class->term_id);
		array_push($context['school_classes']['sixieme-cinquieme']['names'], $school_class->name);
	}


	if ( $school_class->slug === 'quatrieme' || $school_class->slug === 'troisieme' ) {
		array_push($context['school_classes']['quatrieme-troisieme']['term_ids'], $school_class->term_id);
		array_push($context['school_classes']['quatrieme-troisieme']['names'], $school_class->name);
	}	
}


// Programming
$context['programmings'] = Timber::get_posts(
	array( 
		'post_type' 	=> 'programming',
		'post_status'	=> 'publish',
		'meta_query' 	=> array(
	        'relation' 	=> 'AND',
	        'quarter_clause' => array(
	            'key' 	=> 'quarter',
	        ),
	        'school_class_clause' => array(
	            'key' 	=> 'school_class',
	        ), 
	    ),
        'orderby'    	=> array(
			'school_class_clause' 	=> 'ASC',
			'quarter_clause' 		=> 'ASC',
		),
		'tax_query' 	=> array(
			array(
				'taxonomy'	=> 'season',
				'field'    	=> 'term_id',
				'terms'    	=> $season->term_id
			)
		)
	)
);


$templates = array( 'pages/college-au-cinema-37.twig' );


Timber::render( $templates, $context );