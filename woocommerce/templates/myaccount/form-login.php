<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to milimol/woocommerce/myaccount/form-login.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

    <div class="" id="customer_login">

<?php endif; ?>

		<h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>

        <form class="login__form woocommerce-form-login login" method="post">

            <?php do_action( 'woocommerce_login_form_start' ); ?>

            <div class="login__form-item login__form-username">
                <label for="username">
                    <?php esc_html_e( 'ایمیل و نام کاربری', 'woocommerce' ); ?>&nbsp;
                    <span class="required">*</span>
                </label>
                <input type="text" class="login__form-input" name="username" id="username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </div>

            <div class="login__form-item login__form-password">
                <label for="password">
                    <?php esc_html_e( 'رمز عبور', 'woocommerce' ); ?>
                    <span class="required">*</span>
                </label>
                <input class="login__form-input" type="password" name="password" id="password" autocomplete="current-password" />
            </div>

            <?php do_action( 'woocommerce_login_form' ); ?>

            <div class="login__form-buttons">
                <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
                <button type="submit" class="login__form-submit-button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="login" value="<?php esc_attr_e( 'Log in', 'woocommerce' ); ?>">
                    <?php esc_html_e( 'ورود با رمز عبور', 'woocommerce' ); ?>
                </button>
                <label class="login__form-remember-me">
                    <input class="login__form-input-remember-me" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'من را به خاطر بسپارید.', 'woocommerce' ); ?></span>
                </label>
            </div>

            <?php do_action( 'woocommerce_login_form_end' ); ?>

            <div class="login__form-lost-password lost_password">
                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'رمز عبور خود را فراموش کرده اید؟', 'woocommerce' ); ?></a>
            </div>

            <div class="login__form-not-logged-in">
                <p>آیا عضو نیستید؟</p>
                <a href="<?php echo esc_url( '/register' ); ?>"><?php esc_html_e( 'هم اکنون عضو شوید.', 'woocommerce' ); ?></a>
            </div>
        </form>

    </div>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>
