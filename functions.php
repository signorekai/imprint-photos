<?php
/**
 * Timber starter-theme
 * https://github.com/timber/starter-theme
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

require get_template_directory() . '/inc/customizer.php';

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
		echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
	});

	add_filter('template_include', function( $template ) {
		return get_stylesheet_directory() . '/static/no-timber.html';
	});

	return;
}

/**
 * Sets the directories (inside your theme) to find .twig files
 */
Timber::$dirname = array( 'templates', 'views' );

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


/**
 * We're going to configure our theme inside of a subclass of Timber\Site
 * You can move this to its own file and include here via php's include("MySite.php")
 */
class StarterSite extends Timber\Site {
	/** Add timber support. */
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action('wp_head', 'rest_output_link_wp_head', 10);
		remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types() {

	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {

	}

	public function enqueue_scripts() {
		wp_deregister_script('masonry');
		wp_register_script('masonry', get_template_directory_uri() . '/vendor/masonry.min.js', array('imagesloaded'), '4.2.2');
		wp_register_script('rallax', get_template_directory_uri() . '/vendor/rallax.js', false, '2.0.4');
		wp_register_script('lodash-custom', get_template_directory_uri() . '/vendor/lodash.min.js', false, '1.8.3');

		wp_register_script('lightbox', get_template_directory_uri() . '/vendor/lightbox.min.js', false, '1.7.0', true);
		wp_register_style('lightbox', get_template_directory_uri() . '/vendor/lightbox.min.css', false, '1.7.0');

		wp_enqueue_script( 'f', get_template_directory_uri() . '/static/scripts/f.js', array(), '1.0.0' );
		wp_enqueue_script( 'site', get_template_directory_uri() . '/static/scripts/site.js', array('f'), '1.0.0', true );
		if (is_front_page()) {
			wp_enqueue_script( 'home', get_template_directory_uri() . '/static/scripts/home.js', array('f'), '1.0.0', true );
		}
		if ( is_singular('portfolio') ) {
			// wp_enqueue_script( 'masonry', get_template_directory_uri() . '/static/scripts/site.js', array('f'), '1.0.0', true );
			wp_enqueue_script('masonry');

			$dep = array('f', 'lightbox', 'rallax');
			wp_enqueue_script( 'single-portfolio', get_template_directory_uri() . '/static/scripts/single-portfolio.js', $dep, '1.0.0', true );
			wp_enqueue_style('lightbox');
		}

		if ( is_page() ) {
			$dep = array('f', 'rallax');
			wp_enqueue_script( 'page', get_template_directory_uri() . '/static/scripts/single-page.js', $dep, '1.0.0', true );
		}
	}

	/** This is where you add some context
	 *
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['menu'] = new Timber\Menu();
		$context['site'] = $this;
		$context['site']->theme->images = $this->theme->link . "/static/images";

		$theme = new Timber\Theme();
		$context['footer_text'] = $theme->theme_mod('footer_text');
		$context['footer_bg'] = $theme->theme_mod('footer_bg');

		$query = array(
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'post_status' => 'publish',
			'post_type' => 'portfolio',
			'posts_per_page' => 50
		);
		$context['works'] = new Timber\PostQuery( $query );
		return $context;
	}

	public function theme_supports() {
		// Add default posts and comments RSS feed links to head.
		// add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5', array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		// add_theme_support(
		// 	'post-formats', array(
		// 		'aside',
		// 		'image',
		// 		'video',
		// 		'quote',
		// 		'link',
		// 		'gallery',
		// 		'audio',
		// 	)
		// );

		add_theme_support( 'menus' );

		register_nav_menus(
			array(
				"menu-1" => __( 'Primary', 'winterfell' )
			)
		);

		add_image_size('full', 1920, 1080);
	}

	/** This Would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/** This is where you can add your own functions to twig.
	 *
	 * @param string $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		$twig->addExtension( new Twig_Extension_StringLoader() );
		$twig->addFilter( new Twig_SimpleFilter( 'myfoo', array( $this, 'myfoo' ) ) );
		return $twig;
	}

}

new StarterSite();
