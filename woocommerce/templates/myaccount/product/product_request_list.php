<?php

/**
 * Edit product request list
 *
 */

defined('ABSPATH') || exit;
acf_form_head();
$current_user = wp_get_current_user();
$user_roles = $current_user->roles;

if(!in_array('customer', $user_roles) && !in_array('company', $user_roles)) {
    exit;
}
$user_id = $current_user->ID;

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = [
    'posts_per_page' => 30,
    'paged' => $paged,
    'post_type' => 'request',
];
$args['meta_query'] = [
    'relation' => 'AND', // default relation
    [
        'key' => 'user_request_linked', // name of custom field
        'value' => $user_id,
        'compare' => '=',
    ],
];
$query = new WP_Query($args);
$posts = $query->posts;
?>
<div class="container account__company-products">

    <div class="row account__company-products-header">
        <h3 class="account__company-products-title">لیست درخواست ها</h3>
        <a class="account__company-products-add-new-button" href="/my-account/product_request_modify/"> افزودن درخواست جدید</a>
    </div>
    <section class="row account__company-products-content">
        <div class="col-12 account__company-products-labels">
            <div class="account__company-products-labels-item">
                <p>ردیف</p>
                <p>عنوان درخواست</p>
                <p>.Cas No</p>
                <p>تاریخ ثبت</p>
                <p>وضعیت</p>
                <p>ویرایش درخواست</p>
            </div>
        </div>
        <div class="col-12 account__company-products-details">
            <?php
            session_start();
            if (isset($_POST['action']) && $_POST['action'] === 'delete_request') {
                $requestId = $_POST['request_id'];

                // Use WordPress function to send the post to trash
                $deleted = wp_trash_post($requestId);

                if ($deleted) {
                    $_SESSION['request_deleted'] = true;
                    wp_safe_redirect($_SERVER['REQUEST_URI']);
                    exit;
                }
            }

            ?>
            <?php $i = ($paged - 1); ?>
            <?php function get_english_to_persian(string $product_date)
            {
                $persianDate = \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($product_date)); // 1395-02-19
                $persianDateFa = \Morilog\Jalali\CalendarUtils::convertNumbers($persianDate); // ۱۳۹۵-۰۲-۱۹

                return $persianDateFa;
            }
            ?>
            <?php foreach ($posts as $request): ?>
                <?php
                    $i++;
                    $requestId = $request->ID;
                    $cas_no = '';
                    $cas_no_tax = wp_get_post_terms($requestId, 'request_cas_no');
                    if($cas_no_tax)
                    {
                        $cas_no = $cas_no_tax[0]->name;
                    }
                    $request_status = get_field('request_status', $requestId);
                    $request_date = $request->post_date;
                    $request_date_fa = get_english_to_persian($request_date);
                    $request_edit_link = '/my-account/product_request_modify/?requestId=' . $requestId;
                ?>
                <div class="account__company-products-details-item">
                    <p><?php echo $i; ?></p>
                    <a class="account__company-products-details-title" href="<?php echo get_permalink($request->ID); ?>">
                        <p><?php echo $request->post_title; ?></p>
                    </a>
                    <p><?php echo $cas_no; ?></p>
                    <p><?php echo $request_date_fa; ?></p>
                    <p><?php if($request_status == 'publish') {
                        echo 'منتشر شده';
                        } elseif ($request_status == 'pending')
                        {
                            echo 'در حال بررسی';

                        } elseif ($request_status == 'draft') {

                            echo 'ذخیره موقت';
                        }
                        ?>
                    </p>
                    <div class="account__company-products-group-btn">
                        <a href="<?php echo $request_edit_link; ?>" class="account__company-products-edit-button">
                            اصلاح
                        </a>
                        <form method="POST" action="" onsubmit="return confirm('آیا برای حذف درخواست مورد نظر مطمئن هستید؟');">
                            <input type="hidden" name="action" value="delete_request">
                            <input type="hidden" name="request_id" value="<?php echo $requestId; ?>">
                            <button type="submit" class="account__company-products-delete-button">
                                حذف
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php
            // Check if the session variable exists and is true
            if (isset($_SESSION['request_deleted']) && $_SESSION['request_deleted'] === true) {
                // Display the success message
                echo '<div class="account__company-products-success-message">درخواست مورد نظر با موفقیت حذف شد. شما میتوانید برای بازیابی درخواست باهمکاران ما در ارتباط باشید.</div>';
                // Reset the session variable
                $_SESSION['request_deleted'] = false;
            }
            ?>
        </div>
    </section>

</div>

<script>
    jQuery(document).ready(function($) {

    });
</script>
<?php