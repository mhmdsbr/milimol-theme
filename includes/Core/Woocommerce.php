<?php
/**
 * All related functions for Woocommerce
 */
namespace EXP\Core;

use JetBrains\PhpStorm\NoReturn;

class Woocommerce
{

    public function __construct()
    {

        add_action( 'after_setup_theme', [&$this, 'theme_add_woocommerce_support'] );
        remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );

        add_filter( 'manage_edit-product_columns', [&$this, 'custom_product_column'], 11);

        add_action( 'manage_product_posts_custom_column', [&$this, 'custom_status_column'], 10, 2 );

        // Hook the custom function to run after the user account details are updated
        add_action('woocommerce_save_account_details', [&$this, 'custom_redirect_after_account_update'], 10, 1);


        add_filter( 'loop_shop_per_page', [&$this, 'new_loop_shop_per_page'], 20 );

        add_filter('pre_get_posts', [&$this, 'pre_get_posts_callback'] );

        add_action('template_redirect', [&$this, 'custom_redirect_my_account_dashboard']);

        add_action('template_redirect', [&$this, 'custom_digits_login_redirect'], 9999);

    }

    function theme_add_woocommerce_support(): void
    {
        add_theme_support( 'woocommerce' );
    }

    // product new status woocommerce
    function custom_product_column($columns): array
    {
        unset($columns['sku']);
        unset($columns['price']);
        unset($columns['is_in_stock']);
        $new_columns = array();
        foreach( $columns as $key => $column ){
            $new_columns[$key] = $column;
            if( $key === 'name' ) {
                $new_columns['edit_status'] = __('وضعیت کنونی محصول');
            }
        }
        error_log('Custom column function called'); // Add this line for debugging

        return $new_columns;
    }

    function custom_status_column($column, $post_id): void
    {
        switch ($column) {
            case 'edit_status':
                $status = get_field('product_status', $post_id);
                switch ($status) {
                    case 'publish';
                        echo '<span style="width: 100px;">منتشر شده</span>';
                        break;
                    case 'draft';
                        echo 'ذخیره موقت';
                        break;
                    case 'pending';
                        echo 'در حال بررسی';
                        break;
                }
                break;
        }
    }

    // Define a custom function to handle the redirection
    #[NoReturn] function custom_redirect_after_account_update($user_id): void
    {
        $redirect_url = '/my-account/user_basic_info/';

        // Redirect the user to the custom URL
        wp_redirect($redirect_url);
        exit;
    }
    function custom_redirect_my_account_dashboard(): void
    {
        global $wp;

        if (
            is_user_logged_in() && ('my-account' == $wp->request || 'my-account/' == $wp->request)
        ) {
            wp_redirect(home_url('/my-account/my_dashboard/'));
            exit;
        }
    }
    function custom_digits_login_redirect(): void
    {
        if (!is_user_logged_in() && is_page('my-account')) {
            // Redirect the user to the login page
            wp_redirect(home_url('/login')); // Change 'login' to the actual login page slug or URL
            exit();
        }
    }
    function new_loop_shop_per_page($cols): int
    {
        return 4;
    }

    function pre_get_posts_callback( $query ): void
    {
        global $argsGenerator;
        $argsGenerator->reset('product', 4);

        $brand_filter = isset($_GET['product_brand']) ? ($_GET['product_brand']) : array();
        $grade_filter = isset($_GET['product_grade']) ? ($_GET['product_grade']) : array();
        $country_filter = isset($_GET['product_country']) ? ($_GET['product_country']) : array();
        $location_filter = isset($_GET['product_location']) ? ($_GET['product_location']) : array();
        $unit_filter = isset($_GET['product_unit']) ? ($_GET['product_unit']) : array();
        $min_order_filter = isset($_GET['min_order_quantity']) ? intval($_GET['min_order_quantity']) : 0;
        $product_purity_filter = isset($_GET['product_purity_filter']) ? intval($_GET['product_purity_filter']) : 0;

        if ( is_shop() && $query->is_main_query() ) {
            // Add Brand filter to the query
            if (!empty($_GET['product_brand'])) {
                $argsGenerator->add_meta_query('product_brand', $brand_filter, 'IN');
            }
            // Add Brand filter to the query
            if (!empty($_GET['product_grade'])) {
                $argsGenerator->add_meta_query('product_grade', $grade_filter, 'IN');
            }
            // Add Country filter to the query
            if (!empty($_GET['product_country'])) {
                $argsGenerator->add_meta_query('product_country', $country_filter, 'IN');
            }
            // Add City filter to the query
            if (!empty($_GET['product_location'])) {
                $argsGenerator->add_meta_query('product_location', $location_filter, 'IN');
            }
            // Add Weight filter to the query
            if (!empty($_GET['product_unit'])) {
                $argsGenerator->add_meta_query('product_unit', $unit_filter, 'IN');
            }
            // Add Min order filter to the query
            if ($min_order_filter > 0) {
                $argsGenerator->add_meta_query('product_order_quantity', array(0, $min_order_filter), 'BETWEEN', 'NUMERIC');
            }
            // Add product purity filter to the query
            if ($product_purity_filter > 0) {
                $argsGenerator->add_meta_query('product_purity', array(0, $product_purity_filter), 'BETWEEN', 'NUMERIC');
            }
            $query->set('meta_query', [$argsGenerator->get_meta_query()]);
        }
        if ((is_tax('product_cas_no') || is_product_category()) && $query->is_main_query()) {
            $queried_object = get_queried_object();
            $term_id = $queried_object->term_id;

            if (is_product_category()) {
                $argsGenerator->add_tax_query('product_cat', 'id', $term_id);
            }
            if (is_tax('product_cas_no')) {
                $argsGenerator->add_tax_query('product_cas_no', 'id', $term_id);
            }

            // Add Brand filter to the query
            if (!empty($_GET['product_brand'])) {
                $argsGenerator->add_meta_query('product_brand', $brand_filter, 'IN');
            }
            // Add Brand filter to the query
            if (!empty($_GET['product_grade'])) {
                $argsGenerator->add_meta_query('product_grade', $grade_filter, 'IN');
            }
            // Add Country filter to the query
            if (!empty($_GET['product_country'])) {
                $argsGenerator->add_meta_query('product_country', $country_filter, 'IN');
            }
            // Add City filter to the query
            if (!empty($_GET['product_location'])) {
                $argsGenerator->add_meta_query('product_location', $location_filter, 'IN');
            }
            // Add Weight filter to the query
            if (!empty($_GET['product_unit'])) {
                $argsGenerator->add_meta_query('product_unit', $unit_filter, 'IN');
            }
            // Add Min order filter to the query
            if ($min_order_filter > 0) {
                $argsGenerator->add_meta_query('product_order_quantity', array(0, $min_order_filter), 'BETWEEN', 'NUMERIC');
            }
            // Add product purity filter to the query
            if ($product_purity_filter > 0) {
                $argsGenerator->add_meta_query('product_purity', array(0, $product_purity_filter), 'BETWEEN', 'NUMERIC');
            }

            $query->set('meta_query', [$argsGenerator->get_meta_query()]);
            $query->set('tax_query', [$argsGenerator->get_tax_query()]);
        }

    }
}
