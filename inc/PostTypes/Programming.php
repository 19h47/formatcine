<?php
/**
 * Class Programming
 *
 * @package Formatcine
 */

namespace Formatcine\PostTypes;

/**
 * Programming class
 */
class Programming {

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

		$this->register_post_type();

		add_action( 'init', array( $this, 'register_post_type' ) );
		add_action( 'admin_head', array( $this, 'admin_css' ) );

		add_filter( 'manage_programming_posts_columns', array( $this, 'add_custom_columns' ) );
		add_action( 'manage_programming_posts_custom_column', array( $this, 'render_custom_columns' ), 10, 2 );

		add_filter( 'wp_insert_post_data', array( $this, 'change_title' ), 99, 2 );
	}


	/**
	 * Register Custom Post Type
	 */
	public function register_post_type() {
		$labels = array(
			'name'                     => _x( 'Programming', 'programming type general', 'frmtcn' ),
			'singular_name'            => _x( 'Programming', 'programming type singular', 'frmtcn' ),
			'add_new'                  => __( 'Add New', 'frmtcn' ),
			'add_new_item'             => __( 'Add New Programming', 'frmtcn' ),
			'edit_item'                => __( 'Edit Programming', 'frmtcn' ),
			'new_item'                 => __( 'New Programming', 'frmtcn' ),
			'view_item'                => __( 'View Programming', 'frmtcn' ),
			'view_items'               => __( 'View programming', 'frmtcn' ),
			'search_items'             => __( 'Search programming', 'frmtcn' ),
			'not_found'                => __( 'No programming found.', 'frmtcn' ),
			'not_found_in_trash'       => __( 'No programming in Trash.', 'frmtcn' ),
			'parent_item_colon'        => __( 'Parent programming:', 'frmtcn' ),
			'all_items'                => __( 'All Programming', 'frmtcn' ),
			'archives'                 => __( 'Programming Archives', 'frmtcn' ),
			'attributes'               => __( 'Programming Attributes', 'frmtcn' ),
			'featured_image'           => _x( 'Featured Image', 'programming', 'frmtcn' ),
			'set_featured_image'       => _x( 'Set featured image', 'programming', 'frmtcn' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'programming', 'frmtcn' ),
			'use_featured_image'       => _x( 'Use as featured image', 'programming', 'frmtcn' ),
			'insert_into_item'         => __( 'Insert into programming', 'frmtcn' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this programming', 'frmtcn' ),
			'items_list'               => __( 'Programming list', 'frmtcn' ),
			'items_list_navigation'    => __( 'Programming list navigation', 'frmtcn' ),
			'item_published'           => __( 'Programming published.', 'frmtcn' ),
			'item_published_privately' => __( 'Programming published privately.', 'frmtcn' ),
			'item_reverted_to_draft'   => __( 'Programming reverted to draft.', 'frmtcn' ),
			'item_scheduled'           => __( 'Programming scheduled.', 'frmtcn' ),
			'item_updated'             => __( 'Programming updated.', 'frmtcn' ),
		);

		$rewrite = array(
			'slug'       => 'programmations',
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => 'programmation',
			'labels'              => $labels,
			'supports'            => array( '' ),
			'taxonomies'          => array( 'school_tag', 'year' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_nav_menus'   => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'show_in_rest'        => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-calendar-alt',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);
		register_post_type( 'programming', $args );
	}


	/**
	 * Admin CSS
	 *
	 * @return bool
	 */
	public function admin_css() {

		global $typenow;

		if ( 'programming' !== $typenow ) {
			return false;
		}

		?>
		<style>
			.fixed .title strong { display: none; }
			.fixed  th.column-title a { display: none; }
			.fixed .title .row-actions {
				left: 0;
				padding: 0;
			}
			.fixed .column-taxonomy-school_class { width: 160px; }

			.fixed .column-taxonomy-season { width: 80px; }
			.fixed .column-quarter { width: 160px; }

			.acf-field-post-object { min-height: 0!important; }
		</style>
		<?php
	}

	/**
	 * Add custom columns
	 *
	 * @param arr $columns Array of columns.
	 */
	public function add_custom_columns( $columns ) {

		$new_columns = array();

		$taxonomy_seasons      = $columns['taxonomy-season'];
		$taxonomy_school_class = $columns['taxonomy-school_class'];

		unset( $columns['date'] );
		unset( $columns['taxonomy-season'] );
		unset( $columns['taxonomy-school_class'] );

		foreach ( $columns as $key => $value ) {
			if ( 'title' === $key ) {
				$new_columns['taxonomy-season']       = $taxonomy_seasons;
				$new_columns['quarter']               = __( 'Quarters', 'frmtcn' );
				$new_columns['taxonomy-school_class'] = $taxonomy_school_class;
				$new_columns['movie']                 = __( 'Movie', 'frmtcn' );
			}
			$new_columns[ $key ] = $value;
		}
		return $new_columns;
	}


	/**
	 * Render custom columns
	 *
	 * @param str $column_name Array of column name.
	 * @param int $post_id The post ID.
	 */
	public function render_custom_columns( $column_name, $post_id ) {

		global $typenow;

		if ( 'programming' !== $typenow ) {
			return;
		}

		switch ( $column_name ) {
			case 'movie':
				$movie = get_field( 'movie', $post_id );
				$html = '—';

				if ( $movie ) {
					$html = edit_post_link( $movie->post_title, '', '', $post_id );
				}

				echo $html;

				break;

			case 'quarter':
				$quarter = get_field( 'quarter', $post_id );

				if ( $quarter ) {
					echo esc_html( $quarter['label'] );
				} else {
					echo '—';
				}
				break;
		}
	}


	/**
	 * Change title
	 *
	 * Manually create the post title and post name since this content type
	 * doesn't have post title field.
	 *
	 * @param  arr $data Array of data.
	 * @param  arr $postarr Array of post.
	 * @return arr
	 */
	public function change_title( $data, $postarr ) {

		$screen = get_current_screen();

		if ( 'programming' !== $screen->post_type ) {
			return $data;
		}

		// Filtering Post.
		$post_data = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

		// Grab some field value to serve as the post_title.
		$title = __( 'Programming', 'frmtcn' );

		/**
		 * Record the manually created post title to $data['post_title'] so
		 * WordPress will save it as post title
		 */
		$data['post_title'] = $title;

		// Create manually post_name using data from title.
		$slug              = sanitize_title_with_dashes( $title );
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
