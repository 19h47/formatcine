<?php // phpcs:ignore
/**
 * Class School Class
 *
 * @package FormatCine
 */

namespace FormatCine\Core;

use WP_Query;

/**
 * SchoolClass tag class
 */
class SchoolClass {

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'init', array( $this, 'register' ) );

		add_action( 'manage_edit-school_class_columns', array( $this, 'add_custom_columns' ) );
		add_action( 'manage_school_class_custom_column', array( $this, 'render_custom_columns' ), 10, 3 );
	}


	/**
	 * Register Custom Taxonomy
	 *
	 * @access public
	 * @return void
	 */
	public function register() {

		$labels = array(
			'name'                       => _x( 'Classes', 'school class general', 'formatcine' ),
			'singular_name'              => _x( 'Class', 'school class singular', 'formatcine' ),
			'search_items'               => __( 'Search Classes', 'formatcine' ),
			'all_items'                  => __( 'All Classes', 'formatcine' ),
			'popular_items'              => __( 'Popular Classes', 'formatcine' ),
			'parent_item'                => __( 'Parent Class', 'formatcine' ),
			'parent_item_colon'          => __( 'Parent Class:', 'formatcine' ),
			'edit_item'                  => __( 'Edit Class', 'formatcine' ),
			'view_item'                  => __( 'View Class', 'formatcine' ),
			'update_item'                => __( 'Update Class', 'formatcine' ),
			'add_new_item'               => __( 'Add New Class', 'formatcine' ),
			'new_item_name'              => __( 'New Class Name', 'formatcine' ),
			'separate_items_with_commas' => __( 'Separate classes with commas', 'formatcine' ),
			'add_or_remove_items'        => __( 'Add or remove classes', 'formatcine' ),
			'choose_from_most_used'      => __( 'Choose from the most used classes', 'formatcine' ),
			'not_found'                  => __( 'No class found in Trash.', 'formatcine' ),
			'no_terms'                   => __( 'No class found.', 'formatcine' ),
			'items_list_navigation'      => __( 'Classes list navigation', 'formatcine' ),
			'items_list'                 => __( 'Classes list', 'formatcine' ),
			/* translators: Tab heading when selecting from the most used terms. */
			'most_used'                  => _x( 'Most Used', 'class', 'formatcine' ),
			'back_to_items'              => __( '&larr; Back to Classes', 'formatcine' ),
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

		register_taxonomy( 'school_class', array( 'programming', 'school_training' ), $args );
	}


	/**
	 * Add custom columns
	 *
	 * @param array $columns Array of columns.
	 * @access public
	 */
	public function add_custom_columns( array $columns ) {

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
								'taxonomy' => 'school_class',
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
								'taxonomy' => 'school_class',
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
}
