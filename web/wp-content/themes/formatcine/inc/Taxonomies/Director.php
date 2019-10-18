<?php
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
			'name'                       => _x( 'Réalisateur·trice·s', 'Taxonomy General Name', 'frmtcn' ),
			'singular_name'              => _x( 'Réalisateur·trice', 'Taxonomy Singular Name', 'frmtcn' ),
			'menu_name'                  => __( 'Réalisateur·trice·s', 'frmtcn' ),
			'all_items'                  => __( 'Tous·tes les réalisateurs·trices', 'frmtcn' ),
			'parent_item'                => __( 'Réalisateur·trice parent·e', 'frmtcn' ),
			'parent_item_colon'          => __( 'Réalisateur·trice parent·e :', 'frmtcn' ),
			'new_item_name'              => __( 'Nom du·de la nouveau·elle réalisateur·trice', 'frmtcn' ),
			'add_new_item'               => __( 'Ajouter un·e nouveau·elle réalisateur·trice', 'frmtcn' ),
			'edit_item'                  => __( 'Éditer le·a réalisateur·trice', 'frmtcn' ),
			'update_item'                => __( 'Mettre à jour le·a réalisateur·trice', 'frmtcn' ),
			'view_item'                  => __( 'Voir le·a réalisateur·trice', 'frmtcn' ),
			'separate_items_with_commas' => __( 'Séparer les réalisateurs·trices par des virgules', 'frmtcn' ),
			'add_or_remove_items'        => __( 'Ajouter ou supprimer un·e réalisateur·trice', 'frmtcn' ),
			'choose_from_most_used'      => __( 'Choisir parmi les réalisateurs·trices les plus utilisé·e·s', 'frmtcn' ),
			'popular_items'              => __( 'Réalisateur·trice populaire', 'frmtcn' ),
			'search_items'               => __( 'Réalisateur·trice·s recherchés', 'frmtcn' ),
			'not_found'                  => __( 'Aucun réalisateur·trice n\'a été trouvé·e', 'frmtcn' ),
			'no_terms'                   => __( 'Pas de réalisateur·trice', 'frmtcn' ),
			'items_list'                 => __( 'Liste des réalisateur·trice·s', 'frmtcn' ),
			'items_list_navigation'      => __( 'Liste de navigation des réalisateur·trice·s', 'frmtcn' ),
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
