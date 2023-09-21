<?php

/**
 * Edit product request list
 *
 */

defined('ABSPATH') || exit;
acf_form_head();
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$com_obj = get_field('p2p_user_company', 'user_' . $user_id);
$com_id = $com_obj[0]->ID;

$paged = get_query_var('paged') ? get_query_var('paged') : 1;
$args = [
    'posts_per_page' => 30,
    'paged' => $paged,
    'post_type' => 'request',
];
$args['meta_query'] = [
    'relation' => 'AND', // default relation
    [
        'key' => 'company_request_linked', // name of custom field
        'value' => '"' .$com_id . "", //
        'compare' => 'LIKE',
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
                    $formatted_date = date('Y-m-d', strtotime($request_date));
                    $request_edit_link = '/my-account/product_request_modify/?requestId=' . $requestId;
                ?>
                <div class="account__company-products-details-item">
                    <p><?php echo $i; ?></p>
                    <p><?php echo $request->post_title; ?></p>
                    <p><?php echo $cas_no; ?></p>
                    <p><?php echo $formatted_date; ?></p>
                    <p><?php if($request_status == 'publish') {
                        echo 'منتشر شده';
                        } elseif ($request_status == 'pending')
                        {
                            echo 'در حال بررسی';

                        } elseif ($request_status == 'draft') {

                            echo 'ذخیره موقت';
                        }
                        ?></p>
                    <a href="<?php echo $request_edit_link; ?>" class="account__company-products-edit-button">
                        اصلاح
                    </a>
                    <form method="POST" action="" onsubmit="return confirm('Are you sure you want to delete this request?');">
                        <input type="hidden" name="action" value="delete_request">
                        <input type="hidden" name="request_id" value="<?php echo $requestId; ?>">
                        <button type="submit" class="account__company-products-delete-button">
                            حذف
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>
            <?php
            // Check if the session variable exists and is true
            if (isset($_SESSION['request_deleted']) && $_SESSION['request_deleted'] === true) {
                // Display the success message
                echo '<div class="success-message">The request has been deleted.</div>';
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