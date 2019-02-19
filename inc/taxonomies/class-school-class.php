<?php
/**
 * Class School Class
 *
 * @package frmtcn
 */

/**
 * SchoolClass tag class
 */
class School_Class {

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

		add_action( 'manage_edit-school_class_columns', array( $this, 'add_custom_columns' ) );
		add_action( 'manage_school_class_custom_column', array( $this, 'render_custom_columns' ), 10, 3 );
	}


	/**
	 * Register Custom Taxonomy
	 *
	 * @access public
	 * @return void
	 */
	public function register_taxonomy() {

		$labels = array(
			'name'                       => _x( 'Classes', 'Taxonomy General Name', 'frmtcn' ),
			'singular_name'              => _x( 'Classe', 'Taxonomy Singular Name', 'frmtcn' ),
			'menu_name'                  => __( 'Classes', 'frmtcn' ),
			'all_items'                  => __( 'Toutes les classes', 'frmtcn' ),
			'parent_item'                => __( 'Classe parente', 'frmtcn' ),
			'parent_item_colon'          => __( 'Classe parente :', 'frmtcn' ),
			'new_item_name'              => __( 'Nom de la nouvelle classe', 'frmtcn' ),
			'add_new_item'               => __( 'Ajouter une nouvelle classe', 'frmtcn' ),
			'edit_item'                  => __( 'Éditer la classe', 'frmtcn' ),
			'update_item'                => __( 'Mettre à jour la classe', 'frmtcn' ),
			'view_item'                  => __( 'Voir la classe', 'frmtcn' ),
			'separate_items_with_commas' => __( 'Séparer les classes par des virgules', 'frmtcn' ),
			'add_or_remove_items'        => __( 'Ajouter ou supprimer une classe', 'frmtcn' ),
			'choose_from_most_used'      => __( 'Choisir parmi les classes les plus utilisées', 'frmtcn' ),
			'popular_items'              => __( 'Classe populaire', 'frmtcn' ),
			'search_items'               => __( 'Classes recherchées', 'frmtcn' ),
			'not_found'                  => __( 'Aucune classe n\'a été trouvée', 'frmtcn' ),
			'no_terms'                   => __( 'Pas de classe', 'frmtcn' ),
			'items_list'                 => __( 'Liste des classes', 'frmtcn' ),
			'items_list_navigation'      => __( 'Liste de navigation des classes', 'frmtcn' ),
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
	 * @param arr $columns Array of columns.
	 * @access public
	 */
	public function add_custom_columns( $columns ) {

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
								'taxonomy' => 'school_class',
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
								'taxonomy' => 'school_class',
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
}
