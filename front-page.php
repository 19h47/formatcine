<?php
/**
 * Front page
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (http://19h47.fr)
 * @file    front-page.php
 * @package Formatcine
 */

use Timber\{ Timber, Post, Helper };


$context          = Timber::get_context();
$context['post']  = new Post();
$context['posts'] = Helper::transient(
	'formatcine_front_page_posts',
	function() {
		$posts = Timber::get_posts(
			array(
				'post_type'     => 'post',
				'post_status'   => 'publish',
				'meta_key'      => 'event_date', // phpcs:ignore
				'orderby'       => 'meta_value',
				'order'         => 'ASC',
				'post_per_page' => 6,
			)
		);

		return $posts;
	},
);

$context['events']['categories'] = get_terms( array( 'taxonomy' => 'category' ) );

$templates = array( 'pages/front-page.html.twig' );

Timber::render( $templates, $context );
