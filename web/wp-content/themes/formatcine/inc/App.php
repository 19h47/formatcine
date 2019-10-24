<?php
/**
 * Class Formatcine
 *
 * @package Formatcine
 */

namespace Formatcine;

use Formatcine\PostTypes\{ Post, Page, Programming, AdultTraining, SchoolTraining, Movie };
use Formatcine\Taxonomies\{ Country, SchoolClass, Director, Season, AdultTrainingCategory };

use Timber\{ Timber, Menu };

use Twig_SimpleFunction as Twig_SimpleFunction;

use Cocur\Slugify\Bridge\Twig\{ SlugifyExtension };
use Cocur\Slugify\{ Slugify };

use Set_Glance_Items;



/**
 * Dirname
 *
 * Tell Timber where are views
 */
Timber::$dirname = array( 'views' );


/**
 * Class Formatcine
 */
class App extends Timber {

	/**
	 * The name of the theme
	 *
	 * @access private
	 * @var string
	 */
	private $theme_name;


	/**
	 * The version of this theme
	 *
	 * @access private
	 * @var string
	 */
	private $theme_version;


	/**
	 * Manifest
	 *
	 * @access private
	 * @var arr
	 */
	private $theme_manifest;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @param str $theme_version The theme version.
	 * @access public
	 */
	public function __construct( $theme_version ) {
		$this->theme_version = $theme_version;

		$this->setup();
		$this->load_dependencies();

		$this->theme_manifest = get_theme_manifest();

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
		require_once get_template_directory() . '/inc/customizer/contact.php';
		require_once get_template_directory() . '/inc/post-template.php';
		require_once get_template_directory() . '/inc/reset.php';
		require_once get_template_directory() . '/inc/acf.php';

		new Movie( $this->get_theme_version() );
		new Post( $this->get_theme_version() );
		new Page( $this->get_theme_version() );
		new Programming( $this->get_theme_version() );
		new SchoolTraining( $this->get_theme_version() );
		new AdultTraining( $this->get_theme_version() );

		new Country( $this->get_theme_version() );
		new SchoolClass( $this->get_theme_version() );
		new Director( $this->get_theme_version() );
		new Season( $this->get_theme_version() );
		new AdultTrainingCategory( $this->get_theme_version() );

		if ( class_exists( 'Set_Glance_Items' ) ) {
			new Set_Glance_Items(
				array(
					array(
						'name' => 'country',
						'code' => '\f11d',
					),
					array(
						'name' => 'school_class',
						'code' => '\f118',
					),
					array(
						'name' => 'director',
						'code' => '\f234',
					),
					array(
						'name' => 'season',
						'code' => '\f469',
					),
					array(
						'name' => 'adult_training_category',
						'code' => '\f118',
					),
				),
				array(
					array(
						'name' => 'movie',
						'code' => '\f524',
					),
					array(
						'name' => 'programming',
						'code' => '\f508',
					),
					array(
						'name' => 'school_training',
						'code' => '\f118',
					),
					array(
						'name' => 'adult_training',
						'code' => '\f118',
					),
				)
			);
		}

		if ( is_admin() ) {
			new Admin( $this->get_theme_version() );
		}
	}


	/**
	 * Add to Twig
	 *
	 * @param obj $twig Twig object.
	 */
	public function add_to_twig( $twig ) {

		if ( function_exists( 'post_class' ) ) {
			$twig->addFunction(
				new Twig_SimpleFunction(
					'post_class',
					function( $args = '' ) {
						return post_class( $args );
					}
				)
			);
		}

		if ( function_exists( 'body_class' ) ) {
			$twig->addFunction(
				new Twig_SimpleFunction(
					'body_class',
					function( $args = '' ) {
						return body_class( $args );
					}
				)
			);
		}

		if ( function_exists( 'html_class' ) ) {
			$twig->addFunction(
				new Twig_SimpleFunction(
					'html_class',
					function( $args = '' ) {
						return html_class( $args );
					}
				)
			);
		}

		$twig->addExtension( new SlugifyExtension( Slugify::create() ) );

		$twig->addFunction(
			new Twig_SimpleFunction(
				'get_theme_manifest',
				function() {
					return $this->theme_manifest;
				}
			)
		);

		return $twig;
	}


	/**
	 * Add to context
	 *
	 * @param arr $context Array of context.
	 * @return  $context
	 * @access  public
	 */
	public function add_to_context( $context ) {

		/**
		 * Menus
		 */
		$menus = get_registered_nav_menus();
		foreach ( $menus as $menu => $value ) {
			$context['menu'][ $menu ] = new Menu( $value );
		}

		// Add socials to context.
		$socials      = array();
		$socials_name = [ 'YouTube', 'Facebook' ];

		foreach ( $socials_name as $name ) {
			if ( get_option( strtolower( $name ) ) ) {
				${ strtolower( $name ) } = array(
					'slug' => strtolower( $name ),
					'name' => $name,
					'url'  => get_option( strtolower( $name ) ),
				);

				$socials[ strtolower( $name ) ] = ${ strtolower( $name ) };
			}
		}

		// Add $socials to $context.
		$context['contact']['socials'] = $socials;

		// Address.
		if ( get_option( 'address' ) ) {
			$context['contact']['address'] = get_option( 'address' );
		}

		// Email address.
		if ( get_option( 'email_addresses' ) ) {
			$context['contact']['email_addresses'] = array();

			$email_addresses = explode( ', ', get_option( 'email_addresses' ) );

			foreach ( $email_addresses as $email_address ) {
				array_push( $context['contact']['email_addresses'], $email_address );
			}
		}

		// Phone.
		if ( get_option( 'phone' ) ) {
			$context['contact']['phone'] = get_option( 'phone' );
		}

		// Permalink.
		$page_args = array();
		$pages     = get_pages( $page_args );

		foreach ( $pages as $page ) {
			// Replace `-` by `_`.
			$slug = str_replace( '-', '_', $page->post_name );

			$context['permalink'][ $slug ] = get_page_link( $page->ID );
		}
		$context['permalink']['current_url'] = get_permalink();

		// Share.
		$shares = array(
			array(
				'slug' => 'facebook',
				'name' => __( 'Partager sur Facebook' ),
				'url'  => 'https://www.facebook.com/sharer.php?u=',
			),
			array(
				'slug' => 'twitter',
				'name' => __( 'Partager sur Twitter' ),
				'url'  => 'https://twitter.com/intent/tweet?url=',
			),
			array(
				'slug' => 'google-plus',
				'name' => __( 'Partager sur Google+' ),
				'url'  => 'https://plus.google.com/share?url=',
			),
			array(
				'slug' => 'envelope',
				'name' => __( 'Partager par Mail' ),
				'url'  => 'mailto:?&amp;body=',
			),
		);

		foreach ( $shares as $share ) {
			$context['contact']['shares'][ $share['slug'] ] = $share;
		}

		$context['manifest'] = $this->theme_manifest;

		return $context;
	}


	/**
	 * Setup
	 *
	 * @access public
	 */
	public function setup() {
		// Let WordPress manage the document title.
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

		// Register nav menus.
		register_nav_menus(
			array(
				'main' => __( 'Main' ),
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

		add_action( 'wp_head', array( $this, 'main_color' ) );
	}


	/**
	 * Main color CSS
	 *
	 * @access public
	 */
	public function main_color() {
		if ( is_404() ) {
			return false;
		}

		global $post;

		$parent_id  = get_post_ancestors( $post->ID );
		$color_main = get_field( 'page_color_main', $post->ID );

		// If page_color_main isn't set, maybe it has a parent ?
		if ( null === $color_main && isset( $parent_id[0] ) ) {
			$color_main = get_field( 'page_color_main', $parent_id[0] );
		}

		// Maybe it hasn't at all.
		if ( null === $color_main ) {
			$color_main = '#000000';
		}

		$color_secondary = get_field( 'page_color_secondary', $post->ID );

		// If page_color_secondary isn't set, maybe it has a parent ?
		if ( null === $color_secondary && isset( $parent_id[0] ) ) {
			$color_secondary = get_field( 'page_color_secondary', $parent_id[0] );
		}

		// Maybe it hasn't at all.
		if ( null === $color_secondary ) {
			$color_secondary = '#969696';
		}

		$color_ternary = get_field( 'page_color_ternary', $post->ID );

		// If page_color_ternary isn't set, maybe it has a parent?
		if ( null === $color_ternary && isset( $parent_id[0] ) ) {

			$color_ternary = get_field( 'page_color_ternary', $parent_id[0] );
		}

		// Maybe it hasn't at all.
		if ( null === $color_ternary || '' === $color_ternary ) {
			$color_ternary = '#FFFFFF';
		}

		?>
		<style>
			:root {
				--main: <?php echo $color_main; ?>;
				--secondary: <?php echo $color_secondary; ?>;
				--ternary: <?php echo $color_ternary; ?>;
			}
		</style>
		<?php
	}


	/**
	 * Enqueue styles.
	 *
	 * @access public
	 */
	public function enqueue_style() {

		// Theme stylesheet.
		wp_register_style(
			$this->theme_name . '-global',
			get_template_directory_uri() . '/dist/' . $this->theme_manifest['main.css'],
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

		// Remove wp-embed script from WordPress.
		wp_deregister_script( 'wp-embed' );

		// Remove native version of jQuery and use custom CDN version instead.
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', '//code.jquery.com/jquery-3.3.1.min.js', false, null, true );

		// Slick.
		wp_register_script(
			'slick',
			'//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js',
			array( 'jquery' ),
			null,
			true
		);

		wp_register_script(
			$this->theme_name . '-main',
			get_template_directory_uri() . '/dist/' . $this->theme_manifest['main.js'],
			array(
				'jquery',
			),
			null,
			true
		);

		wp_localize_script(
			$this->theme_name . '-main',
			'wp',
			array(
				'template_directory_uri' => get_template_directory_uri(),
				'base_url'               => site_url(),
				'home_url'               => home_url( '/' ),
				'ajax_url'               => admin_url( 'admin-ajax.php' ),
				'current_url'            => get_permalink(),
				'nonce'                  => wp_create_nonce( 'security' ),
			)
		);

		wp_enqueue_script( 'slick' );
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
