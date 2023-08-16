<?php
require 'includes/timber.php';

/** Autoload classes in `includes` folder */
spl_autoload_register(function ($classname) {
    $parts = explode('\\', $classname);
    array_shift($parts);
    $path      = implode(DIRECTORY_SEPARATOR, $parts);
    $classpath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . $path . '.php';
    if (file_exists($classpath)) {
        include_once $classpath;
    }
});

/** Admin */
new EXP\Admin\Login();

/** Core */
new EXP\Core\Cleaner();
new EXP\Core\Enqueues();
new EXP\Core\General();
new EXP\Core\Gutenberg();
new EXP\Core\PostType();
new Exp\Core\ExtendTwig();
new Exp\Core\Breadcrumbs();

/** ThirdParty */
new EXP\ThirdParty\ACF();
//new EXP\ThirdParty\Facet\Facet();
new EXP\ThirdParty\GravityForms();

/**
 * Function: env($key, $default = null)
 * Usage: env('WP_ENV', 'production')
 */
if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed
    {
        if (!defined($key)) {
            return $default;
        }

        $value = constant($key);

        if ($value === false) {
            return $default;
        }

        return $value;
    }
}

/**
 * Function: config($key, $default = null)
 * Usage: config('app.name', 'Expedition')
 */
if (!function_exists('config')) {
    function config($key, $default = null): mixed
    {
        $parts = explode('.', $key);
        $file  = array_shift($parts);
        $path  = implode('.', $parts);

        $config = require_once dirname(__FILE__) . '/config/' . $file . '.php';

        return data_get($config, $path, $default);
    }
}

/**
 * @param $filename
 * @return string
 */
function fetch_svg(?string $filename = null): string
{
    if ($filename === null) {
        return '';
    }
    if ($filename == '') {
        return '';
    }
    $svg = file_get_contents(get_theme_file_path('/svg/' . $filename . '.svg'));

    return trim($svg);
}

function cc_mime_types( $mimes ){
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );

function fix_svg() {
    echo '<style type="text/css">
        .attachment-266x266, .thumbnail img {
             width: 100% !important;
             height: auto !important;
        }
        </style>';
}
add_action( 'admin_head', 'fix_svg' );

/**
 * Ajax Global Search
 * @return array
 *
 */
function ajax_search_results() {
    $search_query = $_GET['search_query'] ?? '';
    $templates = array('search.twig', 'archive.twig', 'index.twig');
    $context = Timber::context();
    $context['search_query'] = $search_query;
    $search_query = urldecode($search_query); // Decode the search query

    // Update 1: Sanitize the search query to prevent SQL injection
    $search_query = sanitize_text_field($search_query);

    // Update 2: Make sure the search query is not empty before performing the query
    if (!empty($search_query)) {
        $posts = new Timber\PostQuery(array('s' => $search_query)); // Assign the Timber\PostQuery object to a variable
        $context['posts'] = $posts; // Use the Timber\PostQuery object directly in the context
    } else {
        // If the search query is empty, set an empty array for the posts.
        $context['posts'] = array();
    }

    $context['pagination'] = Timber::get_pagination();

    // Render the search results template and send it back as JSON
    $html = Timber::compile($templates, $context);
    wp_send_json_success(array('html' => $html));
}

add_action('wp_ajax_ajax_search', 'ajax_search_results');
add_action('wp_ajax_nopriv_ajax_search', 'ajax_search_results');


function theme_add_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}

add_action( 'after_setup_theme', 'theme_add_woocommerce_support' );

function timber_set_product( $post ) {
    global $product;

    if ( is_woocommerce() ) {
        $product = wc_get_product( $post->ID );
    }
}

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );