<?php // phpcs:ignore
/**
 * Class Page
 *
 * @package Formatcine
 */

namespace Formatcine\PostTypes;

use Timber\{ Timber };

/**
 * Page class
 */
class Page {

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

		add_filter( 'manage_page_posts_columns', array( $this, 'add_custom_columns' ) );

		add_action( 'manage_page_posts_custom_column', array( $this, 'render_custom_columns' ), 10, 2 );
		add_action( 'admin_head', array( $this, 'css' ) );
	}


	/**
	 * CSS
	 *
	 * @return void
	 */
	public function css() {

		?>
		<style>
			.fixed .column-page_color { text-align: left; }

			.column-page_color .color-indicator {
				display: inline-block;
				vertical-align: middle;
				border: none !important;
				border-radius: 50% !important;
				height: 40px !important;
				width: 40px !important;
				margin-left: 10px;
				margin-right: 10px;
			}
			.column-page_color .color-indicator:first-child {
				margin-left: 0;
			}
			.column-page_color .color-indicator:last-child {
				margin-right: 0;
			}
		</style>
		<?php
	}


	/**
	 * Add custom columns
	 *
	 * @param arr $columns Array of columns.
	 */
	public function add_custom_columns( $columns ) {
		unset( $columns['date'] );
		unset( $columns['comments'] );

		$new_columns = array();

		foreach ( $columns as $key => $value ) {
			if ( 'author' === $key ) {
				$new_columns['page_color'] = __( 'Colors', 'formatcine' );
			}
			$new_columns[ $key ] = $value;
		}
		return $new_columns;
	}



	/**
	 * Render column color
	 *
	 * @param  string $color Color.
	 * @param  int    $id    Post ID.
	 * @return string
	 */
	public function render_column_page_color( string $color, int $id ) : string {
		$data = array(
			'id'    => $id,
			'color' => $color,
			'link'  => get_edit_post_link( $id ),
		);

		return Timber::compile( 'partials/column-page-color.html.twig', $data );
	}


	/**
	 * Render custom columns
	 *
	 * @param str $column_name Column name.
	 * @param int $post_id Post ID.
	 */
	public function render_custom_columns( $column_name, $post_id ) {

		global $post;

		switch ( $column_name ) {
			case 'page_color':
				$parent_id = get_post_ancestors( $post );
				$html      = '—';

				$data_color_main      = get_post_meta( $post_id, 'page_color_main', true );
				$data_color_secondary = get_post_meta( $post_id, 'page_color_secondary', true );
				$data_color_ternary   = get_post_meta( $post_id, 'page_color_ternary', true );

				if ( $data_color_main || $data_color_secondary ) {

					$html  = $data_color_main
						? $this->render_column_page_color( $data_color_main, $post_id )
						: '';
					$html .= $data_color_secondary
						? $this->render_column_page_color( $data_color_secondary, $post_id )
						: '';
					$html .= $data_color_ternary
						? $this->render_column_page_color( $data_color_ternary, $post_id )
						: '';

				} elseif ( $parent_id ) {

					$data_color_main      = get_field( 'page_color_main', $parent_id[0] );
					$data_color_secondary = get_field( 'page_color_secondary', $parent_id[0] );
					$data_color_ternary   = get_field( 'page_color_ternary', $parent_id[0] );

					$html  = $data_color_main
						? $this->render_column_page_color( $data_color_main, $post_id )
						: '';
					$html .= $data_color_secondary
						? $this->render_column_page_color( $data_color_secondary, $post_id )
						: '';
					$html .= $data_color_ternary
						? $this->render_column_page_color( $data_color_ternary, $post_id )
						: '';

				}

				Timber::render_string( $html );

				break;
		}
	}
}
