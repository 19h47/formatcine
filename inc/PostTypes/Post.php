<?php // phpcs:ignore
/**
 * Class Post
 *
 * @package Formatcine
 */

namespace Formatcine\PostTypes;

use Timber\{ Timber };
use WP_Post;

/**
 * Post
 */
class Post {

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
		add_filter( 'manage_post_posts_columns', array( $this, 'add_custom_columns' ) );

		add_action( 'manage_post_posts_custom_column', array( $this, 'render_custom_columns' ), 10, 2 );
		add_action( 'admin_head', array( $this, 'css' ) );

		// Ajax.
		add_action( 'wp_ajax_nopriv_ajax_load_events', array( $this, 'ajax_load_events' ) );
		add_action( 'wp_ajax_ajax_load_events', array( $this, 'ajax_load_events' ) );

		add_action( 'init', array( $this, 'remove_support' ), 10 );
		add_action( 'save_post_post', array( $this, 'save' ), 10, 3 );
	}


	/**
	 * Save
	 *
	 * @param int     $post_ID Post ID.
	 * @param WP_Post $post Post object.
	 * @param bool    $update Whether this is an existing post being updated or not.
	 * @return void
	 */
	public function save( int $post_ID, WP_Post $post, bool $update ) : void {
		delete_transient( 'formatcine_front_page_posts' );
	}


	/**
	 * Remove support
	 *
	 * @access public
	 * @return void
	 */
	public function remove_support() : void {
		remove_post_type_support( 'post', 'editor' );
		remove_post_type_support( 'post', 'excerpt' );
		remove_post_type_support( 'post', 'trackbacks' );
	}

	/**
	 * CSS
	 *
	 * @return void
	 */
	public function css() {
		?>
		<style>
			.fixed .column-event_date { width: 160px; }

			.fixed .column-event_date:first-letter { text-transform: uppercase; }

			.acf-field-color-picker { min-height: 0!important; }
		</style>
		<?php
	}

	/**
	 * Add custom columns
	 *
	 * @param array $columns Array of columns.
	 */
	public function add_custom_columns( $columns ) {

		unset( $columns['date'] );
		unset( $columns['comments'] );

		$new_columns = array();
		$keys        = array_keys( $columns );

		foreach ( $columns as $key => $value ) {

			if ( end( $keys ) === $key ) {
				$new_columns['event_date'] = __( 'Event date', 'frmtcn' );
			}

			$new_columns[ $key ] = $value;
		}
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
			case 'event_date':
				if ( get_field( 'event_date', $post_id ) ) {

					return the_field( 'event_date', $post_id );

				} else {
					return '—';
				}
		}
	}

	/**
	 * Load posts with AJAX request
	 */
	public function ajax_load_events() {
		check_ajax_referer( 'security', 'nonce' );

		$category       = 0;
		$offset         = 0;
		$posts_per_page = 6;

		if ( isset( $_GET['category'] ) ) {
			$category = sanitize_text_field( wp_unslash( $_GET['category'] ) );
		}

		if ( isset( $_GET['offset'] ) ) {
			$offset = sanitize_text_field( wp_unslash( $_GET['offset'] ) );
		}

		if ( isset( $_GET['posts_per_page'] ) ) {
			$posts_per_page = sanitize_text_field( wp_unslash( $_GET['posts_per_page'] ) );
		}

		$args = array(
			'post_type'      => 'post',
			'posts_per_page' => (int) $posts_per_page,
			'offset'         => (int) $offset,
			'post_status'    => 'publish',
			'meta_key'       => 'event_date', // phpcs:ignore
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
		);

		if ( '0' !== $category ) {
			$args['category'] = (int) $category;
		}

		$context          = Timber::get_context();
		$context['posts'] = Timber::get_posts( $args );

		Timber::render( 'partials/tease-event.html.twig', $context );

		wp_die();
	}
}
