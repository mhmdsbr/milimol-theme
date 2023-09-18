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
        'value' => '"' .$com_id . "", // matches exactly "123", not just 123. This prevents a match for "1234"
        'compare' => 'LIKE',
    ],
];
$query = new WP_Query($args);
$posts = $query->posts;
?>
<div class="tbl-list">

    <div class="lstHead">
        لیست محصولات
        <br />
        <a href="/my-account/company_productmodify/">محصول جدید</a>
    </div>
    <table class="table" style="
    width: 100%;
    border: 1px solid lightgray;">
        <tr class="tblheading">
            <th>ردیف</th>
            <th>عنوان محصول</th>
            <th>Cas NO</th>
            <th>تاریخ ثبت</th>
            <th>وضعیت</th>
            <th>#</th>
        </tr>
        <?php foreach ($posts as $product): ?>
            <?php
                $i = ($paged - 1) * 100;
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
                $product_edit_link = '/my-account/company_productmodify/?pid=' . $pid;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $product->post_title; ?></td>
                <td><?php echo $cas_no; ?></td>
                <td><?php echo $product_date; ?></td>
                <td><?php if($product_status == 'publish') {
                    echo 'منتشر شده';
                    } elseif ($product_status == 'pending')
                    {
                        echo 'در حال بررسی';

                    } elseif ($product_status == 'draft') {

                        echo 'ذخیره موقت';
                    }
                    ?></td>
                <td>
                    <a href="<?php echo $product_edit_link; ?>">اصلاح</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>

<style>    
</style>
<script>
    jQuery(document).ready(function($) {
        console.log('ready...');
    });
</script>
<?php