<?php

/* seperate register and login form start */
function wc_reg_form_milimol_callback() {
    if ( is_user_logged_in() ) return '<p>You are already registered</p>';
    ob_start();
    do_action( 'woocommerce_before_customer_login_form' );
    $html = wc_get_template_html( 'myaccount/form-login.php' );
    $dom = new DOMDocument();
    $dom->encoding = 'utf-8';
    $dom->loadHTML( utf8_decode( $html ) );
    $xpath = new DOMXPath( $dom );
    $form = $xpath->query( '//form[contains(@class,"register")]' );
    $form = $form->item( 0 );
    echo $dom->saveXML( $form );
    return ob_get_clean();
}
add_shortcode( 'wc_reg_form_milimol', 'wc_reg_form_milimol_callback' );   

function wc_login_form_milimol_callback() {
    if ( is_user_logged_in() ) return '<p>You are already logged in</p>'; 
    ob_start();
    do_action( 'woocommerce_before_customer_login_form' );
    woocommerce_login_form( array( 'redirect' => wc_get_page_permalink( 'myaccount' ) ) );
    return ob_get_clean();
}
add_shortcode( 'wc_login_form_milimol', 'wc_login_form_milimol_callback' );

function milimol_redirect_login_registration_if_logged_in_callback() {
    if ( is_page() && is_user_logged_in() && ( has_shortcode( get_the_content(), 'wc_login_form_bbloomer' ) || has_shortcode( get_the_content(), 'wc_reg_form_bbloomer' ) ) ) {
        wp_safe_redirect( wc_get_page_permalink( 'myaccount' ) );
        exit;
    }
}
add_action( 'template_redirect', 'milimol_redirect_login_registration_if_logged_in_callback' );
/* seperate register and login form end */
