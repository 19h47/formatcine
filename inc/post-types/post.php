<?php
/**
 * Post
 */
class Post {
	
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
		add_filter( 'manage_post_posts_columns', array( $this, 'add_custom_columns' ) );

		add_action( 'manage_post_posts_custom_column' , array( $this, 'render_custom_columns' ), 10, 2 );
		add_action( 'admin_head', array( $this, 'css' ) );

		// Ajax
		add_action( 'wp_ajax_nopriv_ajax_load_events', array( $this, 'ajax_load_events' ) );
		add_action( 'wp_ajax_ajax_load_events', array( $this, 'ajax_load_events' ) );
	}


	/**
	 * [css description]
	 * 
	 * @return [type] [description]
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
	 * @param $columns
	 */
	public function add_custom_columns( $columns ) {

		unset( $columns['date'] );
		unset( $columns['comments'] );

		$new_columns = array();
		$keys = array_keys( $columns );
		
		foreach( $columns as $key => $value ) {
			
			if ( $key === end( $keys ) ) {
		 
				$new_columns['event_date'] = __( 'Date de l\'événement' );
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

		switch ( $column_name ) {
			
			case 'event_date' :
				
				if ( get_field( 'event_date', $post_id ) ) {
					
					the_field( 'event_date', $post_id );
					
				} else {
					echo '—';
				}

			break;
		}
	}


	/**
	 * Load posts with AJAX request.     
	 */
	public function ajax_load_events() {

		$category = isset( $_GET['category'] ) ? $_GET['category'] : 0;
		$offset = isset( $_GET['offset'] ) ? $_GET['offset'] : 0;
		$posts_per_page = isset( $_GET['posts_per_page'] ) ? $_GET['posts_per_page'] : 6;
		
		$args = array(
			'post_type'         => 'post',
			'posts_per_page'    => (int) $posts_per_page,
			// 'category'           => (int) $category,
			'offset'            => (int) $offset,
			'post_status'       => 'publish',
			'meta_key'          => 'event_date',
			'orderby'           => 'meta_value',
			'order'             => 'ASC',
		);

		// var_dump($category);
		if ( $category !== '0' ) {
			$args['category'] = (int) $category;
		}

		// var_dump($args);

		$context = Timber::get_context();

		$context['posts'] = Timber::get_posts($args);

		// var_dump($context['posts']['projects']);

		Timber::render( 'partials/tease-event.twig', $context );
		
		wp_die();
	}
}