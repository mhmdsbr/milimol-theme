<?php

/**
 * Edit company product list
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
            <?php foreach ($posts as $product): ?>
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
                    $formatted_date = date('Y-m-d', strtotime($product_date));
                    $product_edit_link = '/my-account/company_productmodify/?pid=' . $pid;
                ?>
                <div class="account__company-products-details-item">
                    <p><?php echo $i; ?></p>
                    <p><?php echo $product->post_title; ?></p>
                    <p><?php echo $cas_no; ?></p>
                    <p><?php echo $formatted_date; ?></p>
                    <p><?php if($product_status == 'publish') {
                        echo 'منتشر شده';
                        } elseif ($product_status == 'pending')
                        {
                            echo 'در حال بررسی';

                        } elseif ($product_status == 'draft') {

                            echo 'ذخیره موقت';
                        }
                        ?></p>
                    <a href="<?php echo $product_edit_link; ?>" class="account__company-products-edit-button">
                        اصلاح
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

</div>

<script>
    jQuery(document).ready(function($) {
        console.log('ready...');
    });
</script>
<?php