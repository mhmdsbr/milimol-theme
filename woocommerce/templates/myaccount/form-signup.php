<?php
/**
 * Sign Up Form
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

<div class="" id="customer_signup">

<?php endif; ?>

<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

        <h2><?php esc_html_e( 'Register', 'woocommerce' ); ?></h2>

        <form method="post" class="signup__form woocommerce-form-sign-up register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

            <?php do_action( 'woocommerce_register_form_start' ); ?>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>

                <div class="signup__form-item signup__form-username">
                    <label for="reg_username"><?php esc_html_e( 'نام کاربری', 'woocommerce' ); ?>
                        <span class="required">*</span>
                    </label>
                    <input type="text" class="signup__form-input" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                </div>

            <?php endif; ?>

            <div class="signup__form-item signup__form-email">
                <label for="reg_email">
<!--                    --><?php //esc_html_e( 'آدرس ایمیل', 'woocommerce' ); ?><!--&nbsp;-->
                    <span class="required">*</span>
                </label>
                <input type="email" class="signup__form-input" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
                <span class="signup__form-fill-notice">
                    <?php esc_html_e( 'لطفا شماره را بدون ۰ وارد نمایید.', 'woocommerce' ); ?>&nbsp;
                </span>
            </div>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                <div class="signup__form-item signup__form-password">
                    <label for="reg_password">
                        <?php esc_html_e( 'رمز عبور', 'woocommerce' ); ?>
                        <span class="required">*</span>
                    </label>
                    <input type="password" class="signup__form-input" name="password" id="reg_password" autocomplete="new-password" />
                </div>

            <?php else : ?>

                <p><?php esc_html_e( 'یک ایمیل برای بازنشانی رمز جدید برایتان شد.', 'woocommerce' ); ?></p>

            <?php endif; ?>

            <?php do_action( 'woocommerce_register_form' ); ?>

            <div class="signup__form-buttons">
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <button type="submit" class="signup__form-submit-button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'ثبت نام', 'woocommerce' ); ?>"><?php esc_html_e( 'ثبت نام', 'woocommerce' ); ?></button>
            </div>

            <?php do_action( 'woocommerce_register_form_end' ); ?>
        </form>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>



