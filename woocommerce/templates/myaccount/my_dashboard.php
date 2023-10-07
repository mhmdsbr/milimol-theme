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
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="dashboard-widgets__title">پیشخوان</h3>
                </div>
                <div class="col-12 <?php echo wp_is_mobile() ? 'mb-4 gx-0' : ''; ?> col-md-6">
                    <div class="dashboard-widgets__message-notification">
                        <h4 class="dashboard-widgets__message-title">
                            وضعیت پیام ها
                        </h4>
                        <?php $dashboardWidget->render_widget_message_notification(); ?>
                    </div>
                </div>
                <div class="col-12 <?php echo wp_is_mobile() ? 'mb-4 gx-0' : ''; ?> col-md-6">
                    <div class="dashboard-widgets__product-info">
                        <h4 class="dashboard-widgets__message-title">
                            وضعیت محصولات
                        </h4>
                        <?php $dashboardWidget->render_widget_product_info(); ?>
                    </div>
                </div>
                <div class="col-12">
                    <div class="dashboard-widgets__advertisement">
                        <?php $dashboardWidget->render_widget_advertisement(); ?>
                    </div>
                </div>
            </div>
        </div>

    </div>