<?php

/* dashboard start */
function my_custom_endpoints()
{
    add_rewrite_endpoint('company_basic', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('company_content', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('company_customers', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('company_catalog', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('company_documents', EP_ROOT | EP_PAGES);
    add_rewrite_endpoint('company_social', EP_ROOT | EP_PAGES);
}
add_action('init', 'my_custom_endpoints');

function my_custom_query_vars($vars)
{
    $vars[] = 'company_basic';
    $vars[] = 'company_content';
    $vars[] = 'company_customers';
    $vars[] = 'company_catalog';
    $vars[] = 'company_documents';
    $vars[] = 'company_social';
    return $vars;
}
add_filter('query_vars', 'my_custom_query_vars', 0);

function my_custom_flush_rewrite_rules()
{
    flush_rewrite_rules();
}
add_action('wp_loaded', 'my_custom_flush_rewrite_rules');

function my_custom_my_account_menu_items($items)
{
    $items = array(
        'dashboard'         => __('Dashboard', 'woocommerce'),
        // 'orders'            => __( 'Orders', 'woocommerce' ),
        //'downloads'       => __( 'Downloads', 'woocommerce' ),
        //'edit-address'    => __( 'Addresses', 'woocommerce' ),
        //'payment-methods' => __( 'Payment Methods', 'woocommerce' ),
        //'edit-account'      => __( 'Edit Account', 'woocommerce' ),
        //'customer-logout'   => __('Logout', 'woocommerce'),
    );
    // check role
    $user = wp_get_current_user(); 
    $roles = ( array ) $user->roles; // obtaining the role 
    if (in_array('company', $roles))
    {
        $items['company_basic'] = __('اطلاعات پایه');
        $items['company_content'] = __('اطلاعات محتوی');
        $items['company_customers'] = __('اطلاعات مشتریان');
        $items['company_catalog'] = __('اطلاعات کاتالوگ ها');
        $items['company_documents'] = __('اطلاعات گواهی و مجوز ها');
        $items['company_social'] = __('اطلاعات شبکه های اجتماعی');
    }
    //
    $items['customer-logout'] = __('Logout', 'woocommerce');
    return $items;
}
add_filter('woocommerce_account_menu_items', 'my_custom_my_account_menu_items');

function company_basic_endpoint_callback()
{
    include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/company_basic.php';
}
add_action('woocommerce_account_company_basic_endpoint', 'company_basic_endpoint_callback');
function company_content_endpoint_callback()
{
    include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/company_content.php';
}
add_action('woocommerce_account_company_content_endpoint', 'company_content_endpoint_callback');
function company_customers_endpoint_callback()
{
    include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/company_customers.php';
}
add_action('woocommerce_account_company_customers_endpoint', 'company_customers_endpoint_callback');
function company_catalog_endpoint_callback()
{
    include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/company_catalog.php';
}
add_action('woocommerce_account_company_catalog_endpoint', 'company_catalog_endpoint_callback');
function company_documents_endpoint_callback()
{
    include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/company_documents.php';
}
add_action('woocommerce_account_company_documents_endpoint', 'company_documents_endpoint_callback');
function company_social_endpoint_callback()
{
    include MILIMOL_THEME_DIR . '/woocommerce/templates/myaccount/company_social.php';
}
add_action('woocommerce_account_company_social_endpoint', 'company_social_endpoint_callback');


function logout_confirmation()
{
    global $wp;
    if (isset($wp->query_vars['customer-logout'])) {
        wp_redirect(str_replace('&amp;', '&', wp_logout_url(wc_get_page_permalink('myaccount'))));
        exit;
    }
}
add_action('template_redirect', 'logout_confirmation');

function my_acf_save_post_callback($post_id) // about data published
{
    if (!isset($_POST['frontend_acf']) && $_POST['basic_status'] == 'publish') 
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
    if (!isset($_POST['frontend_acf']) && $_POST['content_status'] == 'publish') 
    {
        $company_map = get_field('company_map_draft', $post_id);
        update_field('company_map', $company_map, $post_id);
        //
        $company_map = get_field('company_map_draft', $post_id);
        update_field('company_map', $company_map, $post_id);
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
    if (!isset($_POST['frontend_acf']) && $_POST['customers_status'] == 'publish') 
    {
        $company_clients = get_field('company_clients_draft', $post_id);
        update_field('company_clients', $company_clients, $post_id);
    }
    if (!isset($_POST['frontend_acf']) && $_POST['catalog_status'] == 'publish') 
    {
        $company_catalog = get_field('company_catalog_draft', $post_id);
        update_field('company_catalog', $company_catalog, $post_id);
    }
    if (!isset($_POST['frontend_acf']) && $_POST['documents_status'] == 'publish') 
    {
        $company_documents = get_field('company_documents_draft', $post_id);
        update_field('company_documents', $company_documents, $post_id);
    }
    if (!isset($_POST['frontend_acf']) && $_POST['social_status'] == 'publish') 
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
}
add_action('acf/save_post', 'my_acf_save_post_callback');


/* dashboard end */