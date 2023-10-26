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
                <div class="col-12 d-flex justify-content-center">
                    <div class="dashboard-widgets__company-notice">
                        <svg fill="none" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px" viewBox="0 0 435.2 435.2" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M414.8,408V170V20.4C414.8,9.133,405.668,0,394.4,0H319.6C308.332,0,299.2,9.133,299.2,20.4V170H88.4l-68,68v170H0V435.2 h435.2V408H414.8z M142.8,380.801H81.6V319.6h61.2V380.801z M142.8,285.6H81.6v-61.199h61.2V285.6z M244.8,380.801h-61.2V319.6 h61.2V380.801z M244.8,285.6h-61.2v-61.199h61.2V285.6z M353.6,380.801H292.4V319.6H353.6V380.801z M353.6,285.6H292.4v-61.199 H353.6V285.6z"></path> </g> </g></svg>
                        <p>
                            کاربر گرامی برای احراز شرکت خود لطفا از طریق صفحه <a href="/contact-us">تماس با ما</a> یا شماره تماس: <a href="tel:989123028025">09123028025</a> در تماس باشید.
                        </p>
                </div>
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