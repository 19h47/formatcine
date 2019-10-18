<?php
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
			'name'                       => _x( 'Pays', 'Taxonomy General Name', 'frmtcn' ),
			'singular_name'              => _x( 'Pays', 'Taxonomy Singular Name', 'frmtcn' ),
			'menu_name'                  => __( 'Pays', 'frmtcn' ),
			'all_items'                  => __( 'Tous les pays', 'frmtcn' ),
			'parent_item'                => __( 'Pays parent', 'frmtcn' ),
			'parent_item_colon'          => __( 'Pays parent :', 'frmtcn' ),
			'new_item_name'              => __( 'Nom du nouveau pays', 'frmtcn' ),
			'add_new_item'               => __( 'Ajouter un nouveau pays', 'frmtcn' ),
			'edit_item'                  => __( 'Éditer le pays', 'frmtcn' ),
			'update_item'                => __( 'Mettre à jour le pays', 'frmtcn' ),
			'view_item'                  => __( 'Voir le pays', 'frmtcn' ),
			'separate_items_with_commas' => __( 'Séparer les pays par des virgules', 'frmtcn' ),
			'add_or_remove_items'        => __( 'Ajouter ou supprimer un pays', 'frmtcn' ),
			'choose_from_most_used'      => __( 'Choisir parmi les pays les plus utilisés', 'frmtcn' ),
			'popular_items'              => __( 'Pays populaire', 'frmtcn' ),
			'search_items'               => __( 'Pays recherchés', 'frmtcn' ),
			'not_found'                  => __( 'Aucun pays n\'a été trouvé', 'frmtcn' ),
			'no_terms'                   => __( 'Pas de pays', 'frmtcn' ),
			'items_list'                 => __( 'Liste des pays', 'frmtcn' ),
			'items_list_navigation'      => __( 'Liste de navigation des pays', 'frmtcn' ),
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
