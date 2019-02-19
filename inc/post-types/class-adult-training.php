<?php
/**
 * Class Adult Training
 *
 * @package frmtcn
 */

/**
 * Adult Training class
 */
class Adult_Training {

	/**
	 * The version of the theme.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string $version The current version of this theme.
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

		$this->register_post_type();

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'admin_head', array( $this, 'css' ) );

		add_filter( 'dashboard_glance_items', array( $this, 'at_a_glance' ) );
	}


	/**
	 * Register Custom Post Type
	 */
	public function register_post_type() {
		$labels = array(
			'name'                  => _x( 'Formations adultes', 'Formation adulte Nom pluriel', 'frmtcn' ),
			'singular_name'         => _x( 'Formation adulte ', 'Formation adulte Nom singulier', 'frmtcn' ),
			'menu_name'             => __( 'Formations adultes', 'frmtcn' ),
			'name_admin_bar'        => __( 'Formation', 'frmtcn' ),
			'all_items'             => __( 'Toutes les formations adultes', 'frmtcn' ),
			'add_new_item'          => __( 'Ajouter une nouvelle formation adulte', 'frmtcn' ),
			'add_new'               => __( 'Ajouter', 'frmtcn' ),
			'new_item'              => __( 'Nouvelle formation adulte', 'frmtcn' ),
			'edit_item'             => __( 'Modifier la formation adulte', 'frmtcn' ),
			'update_item'           => __( 'Mettre à jour la formation adulte', 'frmtcn' ),
			'view_item'             => __( 'Voir la formation adulte', 'frmtcn' ),
			'view_items'            => __( 'Voir les formations adultes', 'frmtcn' ),
			'search_items'          => __( 'Chercher parmi les formations', 'frmtcn' ),
			'not_found'             => __( 'Aucune formation adulte trouvée.', 'frmtcn' ),
			'not_found_in_trash'    => __( 'Aucune formation adulte trouvée dans la corbeille.', 'frmtcn' ),
			'featured_image'        => __( 'Image à la une', 'frmtcn' ),
			'set_featured_image'    => __( 'Mettre une image à la une', 'frmtcn' ),
			'remove_featured_image' => __( 'Retirer l\'image mise en avant', 'frmtcn' ),
			'use_featured_image'    => __( 'Mettre une image à la une', 'frmtcn' ),
			'insert_into_item'      => __( 'Insérer dans la formation adulte', 'frmtcn' ),
			'uploaded_to_this_item' => __( 'Ajouter à cette formation adulte', 'frmtcn' ),
			'items_list'            => __( 'Liste des formations', 'frmtcn' ),
			'items_list_navigation' => __( 'Navigation de liste des formations adultes', 'frmtcn' ),
			'filter_items_list'     => __( 'Filtrer la liste des formations adultes', 'frmtcn' ),
		);

		$rewrite = array(
			'slug'       => 'formations-adultes',
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => 'formation adulte',
			'description'         => __( 'Les formations adultes', 'frmtcn' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'comments', 'thumbnail' ),
			'taxonomies'          => array( 'adult_training_category' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_nav_menus'   => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-welcome-learn-more',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);
		register_post_type( 'adult_training', $args );
	}

	/**
	 * CSS
	 *
	 * @return void
	 */
	public function css() {
		?>
		<style>
			#dashboard_right_now .adult_training-count:before { content: "\f118"; }
		</style>
		<?php
	}

	/**
	 * "At a glance" items (dashboard widget): add the adult_training.
	 *
	 * @param arr $items Array of items.
	 */
	public function at_a_glance( $items ) {
		$post_type   = 'adult_training';
		$post_status = 'publish';
		$object      = get_post_type_object( $post_type );

		$num_posts = wp_count_posts( $post_type );
		if ( ! $num_posts || ! isset( $num_posts->{$post_status} ) || 0 === (int) $num_posts->{$post_status} ) {
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
}
