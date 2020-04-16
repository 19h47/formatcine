<?php // phpcs:ignore
/**
 * Class Country
 *
 * @package Formatcine
 */

namespace Formatcine\Taxonomies;

/**
 * Country tag class
 */
class Country {

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
			'name'                       => _x( 'Countries', 'country general name', 'frmtcn' ),
			'singular_name'              => _x( 'Country', 'country singular name', 'frmtcn' ),
			'search_items'               => __( 'Search Countries', 'frmtcn' ),
			'all_items'                  => __( 'All Countries', 'frmtcn' ),
			'popular_items'              => __( 'Popular Countries', 'frmtcn' ),
			'parent_item'                => __( 'Parent Country', 'frmtcn' ),
			'parent_item_colon'          => __( 'Parent Country:', 'frmtcn' ),
			'edit_item'                  => __( 'Edit Country', 'frmtcn' ),
			'view_item'                  => __( 'View Country', 'frmtcn' ),
			'update_item'                => __( 'Update Country', 'frmtcn' ),
			'add_new_item'               => __( 'Add New Country', 'frmtcn' ),
			'new_item_name'              => __( 'New Country Name', 'frmtcn' ),
			'separate_items_with_commas' => __( 'Separate countries with commas', 'frmtcn' ),
			'add_or_remove_items'        => __( 'Add or remove countries', 'frmtcn' ),
			'choose_from_most_used'      => __( 'Choose from the most used countries', 'frmtcn' ),
			'not_found'                  => __( 'No coutries found.', 'frmtcn' ),
			'no_terms'                   => __( 'No countries', 'frmtcn' ),
			'items_list_navigation'      => __( 'Countries list navigation', 'frmtcn' ),
			'items_list'                 => __( 'Countries list', 'frmtcn' ),
			/* translators: Tab heading when selecting from the most used terms. */
			'most_used'                  => _x( 'Most Used', 'country', 'frmtcn' ),
			'back_to_items'              => __( '&larr; Back to Countries', 'frmtcn' ),
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

		register_taxonomy( 'country', array( 'movie' ), $args );
	}
}
