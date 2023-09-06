<?php
/**
 * Login/Sign-up
 */
namespace EXP\Core;

use DOMDocument;
use DOMXPath;

class Login
{
    public function __construct()
    {
        add_shortcode( 'REGISTER_FORM_MILIMOL', [&$this, 'wc_reg_form_milimol_callback']);
        add_shortcode( 'LOGIN_FORM_MILIMOL', [&$this, 'wc_login_form_milimol_callback'] );

        add_action( 'template_redirect', [&$this, 'milimol_redirect_login_registration_if_logged_in_callback'] );

        add_action( 'woocommerce_register_form_start', [&$this, 'milimol_display_account_registration_field'] );
        add_action( 'woocommerce_edit_account_form_start', [&$this, 'woocommerce_edit_account_form_start_callback'] );
        add_action( 'woocommerce_created_customer', [&$this, 'milimol_save_account_registration_field'] );
        add_action( 'woocommerce_save_account_details', [&$this, 'milimol_save_my_account_billing_account_number'], 10, 1 );

        add_filter( 'woocommerce_customer_meta_fields', [&$this, 'woocommerce_customer_meta_fields_callback'], 10, 1 );
        add_filter( 'woocommerce_registration_errors', [&$this, 'milimol_account_registration_field_validation'], 10, 3 );
    }

    function wc_reg_form_milimol_callback(): bool|string
    {
        if ( is_user_logged_in() ) return '<p>You are already registered</p>';
        ob_start();
        do_action( 'woocommerce_before_customer_login_form' );
        $html = wc_get_template_html( 'myaccount/form-login.php' );
        $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
        $dom = new DOMDocument();
        $dom->encoding = 'UTF-8';
        $dom->loadHTML( $html );
        $xpath = new DOMXPath( $dom );
        $form = $xpath->query( '//form[contains(@class,"register")]' );
        $form = $form->item( 0 );
        echo $dom->saveXML( $form );
        return ob_get_clean();
    }

    function wc_login_form_milimol_callback(): bool|string
    {
        if ( is_user_logged_in() ) return '<p>You are already logged in</p>';
        ob_start();
        do_action( 'woocommerce_before_customer_login_form' );
        woocommerce_login_form( array( 'redirect' => wc_get_page_permalink( 'myaccount' ) ) );
        return ob_get_clean();
    }

    function milimol_redirect_login_registration_if_logged_in_callback(): void
    {
        if ( is_page() && is_user_logged_in() && ( has_shortcode( get_the_content(), 'LOGIN_FORM_MILIMOL' ) || has_shortcode( get_the_content(), 'REGISTER_FORM_MILIMOL' ) ) ) {
            wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
            exit;
        }
    }

    /* registration form start */

    // Display a field in Registration / Edit account
    function milimol_display_account_registration_field(): void
    {
        $user = wp_get_current_user();
        $value = isset($_POST['billing_account_number']) ? esc_attr($_POST['billing_account_number']) : $user->billing_account_number;
        ?>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="reg_billing_account_number"><?php _e( 'Ship to/ Account number', 'woocommerce' ); ?> <span class="required">*</span></label>
            <input type="text" maxlength="6" class="input-text" name="billing_account_number" id="reg_billing_account_number" value="<?php echo $value ?>" />
        </p>
        <div class="clear"></div>
        <?php
    }

    // registration Field validation
    function milimol_account_registration_field_validation( $errors, $username, $email ) {
        if ( isset( $_POST['billing_account_number'] ) && empty( $_POST['billing_account_number'] ) ) {
            $errors->add( 'billing_account_number_error', __( '<strong>Error</strong>: account number is required!', 'woocommerce' ) ); }
        return $errors;
    }

    // Save registration Field value
    function milimol_save_account_registration_field( $customer_id ): void
    {
        if ( isset( $_POST['billing_account_number'] ) ) {
            update_user_meta( $customer_id, 'billing_account_number', sanitize_text_field( $_POST['billing_account_number'] ) );
        }

        if ( isset( $_POST['billing_phone2'] ) ) {
            update_user_meta( $customer_id, 'billing_phone2', sanitize_text_field( $_POST['billing_phone2'] ) );
        }
    }

    // Save Field value in Edit account
    function milimol_save_my_account_billing_account_number( $user_id ): void
    {
        if( isset( $_POST['billing_account_number'] ) ){
            update_user_meta( $user_id, 'billing_account_number', sanitize_text_field( $_POST['billing_account_number'] ) );
        }
    }

    // Display field in admin user billing fields section
    function milimol_admin_user_custom_billing_field( $args ): array
    {
        $args['billing']['fields']['billing_account_number'] = array(
            'label' => __( 'Ship to/ Account number', 'woocommerce' ),
            'description' => '',
            'custom_attributes' => array('maxlength' => 6),
        );
        return $args;
    }
    /* registration form end */

    function woocommerce_edit_account_form_start_callback(): array
    {
        $user = wp_get_current_user();
        $value = isset($_POST['billing_phone2']) ? esc_attr($_POST['billing_phone2']) : $user->billing_phone2;
        ?>
        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="reg_billing_account_number"><?php _e( 'Ship to/ Account number', 'woocommerce' ); ?> <span class="required">*</span></label>
            <input type="text" maxlength="6" class="input-text" name="billing_phone2" id="billing_phone2" value="<?php echo $value ?>" />
        </p>
        <div class="clear"></div>
        <?php
    }

    // Display field in admin user billing fields section
    function woocommerce_customer_meta_fields_callback( $args ): array
    {
        $args['billing']['fields']['billing_phone2'] = array(
            'label' => __( 'Billing phone2', 'woocommerce' ),
            'description' => '',
            'custom_attributes' => array('maxlength' => 12),
        );
        return $args;
    }


}
