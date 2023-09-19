<?php
/**
 * Account Class
 *
 * This class manages various aspects of user accounts and customization within WordPress
 * and WooCommerce. It defines custom rewrite endpoints, query variables, menu items,
 * and callback functions for WooCommerce account endpoints, handles logout confirmation,
 * and manages the saving of Advanced Custom Fields (ACF) data for user accounts.
 *
 * Instructions:
 * 1. Use this class to customize and extend user account functionality in WordPress and WooCommerce.
 * 2. Review and modify the provided callback functions to customize endpoint behavior and data handling.
 * 3. Ensure that your theme or plugin includes the necessary template files for custom endpoints.
 * 4. Hook this class into WordPress actions and filters as needed for your project.
 *
 * @see MILIMOL_THEME_DIR - The directory path to your theme.
 */
namespace EXP\Core;


class Account
{
    public function __construct()
    {
        add_action('init', [&$this, 'my_custom_endpoints']);

        add_filter('query_vars', [&$this, 'my_custom_query_vars'], 0);

        add_action('wp_loaded', [&$this, 'my_custom_flush_rewrite_rules']);

        add_filter('woocommerce_account_menu_items', [&$this, 'my_custom_my_account_menu_items']);


        add_action('woocommerce_account_user_basic_info_endpoint', [&$this, 'user_basic_info_endpoint_callback']);
        add_action('woocommerce_account_my_dashboard_endpoint', [&$this, 'my_dashboard_endpoint_callback']);
        add_action('woocommerce_account_company_basic_endpoint', [&$this, 'company_basic_endpoint_callback']);
        add_action('woocommerce_account_company_content_endpoint', [&$this, 'company_content_endpoint_callback']);
        add_action('woocommerce_account_company_customers_endpoint', [&$this, 'company_customers_endpoint_callback']);
        add_action('woocommerce_account_company_catalog_endpoint', [&$this, 'company_catalog_endpoint_callback']);
        add_action('woocommerce_account_company_documents_endpoint', [&$this, 'company_documents_endpoint_callback']);
        add_action('woocommerce_account_company_social_endpoint', [&$this, 'company_social_endpoint_callback']);
        add_action('woocommerce_account_request_endpoint', [&$this, 'request_endpoint_callback']);
        add_action('woocommerce_account_message_management_endpoint', [&$this, 'message_management_endpoint_callback']);

        add_action('woocommerce_account_company_productlist_endpoint', [&$this,'company_productlist_endpoint_callback']);
        add_action('woocommerce_account_company_productmodify_endpoint', [&$this,'company_productmodify_endpoint_callback']);

        add_action('template_redirect', [&$this, 'logout_confirmation']);

        add_action('acf/save_post', [&$this, 'my_acf_save_post_callback']);

    }

    /**
     * Registers custom rewrite endpoints for WordPress.
     *
     * This function adds custom rewrite endpoints to the WordPress site's URL structure.
     * Each endpoint can be used to create custom URL patterns for specific content or functionality.
     *
     * @note Make sure to use `flush_rewrite_rules()` after modifying endpoints to update the rewrite rules.
     * @see add_rewrite_endpoint()
     */
    function my_custom_endpoints(): void
    {
        add_rewrite_endpoint('user_basic_info', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('my_dashboard', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('company_basic', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('company_content', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('company_customers', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('company_catalog', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('company_documents', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('company_social', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('request', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('company_productlist', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('company_productmodify', EP_ROOT | EP_PAGES);
        add_rewrite_endpoint('message_management', EP_ROOT | EP_PAGES);
    }

    /**
     * Registers custom query variables for WordPress rewrite endpoints.
     *
     * This function adds custom query variables corresponding to the custom
     * rewrite endpoints defined elsewhere in the code. These query variables
     * capture values from the URL and make them available for use in WordPress queries.
     *
     * @param array $vars An array of existing query variables.
     * @return array The modified array with custom query variables added.
     */
    function my_custom_query_vars(array $vars): array
    {
        $vars[] = 'user_basic_info';
        $vars[] = 'my_dashboard';
        $vars[] = 'company_basic';
        $vars[] = 'company_content';
        $vars[] = 'company_customers';
        $vars[] = 'company_catalog';
        $vars[] = 'company_documents';
        $vars[] = 'company_social';
        $vars[] = 'company_productlist';
        $vars[] = 'company_productmodify';
        $vars[] = 'request';
        $vars[] = 'message_management';
        return $vars;
    }

    /**
     * Flushes the WordPress rewrite rules to apply custom endpoint changes.
     *
     * This function triggers a flush of the WordPress rewrite rules, ensuring that any
     * custom endpoint modifications made in the code are applied and take effect.
     *
     * @note Use this function after adding or modifying custom rewrite endpoints.
     * @see flush_rewrite_rules()
     */
    function my_custom_flush_rewrite_rules(): void
    {
        flush_rewrite_rules();
    }

    /**
     * Customizes the WooCommerce "My Account" menu items based on user role.
     *
     * This function filters the WooCommerce "My Account" menu items and customizes them
     * based on the user's role. It adds or removes menu items dynamically depending on
     * whether the user has the 'company' role or not.
     *
     * @param array $items The original array of My Account menu items.
     * @return array The modified array of menu items.
     */
    function my_custom_my_account_menu_items(array $items): array
    {
        // Commented out menu items are placeholders for reference.
        // Uncomment them and customize as needed.
        // Example:
        // $items['dashboard'] = __('Dashboard', 'woocommerce');

        // Check user's role
        $user = wp_get_current_user();
        $roles = (array)$user->roles; // Obtain the user's role
        $items = array(
            //'dashboard'         => __('Dashboard', 'woocommerce'),
            //'orders'            => __( 'Orders', 'woocommerce' ),
            //'downloads'       => __( 'Downloads', 'woocommerce' ),
            //'edit-address'    => __( 'Addresses', 'woocommerce' ),
            //'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
//            'edit-account'      => __( 'Edit Account', 'woocommerce' ),
            //'customer-logout'   => __('Logout', 'woocommerce'),
        );
        if (in_array('company', $roles)) {
            // Add custom menu items for users with the 'company' role
            $items['my_dashboard'] = __('پیشخوان');
            $items['user_basic_info'] = __('اطلاعات کاربر');
            $items['profile_management'] = __('مدیریت شرکت');
            $items['company_basic'] = __('اطلاعات پایه');
            $items['company_content'] = __('محتوای شرکتی');
            $items['company_customers'] = __('مشتریان');
            $items['company_catalog'] = __('کاتالوگ ها');
            $items['company_documents'] = __('گواهی و مجوز ها');
            $items['company_social'] = __('شبکه های اجتماعی');
            $items['product_management'] = __('مدیریت محصولات');
            $items['company_productlist'] = __('لیست محصولات');
            $items['company_productmodify'] = __('محصول جدید');
            $items['request_management'] = __('مدیریت درخواست ها');
            $items['request'] = __('ارسال درخواست خرید');
            $items['message_management'] = __('مدیریت پیام ها');
        }

        // Always include the logout item
        $items['customer-logout'] = __('Logout', 'woocommerce');

        return $items;
    }

    /**
     * Callback functions for custom WooCommerce account endpoints.
     *
     * These functions are responsible for including specific template files when
     * their respective custom WooCommerce account endpoints are accessed. They are
     * hooked into their respective endpoint actions.
     *
     * @see MILIMOL_THEME_DIR - The directory path to your theme.
     *
     * @note Ensure that the included template files exist in the specified directory.
     */
    function user_basic_info_endpoint_callback(): void
    {
        include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/form-edit-account.php';
    }

    function my_dashboard_endpoint_callback(): void
    {
        include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/my_dashboard.php';
    }

    function company_basic_endpoint_callback(): void
    {
        include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/company/company_basic.php';
    }

    function company_content_endpoint_callback(): void
    {
        include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/company/company_content.php';
    }

    function company_customers_endpoint_callback(): void
    {
        include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/company/company_customers.php';
    }

    function company_catalog_endpoint_callback(): void
    {
        include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/company/company_catalog.php';
    }

    function company_documents_endpoint_callback(): void
    {
        include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/company/company_documents.php';
    }

    function company_social_endpoint_callback(): void
    {
        include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/company/company_social.php';
    }

    function company_productlist_endpoint_callback(): void
    {
        include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/product/company_productlist.php';
    }

    function company_productmodify_endpoint_callback(): void
    {
        include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/product/company_productmodify.php';
    }
    function request_endpoint_callback(): void
    {
        include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/request.php';
    }

    function message_management_endpoint_callback(): void
    {
        include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/message/form-message.php';
    }

    /**
     * Logout Confirmation Redirect Function
     *
     * This function is responsible for handling the logout confirmation process in WordPress.
     * When the 'customer-logout' query variable is present in the URL, it redirects the user
     * to the logout URL and ensures proper logout. It is hooked into the 'template_redirect' action.
     *
     * @global WP $wp The WordPress global object.
     * @see wp_logout_url() - Generates the logout URL.
     * @see wc_get_page_permalink() - Retrieves the URL of a WooCommerce page.
     */
    function logout_confirmation(): void
    {
        global $wp;

        // Check if the 'customer-logout' query variable is present
        if (isset($wp->query_vars['customer-logout'])) {
            // Redirect the user to the logout URL
            wp_redirect(str_replace('&amp;', '&', wp_logout_url(wc_get_page_permalink('myaccount'))));
            exit;
        }
    }

    /**
     * Custom ACF Save Post Callback
     *
     * This function is a callback for the ACF (Advanced Custom Fields) 'acf/save_post' action.
     * It handles the saving of ACF fields based on specific conditions and post statuses.
     * Fields are updated when certain post statuses are met.
     *
     * @param int $post_id The ID of the post being saved.
     *
     * @note This function checks post statuses and saves ACF fields accordingly.
     * @see get_field() - Retrieves an ACF field value.
     * @see update_field() - Updates an ACF field value.
     */
    function my_acf_save_post_callback($post_id): void // about data published
    {

        if (!isset($_POST['frontend_acf']) && $_POST['acf']['field_64f3496d77597'] == 'publish')
        {
            $this->publish_basic_info($post_id);
        }
        if (!isset($_POST['frontend_acf']) && $_POST['acf']['field_65084a1e639ae'] == 'publish')
        {
            $this->publish_content_info($post_id);
        }
        if (!isset($_POST['frontend_acf']) && $_POST['acf']['field_65084a64639af'] == 'publish')
        {
            $this->publish_customers_info($post_id);
        }
        if (!isset($_POST['frontend_acf']) && $_POST['acf']['field_65084a8e639b0'] == 'publish')
        {
            $this->publish_catalog_info($post_id);
        }
        if (!isset($_POST['frontend_acf']) && $_POST['acf']['field_65084ac7639b1'] == 'publish')
        {
            $this->publish_documents_info($post_id);
        }
        if (!isset($_POST['frontend_acf']) && $_POST['acf']['field_65084af2639b2'] == 'publish')
        {
            $this->publish_social_info($post_id);
        }

        if (!isset($_POST['frontend_acf']) && $_POST['acf']['field_6508127b649a7'] == 'publish')
        {
            $this->publish_product_info($post_id);

        }
    }

    function publish_basic_info($post_id): void
    {
        $company_icon = get_field('company_icon_draft', $post_id);
        update_field('company_icon', $company_icon, $post_id);
        //
        $company_intro = get_field('company_intro_draft', $post_id);
        update_field('company_intro', $company_intro, $post_id);
        //
        $company_country = get_field('company_country_draft', $post_id);
        update_field('company_country', $company_country, $post_id);
        //
        $company_city = get_field('company_city_draft', $post_id);
        update_field('company_city', $company_city, $post_id);
        //
        $company_start_date = get_field('company_start_date_draft', $post_id);
        update_field('company_start_date', $company_start_date, $post_id);
        //
        $company_job_field = get_field('company_job_field_draft', $post_id);
        update_field('company_job_field', $company_job_field, $post_id);
        //
        $company_ceo = get_field('company_ceo_draft', $post_id);
        update_field('company_ceo', $company_ceo, $post_id);
        //
        $company_personnel = get_field('company_personnel_draft', $post_id);
        update_field('company_personnel', $company_personnel, $post_id);
        //
        $company_office_phone = get_field('company_office_phone_draft', $post_id);
        update_field('company_office_phone', $company_office_phone, $post_id);
        //
        $company_phone = get_field('company_phone_draft', $post_id);
        update_field('company_phone', $company_phone, $post_id);
        //
        $company_office_address = get_field('company_office_address_draft', $post_id);
        update_field('company_office_address', $company_office_address, $post_id);
        //
        $company_address = get_field('company_address_draft', $post_id);
        update_field('company_address', $company_address, $post_id);
        //
        $company_mobile = get_field('company_mobile_draft', $post_id);
        update_field('company_mobile', $company_mobile, $post_id);
        //
        $company_fax = get_field('company_fax_draft', $post_id);
        update_field('company_fax', $company_fax, $post_id);
        //
        $company_email = get_field('company_email_draft', $post_id);
        update_field('company_email', $company_email, $post_id);
    }

    function publish_content_info($post_id): void
    {
        $company_map = get_field('company_map_draft', $post_id);
        update_field('company_map', $company_map, $post_id);
        //
        $company_video_id = get_field('company_video_id_draft', $post_id);
        update_field('company_video_id', $company_video_id, $post_id);
        //
        $company_video_bg = get_field('company_video_bg_draft', $post_id);
        update_field('company_video_bg', $company_video_bg, $post_id);
        //
        $company_ad_banner = get_field('company_ad_banner_draft', $post_id);
        update_field('company_ad_banner', $company_ad_banner, $post_id);
        //
        $company_img_gallery = get_field('company_img_gallery_draft', $post_id);
        update_field('company_img_gallery', $company_img_gallery, $post_id);
    }

    function publish_customers_info($post_id): void
    {
        $company_clients = get_field('company_clients_draft', $post_id);
        update_field('company_clients', $company_clients, $post_id);
    }

    function publish_catalog_info($post_id): void
    {
        $company_catalog = get_field('company_catalog_draft', $post_id);
        update_field('company_catalog', $company_catalog, $post_id);
    }

    function publish_documents_info($post_id): void
    {
        $company_documents = get_field('company_documents_draft', $post_id);
        update_field('company_documents', $company_documents, $post_id);
    }

    function publish_social_info($post_id): void
    {
        $company_website = get_field('company_website_draft', $post_id);
        update_field('company_website', $company_website, $post_id);
        //
        $company_whatsapp = get_field('company_whatsapp_draft', $post_id);
        update_field('company_whatsapp', $company_whatsapp, $post_id);
        //
        $company_instagram = get_field('company_instagram_draft', $post_id);
        update_field('company_instagram', $company_instagram, $post_id);
        //
        $company_email_icon = get_field('company_email_icon_draft', $post_id);
        update_field('company_email_icon', $company_email_icon, $post_id);
        //
        $company_aparat = get_field('company_aparat_draft', $post_id);
        update_field('company_aparat', $company_aparat, $post_id);
        //
        $company_facebook = get_field('company_facebook_draft', $post_id);
        update_field('company_facebook', $company_facebook, $post_id);
        //
        $company_twitter = get_field('company_twitter_draft', $post_id);
        update_field('company_twitter', $company_twitter, $post_id);
        //
        $company_telegram = get_field('company_telegram_draft', $post_id);
        update_field('company_telegram', $company_telegram, $post_id);
        //
        $company_youtube = get_field('company_youtube_draft', $post_id);
        update_field('company_youtube', $company_youtube, $post_id);
    }

    function publish_product_info($post_id): void
    {
        $product_header_bg = get_field('product_header_bg_draft', $post_id);
        update_field('product_header_bg', $product_header_bg, $post_id);
        //

        $product_appearence = get_field('product_appearence_draft', $post_id);
        update_field('product_appearence', $product_appearence, $post_id);
        //

        $product_unique_id = get_field('product_unique_id_draft', $post_id);
        update_field('product_unique_id', $product_unique_id, $post_id);
        //
        $product_purity = get_field('product_purity_draft', $post_id);
        update_field('product_purity', $product_purity, $post_id);
        //
        $product_grade = get_field('product_grade_draft', $post_id);
        update_field('product_grade', $product_grade, $post_id);
        //
        $product_package = get_field('product_package_draft', $post_id);
        update_field('product_package', $product_package, $post_id);
        //
        $product_weight = get_field('product_weight_draft', $post_id);
        update_field('product_weight', $product_weight, $post_id);
        //
        $product_order_quantity = get_field('product_order_quantity_draft', $post_id);
        update_field('product_order_quantity', $product_order_quantity, $post_id);
        //
        $product_price = get_field('product_price_draft', $post_id);
        update_field('product_price', $product_price, $post_id);
        //
        $product_analyse_download = get_field('product_analyse_download_draft', $post_id);
        update_field('product_analyse_download', $product_analyse_download, $post_id);
        //
        $product_ad_banner_first = get_field('product_ad_banner_first_draft', $post_id);
        update_field('product_ad_banner_first', $product_ad_banner_first, $post_id);
        //
        $product_ad_banner_second = get_field('product_ad_banner_second_draft', $post_id);
        update_field('product_ad_banner_second', $product_ad_banner_second, $post_id);
        //

        $this->updateSelectFields($post_id, 'product_brand_other_draft');

    }

    function updateSelectFields($post_id, $otherFieldKey): void
    {
        $product_brand_other_draft = get_field($otherFieldKey, $post_id);

        if (!empty($product_brand_other_draft)) {
            // Get the choices for both fields
            $finfo_brand = $this->myacf_getField('1412', 'product_brand');
            $finfo_brand_draft = $this->myacf_getField('1412', 'product_brand_draft');

            $is_found = false;
            $new_choice_key = null;

            // Check if the value already exists in the choices
            foreach ($finfo_brand['choices'] as $key => $item) {
                if ($item == $product_brand_other_draft) {
                    $is_found = true;
                    $new_choice_key = $key;
                    break;
                }
            }

            // If the value doesn't exist, add it to the choices
            if (!$is_found) {
                $new_choice_key = count($finfo_brand['choices']);
                $finfo_brand['choices'][$new_choice_key] = $product_brand_other_draft;
                $finfo_brand_draft['choices'][$new_choice_key] = $product_brand_other_draft;

                // Save the new choices as options for the fields
                acf_update_field($finfo_brand);
                acf_update_field($finfo_brand_draft);
            }

            // Update both fields with the new choice key
            update_field('product_brand', $new_choice_key, $post_id);
            update_field('product_brand_draft', $new_choice_key, $post_id);

            // Clear the value in product_brand_other_draft
            update_field($otherFieldKey, '', $post_id);
        }
    }

    function myacf_getField($groupId, $fieldName)
    {
        $result = array();
        $tmp_fields = acf_get_fields_by_id($groupId);
        foreach ($tmp_fields as $tmpitem)
        {
            if ($tmpitem['name'] == $fieldName)
            {
                $result = $tmpitem;
                break;
            }

        }
        return $result;
    }

}

