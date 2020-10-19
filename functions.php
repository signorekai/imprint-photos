<?php
/**
 * Winterfell for Liuying
 *
 * @package  Sulphur 
 * @package  Winterfell 
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
		add_action( 'after_setup_theme', array( $this, 'wordpress_cleanup' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_filter( 'sanitize_file_name', array( $this, 'so_3261107_hash_filename' ), 10 );
		
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action('wp_head', 'rest_output_link_wp_head', 10);
		remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);

		parent::__construct();
	}
	/** This is where you can register custom post types. */
	public function register_post_types() {

		/**
		 * Post Type: Portfolio Items.
		 */
		$labels = array(
			"name" => __( "Portfolio Items", "custom-post-type-ui" ),
			"singular_name" => __( "Portfolio Item", "custom-post-type-ui" ),
			"menu_name" => __( "Portfolio", "custom-post-type-ui" ),
			"all_items" => __( "All Portfolio Items", "custom-post-type-ui" ),
		);
	
		$args = array(
			"label" => __( "Portfolio Items", "custom-post-type-ui" ),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"delete_with_user" => false,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => array( "slug" => "work", "with_front" => false ),
			"query_var" => true,
			"menu_position" => 5,
			"supports" => array( "title", "thumbnail", "custom-fields" ),
		);
	
		register_post_type( "portfolio", $args );

		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_5cd4525556e76',
				'title' => 'Portfolio Meta',
				'fields' => array(
					array(
						'key' => 'field_5cd45bb7b9e8e',
						'label' => 'Main description',
						'name' => 'main_description',
						'type' => 'textarea',
						'instructions' => 'This is the main description that will show up at the top of the portfolio page.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => '',
						'new_lines' => '',
					),
					array(
						'key' => 'field_5cd4526b8c531',
						'label' => 'Projects',
						'name' => 'projects',
						'type' => 'repeater',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'collapsed' => '',
						'min' => 0,
						'max' => 0,
						'layout' => 'block',
						'button_label' => '',
						'sub_fields' => array(
							array(
								'key' => 'field_5cd452928c532',
								'label' => 'Name',
								'name' => 'name',
								'type' => 'text',
								'instructions' => '',
								'required' => 1,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'prepend' => '',
								'append' => '',
								'maxlength' => '',
							),
							array(
								'key' => 'field_5cd452a58c533',
								'label' => 'Description',
								'name' => 'description',
								'type' => 'textarea',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'default_value' => '',
								'placeholder' => '',
								'maxlength' => '',
								'rows' => '',
								'new_lines' => '',
							),
							array(
								'key' => 'field_5cd452b28c534',
								'label' => 'Photos',
								'name' => 'photos',
								'type' => 'gallery',
								'instructions' => '',
								'required' => 1,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'min' => '',
								'max' => '',
								'insert' => 'append',
								'library' => 'all',
								'min_width' => '',
								'min_height' => '',
								'min_size' => '',
								'max_width' => '',
								'max_height' => '',
								'max_size' => '',
								'mime_types' => '',
								'return_format' => 'array',
								'preview_size' => 'medium',
							),
						),
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'portfolio',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'acf_after_title',
				'style' => 'seamless',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => array(
					0 => 'the_content',
				),
				'active' => true,
				'description' => '',
			));
			
			endif;
	}
	/** This is where you can register custom taxonomies. */
	public function register_taxonomies() {
	}

	public function wordpress_cleanup() {
		remove_action('wp_head', 'wlwmanifest_link'); 							// remove support to Windows Live Writer
		remove_action('wp_head', 'wp_generator'); 									// remove wordpress version in header
		remove_action('wp_head', 'rsd_link'); 											// remove XML-RPC RSD link
		remove_action('wp_head', 'rest_output_link_wp_head', 10);		// disable WP REST API
	}

	/**
	 * @link http://stackoverflow.com/a/3261107/247223
	 */
	public function so_3261107_hash_filename( $filename ) {
		$info = pathinfo( $filename );
		$ext  = empty( $info['extension'] ) ? '' : '.' . $info['extension'];
		$name = basename( $filename, $ext );

		return md5( $name ) . $ext;
	}

	public function enqueue_scripts() {
		wp_deregister_script('masonry');
		wp_register_script('masonry', get_template_directory_uri() . '/vendor/masonry.min.js', array('imagesloaded'), '4.2.2');
		wp_register_script('rallax', get_template_directory_uri() . '/vendor/rallax.js', false, '2.0.4');
		wp_register_script('lodash-custom', get_template_directory_uri() . '/vendor/lodash.min.js', false, '1.8.3');
		wp_register_script('barbajs', get_template_directory_uri() . '/vendor/barba.umd.js', false, '2.9.7');
		wp_enqueue_script('modernizr', get_template_directory_uri() . '/vendor/modernizr.js', false, '3.6.0', true);

		wp_register_script('lightbox', get_template_directory_uri() . '/vendor/lightbox.min.js', false, '1.7.0', true);
		wp_register_style('lightbox', get_template_directory_uri() . '/vendor/lightbox.min.css', false, '1.7.0');

		wp_enqueue_script('masonry');
		wp_enqueue_script('lightbox');
		wp_enqueue_script('rallax');

		wp_enqueue_script( 'f', get_template_directory_uri() . '/static/scripts/f.js', array(), '1.0.0' );
		wp_enqueue_script( 'site', get_template_directory_uri() . '/static/scripts/site.js', array('f', 'barbajs'), '1.0.0', true);

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
		$context['footer_bg'] = new Timber\Image($theme->theme_mod('footer_bg'));
		$context['test'] = "test";

		$context['footer'] = array(
			'text' => $theme->theme_mod('footer_text'),
			'bg' => new Timber\Image($theme->theme_mod('footer_bg')),
		);

		$context['seo'] = array(
			'description' => $theme->theme_mod('seo_description'),
			'photo' => $theme->theme_mod('seo_photo'),
		);

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

		add_theme_support( 'menus' );

		register_nav_menus(
			array(
				"menu-1" => __( 'Primary', 'winterfell' )
			)
		);

		add_image_size('gallery', 1200);
		add_image_size('hd', 1920, 1080);
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
		$twig->addFilter( new Timber\Twig_Filter( 'slugify', function( $title ) {
			return sanitize_title( $title );
		}));
		return $twig;
	}

}

new StarterSite();
