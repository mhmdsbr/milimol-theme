<?php

return [
    /*
     * Current environment variables
     */
    'wp_env' => env('WP_ENV', 'production'),
    'wp_home' => env('WP_HOME', 'http://localhost'),
    'wp_siteurl' => env('WP_SITEURL', 'http://localhost/wp'),
    'app_domain' => env('APP_DOMAIN', 'localhost'),

    /*
     * Debugging variables
     */
    'wp_debug' => env('WP_DEBUG', false),
    'wp_debug_log' => env('WP_DEBUG_LOG', false),
];
