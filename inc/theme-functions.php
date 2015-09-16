<?php
/**
 * odin functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 */

/**
 * Sets content width.
 */
if ( ! isset( $content_width ) ) {
    $content_width = 600;
}

if ( ! function_exists( 'odin_setup_features' ) ) {

    /**
     * Setup theme features.
     *
     * @since 2.2.0
     */
    function odin_setup_features() {

        /**
         * Add support for multiple languages.
         */
        load_theme_textdomain( 'odin', get_template_directory() . '/languages' );

        /**
         * Register nav menus.
         */
        register_nav_menus(
            array(
                'main-menu' => __( 'Main Menu', 'odin' )
            )
        );

        /*
         * Add post_thumbnails suport.
         */
        add_theme_support( 'post-thumbnails' );

        /**
         * Add feed link.
         */
        add_theme_support( 'automatic-feed-links' );

        /**
         * Support Custom Header.
         */
        $default = array(
            'width'         => 0,
            'height'        => 0,
            'flex-height'   => false,
            'flex-width'    => false,
            'header-text'   => false,
            'default-image' => '',
            'uploads'       => true,
        );

        add_theme_support( 'custom-header', $default );

        /**
         * Support Custom Background.
         */
        $defaults = array(
            'default-color' => '',
            'default-image' => '',
        );

        add_theme_support( 'custom-background', $defaults );

        /**
         * Support Custom Editor Style.
         */
        add_editor_style( 'assets/css/editor-style.css' );

        /**
         * Add support for infinite scroll.
         */
        add_theme_support(
            'infinite-scroll',
            array(
                'type'           => 'scroll',
                'footer_widgets' => false,
                'container'      => 'content',
                'wrapper'        => false,
                'render'         => false,
                'posts_per_page' => get_option( 'posts_per_page' )
            )
        );

        /**
         * Add support for Post Formats.
         */
        // add_theme_support( 'post-formats', array(
        //     'aside',
        //     'gallery',
        //     'link',
        //     'image',
        //     'quote',
        //     'status',
        //     'video',
        //     'audio',
        //     'chat'
        // ) );

        /**
         * Support The Excerpt on pages.
         */
        // add_post_type_support( 'page', 'excerpt' );

        /**
         * Switch default core markup for search form, comment form, and comments to output valid HTML5.
         */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption'
            )
        );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );
    }
}

add_action( 'after_setup_theme', 'odin_setup_features' );

/**
 * Custom stylesheet URI.
 *
 * @param  string $uri Default URI.
 * @param  string $dir Stylesheet directory URI.
 *
 * @return string      New URI.
 */
function odin_stylesheet_uri( $uri, $dir ) {
    return $dir . '/assets/css/style.css';
}

add_filter( 'stylesheet_uri', 'odin_stylesheet_uri', 10, 2 );

/**
 * Register widget areas.
 *
 * @since 2.2.0
 */
function odin_widgets_init() {
    register_sidebar(
        array(
            'name' => __( 'Main Sidebar', 'odin' ),
            'id' => 'main-sidebar',
            'description' => __( 'Site Main Sidebar', 'odin' ),
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget' => '</aside>',
            'before_title' => '<h3 class="widgettitle widget-title">',
            'after_title' => '</h3>',
        )
    );
}

add_action( 'widgets_init', 'odin_widgets_init' );

/**
 * Remove "p" around images
 */
function odin_filter_ptags_on_images( $content ) {
   return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
}

add_filter( 'the_content', 'odin_filter_ptags_on_images', 99 );

/**
 * Clean Up shortcodes entry
 */
function odin_clean_shortcodes( $content ) {
    $array = array(
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );

    $content = strtr( $content, $array );

    return $content;
}

add_filter( 'the_content', 'odin_clean_shortcodes' );

/**
 * Allow shortcodes in Widgets Texts
 */
add_filter( 'widget_text', 'do_shortcode' );

/**
 * Flush Rewrite Rules for new CPTs and Taxonomies.
 */
function odin_flush_rewrite() {
    flush_rewrite_rules();
}

add_action( 'after_switch_theme', 'odin_flush_rewrite' );

/**
 * WPCF7
 *
 * Optimize and style Contact Form 7
 */
// add_filter( 'wpcf7_load_js', '__return_false' );
// add_filter( 'wpcf7_load_css', '__return_false' );

/**
 * WPCF7
 *
 * Fallback to disable HTML5 input fields in browser whithout support (Firefox and I.E)
 */
add_filter( 'wpcf7_support_html5_fallback', '__return_true' );

/**
 * Change Limits Post Per Page in Search Template
 */
function odin_posts_per_archive_page_search() {
    if ( is_search() )
        set_query_var( 'posts_per_archive_page', 10 ); // or use variable key: posts_per_page
}

// add_filter( 'pre_get_posts', 'odin_posts_per_archive_page_search' );

/**
 * Add filter to showing only Post Type in search results
 */
function odin_search_filter( $query ) {
    if ( $query->is_search ) {
        $query->set( 'post_type', 'post' );
    }

    return $query;
}

// add_filter( 'pre_get_posts', 'odin_search_filter' );

/**
 * Disable the built-in front-end search capabilities of WordPress.
 *
 * @param $obj
 *
 * @return void
 */
function parse_query( $obj ) {
    if ( $obj->is_search && $obj->is_main_query() ) {
        unset( $_GET['s'] );
        unset( $_POST['s'] );
        unset( $_REQUEST['s'] );
        unset( $obj->query['s'] );
        $obj->set( 's', '' );
        $obj->is_search = false;
        $obj->set_404();
    }
}

// add_action( 'parse_query', 'parse_query', 5 );

/**
 * Make javascritps sites Asynchronous to improve site performance
 *
 * @return void
 */
if ( ! is_admin() ) {
    function odin_front_end_js_async( $url ) {
        if ( FALSE === strpos( $url, '.js' ) ) {
            // not our file
            return $url;
        }

        // Must be a ', not "!
        return "$url' async='async";
    }

    // add_filter( 'clean_url', 'odin_front_end_js_async', 11, 1 );
}

/**
 * Query WooCommerce activation
 *
 * @since  2.2.6
 *
 * @return boolean
 */
if ( ! function_exists( 'is_woocommerce_activated' ) ) {
    function is_woocommerce_activated() {
        return class_exists( 'woocommerce' ) ? true : false;
    }
}

/**
 * Different File Locations for Options Framework Theme
 *
 * @link https://github.com/devinsays/options-framework-theme/issues/82
 * @return void
 */
function options_framework_file( $file ) {
    return 'core/options/options.php';
}

// add_filter( 'options_framework_location', 'options_framework_file' );

/**
 * Helper function to return the theme option value. If no value has been saved, it returns $default.
 * Needed because options are saved as serialized strings.
 *
 * This code allows the theme to work without errors if the Options Framework plugin has been disabled.
 */
if ( ! function_exists( 'of_get_option' ) ) {
    function of_get_option( $name, $default = false ) {

        $optionsframework_settings = get_option( 'optionsframework' );

        // Gets the unique option id
        $option_name = $optionsframework_settings['id'];

        if ( get_option( $option_name ) ) {
            $options = get_option( $option_name );
        }

        if ( isset( $options[$name] ) ) {
            return $options[$name];
        } else {
            return $default;
        }
    }
}