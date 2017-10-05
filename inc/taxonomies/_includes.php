<?php 

class Custom_Taxonomies {
	
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
        $this->include_custom_taxonomies();
        $this->instanciate_custom_taxonomies();
	}


    /**
     * Include all custom post types
     *
     * @access public
     */
	public function include_custom_taxonomies() {
        include __DIR__ . '/country.php';
		include __DIR__ . '/director.php';
        include __DIR__ . '/school-class.php';
        include __DIR__ . '/season.php';
        include __DIR__ . '/adult-training-category.php';
	}

	
    /**
     * Instanciate all custom post types
     */
    public function instanciate_custom_taxonomies() {
        new Country( $this->theme_name, $this->theme_version );
        new SchoolClass( $this->theme_name, $this->theme_version );      
        new Director( $this->theme_name, $this->theme_version );
        new Season( $this->theme_name, $this->theme_version );      
        new AdultTrainingCategory( $this->theme_name, $this->theme_version );      
    }
}