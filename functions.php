<?php


require 'includes/timber.php';
require_once __DIR__ . '/vendor/autoload.php';

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


function timber_set_product( $post ): void
{
    global $product;

    if ( is_woocommerce() ) {
       $product = wc_get_product( $post->ID );
    }
}


