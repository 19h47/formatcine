<?php
/**
 * Class Adult Training Category
 *
 * @package Formatcine
 */

namespace Formatcine\Taxonomies;

/**
 * Adult Training Category tag class
 */
class AdultTrainingCategory {

	/**
	 * The version of the theme.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this theme.
	 */
	private $theme_version;

	/**
	 * Construct function
	 *
	 * @param str $theme_version Theme version.
	 * @access public
	 */
	public function __construct( $theme_version ) {
		$this->theme_version = $theme_version;

		add_action( 'init', array( $this, 'register_taxonomy' ) );
	}


	/**
	 * Register Custom Taxonomy
	 *
	 * @access public
	 * @return void
	 */
	public function register_taxonomy() {

		$labels = array(
			'name'                       => _x( 'Categories', 'adult training category general name', 'frmtcn' ),
			'singular_name'              => _x( 'Category', 'adult training category singular name', 'frmtcn' ),
			'search_items'               => __( 'Search Categories', 'frmtcn' ),
			'all_items'                  => __( 'All Categories', 'frmtcn' ),
			'popular_items'              => __( 'Popular Categories', 'frmtcn' ),
			'parent_item'                => __( 'Parent Category', 'frmtcn' ),
			'parent_item_colon'          => __( 'Parent Category:', 'frmtcn' ),
			'edit_item'                  => __( 'Edit Category', 'frmtcn' ),
			'view_item'                  => __( 'View Category', 'frmtcn' ),
			'update_item'                => __( 'Update Category', 'frmtcn' ),
			'add_new_item'               => __( 'Add New Category', 'frmtcn' ),
			'new_item_name'              => __( 'New Category Name', 'frmtcn' ),
			'separate_items_with_commas' => __( 'Separate categories with commas', 'frmtcn' ),
			'add_or_remove_items'        => __( 'Add or remove categories', 'frmtcn' ),
			'choose_from_most_used'      => __( 'Choose from the most used categories', 'frmtcn' ),
			'not_found'                  => __( 'No adult training category found in Trash.', 'frmtcn' ),
			'no_terms'                   => __( 'No adult training category found.', 'frmtcn' ),
			'items_list'                 => __( 'Categories list navigation', 'frmtcn' ),
			'items_list_navigation'      => __( 'Categories list', 'frmtcn' ),
			/* translators: Tab heading when selecting from the most used terms. */
			'most_used'                  => _x( 'Most Used', 'adult training category', 'frmtcn' ),
			'back_to_items'              => __( '&larr; Back to Adults training categories', 'frmtcn' ),
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

		register_taxonomy( 'adult_training_category', array( 'adult_training' ), $args );
	}
}
