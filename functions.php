<?php
/**
 * Format'Ciné functions and definitions
 *
 * @see https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage pup
 * @since 1.0
 *
 * Functions'prefix is frmtcn_
 */
 

/**
 * Autoload
 */
require_once( __DIR__ . '/vendor/autoload.php' );


/**
 * Timber
 * 
 * Instanciate Timber
 *
 * @see         https://github.com/timber/timber
 * @version     1.3.0
 */
$timber = new \Timber\Timber(); 


/**
 * Dirname
 * 
 * Tell Timber where are views
 */
Timber::$dirname = array( 'views' );


/**
 * class FRMTCN
 */
class FRMTCN extends TimberSite {

    /**
     * The name of the theme
     *
     * @access private
     */
    private $theme_name;


    /**
     * The version of this theme
     *
     * @access private
     */
    private $theme_version;


    /**
     * Manifest
     *)
     */
    private $theme_manifest;


    /**
     * Initialize the class and set its properties.
     *
     * @param  $theme_name
     * @param  $theme_version
     * @access public
     */
    public function __construct( $theme_name, $theme_version ) {
        
        $this->theme_name = $theme_name;
        $this->theme_version = $theme_version;

        // Prod
        // $this->theme_manifest = json_decode( 
        //     file_get_contents( __DIR__ . '/public/manifest.json' ), 
        //     true
        // );

        // Dev
        $this->theme_manifest = array(
            'main.css'  => 'global.css',
            'main.js'   => 'bundle.js'
        );

        $this->setup();
        $this->load_dependencies();

        add_filter( 'timber_context', array( $this, 'add_to_context' ) );
        add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );

        parent::__construct();
    }


    /**
     * Load dependencies description
     * 
     * @access private
     */
    private function load_dependencies() {

        require_once get_template_directory() . '/inc/utilities.php';
        require_once get_template_directory() . '/inc/post-types/_includes.php';
        require_once get_template_directory() . '/inc/taxonomies/_includes.php';
        require_once get_template_directory() . '/inc/customizer/_includes.php';
        require_once get_template_directory() . '/inc/post-template.php';
        require_once get_template_directory() . '/inc/reset.php';
        require_once get_template_directory() . '/inc/admin.php';

    
        new Custom_Post_Types( $this->get_theme_name(), $this->get_theme_version() );
        new Custom_Taxonomies( $this->get_theme_name(), $this->get_theme_version() );
        
        if ( is_admin() ) new Admin( $this->get_theme_name(), $this->get_theme_version() );
    }


    /**
     * Add to Twig
     */
    public function add_to_twig( $twig ) {


        if ( function_exists( 'post_class' ) ) {
            $twig->addFunction( new \Twig_SimpleFunction( 'post_class', function( $args = '' ) {
                return post_class( $args );
            } ) );
        }


        if ( function_exists( 'body_class' ) ) {
            $twig->addFunction( new \Twig_SimpleFunction( 'body_class', function( $args = '' ) {
                return body_class( $args );
            } ) );
        }


        if ( function_exists( 'html_class' ) ) {
            $twig->addFunction( new \Twig_SimpleFunction( 'html_class', function( $args = '' ) {
                return html_class( $args );
            } ) );
        }


        return $twig;
    }


    /**
     * Add to context
     *
     * @return  $context
     * @access  public
     */
    public function add_to_context( $context ) {

        /**
         * Menus
         */
        $menus = get_registered_nav_menus();
        foreach ( $menus as $menu => $value ) {
            $context['menu'][$menu] = new TimberMenu( $value );
        }


        // Add socials to context
        $socials = array();
        $socials_name = [ 'YouTube', 'Facebook' ];

        foreach ( $socials_name as $name ) {
            ${ strtolower( $name ) } = array(
                'slug'  => strtolower( $name ),
                'name'  => $name,
                'url'   => get_option( strtolower( $name ) )
            );

            $socials[strtolower( $name )] = ${ strtolower( $name ) };
        }

        // Add $socials to $context
        $context['contact']['socials'] = $socials;
        

        // Address
        if ( get_option( 'address' ) ) {

            $context['contact']['address'] = nl2br( get_option( 'address' ) );
        }

        // Email address
        if ( get_option( 'email_addresses' ) ) {

            $context['contact']['email_addresses'] = array();
            $email_addresses = explode( ', ', get_option( 'email_addresses' ) );

            foreach ( $email_addresses as $email_address ) {

                array_push( $context['contact']['email_addresses'], $email_address );
            }
        }

        // Phone
        if ( get_option( 'phone' ) ) {

            $context['contact']['phone'] = get_option( 'phone' );
        }


        // Permalink
        $page_args = array();
        $pages = get_pages( $page_args );

        foreach ( $pages as $page ) {

            // Replace `-` by `_`
            $slug = str_replace('-', '_', $page->post_name);

            $context['permalink'][$slug] = get_page_link( $page->ID );
        }
        $context['permalink']['current_url'] = get_permalink();


        // Share
        $shares = array(
            array(
                'slug'  => 'facebook',
                'name' => __( 'Partager sur Facebook' ),
                'url'  => 'https://www.facebook.com/sharer.php?u='
            ),
            array(
                'slug'  => 'twitter',
                'name' => __( 'Partager sur Twitter' ),
                'url'  => 'https://twitter.com/intent/tweet?url='
            ),
            array(
                'slug'  => 'google-plus',
                'name' => __( 'Partager sur Google+' ),
                'url'  => 'https://plus.google.com/share?url='
            ),
            array(
                'slug'  => 'envelope',
                'name' => __( 'Partager par Mail' ),
                'url'  => 'mailto:?&amp;body='
            )
        );

        foreach ( $shares as $share ) {
            $context['contact']['shares'][$share['slug']] = $share;
        }

       
        return $context;
    }


    /**
     * Setup
     * 
     * @access public
     */
    public function setup() {

        /*
         * Let WordPress manage the document title.
         */
        add_theme_support( 'title-tag' );


        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @see https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );


        /*
        * Switch default core markup for search form, comment form, and comments
        * to output valid HTML5.
        */
        add_theme_support( 
            'html5', 
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
            ) 
        );


        /**
         * Register nav menus
         */
        register_nav_menus( 
            array(
                'main'          => __( 'Main' ),
                'categories'    => __( 'Catégories' ),
            ) 
        );


        /**
         * Add excerpt on page
         *
         * @see  https://codex.wordpress.org/Function_Reference/add_post_type_support
         */
        add_post_type_support( 'page', 'excerpt' );


        add_action( 'wp_head', array( $this, 'javascript_detection' ), 2 );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_style' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );


        /**
         * Add favicons
         */
        // add_action( 'wp_head', array( $this, 'favicons' ) );

    }


    /**
     * Enqueue styles.
     * 
     * @access public
     */
    public function enqueue_style() {

        /**
         * Theme stylesheet
         */
        wp_register_style(  
            $this->theme_name . '-global', 
            get_template_directory_uri() . '/public/' . $this->theme_manifest['main.css'], 
            array(), 
            null 
        );


        wp_enqueue_style( $this->theme_name . '-global' );
    }


    /**
     * Enqueue scripts
     *
     * @access public
     */
    public function enqueue_scripts() {
        
        /**
         * Remove wp-embed script from WordPress
         */
        wp_deregister_script( 'wp-embed' );


        /**
         * Remove native version of jQuery and use custom CDN version instead
         */
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', '//code.jquery.com/jquery-3.1.1.min.js', false, null, true );


        wp_register_script( 
            $this->theme_name . '-main', 
            get_template_directory_uri() . '/public/' . $this->theme_manifest['main.js'], 
            array( 
                'jquery'
            ), 
            null, 
            true 
        );


        wp_localize_script( 
            $this->theme_name . '-main', 
            'wp', 
            array(
                'template_directory_uri'    => get_template_directory_uri(),
                'base_url'                  => site_url(),
                'home_url'                  => home_url( '/' ),
                'ajax_url'                  => admin_url( 'admin-ajax.php' ),
                'current_url'               => get_permalink()
            )
        );
        wp_enqueue_script( $this->theme_name . '-main' );
    }


    /**
     * Handles JavaScript detection.
     * Adds a `js` class to the root `<html>` element when JavaScript is detected.
     *
     * @access public
     */
    public function javascript_detection() {
    ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feature.js/1.0.1/feature.min.js"></script>
        <script>
            document.documentElement.className = document.documentElement.className.replace('no-js', 'js');
            
            if (feature.touch && !navigator.userAgent.match(/Trident\/(6|7)\./)) {
                document.documentElement.className = document.documentElement.className.replace('no-touch', 'touch');
            }
        </script>
    <?php
    }


    /**
     * Add all favicon metas in <head>
     *
     * @see  http://realfavicongenerator.net/
     */
    function favicons() {

        ?>

        <link rel="apple-touch-icon" sizes="57x57" href="<?php echo get_template_directory_uri() ?>/img/favicons/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?php echo get_template_directory_uri() ?>/img/favicons/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri() ?>/img/favicons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo get_template_directory_uri() ?>/img/favicons/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri() ?>/img/favicons/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?php echo get_template_directory_uri() ?>/img/favicons/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?php echo get_template_directory_uri() ?>/img/favicons/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?php echo get_template_directory_uri() ?>/img/favicons/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri() ?>/img/favicons/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri() ?>/img/favicons/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="194x194" href="<?php echo get_template_directory_uri() ?>/img/favicons/favicon-194x194.png">
        <link rel="icon" type="image/png" sizes="192x192" href="<?php echo get_template_directory_uri() ?>/img/favicons/android-chrome-192x192.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri() ?>/img/favicons/favicon-16x16.png">
        <link rel="manifest" href="<?php echo get_template_directory_uri() ?>/img/favicons/manifest.json">
        <link rel="mask-icon" href="<?php echo get_template_directory_uri() ?>/img/favicons/safari-pinned-tab.svg" color="#5bbad5">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri() ?>/img/favicons/mstile-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <?php
    }
    


    /**
     * Retrieve the version number of the theme.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_theme_version() {
        return $this->theme_version;
    }


    /**
     * The name of the theme used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_theme_name() {
        return $this->theme_name;
    }
}


/**
 * Begins execution of the theme.
 */
$theme = new FRMTCN( 'frmtcn', '1.0.0' );