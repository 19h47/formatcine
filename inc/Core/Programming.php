<?php // phpcs:ignore
/**
 * Class Programming
 *
 * @package WordPress
 * @subpackage Formatcine
 */

namespace FormatCine\Core;

use Timber\{ Timber };
use WP_Post;

/**
 * Programming class
 */
class Programming {

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'init', array( $this, 'register' ), 10, 0 );
		add_action( 'admin_head', array( $this, 'admin_css' ) );

		add_filter( 'manage_programming_posts_columns', array( $this, 'add_custom_columns' ) );
		add_action( 'manage_programming_posts_custom_column', array( $this, 'render_custom_columns' ), 10, 2 );

		add_filter( 'wp_insert_post_data', array( $this, 'change_title' ), 99, 2 );
	}


	/**
	 * Register Custom Post Type
	 *
	 * @return void
	 * @access public
	 */
	public function register() : void {
		$labels = array(
			'name'                     => _x( 'Programming', 'programming type general', 'formatcine' ),
			'singular_name'            => _x( 'Programming', 'programming type singular', 'formatcine' ),
			'add_new'                  => __( 'Add New', 'formatcine' ),
			'add_new_item'             => __( 'Add New Programming', 'formatcine' ),
			'edit_item'                => __( 'Edit Programming', 'formatcine' ),
			'new_item'                 => __( 'New Programming', 'formatcine' ),
			'view_item'                => __( 'View Programming', 'formatcine' ),
			'view_items'               => __( 'View programming', 'formatcine' ),
			'search_items'             => __( 'Search programming', 'formatcine' ),
			'not_found'                => __( 'No programming found.', 'formatcine' ),
			'not_found_in_trash'       => __( 'No programming in Trash.', 'formatcine' ),
			'parent_item_colon'        => __( 'Parent programming:', 'formatcine' ),
			'all_items'                => __( 'All Programming', 'formatcine' ),
			'archives'                 => __( 'Programming Archives', 'formatcine' ),
			'attributes'               => __( 'Programming Attributes', 'formatcine' ),
			'featured_image'           => _x( 'Featured Image', 'programming', 'formatcine' ),
			'set_featured_image'       => _x( 'Set featured image', 'programming', 'formatcine' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'programming', 'formatcine' ),
			'use_featured_image'       => _x( 'Use as featured image', 'programming', 'formatcine' ),
			'insert_into_item'         => __( 'Insert into programming', 'formatcine' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this programming', 'formatcine' ),
			'items_list'               => __( 'Programming list', 'formatcine' ),
			'items_list_navigation'    => __( 'Programming list navigation', 'formatcine' ),
			'item_published'           => __( 'Programming published.', 'formatcine' ),
			'item_published_privately' => __( 'Programming published privately.', 'formatcine' ),
			'item_reverted_to_draft'   => __( 'Programming reverted to draft.', 'formatcine' ),
			'item_scheduled'           => __( 'Programming scheduled.', 'formatcine' ),
			'item_updated'             => __( 'Programming updated.', 'formatcine' ),
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
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
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
	 * @param array $columns Array of columns.
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
				$new_columns['quarter']               = __( 'Quarters', 'formatcine' );
				$new_columns['taxonomy-school_class'] = $taxonomy_school_class;
				$new_columns['movie']                 = __( 'Movie', 'formatcine' );
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
				$html  = '—';

				if ( $movie instanceof WP_Post ) {
					$html = Timber::compile(
						'partials/post-link.html.twig',
						array(
							'link'    => get_edit_post_link( $post_id ),
							'content' => $movie->post_title,
						)
					);
				}

				Timber::render_string( $html );

				break;

			case 'quarter':
				$quarter = get_field( 'quarter', $post_id );

				Timber::render_string( $quarter ? $quarter['label'] : '—' );

				break;
		}
	}


	/**
	 * Change title
	 *
	 * Manually create the post title and post name since this content type
	 * doesn't have post title field.
	 *
	 * @param  array $data Array of data.
	 * @param  array $postarr Array of post.
	 * @return array $data
	 */
	public function change_title( array $data, array $postarr ) : array {

		$screen = get_current_screen();

		if ( 'programming' !== $screen->post_type ) {
			return $data;
		}

		// Filtering Post.
		$post_data = filter_input_array( INPUT_POST, FILTER_SANITIZE_STRING );

		// Grab some field value to serve as the post_title.
		$title = __( 'Programming', 'formatcine' );

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
