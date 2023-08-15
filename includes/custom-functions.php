<?php

/* registeration form start */
// Display a field in Registration / Edit account 
add_action( 'woocommerce_register_form_start', 'ql_display_account_registration_field' ); 
add_action( 'woocommerce_edit_account_form_start', 'ql_display_account_registration_field' ); 
function ql_display_account_registration_field() { 
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
add_filter( 'woocommerce_registration_errors', 'ql_account_registration_field_validation', 10, 3 ); 
function ql_account_registration_field_validation( $errors, $username, $email ) { 
    if ( isset( $_POST['billing_account_number'] ) && empty( $_POST['billing_account_number'] ) ) { 
    $errors->add( 'billing_account_number_error', __( '<strong>Error</strong>: account number is required!', 'woocommerce' ) ); } 
    return $errors; 
}

// Save registration Field value 
add_action( 'woocommerce_created_customer', 'ql_save_account_registration_field' ); 
function ql_save_account_registration_field( $customer_id ) { 
    if ( isset( $_POST['billing_account_number'] ) ) { 
    update_user_meta( $customer_id, 'billing_account_number', sanitize_text_field( $_POST['billing_account_number'] ) ); 
    }
}

// Save Field value in Edit account 
add_action( 'woocommerce_save_account_details', 'ql_save_my_account_billing_account_number', 10, 1 );
function ql_save_my_account_billing_account_number( $user_id ) { 
    if( isset( $_POST['billing_account_number'] ) ){ 
    update_user_meta( $user_id, 'billing_account_number', sanitize_text_field( $_POST['billing_account_number'] ) ); 
    }
}

// Display field in admin user billing fields section 
add_filter( 'woocommerce_customer_meta_fields', 'ql_admin_user_custom_billing_field', 10, 1 ); 
function ql_admin_user_custom_billing_field( $args ) {
    $args['billing']['fields']['billing_account_number'] = array( 
    'label' => __( 'Ship to/ Account number', 'woocommerce' ), 
    'description' => '', 
    'custom_attributes' => array('maxlength' => 6), 
    ); 
    return $args;
}
/* registeration form end */