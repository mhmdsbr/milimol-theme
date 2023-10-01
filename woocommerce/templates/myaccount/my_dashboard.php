<?php  global $dashboardWidget;
/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to milimol/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) 
{
	exit; // Exit if accessed directly.
}
	?>

    <div class="dashboard-widgets">

        <h2 class="dashboard-widget__title">پیشخوان</h2>

        <div class="dashboard__message-notification">
            <?php $dashboardWidget->render_widget_message_notification(); ?>
        </div>

        <div class="dashboard__userpanel-advertisement">
            <?php $dashboardWidget->render_widget_advertisement(); ?>
        </div>

        <div class="dashboard__userpanel-product-info">
            <?php $dashboardWidget->render_widget_product_info(); ?>
        </div>
    </div>