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

        // Customize the number of products per page
        add_action('pre_get_posts', [&$this, 'custom_shop_page_query']);

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

    function custom_shop_page_query($query): void
    {
        if (is_shop() || is_product_category() || is_tax('product_cas_no')) {
            $query->set('posts_per_page', 8); // Adjust this number as needed
        }
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

}
