<?php
/**
 * Class Adult Training Category
 *
 * @package frmtcn
 */

/**
 * Adult Training Category tag class
 */
class Adult_Training_Category {

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
			'name'                       => _x( 'Catégories de formation', 'Taxonomy General Name', 'frmtcn' ),
			'singular_name'              => _x( 'Catégorie de formation', 'Taxonomy Singular Name', 'frmtcn' ),
			'menu_name'                  => __( 'Catégories de formation', 'frmtcn' ),
			'all_items'                  => __( 'Toutes les catégories de formation', 'frmtcn' ),
			'parent_item'                => __( 'Catégorie de formation parente', 'frmtcn' ),
			'parent_item_colon'          => __( 'Catégorie de formation parente :', 'frmtcn' ),
			'new_item_name'              => __( 'Nom de la nouvelle catégorie de formation', 'frmtcn' ),
			'add_new_item'               => __( 'Ajouter une nouvelle catégorie de formation', 'frmtcn' ),
			'edit_item'                  => __( 'Éditer la catégorie de formation', 'frmtcn' ),
			'update_item'                => __( 'Mettre à jour la catégorie de formation', 'frmtcn' ),
			'view_item'                  => __( 'Voir la catégorie de formation', 'frmtcn' ),
			'separate_items_with_commas' => __( 'Séparer les catégories de formation par des virgules', 'frmtcn' ),
			'add_or_remove_items'        => __( 'Ajouter ou supprimer une catégorie de formation', 'frmtcn' ),
			'choose_from_most_used'      => __( 'Choisir parmi les catégories de formation les plus utilisées', 'frmtcn' ),
			'popular_items'              => __( 'Catégorie de formation populaire', 'frmtcn' ),
			'search_items'               => __( 'Catégories de formation recherchées', 'frmtcn' ),
			'not_found'                  => __( 'Aucune catégorie de formation n\'a été trouvée', 'frmtcn' ),
			'no_terms'                   => __( 'Pas de catégorie de formation', 'frmtcn' ),
			'items_list'                 => __( 'Liste des catégories de formation', 'frmtcn' ),
			'items_list_navigation'      => __( 'Liste de navigation des catégories de formation', 'frmtcn' ),
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
