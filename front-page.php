<?php
/**
 * Front page
 *
 * @author  Jérémy Levron <jeremylevron@19h47.fr> (https://19h47.fr)
 * @package WordPress
 * @subpackage Formatcine
 */

use Timber\{ Timber, Helper };

$filenems = array( 'pages/front-page.html.twig' );

$data          = Timber::context();
$data['post']  = Timber::get_post();
$data['posts'] = Helper::transient(
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

$data['events']['categories'] = get_terms( array( 'taxonomy' => 'category' ) );

Timber::render( $filenems, $data );
