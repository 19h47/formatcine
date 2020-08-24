<?php // phpcs:ignore
/**
 * Class Season
 *
 * @package FormatCine
 */

namespace FormatCine\Core;

use WP_Query;

/**
 * Season tag class
 */
class Season {

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'init', array( $this, 'register' ) );

		add_action( 'manage_edit-season_columns', array( $this, 'add_custom_columns' ) );
		add_action( 'manage_season_custom_column', array( $this, 'render_custom_columns' ), 10, 3 );
	}


	/**
	 * Add custom columns
	 *
	 * @param arr $columns Array of columns.
	 */
	public function add_custom_columns( $columns ) {

		unset( $columns['date'] );

		$new_columns = array();

		foreach ( $columns as $key => $value ) {
			if ( 'posts' === $key ) {
				$new_columns['programming'] = __( 'Programming', 'formatcine' );
				$new_columns['training']    = __( 'Training', 'formatcine' );
			}
			$new_columns[ $key ] = $value;
		}
		return $new_columns;
	}


	/**
	 * Render custom columns
	 *
	 * @param string $content The content.
	 * @param string $column_name Array of column name.
	 * @param int    $term_id The post ID.
	 *
	 * @return void
	 */
	public function render_custom_columns( string $content, string $column_name, int $term_id ) : void {

		switch ( $column_name ) {
			case 'training':
				$query = new WP_Query(
					array(
						'post_type' => 'school_training',
						'tax_query' => array( // phpcs:ignore
							array(
								'taxonomy' => 'season',
								'field'    => 'id',
								'terms'    => $term_id,
							),
						),
					)
				);

				echo (int) $query->post_count;

				break;

			case 'programming':
				$query = new WP_Query(
					array(
						'post_type' => 'programming',
						'tax_query' => array( // phpcs:ignore
							array(
								'taxonomy' => 'season',
								'field'    => 'id',
								'terms'    => $term_id,
							),
						),
					)
				);

				echo (int) $query->post_count;

				break;
		}
	}


	/**
	 * Register
	 *
	 * @access public
	 * @return void
	 */
	public function register() : void {
		$labels = array(
			'name'                       => _x( 'Seasons', 'season general name', 'formatcine' ),
			'singular_name'              => _x( 'Season', 'season singular name', 'formatcine' ),
			'search_items'               => __( 'Search Seasons', 'formatcine' ),
			'all_items'                  => __( 'All seasons', 'formatcine' ),
			'popular_items'              => __( 'Popular Seasons', 'formatcine' ),
			'parent_item'                => __( 'Parent Season', 'formatcine' ),
			'parent_item_colon'          => __( 'Parent Season:', 'formatcine' ),
			'edit_item'                  => __( 'Edit Season', 'formatcine' ),
			'view_item'                  => __( 'View Season', 'formatcine' ),
			'update_item'                => __( 'Update Season', 'formatcine' ),
			'add_new_item'               => __( 'Add New season', 'formatcine' ),
			'separate_items_with_commas' => __( 'Separate seasons with commas', 'formatcine' ),
			'add_or_remove_items'        => __( 'Add or remove seasons', 'formatcine' ),
			'choose_from_most_used'      => __( 'Choose from the most used seasons', 'formatcine' ),
			'not_found'                  => __( 'No season found in Trash.', 'formatcine' ),
			'no_terms'                   => __( 'No season found.', 'formatcine' ),
			'items_list_navigation'      => __( 'Seasons list navigation', 'formatcine' ),
			'items_list'                 => __( 'Seasons list', 'formatcine' ),
			/* translators: Tab heading when selecting from the most used terms. */
			'most_used'                  => _x( 'Most Used', 'season', 'formatcine' ),
			'back_to_items'              => __( '&larr; Back to Seasons', 'formatcine' ),
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'meta_box_cb'       => false,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
		);

		register_taxonomy( 'season', array( 'programming', 'school_training' ), $args );
	}
}
