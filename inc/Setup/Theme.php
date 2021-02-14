<?php // phpcs:ignore
/**
 * Bootstraps WordPress theme related functions, most importantly enqueuing javascript and styles.
 *
 * @package WordPress
 * @subpackage Formatcine
 */

namespace FormatCine\Setup;

use Timber\{ Timber, Menu };
use Twig\{ TwigFunction };

use Cocur\Slugify\Bridge\Twig\{ SlugifyExtension };
use Cocur\Slugify\{ Slugify };

$timber = new Timber();

Timber::$dirname = array( 'views', 'templates', 'dist' );

/**
 * Theme
 */
class Theme {

	/**
	 * The manifest of this theme
	 *
	 * @access private
	 * @var    array
	 */
	private $theme_manifest;


	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function run() : void {
		$this->theme_manifest = get_theme_manifest();

		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_filter( 'timber_context', array( $this, 'add_socials_to_context' ) );
		add_filter( 'timber_context', array( $this, 'add_manifest_to_context' ) );
		add_filter( 'timber_context', array( $this, 'add_menus_to_context' ) );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );

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
				--main: <?php echo esc_html( $color_main ); ?>;
				--secondary: <?php echo esc_html( $color_secondary ); ?>;
				--ternary: <?php echo esc_html( $color_ternary ); ?>;
			}
		</style>
		<?php
	}


	/**
	 * Add to Twig
	 *
	 * @param object $twig Twig environment.
	 * @return object $twig
	 * @access public
	 */
	public function add_to_twig( object $twig ) : object {
		if ( function_exists( 'post_class' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'post_class',
					function( $args = '' ) {
						return post_class( $args );
					}
				)
			);
		}

		if ( function_exists( 'body_class' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'body_class',
					function( $args = '' ) {
						return body_class( $args );
					}
				)
			);
		}

		if ( function_exists( 'html_class' ) ) {
			$twig->addFunction(
				new TwigFunction(
					'html_class',
					function( $args = '' ) {
						return html_class( $args );
					}
				)
			);
		}

		$twig->addExtension( new SlugifyExtension( Slugify::create() ) );

		$twig->addFunction(
			new TwigFunction(
				'get_theme_manifest',
				function() {
					return $this->theme_manifest;
				}
			)
		);

		return $twig;
	}


	/**
	 * Add manifest to context
	 *
	 * @param array $context Timber context.
	 */
	public function add_manifest_to_context( array $context ) : array {
		$context['manifest'] = get_theme_manifest();

		return $context;
	}


	/**
	 * Add socials to context
	 *
	 * @param array $context Timber context.
	 * @return array
	 */
	public function add_socials_to_context( array $context ) : array {
		// Add socials to context.
		$socials      = array();
		$socials_name = array( 'YouTube', 'Facebook' );

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

		return $context;
	}


	/**
	 * Add menus to context
	 *
	 * @param array $context Timber context.
	 * @return array
	 * @since  1.0.0
	 */
	public function add_menus_to_context( array $context ) : array {
		$menus = get_registered_nav_menus();

		foreach ( $menus as $menu => $value ) {
			$context['menu'][ $menu ] = new Menu( $value );
		}

		return $context;
	}


	/**
	 * Add to context
	 *
	 * @param array $context Timber context.
	 *
	 * @return array
	 * @since  1.0.0
	 */
	public function add_to_context( array $context ) : array {

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
				'name' => __( 'Share on Facebook', 'formatcine' ),
				'url'  => 'https://www.facebook.com/sharer.php?u=',
			),
			array(
				'slug' => 'twitter',
				'name' => __( 'Share on Twitter', 'formatcine' ),
				'url'  => 'https://twitter.com/intent/tweet?url=',
			),
			array(
				'slug' => 'envelope',
				'name' => __( 'Share by email' ),
				'url'  => 'mailto:?&amp;body=',
			),
		);

		foreach ( $shares as $share ) {
			$context['contact']['shares'][ $share['slug'] ] = $share;
		}

		return $context;
	}
}
