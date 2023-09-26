<?php

/**
 * compony prodcut modify  form
 *
 */

defined('ABSPATH') || exit;
acf_form_head();
$current_user = wp_get_current_user();
$user_id = $current_user->ID;
$com_obj = get_field('p2p_user_company', 'user_' . $user_id);
$com_id = $com_obj[0]->ID;

$pid = $_GET['pid'] ? $_GET['pid'] : '';
$product = wc_get_product( $pid );

if ($product)
{
    $product_supplier_linked = get_field('product_supplier_linked', $pid);
    if ($product_supplier_linked[0]->ID !== $com_id)
    {
        // this product is not yours
        exit(0);
    }
}
else
{
   if(!empty($pid)) {
       exit(0);
   }
}

// check status
$cdata_status = get_field('product_status', $pid);
if ($cdata_status == 'publish') {
    $product_title = get_the_title($pid);
    update_field('product_title_draft', $product_title, $pid);
    //
    $product_cas_no = wp_get_post_terms($pid, 'product_cas_no');
    if($product_cas_no)
    {
        $product_cas_no_id = $product_cas_no[0]->term_id;
        update_field('product_cas_no_draft', $product_cas_no_id, $pid);
    }
    //
    $product_category = wp_get_post_terms($pid, 'product_cat');
    if($product_category)
    {
        $product_category_id = $product_category[0]->term_id;
        update_field('product_category_draft', $product_category_id, $pid);
    }

    $product_brand = get_field('product_brand', $pid);
    update_field('product_brand_draft', $product_brand, $pid);
    //
    $product_appearence = get_field('product_appearence', $pid);
    update_field('product_appearence_draft', $product_appearence, $pid);
    //
    $product_country = get_field('product_country', $pid);
    update_field('product_country_draft', $product_country, $pid);
    //
    $product_analyse = get_field('product_analyse', $pid);
    update_field('product_analyse_draft', $product_analyse, $pid);
    //
    $product_location = get_field('product_location', $pid);
    update_field('product_location_draft', $product_location, $pid);
    //
    $product_unique_id = get_field('product_unique_id', $pid);
    update_field('product_unique_id_draft', $product_unique_id, $pid);
    //
    $product_purity = get_field('product_purity', $pid);
    update_field('product_purity_draft', $product_purity, $pid);
    //
    $product_grade = get_field('product_grade', $pid);
    update_field('product_grade_draft', $product_grade, $pid);
    //
    $product_package = get_field('product_package', $pid);
    update_field('product_package_draft', $product_package, $pid);
    //
    $product_unit = get_field('product_unit', $pid);
    update_field('product_unit_draft', $product_unit, $pid);
    //
    $product_weight = get_field('product_weight', $pid);
    update_field('product_weight_draft', $product_weight, $pid);
    //
    $product_order_quantity = get_field('product_order_quantity', $pid);
    update_field('product_order_quantity_draft', $product_order_quantity, $pid);
    //
    $product_price = get_field('product_price', $pid);
    update_field('product_price_draft', $product_price, $pid);
    //
    $product_analyse_download = get_field('product_analyse_download', $pid);
    update_field('product_analyse_download_draft', $product_analyse_download, $pid);
    //
    $product_ad_banner_first = get_field('product_ad_banner_first', $pid);
    update_field('product_ad_banner_first_draft', $product_ad_banner_first, $pid);
    //
    $product_ad_banner_second = get_field('product_ad_banner_second', $pid);
    update_field('product_ad_banner_second_draft', $product_ad_banner_second, $pid);
    //
    $product_header_bg = get_field('product_header_bg', $pid);
    update_field('product_header_bg_draft', $product_header_bg, $pid);
    //
}
//
if ($cdata_status == 'pending') {
    echo '<div class="account__company-product-new">';
    echo '<div class="account__company-product-new-content">';
    //
    echo '<span class="account__company-product-new-admin-check">
    اطلاعات این قسمت توسط مدیر سیستم در حال بررسی است...
    </span>';
    echo '</div>';  //end of body
    echo '</div>';  // end of section
} else {
    // company info
    echo '<div class="account__company-product-new">';
    echo '<div class="account__company-product-new-header">';
    echo '<h3 class="account__company-product-new-title">اطلاعات محصول</h3>';
    echo '</div>';
    echo '<div class="account__company-product-new-content">';


    if(empty($pid)) {
        $formsetting = [
            'post_id' => 'new_post',
            'id' => 'cform',
            'form' => true,
            'new_post' => [
                'post_type' => 'product',
                'post_status' => 'publish',
            ],
            'post_title' => false,
            'field_groups' => ['1412'],
            'fields' => array(
                'product_title_draft',
                'product_category_draft',
                'product_cas_no_draft',
                'product_cas_no_other_draft',
                'product_brand_draft',
                'product_brand_other_draft',
                'product_appearence_draft',
                'product_country_draft',
                'product_country_other_draft',
                'product_analyse_draft',
                'product_location_draft',
                'product_location_other_draft',
                'product_unique_id_draft',
                'product_purity_draft',
                'product_grade_draft',
                'product_package_draft',
                'product_unit_draft',
                'product_unit_other_draft',
                'product_weight_draft',
                'product_order_quantity_draft',
                'product_price_draft',
                'product_analyse_download_draft',
                'product_ad_banner_first_draft',
                'product_ad_banner_second_draft',
                'product_header_bg_draft',
            ),
            'html_after_fields' => '<input type="hidden" name="frontend_acf" value="product_new"/>
            <input type="hidden" id="acf-field_6508127b649a7" name="acf[field_6508127b649a7]" value="draft"/>
            <input type="hidden" name="acf[field_64c7fa1de0d78][]" value="' . $com_id . '">
        ',
            'updated_message' => ' اطلاعات با موفقیت ذخیره شد.',
            'submit_value' => __("ذخیره", 'acf'),

        ];
    } else {
        $formsetting = array(
            'post_id' => $pid,
            'id' => 'cform',
            'form' => true,
            'new_post' => false,
            'post_title' => false,
            'field_groups' => array('1412'),
            'fields' => array(
                'product_title_draft',
                'product_category_draft',
                'product_cas_no_draft',
                'product_cas_no_other_draft',
                'product_brand_draft',
                'product_brand_other_draft',
                'product_appearence_draft',
                'product_country_draft',
                'product_country_other_draft',
                'product_analyse_draft',
                'product_location_draft',
                'product_location_other_draft',
                'product_unique_id_draft',
                'product_purity_draft',
                'product_grade_draft',
                'product_package_draft',
                'product_unit_draft',
                'product_unit_other_draft',
                'product_weight_draft',
                'product_order_quantity_draft',
                'product_price_draft',
                'product_analyse_download_draft',
                'product_ad_banner_first_draft',
                'product_ad_banner_second_draft',
                'product_header_bg_draft',
            ),
            'html_after_fields' => '<input type="hidden" name="frontend_acf" value="product_edit"/>
            <input type="hidden" id="acf-field_6508127b649a7" name="acf[field_6508127b649a7]" value="draft"/>
        ',
            'updated_message' => ' اطلاعات با موفقیت ذخیره شد.',
            'submit_value' => __("ذخیره", 'acf'),
        );

    }
    acf_form($formsetting);

    echo '</div>';  //end of body
    echo '</div>';  // end of section
}
?>
<script>
    jQuery(document).ready(function($) {
        jQuery(".acf-form-submit").append('<input type="submit" id="btnsend" name="btnsend" value="ارسال برای تایید و انتشار"/>');
        $('#btnsend').on('click', function() {
            if (!confirm("آیا مطمئن هستید؟ (بعد از تایید اطلاعات این فرم جهت بازبینی و انتشار در سایت برای مدیر ارسال خواهد شد.)")) {
                event.preventDefault();
            } else {
                event.preventDefault();
                $('#acf-field_6508127b649a7').val('pending');
                $('form#cform').submit();
            }
        });
    });
</script>
<?php
