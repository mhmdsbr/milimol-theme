<?php
/**
 * Login/Sign-up
 */
namespace EXP\Core;


class Login
{
    public function __construct()
    {

        add_action( 'template_redirect', [&$this, 'milimol_redirect_login_registration_if_logged_in_callback'] );

//        add_action( 'woocommerce_register_form_start', [&$this, 'woocommerce_register_form_start_callback'] );
//        add_action( 'woocommerce_edit_account_form_start', [&$this, 'woocommerce_register_form_start_callback'] );
//        add_action( 'woocommerce_created_customer', [&$this, 'woocommerce_created_customer_callback'] );
//        add_action( 'woocommerce_save_account_details', [&$this, 'woocommerce_save_account_details_callback'], 10, 1 );

//        add_filter( 'woocommerce_customer_meta_fields', [&$this, 'woocommerce_customer_meta_fields_callback'], 10, 1 );
//        add_filter( 'woocommerce_registration_errors', [&$this, 'woocommerce_registration_errors'], 10, 3 );
//        add_filter('woocommerce_registration_errors', [&$this, 'woocommerce_registration_errors_password_callback'], 10, 3);

    }


    function milimol_redirect_login_registration_if_logged_in_callback(): void
    {
        if ( is_page() && is_user_logged_in() && ( has_shortcode( get_the_content(), 'LOGIN_FORM_MILIMOL' ) || has_shortcode( get_the_content(), 'REGISTER_FORM_MILIMOL' ) ) ) {
            wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
            exit;
        }
    }


    // Display a field in Registration / Edit account
    function woocommerce_register_form_start_callback(): void
    {
        $user = wp_get_current_user();
        $phone = isset($_POST['billing_phone']) ? esc_attr($_POST['billing_phone']) : $user->billing_phone;
        ?>

        <p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
            <label for="reg_billing_phone"><?php _e( 'موبایل ', 'woocommerce' ); ?> <span class="required">*</span></label>
            <input type="text" maxlength="12" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php echo $phone ?>" />
        </p>

        <p class="form-row form-row-wide">
            <label for="reg_password2"><?php _e( 'تایید رمز عبور ', 'woocommerce' ); ?> <span class="required">*</span></label>
            <input type="password" class="input-text" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
        </p>

        <?php
    }

    // Save registration Field value
    function woocommerce_created_customer_callback($customer_id): void
    {
        if ( isset( $_POST['billing_phone'] ) ) {
            update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
        }
    }

    // Save Field value in Edit account
    function woocommerce_save_account_details_callback($user_id): void
    {
        if( isset( $_POST['billing_phone'] ) ){
            update_user_meta( $user_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );
        }

    }

    // Display field in admin user billing fields section
    function woocommerce_customer_meta_fields_callback( $args ): array
    {
        $args['billing']['fields']['billing_phone'] = array(
            'label' => __( 'موبایل: ', 'woocommerce' ),
            'description' => '',
            'custom_attributes' => array('maxlength' => 12),
        );
        return $args;
    }

    // Registration Field validation
    function woocommerce_registration_errors( $errors, $username, $email ) {
        if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {
            $errors->add( 'billing_phone_error', __( '<strong>Error</strong>: شماره تماس برای ثبت نام الزامی می باشد.', 'woocommerce' ) ); }
        return $errors;
    }

    // Registration Field Password validation
    function woocommerce_registration_errors_password_callback($reg_errors, $sanitized_user_login, $user_email) {
        global $woocommerce;
        extract( $_POST );
        if ( strcmp( $password, $password2 ) !== 0 ) {
            return new WP_Error( 'registration-error', __( 'رمز عبور ها مطابقت ندارند.', 'woocommerce' ) );
        }
        return $reg_errors;
    }


}
