<?php
/**
 * Class Movie
 *
 * @package Formatcine
 */

namespace Formatcine\PostTypes;

/**
 * Movie class
 */
class Movie {

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
	 * @param  string $theme_version Theme version.
	 * @access public
	 */
	public function __construct( string $theme_version ) {
		$this->theme_version = $theme_version;

		$this->register_post_type();

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'admin_head', array( $this, 'css' ) );
		add_action( 'admin_head', array( $this, 'custom_post_type_css' ) );

		add_filter( 'manage_movie_posts_columns', array( $this, 'add_custom_columns' ) );
		add_action( 'manage_movie_posts_custom_column', array( $this, 'render_custom_columns' ), 10, 2 );
	}

	/**
	 * CSS for movie CPT
	 */
	public function custom_post_type_css() {
		global $pagenow, $typenow;

		if ( ( 'post.php' !== $pagenow ) && ( 'movie' !== $typenow ) ) {
			return false;
		}

		?>
		<style>.acf-field-taxonomy { min-height: auto!important; }</style>
		<?php
	}


	/**
	 * Register Custom Post Type
	 */
	public function register_post_type() {
		$labels = array(
			'name'                  => _x( 'Films', 'Film Nom pluriel', 'frmtcn' ),
			'singular_name'         => _x( 'Film', 'Film Nom singulier', 'frmtcn' ),
			'menu_name'             => __( 'Films', 'frmtcn' ),
			'name_admin_bar'        => __( 'Film', 'frmtcn' ),
			'all_items'             => __( 'Tous les films', 'frmtcn' ),
			'add_new_item'          => __( 'Ajouter un nouveau film', 'frmtcn' ),
			'add_new'               => __( 'Ajouter', 'frmtcn' ),
			'new_item'              => __( 'Nouveau film', 'frmtcn' ),
			'edit_item'             => __( 'Modifier le film', 'frmtcn' ),
			'update_item'           => __( 'Mettre à jour le film', 'frmtcn' ),
			'view_item'             => __( 'Voir le film', 'frmtcn' ),
			'view_items'            => __( 'Voir les films', 'frmtcn' ),
			'search_items'          => __( 'Chercher parmi les films', 'frmtcn' ),
			'not_found'             => __( 'Aucun film trouvé.', 'frmtcn' ),
			'not_found_in_trash'    => __( 'Aucun film trouvé dans la corbeille.', 'frmtcn' ),
			'featured_image'        => __( 'Image à la une', 'frmtcn' ),
			'set_featured_image'    => __( 'Mettre une image à la une', 'frmtcn' ),
			'remove_featured_image' => __( 'Retirer l\'image mise en avant', 'frmtcn' ),
			'use_featured_image'    => __( 'Mettre une image à la une', 'frmtcn' ),
			'insert_into_item'      => __( 'Insérer dans le film', 'frmtcn' ),
			'uploaded_to_this_item' => __( 'Ajouter à ce film', 'frmtcn' ),
			'items_list'            => __( 'Liste des films', 'frmtcn' ),
			'items_list_navigation' => __( 'Navigation de liste des films', 'frmtcn' ),
			'filter_items_list'     => __( 'Filtrer la liste des films', 'frmtcn' ),
		);

		$rewrite = array(
			'slug'       => 'films',
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => 'film',
			'description'         => __( 'Les films', 'frmtcn' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'revisions', 'thumbnail' ),
			'taxonomies'          => array(),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_nav_menus'   => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-tickets-alt',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);
		register_post_type( 'movie', $args );
	}

	/**
	 * CSS
	 *
	 * @return void
	 */
	public function css() {
		?>
		<style>
			.fixed .column-poster {
				vertical-align: top;
				width: 80px;
			}
			.column-poster a {
				display: block;
			}
			.column-poster a img {
				display: inline-block;
				vertical-align: middle;
				width: 100%;
				max-width: 100%;
				height: auto;
			}

			.column-running_time { width: 80px; }

			.column-taxonomy-country { width: 160px; }

			.column-release_year { width: 160px; }

			.column-taxonomy-director { width: 240px; }

		</style>
		<?php
	}

	/**
	 * Add custom columns
	 *
	 * @param arr $columns Array of columns.
	 * @return $new_columns
	 */
	public function add_custom_columns( $columns ) {

		unset( $columns['date'] );

		$new_columns = array();

		foreach ( $columns as $key => $value ) {
			if ( 'title' === $key ) {
				$new_columns['poster'] = __( 'Affiche' );
			}
			$new_columns[ $key ] = $value;
		}

		$new_columns['release_year'] = __( 'Année de sortie' );
		$new_columns['running_time'] = __( 'Durée' );

		return $new_columns;
	}


	/**
	 * Render custom columns
	 *
	 * @param arr $column_name Array of column name.
	 * @param int $post_id The post ID.
	 */
	public function render_custom_columns( $column_name, $post_id ) {
		switch ( $column_name ) {
			case 'poster':
				$html = '';

				if ( get_the_post_thumbnail( $post_id ) ) {
					$html .= '<a href="' . get_edit_post_link( $post_id ) . '">';
					$html .= get_the_post_thumbnail( $post_id, 'thumbnail' );
					$html .= '</a>';
				} else {
					$html .= '—';
				}
				echo $html;

				break;

			case 'release_year':
				$html = '';
				if ( get_field( 'release_year', $post_id ) ) {
					$html .= get_field( 'release_year', $post_id );
				} else {
					$html .= '—';
				}
				echo $html;

				break;

			case 'running_time':
				$html = '';

				if ( get_field( 'running_time', $post_id ) ) {
					$html .= get_field( 'running_time', $post_id );
				} else {
					$html .= '—';
				}
				echo $html;

				break;
		}
	}
}
