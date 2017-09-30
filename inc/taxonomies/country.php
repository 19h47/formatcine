<?php

/**
 * Country tag class
 */
class Country {

	/**
     * The unique identifier of this theme.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this theme.
     */
    protected $theme_name;


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
	 * @access public
	 */
	public function __construct( $theme_name, $theme_version ) {
		$this->theme_name = $theme_name;
        $this->theme_version = $theme_version;

        add_action( 'init', array( $this, 'register_taxonomy' ) );
	}
	

	// Register Custom Taxonomy
	function register_taxonomy() {

		$labels = array(
			'name'                       	=> _x( 'Pays', 'Taxonomy General Name', $this->theme_name ),
			'singular_name'              	=> _x( 'Pays', 'Taxonomy Singular Name', $this->theme_name ),
			'menu_name'                  	=> __( 'Pays', $this->theme_name ),
			'all_items'                  	=> __( 'Tous les pays', $this->theme_name ),
			'parent_item'                	=> __( 'Pays parent', $this->theme_name ),
			'parent_item_colon'          	=> __( 'Pays parent :', $this->theme_name ),
			'new_item_name'              	=> __( 'Nom du nouveau pays', $this->theme_name ),
			'add_new_item'               	=> __( 'Ajouter un nouveau pays', $this->theme_name ),
			'edit_item'                  	=> __( 'Éditer le pays', $this->theme_name ),
			'update_item'                	=> __( 'Mettre à jour le pays', $this->theme_name ),
			'view_item'                  	=> __( 'Voir le pays', $this->theme_name ),
			'separate_items_with_commas'	=> __( 'Séparer les pays par des virgules', $this->theme_name ),
			'add_or_remove_items'        	=> __( 'Ajouter ou supprimer un pays', $this->theme_name ),
			'choose_from_most_used'      	=> __( 'Choisir parmi les pays les plus utilisés', $this->theme_name ),
			'popular_items'              	=> __( 'Pays populaire', $this->theme_name ),
			'search_items'               	=> __( 'Pays recherchés', $this->theme_name ),
			'not_found'                  	=> __( 'Aucun pays n\'a été trouvé', $this->theme_name ),
			'no_terms'                   	=> __( 'Pas de pays', $this->theme_name ),
			'items_list'                 	=> __( 'Liste des pays', $this->theme_name ),
			'items_list_navigation'      	=> __( 'Liste de navigation des pays', $this->theme_name ),
		);
		$args = array(
			'labels'                    	=> $labels,
			'hierarchical'              	=> false,
			'public'                    	=> true,
			'show_ui'                   	=> true,
			'show_admin_column'         	=> true,
			'meta_box_cb'					=> false,
			'show_in_nav_menus'          	=> true,
			'show_tagcloud'              	=> true,
		);
		register_taxonomy( 'country', array( 'movie' ), $args );

	}
}