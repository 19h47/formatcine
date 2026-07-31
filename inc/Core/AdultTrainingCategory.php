<?php // phpcs:ignore
/**
 * Class Adult Training Category
 *
 * @package WordPress
 * @subpackage Formatcine
 */

namespace FormatCine\Core;

/**
 * Adult Training Category tag class
 */
class AdultTrainingCategory {

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'init', array( $this, 'register' ) );
	}


	/**
	 * Register
	 *
	 * @access public
	 * @return void
	 */
	public function register() : void {

		$labels = array(
			'name'                       => _x( 'Categories', 'adult training category general name', 'formatcine' ),
			'singular_name'              => _x( 'Category', 'adult training category singular name', 'formatcine' ),
			'search_items'               => __( 'Search Categories', 'formatcine' ),
			'all_items'                  => __( 'All Categories', 'formatcine' ),
			'popular_items'              => __( 'Popular Categories', 'formatcine' ),
			'parent_item'                => __( 'Parent Category', 'formatcine' ),
			'parent_item_colon'          => __( 'Parent Category:', 'formatcine' ),
			'edit_item'                  => __( 'Edit Category', 'formatcine' ),
			'view_item'                  => __( 'View Category', 'formatcine' ),
			'update_item'                => __( 'Update Category', 'formatcine' ),
			'add_new_item'               => __( 'Add New Category', 'formatcine' ),
			'new_item_name'              => __( 'New Category Name', 'formatcine' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'formatcine' ),
			'add_or_remove_items'        => __( 'Add or remove categories', 'formatcine' ),
			'choose_from_most_used'      => __( 'Choose from the most used categories', 'formatcine' ),
			'not_found'                  => __( 'No adult training category found in Trash.', 'formatcine' ),
			'no_terms'                   => __( 'No adult training category found.', 'formatcine' ),
			'items_list'                 => __( 'Categories list navigation', 'formatcine' ),
			'items_list_navigation'      => __( 'Categories list', 'formatcine' ),
			/* translators: Tab heading when selecting from the most used terms. */
			'most_used'                  => _x( 'Most Used', 'adult training category', 'formatcine' ),
			'back_to_items'              => __( '&larr; Back to Adults training categories', 'formatcine' ),
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => false,
			'query_var'         => false,
			'rewrite'           => false,
			'show_ui'           => true,
			'show_admin_column' => true,
			'meta_box_cb'       => false,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
		);

		register_taxonomy( 'adult_training_category', array( 'adult_training' ), $args );
	}
}
