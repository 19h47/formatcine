<?php

/**
 * School Training class
 */
class School_Training {
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
        
        $this->register_post_type();

        add_action( 'init', array( $this, 'register_post_type' ) );
        add_action( 'admin_head', array( $this, 'css' ) );
        add_action( 'admin_head', array( $this, 'admin_css' ) );
        add_filter( 'dashboard_glance_items', array( $this, 'at_a_glance' ) );

        add_filter( 'manage_school_training_posts_columns', array( $this, 'add_custom_columns' ) );
        add_action( 'manage_school_training_posts_custom_column' , array( $this, 'render_custom_columns' ), 10, 2 );


        add_filter( 'wp_insert_post_data', array( $this, 'change_title' ), 99, 2 );
	}

	
	/**
	 * Register Custom Post Type
	 */
	public function register_post_type() {
		$labels = array(
			'name'                  => _x( 'Formations scolaires', 'Formation Nom pluriel', $this->theme_name ),
	        'singular_name'         => _x( 'Formation scolaire ', 'Formation Nom singulier', $this->theme_name ),
	        'menu_name'             => __( 'Formations scolaires', $this->theme_name ),
	        'name_admin_bar'        => __( 'Formation', $this->theme_name ),
	        'parent_item_colon'     => __( '', $this->theme_name ),
	        'all_items'             => __( 'Toutes les formations scolaires', $this->theme_name ),
	        'add_new_item'          => __( 'Ajouter une nouvelle formation scolaire', $this->theme_name ),
	        'add_new'               => __( 'Ajouter', $this->theme_name ),
	        'new_item'              => __( 'Nouvelle formation scolaire', $this->theme_name ),
	        'edit_item'             => __( 'Modifier la formation scolaire', $this->theme_name ),
	        'update_item'           => __( 'Mettre à jour la formation scolaire', $this->theme_name ),
	        'view_item'             => __( 'Voir la formation scolaire', $this->theme_name ),
	        'view_items'            => __( 'Voir les formations scolaires', $this->theme_name ),
	        'search_items'          => __( 'Chercher parmi les formations', $this->theme_name ),
	        'not_found'             => __( 'Aucune formation scolaire trouvée.', $this->theme_name ),
	        'not_found_in_trash'    => __( 'Aucune formation scolaire trouvée dans la corbeille.', $this->theme_name ),
	        'featured_image'        => __( 'Image à la une', $this->theme_name ),
	        'set_featured_image'    => __( 'Mettre une image à la une', $this->theme_name ),
	        'remove_featured_image' => __( 'Retirer l\'image mise en avant', $this->theme_name ),
	        'use_featured_image'    => __( 'Mettre une image à la une', $this->theme_name ),
	        'insert_into_item'      => __( 'Insérer dans la formation scolaire', $this->theme_name ),
	        'uploaded_to_this_item' => __( 'Ajouter à cette formation scolaire', $this->theme_name ),
	        'items_list'            => __( 'Liste des formations', $this->theme_name ),
	        'items_list_navigation' => __( 'Navigation de liste des formations scolaires', $this->theme_name ),
	        'filter_items_list'     => __( 'Filtrer la liste des formations scolaires', $this->theme_name ),
		);
		$rewrite = array(
	        'slug'                	=> 'formations-scolaires',
	        'with_front'          	=> true,
	        'pages'               	=> true,
	        'feeds'               	=> true,
	    );
		$args = array(
			'label'               	=> 'formation scolaire',
	        'description'         	=> __( 'Les formations scolaires', $this->theme_name ),
	        'labels'              	=> $labels,
	        'supports'            	=> array( '' ),
	        'taxonomies'          	=> array( 'school_tag', 'year' ),
	        'hierarchical'        	=> false,
	        'public'              	=> true,
	        'show_ui'             	=> true,
	        'show_in_nav_menus'   	=> true,
	        'show_in_menu'        	=> true,
	        'show_in_admin_bar'   	=> true,
	        'show_in_rest'   		=> true,
	        'menu_position'       	=> 5,
	        'menu_icon'           	=> 'dashicons-welcome-learn-more',
	        'can_export'          	=> true,
	        'has_archive'         	=> true,
	        'exclude_from_search' 	=> false,
	        'publicly_queryable'  	=> true,
	        'rewrite'             	=> $rewrite,
	        'capability_type'     	=> 'post',
		);
		register_post_type( 'school_training', $args );
	}


	public function css() { 
		
		?>
	    <style>
	        #dashboard_right_now .school_training-count:before { content: "\f118"; }
	    </style>
	<?php
	}


	public function admin_css() { 

		global $typenow;
		
		if ( 'school_training' !== $typenow ) {
			return;
		}
		
		?>
	    <style>

	        .fixed .title strong { display: none; }
	        .fixed .title .row-actions { 
	        	left: 0; 
	        	padding: 0;
	        }
	        .fixed  th.column-title a { display: none; }
	        .fixed .column-taxonomy-school_class {
	        	width: 160px;
	        }
	        .fixed .column-taxonomy-season { width: 80px; }
			
			.acf-field-taxonomy,
	        .acf-field-date-picker,
	        .acf-field-post-object { 
	        	min-height: 0!important; 
	        }
	    </style>
	<?php
	}


	/**
	 * Add custom columns
	 * 
	 * @param $columns
	 */
	public function add_custom_columns( $columns ) {

		global $typenow;
		
		if ( 'school_training' !== $typenow ) {
			return;
		}

		$taxonomy_seasons = $columns['taxonomy-season'];
		$taxonomy_school_class = $columns['taxonomy-school_class'];

		unset( $columns['date'] );
		unset( $columns['taxonomy-season'] );
		unset( $columns['taxonomy-school_class'] );


	    $new_columns = array();
	  	
	  	foreach( $columns as $key => $value ) {

      	  	if ( $key === 'title' ) {
	      	  	$new_columns['taxonomy-season'] = $taxonomy_seasons;
      	  		$new_columns['taxonomy-school_class'] = $taxonomy_school_class;
      	    	$new_columns['movies'] = __( 'Films' );
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
    public function render_custom_columns( $column_name, $post_id ) {

    	global $typenow;
    	
    	if ( 'school_training' !== $typenow ) {
    		return;
    	}

        switch ( $column_name ) {

    	    case 'movies' :

    	    	if ( get_field( 'movies', $post_id ) ) {

    	    		$movies = get_field( 'movies', $post_id );
    	    		$output = array();

    	    		
    	    		foreach ( $movies as $movie ) {
    	    			
	   					$html = '<a href="' . get_edit_post_link( $movie->ID );
	   					$html .= '">' . $movie->post_title . '</a>';

	   					array_push( $output, $html );
    	    		}

    	    		echo join( '<br>', $output );

    	    	} else {
    	    		echo '—';
    	    	}

    			break;
        }
    }


	/**
	 * "At a glance" items (dashboard widget): add the school_training.
	 */
	public function at_a_glance( $items ) {
	    $post_type = 'school_training';
	    $post_status = 'publish';
	    $object = get_post_type_object( $post_type );
	    
	    $num_posts = wp_count_posts( $post_type );
	    if ( ! $num_posts || ! isset ( $num_posts->{$post_status} ) || 0 === (int) $num_posts->{$post_status} ) {
	        
	        return $items;
	    }
	    $text = sprintf(
	        _n( '%1$s %4$s%2$s', '%1$s %4$s%3$s', $num_posts->{$post_status} ), 
	        number_format_i18n( $num_posts->{$post_status} ), 
	        strtolower( $object->labels->singular_name ), 
	        strtolower( $object->labels->name ),
	        'pending' === $post_status ? 'Pending ' : ''
	    );
	    if ( current_user_can( $object->cap->edit_posts ) ) {
	        $items[] = sprintf( '<a class="%1$s-count" href="edit.php?post_status=%2$s&post_type=%1$s">%3$s</a>', $post_type, $post_status, $text );
	    
	    } else {
	        $items[] = sprintf( '<span class="%1$s-count">%s</span>', $text );
	    }
	    
	    return $items;
	}


	/**
    * Manually create the post title and post name since
    * this content type doesn't have post title field.
    *
    * @param 	array 	$data
    * @param 	array 	$postarr
    * @return 	array
    */
  	public function change_title( $data, $postarr ) {
    	
    	$screen = get_current_screen();

    	if ( $screen->post_type !== 'school_training' ) {

     		return $data;
    	}
     
    	// Filtering Post
    	$post_data = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

    	// Grab some field value to serve as the post_title
    	$title = 'Formation';
     
    	// Record the manually created post title to $data['post_title'] so
    	// WordPress will save it as post title
    	$data['post_title'] = $title;
 
    	// Create manually post_name using data from title
    	$slug = sanitize_title_with_dashes( $title );
    	$data['post_name'] = wp_unique_post_slug(
    		$slug, 
    		$postarr['ID'],  
    		$postarr['post_status'], 
    		$postarr['post_type'], 
    		$postarr['post_parent']
    	);
     
    	// Remember this is a "filter", need to return the data back!
    	return $data;
  	}
}
