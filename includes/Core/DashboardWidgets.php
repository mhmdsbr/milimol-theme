<?php
/**
 * Dashboard Widget Handler
 */
namespace EXP\Core;
use EXP\Core\ArgsGenerator;

class DashboardWidgets
{
    private ?\WP_User $current_user;
    public function __construct()
    {
        $this->current_user = wp_get_current_user();
    }

    public function render_widget_avatar(): void
    {
        $user_display_name = $this->current_user->display_name;
        $user_avatar = get_wp_user_avatar( $this->current_user->ID, 100 );
        ?>

        <div class="account__user">
            <div class="account__user-avatar">
                <?php echo $user_avatar; ?>
            </div>
            <p class="account__user-display-name">
                کاربر گرامی <strong><?php echo $user_display_name; ?></strong> خوش آمدید.
            </p>
        </div>

        <?php

    }

    public function render_widget_message_notification(): void
    {
        $total_count = fep_get_user_message_count( 'total' );
        $unread_count = fep_get_user_message_count( 'unread' );
        $unread_ann_count = fep_get_user_announcement_count( 'unread' );
        $max_total = fep_get_current_user_max_message_number();
        $max_text = $max_total ? number_format_i18n( $max_total) : __( 'unlimited', 'front-end-pm' );
        ?>

        <div class="fep-header-unread-text">
            <?php echo strip_tags( sprintf( __('You have %1$s and %2$s unread', 'front-end-pm'), '<span class="fep_unread_message_count_text">' . sprintf( _n( '%s message', '%s messages', $unread_count, 'front-end-pm' ), number_format_i18n( $unread_count ) ) . '</span>', '<span class="fep_unread_announcement_count_text">' . sprintf( _n( '%s announcement', '%s announcements', $unread_ann_count, 'front-end-pm' ), number_format_i18n( $unread_ann_count ) ) . '</span>' ), '<span>' ); ?>
        </div>
        <div class="fep-header-box-size">
            <?php echo strip_tags( sprintf( __( 'Message box size: %1$s of %2$s', 'front-end-pm' ), '<span class="fep_total_message_count">' . number_format_i18n( $total_count ) . '</span>', $max_text ), '<span>' ); ?>
        </div>

        <?php

    }

    public function render_widget_advertisement(): void
    {
        $ad_url = get_field('userpanel_ad', 'option')
        ?>

        <div class="userpanel_ad">
            <img src="<?php echo $ad_url; ?>" alt="" />
        </div>

        <?php

    }

    public function render_widget_product_info(): void
    {
        global $argsGenerator;
        $com_obj = get_field('p2p_user_company', 'user_' . $this->current_user->ID);
        $com_id = $com_obj[0]->ID;
        $argsGenerator->reset('product', -1);
        $argsGenerator->add_meta_query('product_supplier_linked', '"' .$com_id . '"', 'LIKE');
        $products = new \WP_Query($argsGenerator->generate_arguments());
        $total_products = $products->found_posts;

        $argsGenerator->add_meta_query('product_status', 'pending', '=');
        $products_status_pending = new \WP_Query($argsGenerator->generate_arguments());
        $products_status_pending_total = $products_status_pending->found_posts;

        $argsGenerator->clear_meta_query();
        $argsGenerator->add_meta_query('product_supplier_linked', '"' .$com_id . '"', 'LIKE');
        $argsGenerator->add_meta_query('product_status', 'publish', '=');
        $products_status_publish = new \WP_Query($argsGenerator->generate_arguments());
        $products_status_publish_total = $products_status_publish->found_posts;

        ?>

        <div class="userpanel_product">
            تعداد کل محصولات ثبت شده
                <?php echo $total_products; ?>
            <hr>
            محصولات در حال بررسی
                <?php echo $products_status_pending_total; ?>
            <hr>
            محصولات منتشر شده
                <?php echo $products_status_publish_total; ?>
        </div>

        <?php

    }

}
