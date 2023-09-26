<?php

/**
 * Edit company product list
 *
 */

use Morilog\Jalali\Jalalian;

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
    'post_type' => 'product',    
];
$args['meta_query'] = [
    'relation' => 'AND', // default relation
    [
        'key' => 'product_supplier_linked', // name of custom field
        'value' => '"' .$com_id . "", //
        'compare' => 'LIKE',
    ],
];
$query = new WP_Query($args);
$posts = $query->posts;
?>
<div class="container account__company-products">
    <?php
    session_start();
    if (isset($_POST['action']) && $_POST['action'] === 'delete_product') {
        $pid = $_POST['product_id'];

        // Use WordPress function to send the post to trash
        $deleted = wp_trash_post($pid);

        if ($deleted) {
            $_SESSION['product_deleted'] = true;
            wp_safe_redirect($_SERVER['REQUEST_URI']);
            exit;
        }
    }

    ?>
    <div class="row account__company-products-header">
        <h3 class="account__company-products-title">لیست محصولات</h3>
        <a class="account__company-products-add-new-button" href="/my-account/company_productmodify/"> افزودن محصول جدید</a>
    </div>
    <section class="row account__company-products-content">
        <div class="col-12 account__company-products-labels">
            <div class="account__company-products-labels-item">
                <p>ردیف</p>
                <p>عنوان محصول</p>
                <p>.Cas No</p>
                <p>تاریخ ثبت</p>
                <p>وضعیت</p>
                <p>ویرایش محصول</p>
            </div>
        </div>
        <div class="col-12 account__company-products-details">
            <?php $i = ($paged - 1); ?>
            <?php function get_english_to_persian(string $product_date)
            {
                $persianDate = \Morilog\Jalali\CalendarUtils::strftime('Y-m-d', strtotime($product_date)); // 1395-02-19
                $persianDateFa = \Morilog\Jalali\CalendarUtils::convertNumbers($persianDate); // ۱۳۹۵-۰۲-۱۹

                return $persianDateFa;
            }

            foreach ($posts as $product): ?>
                <?php
                    $i++;
                    $pid = $product->ID;
                    $cas_no = '';
                    $cas_no_tax = wp_get_post_terms($pid, 'product_cas_no');
                    $product_status = get_field('product_status', $pid);
                    if($cas_no_tax)
                    {
                        $cas_no = $cas_no_tax[0]->name;
                    }
                    $product_date = $product->post_date;
                    $product_date_fa = get_english_to_persian($product_date);
                    $product_edit_link = '/my-account/company_productmodify/?pid=' . $pid;
                ?>
                <div class="account__company-products-details-item">
                    <p><?php echo $i; ?></p>
                    <p><?php echo $product->post_title; ?></p>
                    <p><?php echo $cas_no; ?></p>
                    <p><?php echo $product_date_fa; ?></p>
                    <p>
                        <?php if($product_status == 'publish') {
                        echo 'منتشر شده';
                        } elseif ($product_status == 'pending')
                        {
                            echo 'در حال بررسی';

                        } elseif ($product_status == 'draft') {

                            echo 'ذخیره موقت';
                        }
                        ?>
                    </p>
                    <div class="account__company-products-group-btn">
                        <a href="<?php echo $product_edit_link; ?>" class="account__company-products-edit-button">
                            اصلاح
                        </a>
                        <form method="POST" action="" onsubmit="return confirm('آیا برای حذف محصول مورد نظر مطمئن هستید؟');">
                            <input type="hidden" name="action" value="delete_product">
                            <input type="hidden" name="product_id" value="<?php echo $pid; ?>">
                            <button type="submit" class="account__company-products-delete-button">
                                حذف
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php
            // Check if the session variable exists and is true
            if (isset($_SESSION['product_deleted']) && $_SESSION['product_deleted'] === true) {
                // Display the success message
                echo '<div class="account__company-products-success-message">درخواست مورد نظر با موفقیت حذف شد. شما میتوانید برای بازیابی درخواست باهمکاران ما در ارتباط باشید.</div>';
                // Reset the session variable
                $_SESSION['product_deleted'] = false;
            }
            ?>
        </div>
    </section>

</div>

<script>
    jQuery(document).ready(function($) {
        console.log('ready...');
    });
</script>
<?php