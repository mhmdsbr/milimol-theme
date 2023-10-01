<?php
/**
 * Shortcodes Class
 *
 * This class manages custom shortcodes for WordPress and WooCommerce. It provides methods for
 * creating and customizing shortcodes related to user registration, login, account navigation,
 * and account content. Additionally, it includes a helper method for rendering WooCommerce forms.
 *
 * Instructions:
 * 1. Use this class to define and manage custom shortcodes in your WordPress project.
 * 2. Review and modify the provided shortcode callback functions as needed for your use case.
 * 3. Utilize the `render_woocommerce_form` helper method to render WooCommerce forms consistently.
 * 4. Hook this class into WordPress actions and filters to enable your custom shortcodes.
 *
 * @see wc_reg_form_milimol_callback() - Callback for the user registration form shortcode.
 * @see wc_login_form_milimol_callback() - Callback for the user login form shortcode.
 * @see wc_acc_nav_milimol_callback() - Callback for the account navigation shortcode.
 * @see wc_acc_content_milimol_callback() - Callback for the account content shortcode.
 */
namespace EXP\Core;

use DOMDocument;
use DOMXPath;

class Shortcodes
{
    /**
     * Constructor for the Shortcodes class.
     * Initializes and registers shortcode callbacks.
     */
    public function __construct()
    {
        // Register shortcodes and their respective callback methods
        add_shortcode( 'REGISTER_FORM_MILIMOL', [&$this, 'wc_reg_form_milimol_callback']);
        add_shortcode( 'LOGIN_FORM_MILIMOL', [&$this, 'wc_login_form_milimol_callback'] );

        add_shortcode( 'ACCOUNT_NAV_MILIMOL', [&$this, 'wc_acc_nav_milimol_callback']);
        add_shortcode( 'ACCOUNT_CONTENT_MILIMOL', [&$this, 'wc_acc_content_milimol_callback']);
    }

    /**
     * Helper method for rendering WooCommerce forms.
     *
     * @param string $form_class The class name of the form.
     * @param string $template_path The path to the WooCommerce template.
     *
     * @return bool|string Rendered form HTML or an error message.
     */
    private function render_woocommerce_form(string $form_class, string $template_path): bool|string
    {
        if ( is_user_logged_in() ) {
            wp_safe_redirect( wc_get_page_permalink( 'myaccount/my_dashboard/' ) );
            exit;
        } else {
            ob_start();
            do_action( 'woocommerce_before_customer_login_form' );
            $html = wc_get_template_html( $template_path );
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
            $dom = new DOMDocument();
            $dom->encoding = 'UTF-8';
            @$dom->loadHTML( $html );
            $xpath = new DOMXPath( $dom );
            $form = $xpath->query( "//form[contains(@class,'$form_class')]" );
            $form = $form->item( 0 );
            echo $dom->saveXML( $form );
            return ob_get_clean();
        }
    }

    /**
     * Register form shortcode callback.
     *
     * @return bool|string Rendered registration form HTML.
     */
    function wc_reg_form_milimol_callback(): bool|string
    {
        return $this->render_woocommerce_form('register', '/woocommerce/templates/myaccount/form-signup.php');
    }

    /**
     * Login form shortcode callback.
     *
     * @return bool|string Rendered login form HTML.
     */
    function wc_login_form_milimol_callback(): bool|string
    {
        return $this->render_woocommerce_form('login', '/woocommerce/templates/myaccount/form-login.php');
    }

    /**
     * Account navigation shortcode callback.
     *
     * @return bool|string Rendered account navigation HTML.
     */
    function wc_acc_nav_milimol_callback(): bool|string
    {
        if ( is_user_logged_in() ) {
            ob_start();
            wc_get_template('/woocommerce/templates/myaccount/navigation.php');
        };
        return ob_get_clean();
    }

    /**
     * Account content shortcode callback.
     *
     * @return bool|string Rendered account content HTML.
     */
    function wc_acc_content_milimol_callback(): bool|string
    {
        if ( is_user_logged_in() ) {
            ob_start();
            wc_get_template('/woocommerce/templates/myaccount/my-account.php');
        };
        return ob_get_clean();
    }
}
