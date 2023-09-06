<?php
/**
 * Login Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-login.php.
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

	<div class="u-column2 col-2">

<?php endif; ?>

		<h2><?php esc_html_e( 'Login', 'woocommerce' ); ?></h2>
        <?php
            $user = wp_get_current_user();
            $phone = isset($_POST['billing_phone']) ? esc_attr($_POST['billing_phone']) : $user->billing_phone;
        ?>

        <form class="login__form woocommerce-form-login login" method="post">

            <?php do_action( 'woocommerce_login_form_start' ); ?>

            <div class="login__form-item login__form-mobile">
                <label for="login_billing_phone">
                    <?php _e( 'موبایل ', 'woocommerce' ); ?>
                    <span class="required">*</span>
                </label>
                <input type="text" maxlength="12" class="login__form-input" name="billing_phone" id="login_billing_phone" value="<?php echo $phone ?>" />
            </div>
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
                    <?php esc_html_e( 'ورود', 'woocommerce' ); ?>
                </button>
                <label class="login__form-remember-me">
                    <input class="login__form-input-remember-me" name="rememberme" type="checkbox" id="rememberme" value="forever" /> <span><?php esc_html_e( 'من را به خاطر بسپارید.', 'woocommerce' ); ?></span>
                </label>
            </div>
            <div class="login__form-lost-password lost_password">
                <a href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'رمز عبور خود را فراموش کرده اید؟', 'woocommerce' ); ?></a>
            </div>

            <?php do_action( 'woocommerce_login_form_end' ); ?>
        </form>


<?php if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) ) : ?>

	</div>

    <div class="u-column2 col-2">

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

            <div class="signup__form-item signup__form-mobile">
                <label for="reg_billing_phone">
                    <?php _e( 'موبایل ', 'woocommerce' ); ?>
                    <span class="required">*</span>
                </label>
                <input type="text" maxlength="12" class="signup__form-input" name="billing_phone" id="reg_billing_phone" value="<?php echo $phone ?>" />
            </div>

            <div class="signup__form-item signup__form-email">
                <label for="reg_email">
                    <?php esc_html_e( 'آدرس ایمیل', 'woocommerce' ); ?>&nbsp;
                    <span class="required">*</span>
                </label>
                <input type="email" class="signup__form-input" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
            </div>

            <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>

                <div class="signup__form-item signup__form-password">
                    <label for="reg_password">
                        <?php esc_html_e( 'رمز عبور', 'woocommerce' ); ?>
                        <span class="required">*</span>
                    </label>
                    <input type="password" class="signup__form-input" name="password" id="reg_password" autocomplete="new-password" />
                </div>

                <div class="signup__form-item signup__form-password-repeat">
                    <label for="reg_password2">
                        <?php _e( 'تایید رمز عبور ', 'woocommerce' ); ?>
                        <span class="required">*</span>
                    </label>
                    <input type="password" class="signup__form-input" name="password2" id="reg_password2" value="<?php if ( ! empty( $_POST['password2'] ) ) echo esc_attr( $_POST['password2'] ); ?>" />
                </div>

            <?php else : ?>

                <p><?php esc_html_e( 'یک ایمیل برای بازنشانی رمز جدید برایتان شد.', 'woocommerce' ); ?></p>

            <?php endif; ?>

<!--            --><?php //do_action( 'woocommerce_register_form' ); ?>

            <div class="signup__form-buttons">
                <?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
                <button type="submit" class="signup__form-submit-button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?> woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'ثبت نام', 'woocommerce' ); ?>"><?php esc_html_e( 'ثبت نام', 'woocommerce' ); ?></button>
            </div>

            <?php do_action( 'woocommerce_register_form_end' ); ?>

        </form>

    </div>

</div>
<?php endif; ?>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>


<!--<section class-->