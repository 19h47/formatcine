<?php // phpcs:ignore
/**
 * Class Adult Training
 *
 * @package WordPress
 * @subpackage Formatcine
 */

namespace FormatCine\Core;

/**
 * Adult Training class
 */
class AdultTraining {

	/**
	 * Runs initialization tasks.
	 *
	 * @access public
	 */
	public function run() {
		add_action( 'init', array( $this, 'register' ), 10, 0 );
	}


	/**
	 * Register Custom Post Type
	 *
	 * @return void
	 * @access public
	 */
	public function register() : void {
		$labels = array(
			'name'                     => _x( 'Adults training', 'adult training type general', 'formatcine' ),
			'singular_name'            => _x( 'Adult training', 'adult training type singular', 'formatcine' ),
			'add_new'                  => __( 'Add New', 'formatcine' ),
			'add_new_item'             => __( 'Add New Adult training', 'formatcine' ),
			'edit_item'                => __( 'Edit Adult training', 'formatcine' ),
			'new_item'                 => __( 'New Adult training', 'formatcine' ),
			'view_item'                => __( 'View Adult training', 'formatcine' ),
			'view_items'               => __( 'View Adults training', 'formatcine' ),
			'search_items'             => __( 'Search Adult training', 'formatcine' ),
			'not_found'                => __( 'No adult training found.', 'formatcine' ),
			'not_found_in_trash'       => __( 'No adult training in Trash.', 'formatcine' ),
			'parent_item_colon'        => __( 'Parent Adult training:', 'formatcine' ),
			'all_items'                => __( 'All adults training', 'formatcine' ),
			'archives'                 => __( 'Adult training Archives', 'formatcine' ),
			'attributes'               => __( 'Adult training Attributes', 'formatcine' ),
			'featured_image'           => _x( 'Featured Image', 'adult training', 'formatcine' ),
			'set_featured_image'       => _x( 'Set featured image', 'adult training', 'formatcine' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'adult training', 'formatcine' ),
			'use_featured_image'       => _x( 'Use as featured image', 'adult training', 'formatcine' ),
			'insert_into_item'         => __( 'Insert into adult training', 'formatcine' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this adult training', 'formatcine' ),
			'items_list'               => __( 'Adults training list', 'formatcine' ),
			'items_list_navigation'    => __( 'Adults training list navigation', 'formatcine' ),
			'item_published'           => __( 'Adult training published.', 'formatcine' ),
			'item_published_privately' => __( 'Adult training published privately.', 'formatcine' ),
			'item_reverted_to_draft'   => __( 'Adult training reverted to draft.', 'formatcine' ),
			'item_scheduled'           => __( 'Adult training scheduled.', 'formatcine' ),
			'item_updated'             => __( 'Adult training updated.', 'formatcine' ),
		);

		$rewrite = array(
			'slug'       => 'formations-adultes',
			'with_front' => true,
			'pages'      => true,
			'feeds'      => true,
		);

		$args = array(
			'label'               => 'formation adulte',
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
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);
		register_post_type( 'adult_training', $args );
	}
}
