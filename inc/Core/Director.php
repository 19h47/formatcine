<?php // phpcs:ignore
/**
 * Class Director
 *
 * @package FormatCine
 */

namespace FormatCine\Core;

/**
 * Director tag class
 */
class Director {

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Register Custom Taxonomy
	 *
	 * @access public
	 * @return void
	 */
	public function register() {
		$labels = array(
			'name'                       => _x( 'Directors', 'director general name', 'formatcine' ),
			'singular_name'              => _x( 'Director', 'director singular name', 'formatcine' ),
			'search_items'               => __( 'Search Directors', 'formatcine' ),
			'all_items'                  => __( 'All Directors', 'formatcine' ),
			'popular_items'              => __( 'Popular Directors', 'formatcine' ),
			'parent_item'                => __( 'Parent Director', 'formatcine' ),
			'parent_item_colon'          => __( 'Parent Director:', 'formatcine' ),
			'edit_item'                  => __( 'Edit Director', 'formatcine' ),
			'view_item'                  => __( 'View Director', 'formatcine' ),
			'update_item'                => __( 'Update Director', 'formatcine' ),
			'add_new_item'               => __( 'Add New Director', 'formatcine' ),
			'new_item_name'              => __( 'New Director Name', 'formatcine' ),
			'separate_items_with_commas' => __( 'Separate directors with commas', 'formatcine' ),
			'add_or_remove_items'        => __( 'Add or remove directors', 'formatcine' ),
			'choose_from_most_used'      => __( 'Choose from the most used directors', 'formatcine' ),
			'not_found'                  => __( 'No director found in Trash.', 'formatcine' ),
			'no_terms'                   => __( 'No director found.', 'formatcine' ),
			'items_list_navigation'      => __( 'Directors list navigation', 'formatcine' ),
			'items_list'                 => __( 'Directors list', 'formatcine' ),
			/* translators: Tab heading when selecting from the most used terms. */
			'most_used'                  => _x( 'Most Used', 'director', 'formatcine' ),
			'back_to_items'              => __( '&larr; Back to Directors', 'formatcine' ),
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

		register_taxonomy( 'director', array( 'movie' ), $args );
	}
}
