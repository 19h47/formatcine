<?php
/**
 * Page
 */
class Page {
	
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
        add_filter( 'manage_page_posts_columns', array( $this, 'add_custom_columns' ) );

        add_action( 'manage_page_posts_custom_column' , array( $this, 'render_custom_columns' ), 10, 2 );
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
            .fixed .column-page_color { text-align: center; }

            .column-page_color .color-indicator { 
                display: block;
                border: none !important; 
                border-radius: 50% !important; 
                height: 40px !important; 
                width: 40px !important; 
                margin-left: auto; 
                margin-right: auto;
            }  
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
            
            if ( $key === 'author' ) {
         
              	$new_columns['page_color'] = __( 'Couleur' );
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

        global $post;

        switch ( $column_name ) {
    	    
    	    case 'page_color' :

                $parent_id = get_post_ancestors( $post );
    	    	
    	    	$data = get_post_meta( $post_id, 'page_color', true );
                            
                if ( $data ) {
                    echo '<a id="page_color-' . $post_id . '" ';
                    echo 'title="' . $data . '" ';
                    echo 'href="' . get_edit_post_link( $post_id ) . '"';
                    echo 'class="color-indicator" style="background-color:';
                    echo $data;
                    echo '"></a>';

                } elseif ( $parent_id ) {
                    // Retrieve parent color
                    $data = get_field( 'page_color', $parent_id[0] ); 

                    if ( $data ) {

                        echo '<a id="page_color-' . $post_id . '" ';
                        echo 'title="' . $data . '" ';
                        echo 'href="' . get_edit_post_link( $post_id ) . '"';
                        echo 'class="color-indicator" style="background-color:';
                        echo $data;
                        echo '"></a>';
                    } else {
                        echo '—';
                    }


                } else {
                    echo '—';
                }
                break;

    		break;
        }
    }
}