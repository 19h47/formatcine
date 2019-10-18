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
				$new_columns['programming'] = __( 'Programmation' );
				$new_columns['training']    = __( 'Formation' );
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
			'name'                       => _x( 'Saisons', 'Taxonomy General Name', 'frmtcn' ),
			'singular_name'              => _x( 'Saison', 'Taxonomy Singular Name', 'frmtcn' ),
			'menu_name'                  => __( 'Saisons', 'frmtcn' ),
			'all_items'                  => __( 'Toutes les saisons', 'frmtcn' ),
			'parent_item'                => __( 'Saison parente', 'frmtcn' ),
			'parent_item_colon'          => __( 'Saison parente :', 'frmtcn' ),
			'new_item_name'              => __( 'Nom de la nouvelle saison', 'frmtcn' ),
			'add_new_item'               => __( 'Ajouter une nouvelle saison', 'frmtcn' ),
			'edit_item'                  => __( 'Éditer l\'saison', 'frmtcn' ),
			'update_item'                => __( 'Mettre à jour l\'saison', 'frmtcn' ),
			'view_item'                  => __( 'Voir l\'saison', 'frmtcn' ),
			'separate_items_with_commas' => __( 'Séparer les saisons par des virgules', 'frmtcn' ),
			'add_or_remove_items'        => __( 'Ajouter ou supprimer une saison', 'frmtcn' ),
			'choose_from_most_used'      => __( 'Choisir parmi les saisons les plus utilisées', 'frmtcn' ),
			'popular_items'              => __( 'Saison populaire', 'frmtcn' ),
			'search_items'               => __( 'Saisons recherchées', 'frmtcn' ),
			'not_found'                  => __( 'Aucun saison n\'a été trouvée', 'frmtcn' ),
			'no_terms'                   => __( 'Pas d\'saison', 'frmtcn' ),
			'items_list'                 => __( 'Liste des saisons', 'frmtcn' ),
			'items_list_navigation'      => __( 'Liste de navigation des saisons', 'frmtcn' ),
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
