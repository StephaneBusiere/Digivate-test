<?php

/**
 * Ignition functions and definitions
 *
 * @link    https://developer.wordpress.org/themes/basics/theme-functions/
 * @package Digivate-test
 * @since   1.0
 *
 * The first file to look at is theme.config.json where you can quickly set up some theme settings
 * like google fonts, icons for various areas and logo position
 * you can also set the mobile menu by editing the mobile_menu_type option to open as app-menu or leave blank to open regular
 * default_acf_header_block: add your post types here to force them to have a header block when a new post is made.
 *
 * Then you should set your CSS variables in variables.scss
 *
 * Once those are both edited, you can come here and add image sizes, widgets and anything else
 * Remember it might not be necessary to enqueue js files here as any js file starting with an underscore will be added automatically to the front end js build
 * That will work only if the file is inside the inc or parts folders.
 * This ability also works for any scss file added with an underscore in those folders too.
 * This also works for underscored php files.
 * therefore all php files in the inc folder are already automatically included
 *
 * Besides adding image sizes, you may find you dont have to do much in here.
 */

/**
 * Ignition only works in WordPress 5.5 or later. Here we check before allowing the theme to be used.
 * There is nothing here for you to do.
 */
if ( version_compare( $GLOBALS['wp_version'], '5.5', '<' ) ) {
	require get_template_directory() . '/inc/core/back-compat.php';

	return;
}

/*--------------------------------------------------------------
# Check theme.config.json and make changes as needed.
--------------------------------------------------------------*/


/*--------------------------------------------------------------
# Setup
--------------------------------------------------------------*/
/**
 * This sets up theme defaults and registers support for various WordPress features.
 * Runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 * Here is where you can start changing settings.
 * you can also add google fonts and a submenu arrow via the ign_config variable below
 */
function digivate_test_setup() {


	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/ignition
	 * If you're building a theme based on Ignition, and you downloaded this from github, use a find and replace
	 * to change 'digivate-test' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'digivate-test' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
    */
	add_theme_support( 'post-thumbnails' );

	add_post_type_support( 'page', 'excerpt' );
	/**
	 * default image size for cards and thumbnails and header images
	 * Users should upload twice the size of an image size.
	 * So if the image size is 600 x 600, the user should upload a 1200 by 1200.
	 * Output the image size and WP will automatically include the full size for big display when needed.
	 *
	 * WP is also smart and if you set crop to true it will include the original only if it matches in ratio
	 * Header image size is included for large header images. Users dont have to upload twice that size unless your ok with large files.
	 *
	 * Recommend installing imsanity so users can't upload extremely huge images without them being compressed and resized.
	 */
	set_post_thumbnail_size( 300, 300, true );
	add_image_size( 'header_image', 2000, 9999 );


	add_filter( 'intermediate_image_sizes_advanced', 'remove_default_images' );


	/*
	 * Add menus here
	 */
	register_nav_menus( array(
		'top-menu' => __( 'Top Menu', 'digivate-test' ), //main menu at top.
	) );

	/*
    * Enable support for Post Formats.
    * Uncomment if you want to use this feauture
    * See: https://codex.wordpress.org/Post_Formats
    */

//	add_theme_support( 'post-formats', array(
//		'aside',
//		'image',
//		'video',
//		'quote',
//		'link',
//		'gallery',
//		'audio',
//	) );
//	add_post_type_support( 'post', 'post-formats' );


	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	//Adds Gutenberg Support
	add_theme_support( 'align-wide' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );


	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 400,
		'height'      => 250,
		'flex-width'  => true,
		'flex-height' => true
	) );

	// Add theme support for selective refresh for widgets in customizer.
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'custom-header' );

	/*
	 * tinymce styles
	  */
	add_editor_style( array(
		get_template_directory_uri() . '/dist/frontEnd.css?' . wp_get_theme()->get( 'Version' ),
		ign_google_fonts_url()
	) );


	$GLOBALS['content_width'] = 730;
}

add_action( 'after_setup_theme', 'digivate_test_setup' );


/*--------------------------------------------------------------
# ADMIN ACCESS AND ADMIN BAR VISIBILITY
--------------------------------------------------------------*/
/**
 * Disable admin bar for everyone but administrators
 * You can change this based on capabilities. By default manage_options is used to check for Administrators
 */


if ( ! function_exists( 'disable_admin_bar' ) ) {
	function disable_admin_bar() {
		if ( ! current_user_can( ign_get_config( 'admin_access_capability', 'manage_options' ) ) ) {
			add_filter( 'show_admin_bar', '__return_false' );
		}
	}
}
add_action( 'after_setup_theme', 'disable_admin_bar' );


/**
 * Redirect back to homepage and not allow access to WP Admin.
 */
if ( ! function_exists( 'redirect_admin' ) ) {

	function redirect_admin() {
		if ( ! current_user_can( ign_get_config( 'admin_access_capability', 'manage_options' ) ) && ( ! defined( 'DOING_AJAX' ) || ! DOING_AJAX ) ) {
			wp_redirect( home_url() );
			exit;
		}
	}
}

add_action( 'admin_init', 'redirect_admin' );


/*--------------------------------------------------------------
# Scripts and Styles
--------------------------------------------------------------*/
/**
 * Enqueue all scripts and styles.
 * Add your own scripts and styles below.
 */
function digivate_test_scripts() {
	global $wp;

	// Add google fonts
	if ( ign_get_config( 'google_fonts' ) ) {
		wp_enqueue_style( 'digivate-test-fonts', ign_google_fonts_url(), array(), wp_get_theme()->get( 'Version' ) );
	}


	// Theme stylesheet. Will get this stylesheet or a child themes stylesheet.
	wp_enqueue_style( 'digivate-test-style', get_stylesheet_uri(), '', wp_get_theme()->get( 'Version' ) );

	//Sass compiles styles. Will get child's theme version if found instead. Child theme should import with sass.
	wp_enqueue_style( 'digivate-test-sass-styles', get_theme_file_uri( '/dist/frontEnd.css' ), '', wp_get_theme()->get( 'Version' ) );

	wp_enqueue_script( 'iconify', 'https://code.iconify.design/1/1.0.6/iconify.min.js' );

	//ie11 js polyfills
	wp_enqueue_script( 'polyfill', 'https://polyfill.io/v3/polyfill.min.js?flags=gated&features=AbortController%2Cdefault%2CNodeList.prototype.forEach%2CEvent%2Csmoothscroll' );

	//jQuery 3.0 replaces WP jquery
	wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core', "https://code.jquery.com/jquery-3.5.1.min.js", array(), '3.5.1' );
	wp_deregister_script( 'jquery-migrate' );
	wp_register_script( 'jquery-migrate', "https://code.jquery.com/jquery-migrate-3.3.0.min.js", array( 'jquery-core' ), '3.3.0' );


	//any javascript file in assets/js that ends with custom.js will be lumped into this file.
	wp_enqueue_script( 'digivate-test-custom-js', get_template_directory_uri() . '/dist/frontEnd_bundle.js', array(
		'jquery',
		'polyfill'
	),
		wp_get_theme()->get( 'Version' ), true );

	//AJAX ready for .custom.js files
	wp_localize_script( 'digivate-test-custom-js', 'frontEndAjax', array(
		'ajaxurl'    => admin_url( 'admin-ajax.php' ),
		'nonce'      => wp_create_nonce( 'ajax_nonce' ),
		'url'        => home_url(),
		'currentUrl' => home_url( $wp->request )
	) );


	//Icons: add icons for use in custom js here
	wp_localize_script( 'digivate-test-custom-js', 'icons', array(
		'angleRight' => ign_get_svg( array( 'icon' => 'angle-right' ) ),
		'sidebar'    => ign_get_svg( array( 'icon' => 'sidebar' ) )
	) );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	//add your styles and scripts here

}

add_action( 'wp_enqueue_scripts', 'digivate_test_scripts' );


/*
 * Add Stylesheet for Gutenberg
 */
function ign_gutenberg_styles() {
	//load regular versions if script debug is set to true in wp-config file.
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';


	// Load the theme styles within Gutenberg.
	wp_enqueue_style( 'ign-gutenberg-style', get_theme_file_uri( '/dist/gutenberg-editor-style' . $suffix . '.css' ), false, wp_get_theme()->get( 'Version' ), 'all' );

	wp_enqueue_script( 'digivate-test-custom-js', get_template_directory_uri() . '/dist/custom' . $suffix . '.js', array( 'jquery' ),
		wp_get_theme()->get( 'Version' ), true );
}

//add_action( 'enqueue_block_editor_assets', 'ign_gutenberg_styles' ); //todo remove if already adding admin-css?


/**
 * Add login stylehseet
 */
function login_styles() {
	wp_enqueue_style( 'custom-admin', get_stylesheet_directory_uri() . '/dist/login.css', '', wp_get_theme()->get( 'Version' ) );
}

add_action( 'login_enqueue_scripts', 'login_styles' );


/**
 * Add admin stylesheet
 */
function footer_styles() {
	//load regular versions if script debug is set to true in wp-config file.
	//$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'iconify', 'https://code.iconify.design/1/1.0.6/iconify.min.js' );
	wp_enqueue_style( 'digivate-test-admin-styles', get_theme_file_uri( '/dist/backEnd.css' ), '', wp_get_theme()->get( 'Version' ) );
}

add_action( 'admin_footer', 'footer_styles', 99 );


/**
 * Register widget areas.
 * Change/Remove widget areas here. By default the widget areas are the sidebar and the footer which has 4 widget areas being output in columns.
 * See template-parts/footer/footer-widgets.php
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

if ( ! function_exists( 'ign_widgets_init' ) ) {
	function ign_widgets_init() {
		register_sidebar( array(
			'name'          => __( 'Sidebar', 'digivate-test' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Add widgets here to appear in your sidebar.', 'digivate-test' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );


//footer widgets and sections. up to 4
		register_sidebar( array(
			'name'          => esc_html__( 'Footer', 'digivate-test' ),
			'id'            => 'sidebar-2',
			'description'   => esc_html__( 'Add footer widgets here.', 'pwm' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );


		register_sidebar( array(
			'name'          => esc_html__( 'Footer 2', 'digivate-test' ),
			'id'            => 'sidebar-3',
			'description'   => esc_html__( 'Add footer widgets here.', 'pwm' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );


		register_sidebar( array(
			'name'          => esc_html__( 'Footer 3', 'digivate-test' ),
			'id'            => 'sidebar-4',
			'description'   => esc_html__( 'Add footer widgets here.', 'pwm' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

		register_sidebar( array(
			'name'          => esc_html__( 'Footer 4', 'digivate-test' ),
			'id'            => 'sidebar-5',
			'description'   => esc_html__( 'Add footer widgets here.', 'pwm' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		) );

	}
}
add_action( 'widgets_init', 'ign_widgets_init' );


/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function digivate_test_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}

add_action( 'wp_head', 'digivate_test_pingback_header' );


/*--------------------------------------------------------------
# Adding More PHP Files Automatically
--------------------------------------------------------------*/

require_once get_parent_theme_file_path( '/inc/core/dev-helpers.php' );

//no need to include php files, just add them to the inc folder and start them with an underscore. Ignition takes care of the rest!
//Ignition will also search two directories deep for more underscored files within inc, blocks, and post-types folders.
// (ie: inc/acf-extras/_acf-extras.php )

class Menu_Middle_Logo extends Walker_Nav_Menu {
    function end_el (&$output, $item, $depth = 0, $args = [], $id = 0) {
        parent::end_el($output, $item, $depth, $args, $id);
        
        // the menu slug
        $theme_location = 'top-menu';
        
        // check for top level depth and if correct menu
        if ($depth === 0 && isset($args->menu) && isset($args->menu->slug) && $args->menu->slug === $theme_location) {
            // get current menu items
            $menu_items = wp_get_nav_menu_items($theme_location);
            
            // will indicate how many top level menu items we have
            $parent_menu_items = [];
            
            // get top level menu items
            foreach ($menu_items as $menu_item) {
                if ($menu_item->menu_item_parent == 0) $parent_menu_items[] = $menu_item;
            }
            
            // get total menu items halved
            $half_menu_items = floor(count($parent_menu_items) / 2);
            
            // the menu item we want to add the logo to
            // before or after, depends if menu items are odd or even
            if (is_float($half_menu_items)) {
                // if you have odd menu items lets say three this will add after the first
                // [1] [custom html] [2] [3]
                // if you want it to add after the second remove the - 1, this will result in
                // [1] [2] [custom html] [3]
                $middle_item = $parent_menu_items[$half_menu_items - 1];
            } elseif (is_int($half_menu_items)) {
                // this handles even menu items
                $middle_item = $parent_menu_items[$half_menu_items - 1];
            }
            
            // if current menu item is middle item, add our custom html
            if (isset($middle_item) && $middle_item->ID === $item->ID) {
                $output .= '<li class="my-logo">';
                
                ob_start();
                the_custom_logo();
                // this is for testing because the_custom_logo()
                // is not available in my theme
                // echo 1234; 
                $output .= ob_get_clean();
                
                $output .= '</li>';
            }
        }
    }
}