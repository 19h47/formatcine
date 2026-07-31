<?php // phpcs:ignore
/**
 * Class Movie
 *
 * @package WordPress
 * @subpackage Formatcine
 */

namespace FormatCine\Core;

use Timber\{ Timber };

/**
 * Movie class
 */
class Movie {

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'init', array( $this, 'register' ), 10, 0 );
		add_action( 'admin_head', array( $this, 'css' ) );
		add_action( 'admin_head', array( $this, 'custom_post_type_css' ) );

		add_filter( 'manage_movie_posts_columns', array( $this, 'add_custom_columns' ) );
		add_action( 'manage_movie_posts_custom_column', array( $this, 'render_custom_columns' ), 10, 2 );
	}


	/**
	 * CSS for movie CPT
	 */
	public function custom_post_type_css() {
		global $pagenow, $typenow;

		if ( ( 'post.php' !== $pagenow ) && ( 'movie' !== $typenow ) ) {
			return false;
		}

		?>
		<style>.acf-field-taxonomy { min-height: auto!important; }</style>
		<?php
	}


	/**
	 * Register Custom Post Type
	 *
	 * @return void
	 * @access public
	 */
	public function register() : void {
		$labels = array(
			'name'                     => _x( 'Movies', 'movie type general', 'formatcine' ),
			'singular_name'            => _x( 'Movie', 'movie type singular', 'formatcine' ),
			'add_new'                  => __( 'Add New', 'formatcine' ),
			'add_new_item'             => __( 'Add New Movie', 'formatcine' ),
			'edit_item'                => __( 'Edit Movie', 'formatcine' ),
			'new_item'                 => __( 'New Movie', 'formatcine' ),
			'view_item'                => __( 'View Movie', 'formatcine' ),
			'view_items'               => __( 'View Movies', 'formatcine' ),
			'search_items'             => __( 'Search Movies', 'formatcine' ),
			'not_found'                => __( 'No movie found.', 'formatcine' ),
			'not_found_in_trash'       => __( 'No movie found in Trash.', 'formatcine' ),
			'parent_item_colon'        => __( 'Parent Movie:', 'formatcine' ),
			'all_items'                => __( 'All movies', 'formatcine' ),
			'archives'                 => __( 'Movie Archives', 'formatcine' ),
			'attributes'               => __( 'Movie Attributes', 'formatcine' ),
			'insert_into_item'         => __( 'Insert into movie', 'formatcine' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this movie', 'formatcine' ),
			'featured_image'           => _x( 'Featured Image', 'movie', 'formatcine' ),
			'set_featured_image'       => _x( 'Set featured image', 'movie', 'formatcine' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'movie', 'formatcine' ),
			'use_featured_image'       => _x( 'Use as featured image', 'movie', 'formatcine' ),
			'items_list_navigation'    => __( 'Movie list navigation', 'formatcine' ),
			'items_list'               => __( 'Movie list', 'formatcine' ),
			'item_published'           => __( 'Movie published.', 'formatcine' ),
			'item_published_privately' => __( 'Movie published privately.', 'formatcine' ),
			'item_reverted_to_draft'   => __( 'Movie reverted to draft.', 'formatcine' ),
			'item_scheduled'           => __( 'Movie scheduled.', 'formatcine' ),
			'item_updated'             => __( 'Movie updated.', 'formatcine' ),
		);

		$rewrite = array(
			'slug'       => 'films',
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => 'film',
			'labels'              => $labels,
			'supports'            => array( 'title', 'revisions', 'thumbnail' ),
			'taxonomies'          => array( 'director', 'country' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_nav_menus'   => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-tickets-alt',
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);

		register_post_type( 'movie', $args );
	}

	/**
	 * CSS
	 *
	 * @return void
	 */
	public function css() {
		?>
		<style>
			.fixed .column-poster {
				vertical-align: top;
				width: 80px;
			}
			.column-poster a {
				display: block;
			}
			.column-poster a img {
				display: inline-block;
				vertical-align: middle;
				width: 100%;
				max-width: 100%;
				height: auto;
			}

			.column-running_time { width: 80px; }

			.column-taxonomy-country { width: 160px; }

			.column-release_year { width: 160px; }

			.column-taxonomy-director { width: 240px; }

		</style>
		<?php
	}

	/**
	 * Add custom columns
	 *
	 * @param arr $columns Array of columns.
	 * @return $new_columns
	 */
	public function add_custom_columns( $columns ) {

		unset( $columns['date'] );

		$new_columns = array();

		foreach ( $columns as $key => $value ) {
			if ( 'title' === $key ) {
				$new_columns['poster'] = __( 'Poster', 'formatcine' );
			}
			$new_columns[ $key ] = $value;
		}

		$new_columns['release_year'] = __( 'Release year', 'formatcine' );
		$new_columns['running_time'] = __( 'Duration', 'formatcine' );

		return $new_columns;
	}


	/**
	 * Render custom columns
	 *
	 * @param string $column_name Array of column name.
	 * @param int    $post_id The post ID.
	 *
	 * @return void
	 */
	public function render_custom_columns( string $column_name, int $post_id ) : void {
		switch ( $column_name ) {
			case 'poster':
				$html = '—';

				if ( get_the_post_thumbnail( $post_id ) ) {
					$html = Timber::compile(
						'partials/post-link.html.twig',
						array(
							'link'    => get_edit_post_link( $post_id ),
							'content' => get_the_post_thumbnail( $post_id, 'thumbnail' ),
						),
					);
				}

				Timber::render_string( $html );

				break;

			case 'release_year':
				$release_year = get_field( 'release_year', $post_id );

				Timber::render_string( $release_year ? $release_year : '—' );

				break;

			case 'running_time':
				$running_time = get_field( 'running_time', $post_id );

				Timber::render_string( $running_time ? $running_time : '—' );

				break;
		}
	}
}
