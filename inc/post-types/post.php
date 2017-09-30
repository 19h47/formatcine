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
      	
      	foreach( $columns as $key => $value ) {
            
            if ( $key === end( array_keys( $columns ) ) ) {
         
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
}