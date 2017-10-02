<?php

/**
 * SchoolClass tag class
 */
class SchoolClass {

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

        add_action( 'manage_edit-school_class_columns', array( $this, 'add_custom_columns' ) );
        add_action( 'manage_school_class_custom_column', array( $this, 'render_custom_columns' ),  10, 3 );
	}
	

	// Register Custom Taxonomy
	function register_taxonomy() {

		$labels = array(
			'name'                       	=> _x( 'Classes', 'Taxonomy General Name', $this->theme_name ),
			'singular_name'              	=> _x( 'Classe', 'Taxonomy Singular Name', $this->theme_name ),
			'menu_name'                  	=> __( 'Classes', $this->theme_name ),
			'all_items'                  	=> __( 'Toutes les classes', $this->theme_name ),
			'parent_item'                	=> __( 'Classe parente', $this->theme_name ),
			'parent_item_colon'          	=> __( 'Classe parente :', $this->theme_name ),
			'new_item_name'              	=> __( 'Nom de la nouvelle classe', $this->theme_name ),
			'add_new_item'               	=> __( 'Ajouter une nouvelle classe', $this->theme_name ),
			'edit_item'                  	=> __( 'Éditer la classe', $this->theme_name ),
			'update_item'                	=> __( 'Mettre à jour la classe', $this->theme_name ),
			'view_item'                  	=> __( 'Voir la classe', $this->theme_name ),
			'separate_items_with_commas'	=> __( 'Séparer les classes par des virgules', $this->theme_name ),
			'add_or_remove_items'        	=> __( 'Ajouter ou supprimer une classe', $this->theme_name ),
			'choose_from_most_used'      	=> __( 'Choisir parmi les classes les plus utilisées', $this->theme_name ),
			'popular_items'              	=> __( 'Classe populaire', $this->theme_name ),
			'search_items'               	=> __( 'Classes recherchées', $this->theme_name ),
			'not_found'                  	=> __( 'Aucune classe n\'a été trouvée', $this->theme_name ),
			'no_terms'                   	=> __( 'Pas de classe', $this->theme_name ),
			'items_list'                 	=> __( 'Liste des classes', $this->theme_name ),
			'items_list_navigation'      	=> __( 'Liste de navigation des classes', $this->theme_name ),
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
		register_taxonomy( 'school_class', array( 'programming', 'school_training' ), $args );

	}


	/**
	 * Add custom columns
	 * 
	 * @param $columns
	 */
	public function add_custom_columns( $columns ) {

	    $new_columns = array();
	  	
	  	foreach( $columns as $key => $value ) {
	        
	        if ( $key === 'posts' ) {
	          	$new_columns['programming'] = __( 'Programmation' );
	          	$new_columns['training'] = __( 'Formation' );
	        }
	      	$new_columns[$key] = $value;
	  	}

	  	return $new_columns;
	}


    /**
     * Render custom columns
     * 
     * @param $column_name 
     * @param $post_id     
     */
    public function render_custom_columns( $content, $column_name, $term_id ) {

 
        switch ( $column_name ) {

    	    case 'training' :

    	    	$query = new WP_Query( 
    	    		array( 
    	    			'post_type'	=> 'training',
    	    			'tax_query' => array(
	    					array(
	    						'taxonomy' => 'school_class',
	    						'field'    => 'id',
	    						'terms'    => $term_id
	    					)
	    				) 
    	    		) 
    	    	);

    	    	if ( $query ) {
    	    		echo (int) $query->post_count;
    	    	} else {
    	    		echo '—';
    	    	}

    			break;

		    case 'programming' :

    	    	$query = new WP_Query( 
    	    		array( 
    	    			'post_type'	=> 'programming',
    	    			'tax_query' => array(
	    					array(
	    						'taxonomy' => 'school_class',
	    						'field'    => 'id',
	    						'terms'    => $term_id
	    					)
	    				) 
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