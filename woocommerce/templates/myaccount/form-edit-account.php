<?php
/**
 * Edit account form
 *
 * This template can be overridden by copying it to milimol/woocommerce/myaccount/form-edit-account.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_edit_account_form' );
$user = wp_get_current_user();
?>
<div class="account__basic-info-header">
    <h3 class="account__basic-info-title">
        اطلاعات پایه
    </h3>
</div>
<div class="account__userprofile">
    <?php echo do_shortcode('[avatar_upload]'); ?>
</div>
<div class="account__basic-info-content">
    <form class="account__basic-info-form woocommerce-EditAccountForm edit-account" action="" method="post" <?php do_action( 'woocommerce_edit_account_form_tag' ); ?> >

        <?php do_action( 'woocommerce_edit_account_form_start' ); ?>

        <div class="account__basic-info-item account__basic-info-first-name">
            <label for="account_first_name"><?php esc_html_e( 'First name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="text" class="account__basic-info-form-input" name="account_first_name" id="account_first_name" autocomplete="given-name" value="<?php echo esc_attr( $user->first_name ); ?>" />
        </div>
        <div class="account__basic-info-item account__basic-info-last-name">
            <label for="account_last_name"><?php esc_html_e( 'Last name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="text" class="account__basic-info-form-input" name="account_last_name" id="account_last_name" autocomplete="family-name" value="<?php echo esc_attr( $user->last_name ); ?>" />
        </div>
        <div class="clear"></div>

        <div class="account__basic-info-item account__basic-info-display-name">
            <label for="account_display_name"><?php esc_html_e( 'Display name', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="text" class="account__basic-info-form-input" name="account_display_name" id="account_display_name" value="<?php echo esc_attr( $user->display_name ); ?>" /> <span><em><?php esc_html_e( 'This will be how your name will be displayed in the account section and in reviews', 'woocommerce' ); ?></em></span>
        </div>
        <div class="clear"></div>

        <div class="account__basic-info-item account__basic-info-email">
            <label for="account_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?>&nbsp;<span class="required">*</span></label>
            <input type="email" class="account__basic-info-form-input" name="account_email" id="account_email" autocomplete="email" value="<?php echo esc_attr( $user->user_email ); ?>" />
        </div>

        <fieldset>
            <legend style="margin-bottom: 16px;"><?php esc_html_e( 'Password change', 'woocommerce' ); ?></legend>

            <div class="account__basic-info-item account__basic-info-password">
                <label for="password_current"><?php esc_html_e( 'Current password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
                <input type="password" class="account__basic-info-form-input" name="password_current" id="password_current" autocomplete="off" />
            </div>
            <div class="account__basic-info-item account__basic-info-password">
                <label for="password_1"><?php esc_html_e( 'New password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
                <input type="password" class="account__basic-info-form-input" name="password_1" id="password_1" autocomplete="off" />
            </div>
            <div class="account__basic-info-item account__basic-info-password">
                <label for="password_2"><?php esc_html_e( 'Confirm new password', 'woocommerce' ); ?></label>
                <input type="password" class="account__basic-info-form-input" name="password_2" id="password_2" autocomplete="off" />
            </div>
        </fieldset>
        <div class="clear"></div>

        <?php do_action( 'woocommerce_edit_account_form' ); ?>

        <div class="account__basic-info-form-buttons">
            <?php wp_nonce_field( 'save_account_details', 'save-account-details-nonce' ); ?>
            <button type="submit" class="account__basic-info-form-button button<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="save_account_details" value="<?php esc_attr_e( 'Save changes', 'woocommerce' ); ?>"><?php esc_html_e( 'Save changes', 'woocommerce' ); ?></button>
            <input type="hidden" name="action" value="save_account_details" />
        </div>

        <?php do_action( 'woocommerce_edit_account_form_end' ); ?>
    </form>
</div>

<?php do_action( 'woocommerce_after_edit_account_form' ); ?>
