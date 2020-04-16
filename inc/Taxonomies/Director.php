<?php // phpcs:ignore
/**
 * Class Director
 *
 * @package Formatcine
 */

namespace Formatcine\Taxonomies;

/**
 * Director tag class
 */
class Director {

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
	 * @param str $theme_version The theme version.
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
			'name'                       => _x( 'Directors', 'director general name', 'frmtcn' ),
			'singular_name'              => _x( 'Director', 'director singular name', 'frmtcn' ),
			'search_items'               => __( 'Search Directors', 'frmtcn' ),
			'all_items'                  => __( 'All Directors', 'frmtcn' ),
			'popular_items'              => __( 'Popular Directors', 'frmtcn' ),
			'parent_item'                => __( 'Parent Director', 'frmtcn' ),
			'parent_item_colon'          => __( 'Parent Director:', 'frmtcn' ),
			'edit_item'                  => __( 'Edit Director', 'frmtcn' ),
			'view_item'                  => __( 'View Director', 'frmtcn' ),
			'update_item'                => __( 'Update Director', 'frmtcn' ),
			'add_new_item'               => __( 'Add New Director', 'frmtcn' ),
			'new_item_name'              => __( 'New Director Name', 'frmtcn' ),
			'separate_items_with_commas' => __( 'Separate directors with commas', 'frmtcn' ),
			'add_or_remove_items'        => __( 'Add or remove directors', 'frmtcn' ),
			'choose_from_most_used'      => __( 'Choose from the most used directors', 'frmtcn' ),
			'not_found'                  => __( 'No director found in Trash.', 'frmtcn' ),
			'no_terms'                   => __( 'No director found.', 'frmtcn' ),
			'items_list_navigation'      => __( 'Directors list navigation', 'frmtcn' ),
			'items_list'                 => __( 'Directors list', 'frmtcn' ),
			/* translators: Tab heading when selecting from the most used terms. */
			'most_used'                  => _x( 'Most Used', 'director', 'frmtcn' ),
			'back_to_items'              => __( '&larr; Back to Directors', 'frmtcn' ),
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
