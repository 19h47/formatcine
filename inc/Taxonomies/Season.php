<?php
/**
 * Class Season
 *
 * @package Formatcine
 */

namespace Formatcine\Taxonomies;

/**
 * Season tag class
 */
class Season {

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
	 * @param string $theme_version The theme version.
	 * @access public
	 */
	public function __construct( string $theme_version ) {
		$this->theme_version = $theme_version;

		add_action( 'init', array( $this, 'register_taxonomy' ) );

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
				$new_columns['programming'] = __( 'Programming', 'frmtcn' );
				$new_columns['training']    = __( 'Training', 'frmtcn' );
			}
			$new_columns[ $key ] = $value;
		}
		return $new_columns;
	}

	/**
	 * Render custom columns
	 *
	 * @param str $content The content.
	 * @param arr $column_name Array of column name.
	 * @param int $term_id The post ID.
	 */
	public function render_custom_columns( $content, $column_name, $term_id ) {

		switch ( $column_name ) {
			case 'training':
				$query = new WP_Query(
					array(
						'post_type' => 'training',
						'tax_query' => array(
							array(
								'taxonomy' => 'season',
								'field'    => 'id',
								'terms'    => $term_id,
							),
						),
					)
				);

				if ( $query ) {
					echo (int) $query->post_count;
				} else {
					echo '—';
				}

				break;

			case 'programming':
				$query = new WP_Query(
					array(
						'post_type' => 'programming',
						'tax_query' => array(
							array(
								'taxonomy' => 'season',
								'field'    => 'id',
								'terms'    => $term_id,
							),
						),
					)
				);

				if ( $query ) {
					echo (int) $query->post_count;
				} else {
					echo '—';
				}

				break;
		}
	}


	/**
	 * Register Custom Taxonomy
	 *
	 * @return void
	 * @access public
	 */
	public function register_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Seasons', 'season general name', 'frmtcn' ),
			'singular_name'              => _x( 'Season', 'season singular name', 'frmtcn' ),
			'search_items'               => __( 'Search Seasons', 'frmtcn' ),
			'all_items'                  => __( 'All seasons', 'frmtcn' ),
			'popular_items'              => __( 'Popular Seasons', 'frmtcn' ),
			'parent_item'                => __( 'Parent Season', 'frmtcn' ),
			'parent_item_colon'          => __( 'Parent Season:', 'frmtcn' ),
			'edit_item'                  => __( 'Edit Season', 'frmtcn' ),
			'view_item'                  => __( 'View Season', 'frmtcn' ),
			'update_item'                => __( 'Update Season', 'frmtcn' ),
			'add_new_item'               => __( 'Add New season', 'frmtcn' ),
			'separate_items_with_commas' => __( 'Separate seasons with commas', 'frmtcn' ),
			'add_or_remove_items'        => __( 'Add or remove seasons', 'frmtcn' ),
			'choose_from_most_used'      => __( 'Choose from the most used seasons', 'frmtcn' ),
			'not_found'                  => __( 'No season found in Trash.', 'frmtcn' ),
			'no_terms'                   => __( 'No season found.', 'frmtcn' ),
			'items_list_navigation'      => __( 'Seasons list navigation', 'frmtcn' ),
			'items_list'                 => __( 'Seasons list', 'frmtcn' ),
			/* translators: Tab heading when selecting from the most used terms. */
			'most_used'                  => _x( 'Most Used', 'season', 'frmtcn' ),
			'back_to_items'              => __( '&larr; Back to Seasons', 'frmtcn' ),
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
