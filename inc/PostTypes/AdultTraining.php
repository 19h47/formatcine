<?php
/**
 * Class Adult Training
 *
 * @package Formatcine
 */

namespace Formatcine\PostTypes;

/**
 * Adult Training class
 */
class AdultTraining {

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
	 * @param string $theme_version Theme version.
	 * @access public
	 */
	public function __construct( string $theme_version ) {
		$this->theme_version = $theme_version;

		$this->register_post_type();

		add_action( 'init', array( $this, 'register_post_type' ) );
	}


	/**
	 * Register Custom Post Type
	 */
	public function register_post_type() {
		$labels = array(
			'name'                     => _x( 'Adults training', 'adult training type general', 'frmtcn' ),
			'singular_name'            => _x( 'Adult training', 'adult training type singular', 'frmtcn' ),
			'add_new'                  => __( 'Add New', 'frmtcn' ),
			'add_new_item'             => __( 'Add New Adult training', 'frmtcn' ),
			'edit_item'                => __( 'Edit Adult training', 'frmtcn' ),
			'new_item'                 => __( 'New Adult training', 'frmtcn' ),
			'view_item'                => __( 'View Adult training', 'frmtcn' ),
			'view_items'               => __( 'View Adults training', 'frmtcn' ),
			'search_items'             => __( 'Search Adult training', 'frmtcn' ),
			'not_found'                => __( 'No adult training found.', 'frmtcn' ),
			'not_found_in_trash'       => __( 'No adult training in Trash.', 'frmtcn' ),
			'parent_item_colon'        => __( 'Parent Adult training:', 'frmtcn' ),
			'all_items'                => __( 'All adults training', 'frmtcn' ),
			'archives'                 => __( 'Adult training Archives', 'frmtcn' ),
			'attributes'               => __( 'Adult training Attributes', 'frmtcn' ),
			'featured_image'           => _x( 'Featured Image', 'adult training', 'frmtcn' ),
			'set_featured_image'       => _x( 'Set featured image', 'adult training', 'frmtcn' ),
			'remove_featured_image'    => _x( 'Remove featured image', 'adult training', 'frmtcn' ),
			'use_featured_image'       => _x( 'Use as featured image', 'adult training', 'frmtcn' ),
			'insert_into_item'         => __( 'Insert into adult training', 'frmtcn' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this adult training', 'frmtcn' ),
			'items_list'               => __( 'Adults training list', 'frmtcn' ),
			'items_list_navigation'    => __( 'Adults training list navigation', 'frmtcn' ),
			'item_published'           => __( 'Adult training published.', 'frmtcn' ),
			'item_published_privately' => __( 'Adult training published privately.', 'frmtcn' ),
			'item_reverted_to_draft'   => __( 'Adult training reverted to draft.', 'frmtcn' ),
			'item_scheduled'           => __( 'Adult training scheduled.', 'frmtcn' ),
			'item_updated'             => __( 'Adult training updated.', 'frmtcn' ),



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
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => $rewrite,
			'capability_type'     => 'post',
		);
		register_post_type( 'adult_training', $args );
	}
}
