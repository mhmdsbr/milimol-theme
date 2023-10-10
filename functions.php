<?php



require 'includes/timber.php';
require_once __DIR__ . '/vendor/autoload.php';

define('MILIMOL_THEME_DIR', get_stylesheet_directory());

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
new Exp\Core\Woocommerce();
new Exp\Core\Login();
new Exp\Core\Account();
new Exp\Core\Message();
new Exp\Core\Shortcodes();
$argsGenerator = new Exp\Core\ArgsGenerator('product', '-1');
$smsHandler = new Exp\Core\SmsHandler();
$dashboardWidget = new Exp\Core\DashboardWidgets();

/** ThirdParty */
new EXP\ThirdParty\ACF();
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


function timber_set_product( $post ): void
{
    global $product;

    if ( is_woocommerce() ) {
       $product = wc_get_product( $post->ID );
    }
}


/**
 * Ajax Global Search
 * @return array
 *
 */
function ajax_search_results(): array
{
    $search_query = $_GET['search_query'] ?? '';
    $templates = array('search.twig', 'archive.twig', 'index.twig');
    $context = Timber::context();
    $context['search_query'] = $search_query;
    $search_query = urldecode($search_query); // Decode the search query

    // Update 1: Sanitize the search query to prevent SQL injection
    $search_query = sanitize_text_field($search_query);

    // Update 2: Make sure the search query is not empty before performing the query

    if (!empty($search_query)) {
        // Query for products matching the search query in post content and titles
        $product_args = array(
            's' => $search_query,
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1, // Retrieve all matching results
        );

        $product_posts = new Timber\PostQuery($product_args);

        $taxonomy_args = array(
            'taxonomy'      => array( 'product_cas_no' ), // taxonomy name
            'hide_empty'    => true,
            'fields'        => 'all',
            'name__like'    => $search_query,
        );

        $taxonomy_posts = get_terms( $taxonomy_args );

        if( $product_posts->found_posts == 0 && count($taxonomy_posts) > 0 ) {
            $taxonomy_ids = array();
            foreach( $taxonomy_posts as $taxonomy_product_item ) {
                $taxonomy_ids[] = $taxonomy_product_item->term_id;
            }
            $product_args = array(
                'post_type'             => 'product',
                'post_status'           => 'publish',
                'posts_per_page'        => -1, //  No Limit
                'tax_query'             => [
                    [
                        'taxonomy'      => 'product_cas_no',
                        'field'         => 'term_id', // can be 'term_id', 'slug' or 'name'
                        'terms'         => $taxonomy_ids,
                    ],
                ],
            );
            $product_posts = new Timber\PostQuery($product_args);
        }

        // Separate results for products and custom taxonomy-related products
        $results = array(
            'products' => $product_posts,
            'taxonomy_related' => $taxonomy_posts,
        );

        // Store the results in the context
        $context['results'] = $results;

    }

    $context['pagination'] = Timber::get_pagination();

    // Render the search results template and send it back as JSON
    $html = Timber::compile($templates, $context);
    wp_send_json_success(array('html' => $html));

    return $html;
}

/** Ajax Search */
add_action('wp_ajax_ajax_search', 'ajax_search_results');
add_action('wp_ajax_nopriv_ajax_search', 'ajax_search_results');

function dmp($value, $title = null): void
{
    if($title !== null){
        echo '<h1>' . $title . '</h1>';
    }
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

function render_ob($value, $title = '', $clear = false): void
{
    ob_start();
    dmp($value, $title);
    $output = ob_get_clean();
    ob_end_flush();
    if ($clear === false) {
        $temp_field = get_field('temp', 'option');
        $output = $temp_field.'</hr>'.$output;
    }
    update_field('temp', $output, 'option');

}


